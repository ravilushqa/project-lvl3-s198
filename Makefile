test:
	phpunit tests
install:
	composer install
run:
	php -S localhost:8000 -t public
logs:
	tail -f storage/logs/lumen.log

lint:
	composer run-script phpcs -- --standard=PSR2 app tests
lint-fix:
	composer run-script phpcbf -- --standard=PSR2 app tests