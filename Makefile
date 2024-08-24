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
data:
	docker exec todo-laravel bash -c "php artisan migrate"
	docker exec todo-laravel bash -c "php artisan db:seed"
test:
	php artisan test
migrate:
	php artisan migrate