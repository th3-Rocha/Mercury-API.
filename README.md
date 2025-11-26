# Mercury API

Mercury API is a modern RESTful backend built with Laravel.
It provides a complete and scalable structure for managing products and services, including:

- Authentication with Laravel Sanctum
- API versioning
- Automated testing with PHPUnit
- Structured documentation using Swagger and Laravel API Resources

---

## Features

- Full REST API structure (Controllers, Services, Repositories)
- Token-based authentication (Sanctum)
- MySQL database running on Docker
- Nginx + PHP-FPM container setup
- Ready for production or local development

---

## Requirements

- Docker and Docker Compose installed

---

## Environment Setup

The application runs inside Docker containers:

- **mercury-php** – Laravel runtime
- **mercury-nginx** – Web server
- **mercury-mysql** – Database

All services are defined in `docker-compose.yml`.

---

## How to Run the Project

Follow the steps below to start the environment and prepare the Laravel application.

### 1. Start Docker containers

```bash
docker compose up -d
```

### 2. Generate the Laravel application key

```bash
docker compose exec php php artisan key:generate
```

### 3. Run database migrations

```bash
docker compose exec php php artisan migrate:fresh
```

---

## API URL

Once the environment is running, the API will be available at:

```
http://localhost:8080/api
```

Example request:

```
GET http://localhost:8080/api/health-check
```

---

## Project Structure

```
docker/
  nginx/
  php/
src/
  app/
  bootstrap/
  config/
  database/
  routes/
  tests/
.env
docker-compose.yml
```

---

## Useful Docker Commands

Stop all containers:

```bash
docker compose down
```

Restart containers:

```bash
docker compose restart
```

Enter the PHP container:

```bash
docker compose exec php bash
```

---

## License

This project is open-source and available under the MIT License.
