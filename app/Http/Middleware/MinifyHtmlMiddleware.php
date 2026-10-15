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
                // For JavaScript: remove block comments, trim lines, remove blank lines
                // We keep linebreaks between lines to ensure single-line (//) comments NEVER break following code!
                $lines = explode("\n", $scriptContent);
                $cleanedLines = [];
                $inBlockComment = false;

                foreach ($lines as $line) {
                    $trimmed = trim($line);

                    if ($inBlockComment) {
                        if (str_contains($trimmed, '*/')) {
                            $inBlockComment = false;
                            $trimmed = trim(substr($trimmed, strpos($trimmed, '*/') + 2));
                        } else {
                            continue;
                        }
                    }

                    if (str_starts_with($trimmed, '/*') && !str_contains($trimmed, '*/')) {
                        $inBlockComment = true;
                        continue;
                    }

                    // Remove inline block comments
                    $trimmed = preg_replace('/\/\*.*?\*\//s', '', $trimmed);
                    $trimmed = trim($trimmed);

                    if ($trimmed !== '') {
                        $cleanedLines[] = $trimmed;
                    }
                }
                $minifiedScript = implode("\n", $cleanedLines);
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
            // Collapse whitespace around symbols
            $cleaned = preg_replace('/\s*([{}:;,>+~])\s*/', '$1', $cleaned);
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
}

