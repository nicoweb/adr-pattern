DOCKER_COMPOSE  = docker-compose
DOCKER = docker

SYMFONY         = bin/console
COMPOSER        = composer
YARN            = yarn

## Connect into the PHP running container
ssh-php:
	$(DOCKER_COMPOSE) exec php bash

## Connect into the PHP running container
ssh-db:
	$(DOCKER_COMPOSE) exec db bash

## Install and start the project
install: build composer-install yarn webpack-encore db-install migration-migrate result-downloader

start: # Start containers (technical task)
	@echo "${BLUE}Starting containers...${RESET}"
	$(DOCKER) volume create db-volume
	$(DOCKER_COMPOSE) up -d --build --remove-orphans

destroy-containers: confirm_destructive ##@docker 💣  Destroy docker's containers
	$(DOCKER_COMPOSE) down --remove-orphans
	$(DOCKER) volume rm db-volume node-volume

## Run docker-compose pull && build
build:
	$(DOCKER_COMPOSE) pull --quiet --ignore-pull-failures 2> /dev/null
	$(DOCKER_COMPOSE) build

## Run docker-compose up
up:
	$(DOCKER_COMPOSE) up -d --remove-orphans --no-recreate

## Remove docker containers
stop:
	$(DOCKER_COMPOSE) kill
#	$(DOCKER_COMPOSE) rm -v --force

## Run composer install
composer-install: composer.lock
	$(COMPOSER) install -n

composer.lock: composer.json

## Run docker-compose kill && down
kill:
	$(DOCKER_COMPOSE) kill
	$(DOCKER_COMPOSE) down --volumes --remove-orphans

## Reset the database
db-clear:
	$(SYMFONY) doctrine:database:drop --if-exists --force
	$(MAKE) db-install

db-install:
	$(SYMFONY) doctrine:database:create --if-not-exists
	$(SYMFONY) doctrine:migrations:migrate --no-interaction --allow-no-migration
	$(SYMFONY) doctrine:schema:validate

## Clear the cache in dev env
cache-clear:
	$(SYMFONY) cache:clear --no-warmup

## Yarn Install
yarn:
	$(YARN) install

## Build Webpack Encore assets
webpack-encore:
	$(YARN) encore dev

## Creates a new migration based on database changes
migration-create:
	$(SYMFONY) make:migration -n

migration-migrate:
	$(SYMFONY) doctrine:migrations:migrate -n

result-downloader:
	$(SYMFONY) app:downloader

confirm_destructive:
	@echo "${RED}Do you really want to run this destructive command? [y/N] 💣${RESET}" && read ans && [ $${ans:-N} = y ]

## Help
help:
	@printf "${COLOR_TITLE_BLOCK}Makefile help${COLOR_RESET}\n"
	@printf "\n"
	@printf "${COLOR_COMMENT}Usage:${COLOR_RESET}\n"
	@printf " make [target]\n\n"
	@printf "${COLOR_COMMENT}Available targets:${COLOR_RESET}\n"
	@awk '/^[a-zA-Z\-\_0-9\@]+:/ { \
		helpLine = match(lastLine, /^## (.*)/); \
		helpCommand = substr($$1, 0, index($$1, ":")); \
		helpMessage = substr(lastLine, RSTART + 3, RLENGTH); \
		printf " ${COLOR_INFO}%-16s${COLOR_RESET} %s\n", helpCommand, helpMessage; \
	} \
	{ lastLine = $$0 }' $(MAKEFILE_LIST)

## Default command
.DEFAULT_GOAL := help

.PHONY: help ssh-php start build up stop composer-install kill db-clear db-install migration-create migration-migrate webpack-encore yarn cache-clear confirm_destructive result-downloader

# Perl Colors, with fallback if tput command not available
GREEN  := $(shell command -v tput >/dev/null 2>&1 && tput -Txterm setaf 2 || echo "")
BLUE   := $(shell command -v tput >/dev/null 2>&1 && tput -Txterm setaf 4 || echo "")
WHITE  := $(shell command -v tput >/dev/null 2>&1 && tput -Txterm setaf 7 || echo "")
YELLOW := $(shell command -v tput >/dev/null 2>&1 && tput -Txterm setaf 3 || echo "")
RED    := $(shell command -v tput >/dev/null 2>&1 && tput -Txterm setaf 1 || echo "")
RESET  := $(shell command -v tput >/dev/null 2>&1 && tput -Txterm sgr0 || echo "")
