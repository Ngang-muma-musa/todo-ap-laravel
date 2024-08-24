# Laravel Todo App

## Overview

This Laravel application is designed to manage todos and items with user authentication and CRUD operations. The project uses Docker for containerization and a `Makefile` to simplify common tasks.

## Features

- **User Authentication**: Register, login, and logout functionality.
- **Todo Management**: CRUD operations for todos.
- **Item Management**: CRUD operations for items associated with todos.
- **Repository Pattern**: Organized data access through repository interfaces and implementations.
- **API Resources**: Consistent response formatting using Laravel API resources.

## Requirements

- PHP 8.2 or higher
- Composer
- Docker and Docker Compose

## Installation

### Clone the Repository

```bash
git clone https://github.com/your-username/your-repository.git
cd your-repository

Set Up the Project
Use the make commands to set up and manage the project. Ensure Docker and Docker Compose are installed.

make setup

Environment Configuration
Copy the .env.example file to .env and adjust the configuration as needed.

cp .env.example .env


cp .env.example .env

Generating Application Key

make root
# Inside the container, run:
php artisan key:generate

make root
# Inside the container, run:
php artisan key:generate


Make Commands
Here are the make commands available for managing the project:

make build: Build Docker containers.
make up: Start Docker containers in detached mode.
make stop: Stop Docker containers.
make down: Bring down Docker containers and remove orphans.
make composer-update: Update Composer dependencies.
make migrate: Run database migrations.
make test: Run tests in the Docker container.
make logs: Show logs for the application service.
make root: Access Docker container with root user.
make prune: Remove unused Docker objects.
make deploy-staging: Deploy to staging environment.
make deploy-production: Deploy to production environment.
make install-dependencies: Install Composer dependencies.
make test1: Run tests inside the app container.

Example Usage
Build and Start Containers

make dev
