env:
	@docker-compose run --no-deps --rm producer bash -c "cp -n .env.example .env || true"

install:
	@docker-compose run --no-deps --rm producer bash -c "composer install"

lint:
	@docker-compose run --no-deps --rm producer bash -c "composer exec phpcs -- --standard=PSR12 bin src"

permissions:
	@docker-compose run --no-deps --rm producer bash -c "chmod +x bin/*"

publish:
	@docker-compose run --no-deps --rm producer bash -c "./bin/publish"

restart: stop start

setup: env install permissions

shell:
	@docker-compose exec producer bash

start:
	@docker-compose up -d

stop:
	@docker-compose stop
