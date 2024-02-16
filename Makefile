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

.PHONY: build
build:
	docker compose build

#Utility

.PHONY: phpstan
phpstan:
	docker compose exec -it php-fpm vendor/bin/phpstan

.PHONY: deptrac
deptrac:
	docker compose exec php-fpm \
    	vendor/bin/deptrac --config-file=deptrac/layers.yaml --fail-on-uncovered --report-uncovered

.PHONY: system
system:
	docker compose exec php-fpm bin/phpunit --testsuite "System"

.PHONY: unit
unit:
	docker compose exec php-fpm bin/phpunit --testsuite "Unit"

.PHONY: recreate-database
recreate-database:
	docker compose exec php-fpm bin/console doctrine:database:drop --force --if-exists
	docker compose exec php-fpm bin/console doctrine:database:create -n
	docker compose exec php-fpm bin/console doctrine:migrations:migrate -n --allow-no-migration

.PHONY: install
install:
	docker compose run composer install

.PHONY: tests
tests:
	$(MAKE) stan
	$(MAKE) deptrac
	$(MAKE) recreate-database
	$(MAKE) unit
	$(MAKE) functional
