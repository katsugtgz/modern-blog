```
   ___  ___          __                    ____   __            
  /   |/   /____     ___/ ___  ____  ___     / __ ) / /____   ___ _
 / /|_/ __ \/ _  \_/ __ \/ _ \/ __ \/ _ \   / __  |/ // __ \ / _ `/
/ /  / / / / /_/ / /_/ /  __/ /_/ /  __/  / /_/ // // /_/ //  __/ 
/_/  /_/ /_/\__,_/\__,_/\___/\____/\___/  /_____/_/ \____/ \__, /  
                                                           /____/   
```

<div align="center">

# 🚀 Modern Blog Platform

### A feature-rich, responsive blogging platform built with cutting-edge technologies

[![Laravel](https://img.shields.io/badge/Laravel-v12.0-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-v4.0-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![Alpine.js](https://img.shields.io/badge/Alpine.js-v3.14-8BC34A?style=for-the-badge&logo=alpine.js&logoColor=white)](https://alpinejs.dev)
[![Livewire](https://img.shields.io/badge/Livewire-v3.6-4E56A6?style=for-the-badge&logo=livewire&logoColor=white)](https://livewire.laravel.com)

</div>

---

## 🎯 Project Status

> ⚠️ **Work in Progress**: This project is actively under development and may contain bugs, incomplete features, or experimental code.

### 📊 Development Progress

```
Core Features          ████████████████████████████░░ 90%
Advanced Filtering     ██████████████████████████░░░░ 85%
Multi-Image Upload     ████████████████████████░░░░░░ 80%
User Authentication    ████████████████████████████░░ 95%
Comment System         ███████████████████████████░░░ 88%
Admin Panel           ██████████████████░░░░░░░░░░░░ 60%
Documentation         ████████░░░░░░░░░░░░░░░░░░░░░░ 30%
Testing               ██████░░░░░░░░░░░░░░░░░░░░░░░░ 25%
```

---

## ✨ Features

### 🎨 Core Features
- ✅ **User Authentication & Profiles** - Complete user management system
- ✅ **CRUD Blog Posts** - Create, read, update, delete blog posts
- ✅ **Categories & Tags** - Organize content with flexible taxonomy
- ✅ **Nested Comments** - Interactive comment threads with replies
- ✅ **Responsive Design** - Mobile-first responsive layout

### 🔥 Advanced Features
- 🚧 **Complex Filtering System** - Multi-category, date range, tag combinations
- 🚧 **Multi-Image Upload** - Drag-and-drop with gallery management
- 🚧 **Filter Presets** - Save and load custom filter configurations
- 🚧 **Rich Text Editor** - Enhanced content creation experience
- ⏳ **SEO Optimization** - Meta tags, sitemaps, and more
- ⏳ **Email Notifications** - Comment and post notifications
- ⏳ **Social Media Integration** - Share and connect features

**Legend:** ✅ Complete | 🚧 In Progress | ⏳ Planned

---

## 🛠️ Tech Stack

### Backend
- **[Laravel 12.0](https://laravel.com)** - PHP framework
- **[PHP 8.2+](https://php.net)** - Server-side language
- **[MySQL](https://mysql.com)** - Database (SQLite for development)
- **[Livewire 3.6](https://livewire.laravel.com)** - Dynamic interfaces

### Frontend
- **[Tailwind CSS 4.0](https://tailwindcss.com)** - Utility-first CSS framework
- **[Alpine.js 3.14](https://alpinejs.dev)** - Lightweight JavaScript framework
- **[Vite 6.0](https://vitejs.dev)** - Build tool and dev server

### Additional Libraries
- **[Intervention Image 3.11](https://image.intervention.io)** - Image processing
- **[SortableJS 1.15](https://sortablejs.github.io/Sortable/)** - Drag & drop functionality
- **[Tailwind Plugins](https://tailwindcss.com/docs/plugins)** - Forms, Typography, Aspect Ratio

---

## 🚀 Installation Guide

### 📋 Prerequisites

Ensure you have the following installed on your system:

- **PHP 8.2 or higher**
- **Composer**
- **Node.js 18+ & npm**
- **Git**
- **Database** (MySQL recommended, SQLite for development)

---

### 🪟 Windows Installation

#### Step 1: Install Dependencies

1. **Install PHP**: Download from [php.net](https://windows.php.net/download) or use [XAMPP](https://www.apachefriends.org/)
2. **Install Composer**: Download from [getcomposer.org](https://getcomposer.org/download/)
3. **Install Node.js**: Download from [nodejs.org](https://nodejs.org/)
4. **Install Git**: Download from [git-scm.com](https://git-scm.com/)

#### Step 2: Clone & Setup

```powershell
# Clone the repository
git clone https://github.com/yourusername/modern-blog.git
cd modern-blog

# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install

# Create environment file
copy .env.example .env

# Generate application key
php artisan key:generate

# Create SQLite database (or configure MySQL in .env)
php artisan migrate --seed

