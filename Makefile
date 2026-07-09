.PHONY: docker-init docker-network docker docker-exec yarn-format yarn-format-check yarn-install test test-verbose test-coverage phpstan phpstan-baseline composer-validate composer-audit composer-install-prod

docker-init:
	@if ! docker info > /dev/null 2>&1; then \
		echo "Docker is not running. Please start Docker and try again."; \
		exit 1; \
	fi

docker-network: docker-init
	@docker network inspect dev > /dev/null 2>&1 || docker network create dev

docker: docker-network
	docker compose up -d

docker-exec: docker
	docker compose exec dry-datalist-dev bash

yarn-format: docker
	docker compose exec -T dry-datalist-dev yarn prettier --write --ignore-unknown src

yarn-format-check: docker
	docker compose exec -T dry-datalist-dev yarn prettier --check --ignore-unknown src

yarn-install: docker
	docker compose exec -T dry-datalist-dev yarn install

test: docker
	docker compose exec -T dry-datalist-dev ./vendor/bin/pest

test-verbose: docker
	docker compose exec -T dry-datalist-dev ./vendor/bin/pest -v

test-coverage: docker
	docker compose exec -T dry-datalist-dev ./vendor/bin/pest --coverage

phpstan: docker
	docker compose exec -T dry-datalist-dev composer phpstan

phpstan-baseline: docker
	docker compose exec -T dry-datalist-dev composer phpstan:baseline

composer-validate: docker
	docker compose exec -T dry-datalist-dev composer validate --strict

composer-audit: docker
	docker compose exec -T dry-datalist-dev composer audit

composer-install-prod: docker
	docker compose exec -T dry-datalist-dev composer install --no-dev --optimize-autoloader
