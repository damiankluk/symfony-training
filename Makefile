build:
	docker compose build
up:
	docker compose up -d
bash:
	docker exec -it symfony-training-php-1 bash
composer-install:
	docker exec -it symfony-training-php-1 composer install