# Build assets
npm run build
```

#### Step 3: Run Development Server

```powershell
# Option 1: Use built-in Laravel server
php artisan serve

# Option 2: Use the comprehensive dev command (recommended)
composer run dev
```

---

### 🐧 Linux/Ubuntu Installation

#### Step 1: Install Dependencies

```bash
# Update system
sudo apt update && sudo apt upgrade -y

# Install PHP and extensions
sudo apt install php8.2 php8.2-cli php8.2-fpm php8.2-mysql php8.2-zip php8.2-gd php8.2-mbstring php8.2-curl php8.2-xml php8.2-bcmath -y

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install Node.js
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt-get install -y nodejs

# Install MySQL (optional)
sudo apt install mysql-server -y
```

#### Step 2: Clone & Setup

```bash
# Clone the repository
git clone https://github.com/yourusername/modern-blog.git
cd modern-blog

# Set permissions
sudo chown -R $USER:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate --seed

# Build assets
npm run build
```

#### Step 3: Run Development Server

```bash
# Option 1: Simple server
php artisan serve --host=0.0.0.0 --port=8000

# Option 2: Full development environment
composer run dev
```

---

### 🍎 macOS Installation

#### Step 1: Install Dependencies

```bash
# Install Homebrew (if not already installed)
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"

# Install PHP
brew install php@8.2

# Install Composer
brew install composer

# Install Node.js
brew install node

# Install MySQL (optional)
brew install mysql
brew services start mysql
```

#### Step 2: Clone & Setup

```bash
# Clone the repository
git clone https://github.com/yourusername/modern-blog.git
cd modern-blog

# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate --seed

# Build assets
npm run build
```

#### Step 3: Run Development Server

```bash
# Simple development server
php artisan serve

# Full development environment with hot reload
composer run dev
```

---

## ⚙️ Configuration

### Database Configuration

1. **For SQLite** (default, no setup required):
   ```env
   DB_CONNECTION=sqlite
   ```

2. **For MySQL**:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=modern_blog
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

### Environment Variables

Key environment variables to configure:

```env
APP_NAME="Modern Blog"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Mail Configuration (for notifications)
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
```

---

## 🔧 Development Commands

```bash
# Start development environment (all services)
composer run dev

# Individual commands
php artisan serve              # Start Laravel server
npm run dev                    # Start Vite dev server
php artisan queue:work         # Process background jobs
php artisan pail              # View logs

# Database commands
php artisan migrate:fresh --seed   # Reset database
php artisan db:seed --class=PostSeeder  # Seed specific data

# Cache commands
php artisan optimize:clear     # Clear all caches
php artisan view:cache        # Cache views for production
```

---

## 🐛 Known Issues & Limitations

### Current Issues
- ⚠️ **Tailwind CSS 4.0 Compatibility**: Some utility classes may not work correctly
- ⚠️ **Image Upload**: Large file uploads may timeout on some servers
- ⚠️ **Complex Filters**: Performance optimization needed for large datasets
- ⚠️ **Mobile Navigation**: Minor UI glitches on smaller screens

### Incomplete Features
- 🚧 **Email Notifications** - Backend ready, templates in progress
- 🚧 **SEO Features** - Basic structure exists, needs enhancement
- 🚧 **Admin Dashboard** - User management partially implemented
- 🚧 **API Endpoints** - Not yet implemented for mobile app integration

### Performance Notes
- Database queries are not fully optimized for large datasets
- Image processing may be slow for high-resolution uploads
- Frontend bundle size could be optimized further

---

## 📝 Usage

### Default Accounts
After running `php artisan migrate --seed`:

**Admin Account:**
- Email: `admin@example.com`
- Password: `password`

**User Account:**
- Email: `user@example.com`
- Password: `password`

### Quick Start Guide

1. **Login** with admin account
2. **Create Categories** (e.g., Technology, Lifestyle, Travel)
3. **Add Tags** (e.g., php, laravel, web-development)
4. **Write Your First Post** with images and content
5. **Test Comments** by switching between user accounts

---

## 🤝 Contributing

We welcome contributions! Here's how you can help:

1. **Fork the repository**
2. **Create a feature branch** (`git checkout -b feature/amazing-feature`)
3. **Commit your changes** (`git commit -m 'Add amazing feature'`)
4. **Push to the branch** (`git push origin feature/amazing-feature`)
5. **Open a Pull Request**

### Development Guidelines
- Follow PSR-12 coding standards for PHP
- Use conventional commit messages
- Write tests for new features
- Update documentation for significant changes

---

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

## 🙏 Acknowledgments

- **Laravel Team** for the amazing framework
- **Tailwind CSS** for the utility-first CSS framework
- **Alpine.js** for lightweight reactivity
- **Livewire** for seamless PHP/JavaScript integration

---

<div align="center">

### 🌟 Star this repository if you find it helpful!

**Made with ❤️ and lots of ☕**

</div>

