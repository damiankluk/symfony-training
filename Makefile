build:
	docker compose build
up:
	docker compose up -d
bash:
	docker exec -it symfony-training-php-1 bash
composer-install:
	docker exec -it symfony-training-php-1 composer install
phpunit:
	docker exec -it symfony-training-php-1 ./vendor/bin/phpunit
phpstan:
	docker exec -it symfony-training-php-1 ./vendor/bin/phpstan analyse
php-cs-fixer:
	docker exec -it symfony-training-php-1 ./vendor/bin/php-cs-fixer fix
tools: php-cs-fixer phpstan phpunit