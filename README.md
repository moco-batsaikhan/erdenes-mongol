# Erdenes mongol

It's a document of Erdenes mongol web system

## Системийн шаардлага

- PHP 8.1+
- MySQL 8.0+
- Composer
- Node.js & NPM

## Анхны суулгалт

### 1. PHP Dependencies суулгах

```bash
composer install
```

### 2. Орчны тохиргоо (.env.local файл үүсгэх)

```bash
# .env.local файл үүсгээд доорх тохиргоог оруулна:

APP_ENV=dev
APP_SECRET=ThisIsNotSecureChangeItInProduction123456
ALLOWED_DOMAINS="localhost,127.0.0.1"

# Database тохиргоо (өөрийн database credentials оруулна)
DATABASE_URL="mysql://root:@127.0.0.1:3306/erdenes_mongol?serverVersion=8.0&charset=utf8mb4"

BASE_URL=
FRONT_URL=

IMAGE_PATH='/uploads/images'
PDF_PATH='/uploads/pdf'
IMAGE_PREFIX='/uploads'
```

### 3. Database үүсгэх ба migration ажиллуулах

```bash
# Database үүсгэх
php bin/console doctrine:database:create

# Migration ажиллуулах
php bin/console doctrine:migrations:migrate
```

### 4. CKEditor болон Assets суулгах

```bash
php bin/console ckeditor:install
php bin/console assets:install public
php bin/console elfinder:install
```

**Анхаарах:** CKeditor Asset ажиллуулсны дараа `public/assets/ckeditor.js` файлыг `public/bundles/fosckeditor/ckeditor.js`-д дарж хуулна.

### 5. Frontend Dependencies суулгах

```bash
# NPM packages суулгах
npm install --legacy-peer-deps

# Webpack Encore болон бусад dependencies суулгах
npm install @symfony/webpack-encore @babel/core @babel/preset-env webpack-cli --save-dev --legacy-peer-deps

# Assets build хийх
npm run dev

# Эсвэл production бүтээгдэхүүн build хийх
npm run build
```

### 6. Development Server асаах

```bash

symfony serve

# Эсвэл PHP built-in server ашиглан
php -S localhost:8000 -t public/


```

Системд нэвтрэх хаяг: http://localhost:8000

## Development Commands

### User үүсгэх

```bash
composer require symfony/security-bundle
php bin/console make:user
php bin/console make:migration
php bin/console doctrine:migrations:migrate
php bin/console make:auth
```

### Email Verification

```bash
composer require symfonycasts/verify-email-bundle
php bin/console make:registration-form
```

### Google Mailer

```bash
composer require symfony/google-mailer
```

### Entity үүсгэх

```bash
php bin/console make:entity
```

### Cache цэвэрлэх

```bash
php bin/console cache:clear
```

### Assets build (development)

```bash
npm run dev
```

### Assets build (production)

```bash
npm run build
```

### Assets watch mode

```bash
npm run watch
```

# Erdenes mongol

It's a document of Erdenes mongol web system

## Development Guide

0. $ composer require symfony/security-bundle
1. $ php bin/console make:user
2. $ php bin/console make:migration
3. $ php bin/console doctrine:migrations:migrate
4. $ php bin/console make:auth
5. $ composer require symfonycasts/verify-email-bundle
6. $ php bin/console make:registration-form
7. $ composer require symfony/google-mailer
8. $ php bin/console make:entity

php bin/console ckeditor:install
php bin/console assets:install public
php bin/console elfinder:install

CKeditor Asset ajiluulsnii daraa public/assets/ckeditor.js file-g public/bundles/fosckeditor/ckeditor.js-d darj huulna uu.
