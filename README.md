<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Project Name
Descripcion del proyecto

## Descripción y contexto
Ej: API Backend. Swagger Interface.

## API Reference
- {url}/api/documentation
  
## Authors
- [@j-reyes132](https://www.github.com/j-reyes132)

## Deployment 
- Configurar variables de entorno en archivo .env
- composer install
- php artisan key:generate
- php artisan migrate:refresh --seed
- php artisan passport:install

## Librerias y Requerimientos
- PHP 7.4
- DarkaOnline: l5-swagger
- Laravel: FrameWork 8.54
- Laravel: Passport 10.1
- Laravel: Sanctum 2.11
## Environment Variables

#### APP VARIABLES
- APP_NAME={APP_NAME}
- APP_ENV={local}|{production}
- APP_KEY={base64Key}
- APP_DEBUG={true}|{false}
- APP_URL={API_URL}

#### DATABASE CONNECTION
- DB_CONNECTION=mysql
- DB_HOST={DB_HOST}
- DB_PORT={DB_PORT}
- DB_DATABASE={DB_NAME}
- DB_USERNAME={DB_USERNAME}
- DB_PASSWORD={DB_PASSWORD}

#### SWAGGER DOCUMENTATION
- L5_SWAGGER_GENERATE_ALWAYS=true

#### GOOGLE CLOUD STORAGE
- GOOGLE_CLOUD_ENABLE={true}|{false}
- GOOGLE_CLOUD_FOLDER={FOLDER_NAME}
- GOOGLE_CLOUD_PROJECT_ID={PROJECT_ID}
- GOOGLE_CLOUD_KEY_FILE='../google_credentials.json'
- GOOGLE_CLOUD_STORAGE_BUCKET={BUCKET_NAME}

#### TOKEN SECRET
- TOKEN_SECRET={TOKEN_SECRET}

#### PASSPORT KEYS
- PASSPORT_PRIVATE_KEY={PRIVATE_KEY}
- PASSPORT_PUBLIC_KEY={PUBLIC_KEY}

#### EMAIL CONFIGURATION FOR SENDING NOTIFICATIONS
- MAIL_MAILER=smtp
- MAIL_HOST={SMTP_HOST}
- MAIL_PORT={SMTP_PORT}
- MAIL_USERNAME={SMTP_USER_NAME}
- MAIL_PASSWORD={SMTP_PASSWORD}
- MAIL_ENCRYPTION="TLS"
- MAIL_FROM_ADDRESS={FROM_EMAIL}
- MAIL_FROM_NAME="${APP_NAME}"

  
## Tech Stack

**API** Laravel|Passport|OA2

**Server:** NGINX, Ubuntu 20.04LTS

