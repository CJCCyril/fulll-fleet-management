DOCKER_COMP = docker compose

PHP_CONT = $(DOCKER_COMP) exec fulll-fleet-management-php

COMPOSER = $(PHP_CONT) composer

SYMFONY = $(PHP_CONT) bin/console

help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z0-9\./_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

## -- Docker ------------------------

build: ## Build the docker images
	@$(DOCKER_COMP) build --pull --no-cache

up: ## Start the docker hub
	@$(DOCKER_COMP) up --detach --force-recreate --wait --remove-orphans

down: ## Stop the docker hub
	@$(DOCKER_COMP) down --remove-orphans

bash: ## Connect to the php container
	@$(PHP_CONT) bash

first-start: build up ## Runs build up composer ci
	@$(MAKE) composer c=install
	@$(MAKE) database
	@$(MAKE) database-test
	@$(MAKE) ci

kill-it-with-fire: down ## Use with caution: Cleanup all docker elements
	docker system prune -a --volumes

## -- Composer ------------------------

composer: ## Runs compose | Usage: make composer c=[command] | Example: make composer c=install
	@$(eval c ?=)
	@$(COMPOSER) $(c)

## -- CI ------------------------

phpunit: ## Runs PhpUnit tests
	@$(eval c ?=)
	@$(PHP_CONT) vendor/bin/phpunit $(c)

behat: ## Runs behat tests
	@$(eval c ?=)
	@$(PHP_CONT) vendor/bin/behat $(c)

phpcs: ## Runs PHP CodeSniffer
	@$(eval c?=)
	@$(PHP_CONT) vendor/bin/phpcs $(c)

phpstan: ## Runs PhpStan
	@$(eval c?=)
	@$(PHP_CONT) vendor/bin/phpstan $(c)

phpmd: ## Runs php mess detector
	@$(PHP_CONT) vendor/bin/phpmd src,tests text phpmd.xml --suffixes php

ci: phpunit behat phpcs phpstan phpmd ## Runs phpunit behat phpcs phpstan phpmd

## -- Application ------------------------

sf: ## Runs sf console, Usage: make sf c=[command] | Example: make sf c=list
	@$(eval c ?=)
	@$(SYMFONY) $(c)

database: ## Create the database
	@$(SYMFONY) doctrine:database:drop --if-exists --force
	@$(SYMFONY) doctrine:database:create
	@$(SYMFONY) doctrine:schema:create

database-test:
	@$(SYMFONY) doctrine:database:drop --if-exists --force --env=test
	@$(SYMFONY) doctrine:database:create --env=test
	@$(SYMFONY) doctrine:schema:create --env=test

## -- Application - Fleet ------------------------

fleet-create: ## Create a new fleet | Usage: make fleet-create userId=[userId] | Example: make fleet-create userId=JohnDoe
	@$(eval userId ?=)
	@$(SYMFONY)	fleet:create $(userId)

fleet-register-vehicle: ## Create or find and register a vehicle into the fleet | Usage: make fleet-register-vehicle fleetId=[fleetId] vehiclePlateNumber=[vehiclePlateNumber] | Example: make fleet-register-vehicle fleetId=1 vehiclePlateNumber=GG-123-WP
	@$(eval fleetId ?=)
	@$(eval vehiclePlateNumber ?=)
	@$(SYMFONY)	fleet:register-vehicle $(fleetId) $(vehiclePlateNumber)

fleet-park-vehicle: ## Park a vehicle to a location | Usage: make fleet-park-vehicle vehiclePlateNumber=[vehiclePlateNumber] lat=[lat] lng=[lng] (alt=[alt])| Example: make fleet-park-vehicle vehiclePlateNumber=GG-123-WP lat=43.455252 lng=5.475261
	@$(eval vehiclePlateNumber ?=)
	@$(eval lat ?=)
	@$(eval lng ?=)
	@$(eval alt ?=)
	@$(SYMFONY)	fleet:park-vehicle $(vehiclePlateNumber) $(lat) $(lng) $(alt)
