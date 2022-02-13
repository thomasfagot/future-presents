include .env

DC_COMMAND=sudo ${COMPOSE_COMMAND}

all: help

help:
	@echo ''
	@echo 'Usage: make [TARGET]'
	@echo 'Targets:'
	@echo '  build              Construit les images'
	@echo '  assets             Construit les assets de production'
	@echo '  serve              Lance le serveur avec les assets de développement'
	@echo '  start              Démarre les containers'
	@echo '  stop               Stoppe les containers'
	@echo '  down               Stoppe et détruit les containers'
	@echo '  pull               Recupère les dernières versions des images utilisées'
	@echo '  logs               Affiche les logs en direct'
	@echo '  bash               Ouvre un bash dans le container app'
	@echo '  ccw                Efface et initialise le cache'

check-dev: .env
ifeq ($(APP_ENV), dev)
	@echo "Check OK | APP_ENV=$(APP_ENV)"
else
	$(error APP_ENV is not set to "dev")
endif

# ~ Docker-Compose
check:
	@command -v $(DC_COMMAND) > /dev/null

build: check
	$(DC_COMMAND) build

start: check
	$(DC_COMMAND) up -d

stop: check
	$(DC_COMMAND) stop

down: check
	$(DC_COMMAND) down

pull: check
	$(DC_COMMAND) pull

logs: check
	$(DC_COMMAND) logs -f

# Commande $(DC_COMMAND) classique
dc: check
	$(DC_COMMAND) ${DC_ARGS}

# ~ Docker & Symfony
bash: check
	$(DC_COMMAND) exec --workdir="/var/www/html" -u docker app bash

ccw: check
	$(DC_COMMAND) exec --workdir="/var/www/html/api" -u docker app bash -c 'php bin/console c:c && php bin/console c:w'

assets: check
	$(DC_COMMAND) exec --workdir="/var/www/html" -u docker app bash -c 'npm run build'

serve: check-dev
	$(DC_COMMAND) exec --workdir="/var/www/html" -u docker app bash -c "npm run serve --port=${VUE_PORT || 8080}"

# Aliases
up: start

# Pour permettre d'utiliser dynamiquement `make dc`
# Source : https://stackoverflow.com/a/14061796
# If the first argument is "dc"...
ifeq (dc,$(firstword $(MAKECMDGOALS)))
  # use the rest as arguments for "dc"
  DC_ARGS := $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))
  # ...and turn them into do-nothing targets
  $(eval $(DC_ARGS):;@:)
endif