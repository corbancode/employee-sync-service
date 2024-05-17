## Employee Sync Service

Employee Sync Service receive empoyee information from multiple providers and syncs to Tracktik's API

### Requirements

-   **PHP**: 8.2 or higher.
-   **Composer**

### Installation and Configuration

#### Setup

-   Create a .env file from the .env.example file with this command `cp .env.example .env`.
-   Update your database credentials in your `.env`.
-   Run `composer install` to install dependencies.
-   Run `php artisan key:generate` to generate a new app key if none is created.
-   Run `php artisan migrate` to database migrations.

#### Running Development Server

-   Run `php artisan serve` to start the development server
-   Because some operations are queued, you need to run `php artisan queue:work`.
-   You can now access the server on your localhost e.g `http://localhost:{APP_PORT}`

#### Test create and update event endpoint

-  Test create event

```
POST -> {{base-url}}/api/employees/{provider}/create
{
  "firstname": "Ayomide",
  "lastname": "Olakulehin"
}
```

-   Test update event

```
POST -> {{base-url}}/api/employees/{provider}/update
{
  "firstname": "Ayomide",
  "lastname": "Olakulehin"
}
```
