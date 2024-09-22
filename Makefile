DOCKER_COMP = docker compose

PHP_CONT = $(DOCKER_COMP) exec fulll-fleet-management-php

COMPOSER = $(PHP_CONT) composer

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
	@$(MAKE) ci

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
	@$(PHP_CONT) bin/console $(c)
