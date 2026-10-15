# Doctor Profile & Clinical Management System

A high-performance, dynamic, and fully responsive **Doctor Portfolio, EMR & Clinical Serial Management System** built with **Laravel 13 (PHP 8.3+)**, **Bootstrap 5.3**, and **Hotwire Turbo** for a seamless Single Page Application (SPA) experience with zero page reloads and 100% SEO friendliness.

---

## 🛠️ Technology Stack

| Component | Technology / Library | Details |
| :--- | :--- | :--- |
| **Backend Framework** | **Laravel 13.x** (`^13.0`) | Built on PHP `^8.3` |
| **SPA Engine** | **Hotwire Turbo 8** | Client-side SPA navigation without full page reload |
| **CSS & UI Framework** | **Bootstrap 5.3.3** | Custom-engineered responsive components & grid |
| **Icons** | **Bootstrap Icons 1.11.3** | Crisp SVG medical & operational icons |
| **Typography** | **Google Fonts** | `Inter`, `Outfit`, and `Noto Sans Bengali` |
| **Database** | **SQLite / MySQL / PostgreSQL** | Database-agnostic schema with Eloquent ORM |
| **Asset Bundler** | **Vite 7** | Modern, lightning-fast frontend tooling |
| **Test Suite** | **PHPUnit 12** | Automated Feature & Unit test coverage |

---

## 🌟 Key Features

### 1. ⚡ Hotwire Turbo SPA Experience
- Zero-reload page transitions with integrated top progress bar.
- Maintains high performance while keeping search-engine crawlers happy with clean, server-rendered semantic HTML.

### 2. 🌐 Bilingual Support (English & Bengali)
- Dynamic one-click language switching (`/lang/en` & `/lang/bn`).
- Dual-language fields for doctor credentials, designations, hero biographies, and chamber details.

### 3. 🎨 100% Dynamic White-Label Architecture
- Built not just for a single doctor, but as a multi-client white-label platform.
- **Dynamic Color Palette Engine**: Modify primary, secondary, and accent colors directly from the admin panel (`/drprofile`) without editing CSS.
- Editable qualifications, hero badges, hospital affiliations, and contact channels.

### 4. 🩺 Clinical Research & Academic Showcase
- Interactive international research project cards with peer-reviewed badges, institution tags, and publication links.
- Medical specializations, treatments, and FAQ accordion.

### 5. 📋 Patient Serial Booking & Prescription Management
- **Frontend Appointment Booking**: Patients can select chamber, date, time slot, and describe symptoms.
- **Admin Serial Queue**: Daily patient tracking, status toggles, and printable serial tokens.
- **Digital Rx Prescription Maker**: Generate, manage, and print clinical prescriptions for patients.

### 6. 📱 Responsive Down to 320px
- Handcrafted layout tested across mobile devices down to 320px screen width.
- Native-feeling mobile offcanvas/dropdown navigation.

### 7. 🔍 SEO & Social Graph Ready
- Dedicated admin SEO manager (`/admin/seo`) to configure page titles, meta descriptions, OpenGraph images, and canonical URLs.

---

## 💻 System Requirements

- **PHP**: `^8.3` (with `pdo`, `mbstring`, `openssl`, `curl` extensions)
- **Composer**: `^2.5`
- **Node.js**: `^20.x` or `^22.x` & **npm**

---

## 🚀 Setup & Installation

### 1. Clone the repository
```bash
git clone https://github.com/imtanvir70/doctor-profile.git
cd doctor-profile
```

### 2. Install backend dependencies
```bash
composer install
```

### 3. Configure environment file
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Run database migrations & seeders
```bash
php artisan migrate --seed
```

### 5. Run tests to verify setup
```bash
php artisan test
```

### 6. Start the development server
```bash
php artisan serve
```

Access the application in your browser:
- **Public Portal:** `http://127.0.0.1:8000`
- **Admin Dashboard:** `http://127.0.0.1:8000/drprofile` *(Default credentials: `admin@doctor.com` / `password`)*

---

## 👥 Credits & Development

Developed with ❤️ by **[Solve IT](https://solveitbd.com/)**
