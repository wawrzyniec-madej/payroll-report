#Infrastructure

.PHONY: up
up:
	docker compose up -d

.PHONY: down
down:
	docker compose down

.PHONY: restart
restart:
	$(MAKE) down
	$(MAKE) up

.PHONY: bash-nginx
bash-nginx:
	docker compose exec -it nginx bash

.PHONY: bash
bash:
	USER="$$(id -u):$$(id -g)" docker compose exec -it php-fpm bash

#Utility

.PHONY: phpstan
phpstan:
	USER="$$(id -u):$$(id -g)" docker compose exec -it php-fpm vendor/bin/phpstan

.PHONY: deptrac
deptrac:
	USER="$$(id -u):$$(id -g)" docker compose exec php-fpm vendor/bin/deptrac --config-file=deptrac/layers.yaml --fail-on-uncovered --report-uncovered
	USER="$$(id -u):$$(id -g)" docker compose exec php-fpm vendor/bin/deptrac --config-file=deptrac/modules.yaml --fail-on-uncovered --report-uncovered

.PHONY: cs-fix
cs-fix:
	USER="$$(id -u):$$(id -g)" docker compose exec -it php-fpm vendor/bin/php-cs-fixer fix --config=php-cs-fixer.php --allow-risky=yes

.PHONY: test-acceptance
test-acceptance:
	$(MAKE) recreate-test-database
	USER="$$(id -u):$$(id -g)" docker compose exec php-fpm bin/phpunit --testsuite "Acceptance"

.PHONY: test-unit
test-unit:
	USER="$$(id -u):$$(id -g)" docker compose exec php-fpm bin/phpunit --testsuite "Unit"

.PHONY: identifier
identifier:
	USER="$$(id -u):$$(id -g)" docker compose exec php-fpm bin/console app:generate:identifier

.PHONY: recreate-test-database
recreate-test-database:
	USER="$$(id -u):$$(id -g)" docker compose exec php-fpm bin/console doctrine:database:drop --force --if-exists --env=test
	USER="$$(id -u):$$(id -g)" docker compose exec php-fpm bin/console doctrine:database:create -n --env=test
	USER="$$(id -u):$$(id -g)" docker compose exec php-fpm bin/console doctrine:migrations:migrate -n --allow-no-migration --env=test

.PHONY: recreate-database
recreate-database:
	USER="$$(id -u):$$(id -g)" docker compose exec php-fpm bin/console doctrine:database:drop --force --if-exists --env=dev
	USER="$$(id -u):$$(id -g)" docker compose exec php-fpm bin/console doctrine:database:create -n --env=dev
	USER="$$(id -u):$$(id -g)" docker compose exec php-fpm bin/console doctrine:migrations:migrate -n --allow-no-migration --env=dev

.PHONY: composer-install
composer-install:
	USER="$$(id -u):$$(id -g)" docker compose exec php-fpm composer install

.PHONY: setup
setup:
	$(MAKE) up
	$(MAKE) composer-install
	$(MAKE) recreate-database
	$(MAKE) tests

.PHONY: tests
tests:
	$(MAKE) phpstan
	$(MAKE) deptrac
	$(MAKE) test-unit
	$(MAKE) test-acceptance
