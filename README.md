# Todo Laravel Project

## Overview

This project is a Todo application built with Laravel and Docker. It features user authentication, CRUD operations for todos and items, and uses repositories for data access. The application is containerized using Docker Compose.

## Features

- User registration and login
- CRUD operations for todos and items
- Soft deletes for todos and items
- Custom exception handling
- Automated testing with PHPUnit

## Technologies Used

- **Laravel**: PHP framework for building web applications.
- **Docker**: Containerization platform to manage the application's environment.
- **MySQL**: Database management system.
- **phpMyAdmin**: Web-based database management tool.

## Installation

### Prerequisites

- Docker
- Docker Compose

### Setup
Start project

`make dev   `

Build Docker Containers

`make build`

Start Docker Containers

`make up`

Install Composer Dependencies

`make install-dependencies`

Run Migrations

`make migrate`


Available Commands


`Build Docker containers: make build`
`Start Docker containers in detached mode: make up`
`Stop Docker containers: make stop`
`Update Composer dependencies: make composer-update`
`Run tests: make test`
`Run database migrations: make migrate`
`Bring down Docker containers: make down`
`Access Docker container with root user: make root`
`Show logs for the specified service: make logs`
`Remove unused Docker objects: make prune`
`Deploy to staging: make deploy-staging`
`Deploy to production: make deploy-production`

Testing
To run tests, ensure that Docker containers are up and then execute:

make test


API Endpoints
User Registration: POST /api/v1/register

User Login: POST /api/v1/login

Create Todo: POST /api/v1/users/{userId}/todos

Get Todos: GET /api/v1/users/{userId}/todos

Update Todo: PUT /api/v1/todos/{todoId}

Delete Todo: DELETE /api/v1/todos/{todoId}

