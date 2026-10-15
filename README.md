# Doctor Profile & Clinical Portal

A modern, responsive, and dynamic Doctor Profile & Clinical Appointment Management System built with **Laravel 12**, **Tailwind CSS**, and **Hotwire Turbo** for a blazing-fast Single Page Application (SPA) experience with zero page refreshes and full SEO optimization.

## Key Features

- **⚡ Instant SPA Navigation**: Powered by Hotwire Turbo for snappy, app-like transitions without reload flicker.
- **📱 Pixel-Perfect Responsiveness**: 100% responsive across all screens down to 320px mobile viewports.
- **⚙️ Dynamic Admin Panel (`/drprofile`)**: Change doctor biography, titles, hospital affiliations, research cards, color schemes, and contact details on the fly. Reusable for multiple doctor profiles.
- **🩺 Clinical Research & Expertise Showcases**: Structured academic cards with institutional metadata, peer-reviewed badges, and visual icons.
- **📅 Patient Appointment Booking**: Online appointment scheduling with date, time, and department routing.
- **🔍 SEO & Meta Optimized**: OpenGraph meta tags, clean semantic HTML5, and accessible ARIA navigation.
- **🔒 Secure & Extensible**: Built on the robust Laravel framework with complete automated test coverage.

## Tech Stack

- **Backend**: Laravel 12 (PHP 8.2+)
- **Frontend**: Blade Components, Tailwind CSS, Hotwire Turbo
- **Database**: SQLite / MySQL / PostgreSQL compatible

## Setup & Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/imtanvir70/doctor-profile.git
   cd doctor-profile
   ```

2. **Install dependencies:**
   ```bash
   composer install
   ```

3. **Configure environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Run migrations & seeders:**
   ```bash
   php artisan migrate --seed
   ```

5. **Start the local server:**
   ```bash
   php artisan serve
   ```

6. **Run tests:**
   ```bash
   php artisan test
   ```

---
*Developed by [Solve IT](https://solveitbd.com/)*
