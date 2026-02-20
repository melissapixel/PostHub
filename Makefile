# Загружаем переменные из .env файла
include .env

# ==============================================================================
# 🚀 ОСНОВНЫЕ КОМАНДЫ
# ==============================================================================

up:
	docker-compose up -d

down:
	docker-compose down

build:
	docker-compose build --no-cache

restart:
	docker-compose restart

# ==============================================================================
# 📋 ЛОГИРОВАНИЕ
# ==============================================================================

logs-php:
	docker-compose logs -f php

logs-db:
	docker-compose logs -f db

logs:
	docker-compose logs -f

# ==============================================================================
# 🐚 ДОСТУП В КОНТЕЙНЕРЫ
# ==============================================================================

shell-php:
	docker-compose exec php bash

shell-db:
	docker-compose exec db psql -U $(POSTGRES_USER) -d $(POSTGRES_DB)

# ==============================================================================
# 🗄️ БАЗА ДАННЫХ И МИГРАЦИИ
# ==============================================================================

# Применение миграции: make db-migrate FILENAME=02_create_tables.sql
db-migrate:
	docker-compose exec -T db psql -U $(POSTGRES_USER) -d $(POSTGRES_DB) -f /docker-entrypoint-initdb.d/migrations/$(file)

# Применение всех сидов
db-seed-all:
	docker-compose exec -T db psql -U $(POSTGRES_USER) -d $(POSTGRES_DB) -f /docker-entrypoint-initdb.d/seeds/01_categories.sql
	docker-compose exec -T db psql -U $(POSTGRES_USER) -d $(POSTGRES_DB) -f /docker-entrypoint-initdb.d/seeds/02_posts.sql

# Полная перезагрузка данных (Сброс + Сиды)
db-refresh:
	docker-compose exec -T db psql -U $(POSTGRES_USER) -d $(POSTGRES_DB) -c "TRUNCATE post, category RESTART IDENTITY CASCADE;"
	docker-compose exec -T db psql -U $(POSTGRES_USER) -d $(POSTGRES_DB) -f /docker-entrypoint-initdb.d/seeds/01_categories.sql
	docker-compose exec -T db psql -U $(POSTGRES_USER) -d $(POSTGRES_DB) -f /docker-entrypoint-initdb.d/seeds/02_posts.sql

# Сброс данных
db-reset:
	docker-compose exec -T db psql -U $(POSTGRES_USER) -d $(POSTGRES_DB) -c "TRUNCATE post, category RESTART IDENTITY CASCADE;"

# ==============================================================================
# 🧪 ТЕСТИРОВАНИЕ
# ==============================================================================

test-api:
	curl http://localhost:$(PHP_PORT)/api/posts
	curl http://localhost:$(PHP_PORT)/api/categories

clean:
	docker-compose down -v --rmi all