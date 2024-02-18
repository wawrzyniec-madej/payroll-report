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
	docker compose exec -it php-fpm bash

#Utility

.PHONY: phpstan
phpstan:
	docker compose exec -it php-fpm vendor/bin/phpstan

.PHONY: deptrac
deptrac:
	docker compose exec php-fpm vendor/bin/deptrac --config-file=deptrac/layers.yaml --fail-on-uncovered --report-uncovered
	docker compose exec php-fpm vendor/bin/deptrac --config-file=deptrac/modules.yaml --fail-on-uncovered --report-uncovered

.PHONY: cs-fix
cs-fix:
	docker compose exec -it php-fpm vendor/bin/php-cs-fixer fix --config=php-cs-fixer.php --allow-risky=yes

.PHONY: test-acceptance
test-acceptance:
	$(MAKE) recreate-test-database
	docker compose exec php-fpm bin/phpunit --testsuite "Acceptance"

.PHONY: test-unit
test-unit:
	docker compose exec php-fpm bin/phpunit --testsuite "Unit"

.PHONY: identifier
identifier:
	docker compose exec php-fpm bin/console app:generate:identifier

.PHONY: recreate-test-database
recreate-test-database:
	docker compose exec php-fpm bin/console doctrine:database:drop --force --if-exists --env=test
	docker compose exec php-fpm bin/console doctrine:database:create -n --env=test
	docker compose exec php-fpm bin/console doctrine:migrations:migrate -n --allow-no-migration --env=test

.PHONY: recreate-database
recreate-database:
	docker compose exec php-fpm bin/console doctrine:database:drop --force --if-exists --env=dev
	docker compose exec php-fpm bin/console doctrine:database:create -n --env=dev
	docker compose exec php-fpm bin/console doctrine:migrations:migrate -n --allow-no-migration --env=dev

.PHONY: composer-install
composer-install:
	docker compose exec php-fpm composer install

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
