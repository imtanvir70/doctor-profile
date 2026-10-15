<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MinifyHtmlMiddleware
{
    /**
     * Handle an incoming request and safely minify HTML output.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only minify successful HTML responses
        if (!$this->shouldMinify($request, $response)) {
            return $response;
        }

        $content = $response->getContent();
        if (empty($content) || !is_string($content)) {
            return $response;
        }

        $minified = $this->minify($content);
        $response->setContent($minified);

        return $response;
    }

    /**
     * Determine if response should be minified.
     */
    protected function shouldMinify(Request $request, Response $response): bool
    {
        // Don't minify in print sheet previews
        if ($request->is('*print*')) {
            return false;
        }

        // Check if response has text/html content-type
        $contentType = $response->headers->get('Content-Type', '');
        if (!str_contains($contentType, 'text/html')) {
            return false;
        }

        // Check status code (skip redirects)
        if ($response->isRedirection()) {
            return false;
        }

        return true;
    }

    /**
     * Safely minify HTML content without breaking JavaScript, CSS, textareas, or preformatted blocks.
     */
    protected function minify(string $html): string
    {
        $placeholders = [];
        $counter = 0;

        // 1. Protect <textarea> tags completely verbatim
        $html = preg_replace_callback('/<textarea\b[^>]*>.*?<\/textarea>/is', function ($matches) use (&$placeholders, &$counter) {
            $key = "###PRESERVE_TEXTAREA_{$counter}###";
            $placeholders[$key] = $matches[0];
            $counter++;
            return $key;
        }, $html);

        // 2. Protect <pre> and <code> blocks
        $html = preg_replace_callback('/<(pre|code)\b[^>]*>.*?<\/\1>/is', function ($matches) use (&$placeholders, &$counter) {
            $key = "###PRESERVE_PRE_{$counter}###";
            $placeholders[$key] = $matches[0];
            $counter++;
            return $key;
        }, $html);

        // 3. Safely process and protect <script> blocks
        $html = preg_replace_callback('/<script\b([^>]*)>(.*?)<\/script>/is', function ($matches) use (&$placeholders, &$counter) {
            $attributes = $matches[1];
            $scriptContent = $matches[2];

            // If it's JSON-LD, safely minify JSON
            if (str_contains($attributes, 'application/ld+json')) {
                $decoded = json_decode($scriptContent);
                if ($decoded !== null) {
                    $minifiedScript = json_encode($decoded, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                } else {
                    $minifiedScript = trim($scriptContent);
                }
            } else {
                $minifiedScript = $this->minifyJs($scriptContent);
            }

            $key = "###PRESERVE_SCRIPT_{$counter}###";
            $placeholders[$key] = "<script{$attributes}>{$minifiedScript}</script>";
            $counter++;
            return $key;
        }, $html);

        // 4. Safely process and protect <style> blocks
        $html = preg_replace_callback('/<style\b([^>]*)>(.*?)<\/style>/is', function ($matches) use (&$placeholders, &$counter) {
            $attributes = $matches[1];
            $styleContent = $matches[2];

            // Remove CSS comments
            $cleaned = preg_replace('/\/\*.*?\*\//s', '', $styleContent);
            // Collapse whitespace around symbols (excluding + and - which are required in calc())
            $cleaned = preg_replace('/\s*([{}:;,>~])\s*/', '$1', $cleaned);
            // Ensure spaces around + and - for valid calc() syntax
            $cleaned = preg_replace('/\s*([+])\s*/', ' $1 ', $cleaned);
            // Collapse multiple spaces
            $cleaned = preg_replace('/\s+/', ' ', $cleaned);
            $cleaned = trim($cleaned);

            $key = "###PRESERVE_STYLE_{$counter}###";
            $placeholders[$key] = "<style{$attributes}>{$cleaned}</style>";
            $counter++;
            return $key;
        }, $html);

        // 5. Remove HTML comments (except IE conditional comments)
        $html = preg_replace('/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/s', '', $html);

        // 6. Collapse whitespace between HTML tags (e.g. >   < becomes ><)
        $html = preg_replace('/>\s+</', '><', $html);

        // 7. Collapse multiple spaces and tabs in remaining HTML text into a single space
        $html = preg_replace('/[ \t]+/', ' ', $html);

        // 8. Collapse newlines in HTML
        $html = preg_replace('/[\r\n]+/', '', $html);

        // 9. Restore all protected blocks in reverse order
        if (!empty($placeholders)) {
            $keys = array_reverse(array_keys($placeholders));
            $values = array_reverse(array_values($placeholders));
            $html = str_replace($keys, $values, $html);
        }

        return trim($html);
    }

    /**
     * Safely minify inline JavaScript by isolating string literals and regexes,
     * stripping comments, normalizing whitespace, and joining statements compactly.
     */
    protected function minifyJs(string $js): string
    {
        $js = trim($js);
        if ($js === '') {
            return '';
        }

        $length = strlen($js);
        $i = 0;

        $inSingleQuote = false;
        $inDoubleQuote = false;
        $inTemplateLiteral = false;
        $inBlockComment = false;
        $inLineComment = false;

        $tokens = [];
        $currentToken = '';

        while ($i < $length) {
            $char = $js[$i];
            $next = ($i + 1 < $length) ? $js[$i + 1] : '';

            // Handle block comments
            if ($inBlockComment) {
                if ($char === '*' && $next === '/') {
                    $inBlockComment = false;
                    $i += 2;
                } else {
                    $i++;
                }
                continue;
            }

            // Handle line comments
            if ($inLineComment) {
                if ($char === "\n" || $char === "\r") {
                    $inLineComment = false;
                    $currentToken .= "\n";
                }
                $i++;
                continue;
            }

            // Handle single-quoted strings
            if ($inSingleQuote) {
                $currentToken .= $char;
                if ($char === '\\') {
                    if ($next !== '') {
                        $currentToken .= $next;
                        $i += 2;
                        continue;
                    }
                } elseif ($char === "'") {
                    $inSingleQuote = false;
                    $tokens[] = ['type' => 'string', 'value' => $currentToken];
                    $currentToken = '';
                }
                $i++;
                continue;
            }

            // Handle double-quoted strings
            if ($inDoubleQuote) {
                $currentToken .= $char;
                if ($char === '\\') {
                    if ($next !== '') {
                        $currentToken .= $next;
                        $i += 2;
                        continue;
                    }
                } elseif ($char === '"') {
                    $inDoubleQuote = false;
                    $tokens[] = ['type' => 'string', 'value' => $currentToken];
                    $currentToken = '';
                }
                $i++;
                continue;
            }

            // Handle template literals (backticks)
            if ($inTemplateLiteral) {
                $currentToken .= $char;
                if ($char === '\\') {
                    if ($next !== '') {
                        $currentToken .= $next;
                        $i += 2;
                        continue;
                    }
                } elseif ($char === '`') {
                    $inTemplateLiteral = false;
                    $tokens[] = ['type' => 'string', 'value' => $currentToken];
                    $currentToken = '';
                }
                $i++;
                continue;
            }

            // Check if comment starts
            if ($char === '/' && $next === '*') {
                $inBlockComment = true;
                $i += 2;
                continue;
            }
            if ($char === '/' && $next === '/') {
                $inLineComment = true;
                $i += 2;
                continue;
            }

            // Check if string starts
            if ($char === "'") {
                if ($currentToken !== '') {
                    $tokens[] = ['type' => 'code', 'value' => $currentToken];
                    $currentToken = '';
                }
                $inSingleQuote = true;
                $currentToken = "'";
                $i++;
                continue;
            }
            if ($char === '"') {
                if ($currentToken !== '') {
                    $tokens[] = ['type' => 'code', 'value' => $currentToken];
                    $currentToken = '';
                }
                $inDoubleQuote = true;
                $currentToken = '"';
                $i++;
                continue;
            }
            if ($char === '`') {
                if ($currentToken !== '') {
                    $tokens[] = ['type' => 'code', 'value' => $currentToken];
                    $currentToken = '';
                }
                $inTemplateLiteral = true;
                $currentToken = '`';
                $i++;
                continue;
            }

            // Check if regex literal starts
            if ($char === '/') {
                $prevCode = trim($currentToken);
                $isRegex = false;
                if ($prevCode === '') {
                    $lastToken = end($tokens);
                    if (!$lastToken || $lastToken['type'] === 'code') {
                        $lastChar = $lastToken ? substr(trim($lastToken['value']), -1) : '(';
                        if (in_array($lastChar, ['(', '[', '{', ',', ';', ':', '=', '!', '&', '|', '?', '+', '-', '*', '%', '<', '>'], true)) {
                            $isRegex = true;
                        }
                    }
                } else {
                    $lastChar = substr($prevCode, -1);
                    if (in_array($lastChar, ['(', '[', '{', ',', ';', ':', '=', '!', '&', '|', '?', '+', '-', '*', '%', '<', '>'], true)) {
                        $isRegex = true;
                    }
                }

                if ($isRegex) {
                    if ($currentToken !== '') {
                        $tokens[] = ['type' => 'code', 'value' => $currentToken];
                        $currentToken = '';
                    }
                    $regexStr = '/';
                    $i++;
                    $escaped = false;
                    while ($i < $length) {
                        $rChar = $js[$i];
                        $regexStr .= $rChar;
                        if ($escaped) {
                            $escaped = false;
                        } elseif ($rChar === '\\') {
                            $escaped = true;
                        } elseif ($rChar === '/' && !$escaped) {
                            $i++;
                            while ($i < $length && ctype_alpha($js[$i])) {
                                $regexStr .= $js[$i];
                                $i++;
                            }
                            break;
                        }
                        $i++;
                    }
                    $tokens[] = ['type' => 'regex', 'value' => $regexStr];
                    continue;
                }
            }

            $currentToken .= $char;
            $i++;
        }

        if ($currentToken !== '') {
            $tokens[] = ['type' => 'code', 'value' => $currentToken];
        }

        // Minify code tokens ONLY, keeping strings and regexes 100% verbatim
        $result = '';
        foreach ($tokens as $token) {
            if ($token['type'] === 'string' || $token['type'] === 'regex') {
                $result .= $token['value'];
            } else {
                $code = $token['value'];

                $lines = explode("\n", str_replace(["\r\n", "\r"], "\n", $code));
                $cleanLines = [];
                foreach ($lines as $line) {
                    $t = trim($line);
                    if ($t === '') {
                        continue;
                    }
                    $cleanLines[] = $t;
                }

                $joined = '';
                $count = count($cleanLines);
                for ($k = 0; $k < $count; $k++) {
                    $curr = $cleanLines[$k];
                    $lastChar = substr($curr, -1);
                    $nextFirst = ($k + 1 < $count) ? $cleanLines[$k + 1][0] : '';

                    $needsSemicolon = false;
                    if ($k + 1 < $count) {
                        if (!in_array($lastChar, [';', '{', '}', '(', '[', ',', ':', '?', '=', '+', '-', '*', '/', '%', '&', '|', '!', '<', '>'], true)) {
                            if (!in_array($nextFirst, ['{', '}', ')', ']', ',', ';', ':', '?', '.', '+', '-', '*', '/', '%', '&', '|'], true)) {
                                $needsSemicolon = true;
                            }
                        }
                    }

                    $joined .= $curr . ($needsSemicolon ? ';' : '');
                }

                $joined = preg_replace('/\s*([{}();,:?=&|<>!*\/%^~])\s*/', '$1', $joined);
                $joined = preg_replace('/(?<![+-])\s*([+-])\s*(?![+-])/', '$1', $joined);
                $joined = preg_replace('/\s+/', ' ', $joined);

                $result .= $joined;
            }
        }

        return trim($result);
    }
}


