dev: build up
setup:
	@make build
	@make up 
	@make composer-update
build:
	docker-compose build --no-cache --force-rm
stop:
	docker-compose stop
up:
	docker-compose up -d
composer-update:
	docker exec todo-laravel bash -c "composer update"

test: build test-dev

test-dev:
	docker exec -it todo-laravel bash -c 'php artisan test'
	
migrate:
	php artisan migrate
down:
	docker compose down
root:
	docker exec -it todo-laravel bash
logs:
	docker logs todo-laravel 
prune:
	docker system prune

deploy-staging:
	@echo "Deploying to staging........"
	@echo "Successfully deployed to staging"

deploy-prodoction:
	@echo "Deploying to production........"
	@echo "Successfully deployed to production"

install-dependencies:
	composer install