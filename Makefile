CONTAINER_NAME=back.app

# Instala a aplicação e sobe o sistema
install:
	make build
	make up
	make clear
	make migration

build:
	docker compose build
# Sobe o sistema
up:
	docker compose up -d

# Roda os testes unitário.
test:
	docker exec -it $(CONTAINER_NAME) php artisan test

# Rodas as migrations e limpa o banco
migration:
	docker exec -it $(CONTAINER_NAME) php artisan migrate:fresh

# Roda os as migrations, limpa o banco e popula
migration-seed:
	docker exec -it $(CONTAINER_NAME) php artisan migrate:fresh --seed

# Entra no bash do container
bash:
	docker exec -it $(CONTAINER_NAME) bash

# Limpa os caches, gera as entities e os proxies
clear:
	docker exec $(CONTAINER_NAME) bash  -c "php artisan optimize:clear"
