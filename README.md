
# Skaalab Challenge PHP Laravel

This API provides a complete solution for managing products and categories for an e-commerce platform. It is built using Laravel, with features such as product CRUD, category association, filtering, soft deletes, text search, event notifications, and token-based authentication. Additionally, it includes Swagger documentation and Docker support.

## Features
1. **Product CRUD** - Create, read, update, and delete products.
2. **Category Association** - Assign products to multiple categories.
3. **Filtering and Sorting** - Filter and sort products by name, price, and category.
4. **Soft Deletes** - Allows logical deletion of products.
5. **Text Search** - Search products by name or description.
6. **Event Logging** - Logs product creation and updates for admin.
7. **Low Stock Notification** - Email notification for products with stock below 10 units.
8. **Authentication** - Token-based authentication using Laravel Sanctum.
9. **Request Middleware** - Logs request counts by endpoint.
10. **API Documentation** - Documented with Swagger for easy interaction and testing.

## Installation and Setup

1. **Clone the Repository**:
    ```bash
    git clone git@github.com:hassen66/Skaalab-Challenge-PHP-Laravel.git
    cd Skaalab-Challenge-PHP-Laravel
    ```

2. **Set Up Environment Variables**:
    Copy `.env.example` to `.env` and update necessary configurations.
    ```bash
    cp .env.example .env
    ```

3. **Install Dependencies**:
    ```bash
    composer install
    npm install
    npm run dev
    ```

4. **Generate Application Key**:
    ```bash
    php artisan key:generate
    ```

5. **Run Migrations and Seed Database**:
    ```bash
    php artisan migrate --seed
    ```

6. **Serve the Application**:
    ```bash
    php artisan serve
    ```

## Running with Docker

Ensure Docker and Docker Compose are installed. Then run:
```bash
docker-compose up -d
```

## API Documentation

Access Swagger documentation at `/api/documentation` when running the application.

## Running Tests

To run unit and feature tests:
```bash
php artisan test
```

## Usage

1. **Register and Login**: Register a new user and obtain an authentication token.
2. **CRUD Operations**: Use the provided endpoints to manage products and categories.
3. **Search and Filter**: Filter and search products by criteria.

## License
This project is open-sourced under the MIT License.