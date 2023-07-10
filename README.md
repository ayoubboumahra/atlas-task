# Project Name

This is a Laravel project with Vue.js and Laravel Passport integration.

## Description

Atlas Task

## Installation

### Prerequisites

List the prerequisites for running the project, such as:

- PHP (version ^7.3|^8.0)
- Composer (version 2.2.18)
- Node.js (version 18.13.0)
- NPM (version 8.19.3)

### Steps

1. Clone the repository:

   ```bash
   git clone https://github.com/ayoubboumahra/atlas-task.git

2. Install PHP dependencies:
    ```bash
    composer install

3. Install JavaScript dependencies:

    ````bash
    npm install

4. Create a copy of the .env.example file and rename it to .env.

5. Generate an application key:

    ````bash
    php artisan key:generate

6. Run database migrations:

    ````bash
    php artisan migrate --seed

7. Install Laravel Passport:

    ````bash
    php artisan passport:install

8. Compile assets:

    ````bash
    npm run dev

9. Start the development server:

    ````bash
    php artisan serve

Finaly Visit http://localhost:8000 in your browser to see the application.
