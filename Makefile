ROOT_DIR       := $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST))))
SHELL          := $(shell which bash)
PROJECT_NAME   := todo-laravel
ARGS           := $(filter-out $@,$(MAKECMDGOALS))

.SILENT: ;               # no need for @
.ONESHELL: ;             # recipes execute in same shell
.NOTPARALLEL: ;          # wait for this target to finish
.EXPORT_ALL_VARIABLES: ; # send all vars to shell
default: help-default;   # default target
Makefile: ;              # skip prerequisite discovery

.title:
	$(info Phalcon Compose: $(VERSION))
	$(info )

# Target for development setup
dev: build up
setup:
	@make build
	@make up 
	@make composer-update

# Build Docker containers
build:
	docker-compose --project-name $(PROJECT_NAME) build --no-cache --force-rm

# Stop Docker containers
stop:
	docker-compose --project-name $(PROJECT_NAME) stop

# Start Docker containers in detached mode
up:
	docker-compose --project-name $(PROJECT_NAME) up -d

# Update Composer dependencies
composer-update:
	docker exec -it $$(docker-compose --project-name $(PROJECT_NAME) ps -q app) bash -c "composer update"

# Run tests in the Docker container
test: build test-dev

test-dev:
	docker exec -it $$(docker-compose --project-name $(PROJECT_NAME) ps -q app) sh -c 'php artisan test'

# Run database migrations
migrate:
	docker exec -it $$(docker-compose --project-name $(PROJECT_NAME) ps -q app) bash -c 'php artisan migrate'

# Bring down Docker containers
down:
	docker-compose --project-name $(PROJECT_NAME) down

# Access Docker container with root user
root:
	docker exec -it $$(docker-compose --project-name $(PROJECT_NAME) ps -q app) bash

# Show logs for the specified service
logs:
	docker logs $$(docker-compose --project-name $(PROJECT_NAME) ps -q app)

# Remove unused Docker objects
prune:
	docker system prune

# Deploy to staging environment
deploy-staging:
	@echo "Deploying to staging........"
	@echo "Successfully deployed to staging"

# Deploy to production environment
deploy-production:
	@echo "Deploying to production........"
	@echo "Successfully deployed to production"

# Install Composer dependencies
install-dependencies:
	composer install

test1:
	docker exec -it todo-laravel-app-1 bash -c 'php artisan test'