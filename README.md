# Geekpicker-backend

## Installation

### Clone the repository

    git clone https://github.com/sumoninfo/geekpicker-backend.git

### Switch to the repo folder

    cd geekpicker-backend

### Install all the dependencies using composer

    composer install

### Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

### Database configuration

    DB_DATABASE=your_database_name
    DB_USERNAME=your_user_name
    DB_PASSWORD=your_password

### Mail configuration

    MAIL_MAILER=
    MAIL_HOST=
    MAIL_PORT=
    MAIL_USERNAME=
    MAIL_PASSWORD=
    MAIL_ENCRYPTION=
    MAIL_FROM_ADDRESS=noreplay@example.com
    MAIL_FROM_NAME="${APP_NAME}"

### Generate a new application key & optimize clear

    php artisan key:generate
    php artisan o:c

### Create table & dummy data from seeder

    php artisan migrate --seed

### Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

