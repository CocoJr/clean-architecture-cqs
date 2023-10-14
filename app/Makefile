test: export APP_ENV = test
test-coverage: export APP_ENV = test

init:
	composer install
	yarn install
	npm run build

cs-fixer:
	vendor/bin/php-cs-fixer fix

stan:
	vendor/bin/phpstan

deptrac:
	php deptrac.phar

init-test:
	php bin/console doctrine:database:drop --force --if-exists
	php bin/console doctrine:database:create
	php bin/console doctrine:schema:update -f --complete
	rm -rf var/cache/*

test: init-test
	vendor/bin/phpunit

test-coverage: init-test
	vendor/bin/phpunit --coverage-html public/coverage/