ifneq (,$(wildcard ./.env))
    include .env
    export
endif

no-command:
	@echo Usage: make [scenario]

# Reload Nginx Config
nginx-reload:
	docker exec ${NGINX_CONTAINER} nginx -s reload

docker-rebuild: docker-down docker-build docker-up

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-build:
	docker-compose build

# --------------- Development ----------------

# Unit Tests
test:
	docker exec -ti ${PHP_CONTAINER} php artisan test

# Build front
front:
	npm install && npm run dev


# Выполняем команду "artisan" в docker-контейнере PHP.
ARTISAN = docker exec ${PHP_CONTAINER} php artisan

migrate:
	$(ARTISAN) migrate


# -------------- Deploy to Prod -------------------

# Выполняем команду по SSH на удалённом хосте.
RUN_SSH = ssh ${PROD_SSH_USER}@${PROD_SSH_HOST} -p 22

# Выкатываем обновление на прод
deploy:
	$(RUN_SSH) './${PROJECT_DIR}/bin/deploy.sh'

# Обновляем контейнеры в проде:
rebuild-docker-on-prod:
	$(RUN_SSH) './${PROJECT_DIR}/bin/rebuild-docker.sh'

# Публичный ключ SSH
show-ssh-key:
	$(RUN_SSH) 'cat ~/.ssh/id_rsa.pub'

# Устанавливаем проект на прод
install-to-host:
	$(RUN_SSH) '[ -d "./${PROJECT_DIR}" ] && echo "Repository exists, skipping cloning" || git clone ${BITBUCKET_USER}@bitbucket.org:${BITBUCKET_USER}/${BITBUCKET_REPO}.git ${PROJECT_DIR}'
	$(RUN_SSH) 'chmod +x ./${PROJECT_DIR}/bin/install.sh && ./${PROJECT_DIR}/bin/install.sh'

# Тянем изменения из Git
pull:
	$(RUN_SSH) 'cd ${PROJECT_DIR} && git pull'


