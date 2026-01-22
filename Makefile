.PHONY: docker-init docker docker-exec yarn-format yarn-install test test-verbose test-coverage phpstan phpstan-baseline

docker-init:
	@if ! docker info > /dev/null 2>&1; then \
		echo "Docker is not running. Please start Docker and try again."; \
		exit 1; \
	fi

docker: docker-init
	docker compose up -d

docker-exec: docker
	docker compose exec dry-datalist-dev bash

yarn-format:
	yarn format

yarn-install:
	yarn install

test: docker
	docker compose exec dry-datalist-dev ./vendor/bin/pest

test-verbose: docker
	docker compose exec dry-datalist-dev ./vendor/bin/pest -v

test-coverage: docker
	docker compose exec dry-datalist-dev ./vendor/bin/pest --coverage

phpstan: docker
	docker compose exec dry-datalist-dev composer phpstan

phpstan-baseline: docker
	docker compose exec dry-datalist-dev composer phpstan:baseline
