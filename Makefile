.PHONY: $(shell grep -E '^[a-zA-Z_-]+:' Makefile | sed 's/:.*//g')

#=============================================================================
# PROJECT CONFIGURATION - Customize these for each project
#=============================================================================
PROJECT_NAME := MohabBlog
GIT_BRANCH := main
LOG_FILE := storage/logs/laravel.log
ENV_FILE := .env
ENV_EXAMPLE := .env.example

# Docker Compose Configuration
APP_CONTAINER := mohablog-app
NGINX_CONTAINER := mohablog-nginx
DB_CONTAINER := mohablog-db

# Find available ports for services
APP_PORT ?= $(shell for port in $$(seq 8000 8100); do ! nc -z localhost $$port 2>/dev/null && echo $$port && break; done)
DB_PORT ?= $(shell for port in $$(seq 3307 3399); do ! nc -z localhost $$port 2>/dev/null && echo $$port && break; done)
PHPMYADMIN_PORT ?= $(shell for port in $$(seq 8080 8180); do ! nc -z localhost $$port 2>/dev/null && echo $$port && break; done)

#=============================================================================
# COLORS FOR OUTPUT
#=============================================================================
BLUE := \033[0;34m
BBLUE := \033[1;34m
GREEN := \033[0;32m
BGREEN := \033[1;32m
RED := \033[0;31m
BRED := \033[1;31m
YELLOW := \033[0;33m
MAGENTA := \033[0;35m
WHITE := \033[0;37m
NC := \033[0m

#=============================================================================
# HELP
#=============================================================================
help:
	@echo ""
	@echo "$(BBLUE)╔══════════════════════════════════════════════════════════════╗$(NC)"
	@echo "$(BBLUE)║         $(BGREEN)$(PROJECT_NAME) - Development Environment$(BBLUE)              ║$(NC)"
	@echo "$(BBLUE)╚══════════════════════════════════════════════════════════════╝$(NC)"
	@echo ""
	@echo "$(BBLUE)Service Management:$(NC)"
	@echo "  $(GREEN)make build$(NC)            - Build Docker containers"
	@echo "  $(GREEN)make up$(NC)               - Start all services"
	@echo "  $(GREEN)make down$(NC)             - Stop all services"
	@echo "  $(GREEN)make restart$(NC)          - Restart all services"
	@echo "  $(GREEN)make rebuild$(NC)          - Full rebuild (no cache)"
	@echo "  $(GREEN)make ps$(NC)               - Show running containers"
	@echo "  $(GREEN)make shell$(NC)            - Access app container shell"
	@echo ""
	@echo "$(BBLUE)Logs:$(NC)"
	@echo "  $(GREEN)make logs$(NC)             - View Laravel logs (tail -f)"
	@echo "  $(GREEN)make logs-static$(NC)      - View last 50 lines of Laravel logs"
	@echo "  $(GREEN)make logs-app$(NC)         - View app container logs"
	@echo "  $(GREEN)make logs-nginx$(NC)       - View nginx container logs"
	@echo "  $(GREEN)make logs-db$(NC)          - View database container logs"
	@echo "  $(GREEN)make logs-all$(NC)         - View all container logs"
	@echo ""
	@echo "$(BBLUE)Environment Setup:$(NC)"
	@echo "  $(GREEN)make setup$(NC)            - Initial environment setup"
	@echo "  $(GREEN)make update$(NC)           - Update dependencies and run migrations"
	@echo "  $(GREEN)make clean$(NC)            - Clean up Docker resources"
	@echo ""
	@echo "$(BBLUE)Database Operations:$(NC)"
	@echo "  $(GREEN)make migrate$(NC)          - Run database migrations"
	@echo "  $(GREEN)make seeder name='...'$(NC) - Create a new seeder"
	@echo "  $(GREEN)make db-seeder$(NC)        - Generate and run seed data"
	@echo "  $(GREEN)make reset-db$(NC)         - Reset database (fresh migration + seed)"
	@echo ""
	@echo "$(BBLUE)Git Operations:$(NC)"
	@echo "  $(GREEN)make config$(NC)           - Configure git credentials"
	@echo "  $(GREEN)make fetch$(NC)            - Fetch latest changes from remote"
	@echo "  $(GREEN)make pull$(NC)             - Pull latest changes and update"
	@echo "  $(GREEN)make status$(NC)           - Show git status"
	@echo "  $(GREEN)make commit msg='...'$(NC) - Commit and push changes"
	@echo ""
	@echo "$(BBLUE)Translation Automation:$(NC)"
	@echo "  $(GREEN)make translate$(NC)        - Auto-detect and apply all translations"
	@echo "  $(GREEN)make translate-scan$(NC)   - Scan for untranslated strings"
	@echo "  $(GREEN)make translate-apply$(NC)  - Apply existing translations to files"
	@echo ""
	@echo "$(YELLOW)Examples:$(NC)"
	@echo "  $(YELLOW)make commit msg='Added new feature'$(NC)"
	@echo "  $(YELLOW)make seeder name='UserSeeder'$(NC)"
	@echo "  $(YELLOW)make translate$(NC)"
	@echo ""

#=============================================================================
# PORT VALIDATION HELPER
#=============================================================================
check-ports:
	@if [ -z "$(APP_PORT)" ] || [ -z "$(DB_PORT)" ] || [ -z "$(PHPMYADMIN_PORT)" ]; then \
		echo "$(RED)✗ No available ports found in required ranges$(NC)"; \
		exit 1; \
	fi
	@echo "$(GREEN)Using ports - app: $(APP_PORT), db: $(DB_PORT), phpmyadmin: $(PHPMYADMIN_PORT)$(NC)"

#=============================================================================
# SERVICE MANAGEMENT
#=============================================================================
build: check-ports
	@echo "$(BLUE)Building $(PROJECT_NAME) containers...$(NC)"
	@APP_PORT=$(APP_PORT) DB_PORT=$(DB_PORT) PHPMYADMIN_PORT=$(PHPMYADMIN_PORT) docker compose up -d --build
	@echo "$(GREEN)✓ Build complete - App running on http://localhost:$(APP_PORT)$(NC)"

up: check-ports
	@echo "$(BLUE)Starting $(PROJECT_NAME)...$(NC)"
	@APP_PORT=$(APP_PORT) DB_PORT=$(DB_PORT) PHPMYADMIN_PORT=$(PHPMYADMIN_PORT) docker compose up -d
	@echo "$(GREEN)✓ Services started on http://localhost:$(APP_PORT)$(NC)"

down:
	@echo "$(BLUE)Stopping $(PROJECT_NAME)...$(NC)"
	@docker compose down
	@echo "$(GREEN)✓ Services stopped$(NC)"

restart:
	@echo "$(BLUE)Restarting $(PROJECT_NAME)...$(NC)"
	@docker compose restart
	@echo "$(GREEN)✓ Services restarted$(NC)"

rebuild: check-ports
	@echo "$(BLUE)Rebuilding $(PROJECT_NAME) from scratch...$(NC)"
	@docker compose down --remove-orphans
	@docker compose build --no-cache
	@APP_PORT=$(APP_PORT) DB_PORT=$(DB_PORT) PHPMYADMIN_PORT=$(PHPMYADMIN_PORT) docker compose up -d
	@echo "$(GREEN)✓ Rebuild complete - App running on http://localhost:$(APP_PORT)$(NC)"

ps:
	@echo "$(BLUE)Running containers:$(NC)"
	@docker compose ps

#=============================================================================
# LOGS
#=============================================================================
logs:
	@echo "$(BLUE)Tailing logs from $(LOG_FILE)...$(NC)"
	@echo "$(YELLOW)Press Ctrl+C to exit$(NC)"
	@tail -f $(LOG_FILE)

logs-static:
	@echo "$(BLUE)Last 50 lines from $(LOG_FILE):$(NC)"
	@tail -n 50 $(LOG_FILE)

#=============================================================================
# ENVIRONMENT SETUP
#=============================================================================
setup: check-ports
	@echo "$(BLUE)Setting up environment for $(PROJECT_NAME)...$(NC)"
	@if [ ! -f "$(ENV_FILE)" ]; then \
		echo "$(YELLOW)Creating $(ENV_FILE) from $(ENV_EXAMPLE)...$(NC)"; \
		cp $(ENV_EXAMPLE) $(ENV_FILE); \
	else \
		echo "$(YELLOW)$(ENV_FILE) already exists, skipping...$(NC)"; \
	fi
	@echo "$(BLUE)Building and starting containers...$(NC)"
	@APP_PORT=$(APP_PORT) DB_PORT=$(DB_PORT) PHPMYADMIN_PORT=$(PHPMYADMIN_PORT) docker compose up -d --build
	@echo "$(BLUE)Installing dependencies...$(NC)"
	@docker exec -it $(APP_CONTAINER) composer install
	@echo "$(BLUE)Generating application key...$(NC)"
	@docker exec -it $(APP_CONTAINER) php artisan key:generate
	@echo "$(BLUE)Running migrations...$(NC)"
	@docker exec -it $(APP_CONTAINER) php artisan migrate --force
	@echo "$(BLUE)Generating seed data...$(NC)"
	@docker exec -it $(APP_CONTAINER) php artisan generate:seed
	@echo "$(BLUE)Generating storage link...$(NC)"
	@docker exec -it $(APP_CONTAINER) php artisan storage:link
	@echo "$(GREEN)✓ Setup complete - App: http://localhost:$(APP_PORT) | phpMyAdmin: http://localhost:$(PHPMYADMIN_PORT)$(NC)"

update:
	@echo "$(BLUE)Updating dependencies...$(NC)"
	@docker exec -it $(APP_CONTAINER) composer update
	@echo "$(BLUE)Running migrations...$(NC)"
	@docker exec -it $(APP_CONTAINER) php artisan migrate --force
	@echo "$(BLUE)Generating seed data...$(NC)"
	@$(MAKE) db-seeder
	@echo "$(GREEN)✓ Update complete$(NC)"

clean:
	@echo "$(BLUE)Cleaning up Docker resources...$(NC)"
	@docker system prune -f
	@echo "$(GREEN)✓ Cleanup complete$(NC)"

#=============================================================================
# PHP / ARTISAN COMMANDS
#=============================================================================
migrate:
	@echo "$(BLUE)Running migrations...$(NC)"
	@docker exec -it $(APP_CONTAINER) php artisan migrate --force
	@echo "$(GREEN)✓ Migrations complete$(NC)"

seeder:
ifndef name
	@echo "$(RED)Error: Seeder name is required$(NC)"
	@echo "$(YELLOW)Usage: make seeder name='UserSeeder'$(NC)"
	@exit 1
endif
	@docker exec -it $(APP_CONTAINER) php artisan make:seeder $(name)

db-seeder:
	@docker exec -it $(APP_CONTAINER) php artisan generate:seed

reset-db:
	@echo "$(YELLOW)⚠ WARNING: This will reset the database!$(NC)"
	@echo "$(YELLOW)Press Ctrl+C within 5 seconds to cancel...$(NC)"
	@sleep 5
	@docker exec -it $(APP_CONTAINER) php artisan migrate:fresh --force
	@docker exec -it $(APP_CONTAINER) php artisan generate:seed
	@echo "$(GREEN)✓ Database reset complete$(NC)"

storage:
	@docker exec -it $(APP_CONTAINER) php artisan storage:link

oc:
	@docker exec -it $(APP_CONTAINER) php artisan o:c

#=============================================================================
# GIT OPERATIONS
#=============================================================================
fetch:
	@echo "$(BLUE)Fetching latest changes from remote...$(NC)"
	@git fetch --all
	@echo "$(GREEN)✓ Latest changes fetched$(NC)"

pull:
	@echo "$(BLUE)Pulling latest changes from $(GIT_BRANCH)...$(NC)"
	@git pull origin $(GIT_BRANCH)
	@echo "$(BLUE)Running update...$(NC)"
	@$(MAKE) update
	@echo "$(GREEN)✓ Repository updated successfully$(NC)"

status:
	@echo "$(BLUE)Git status for $(PROJECT_NAME):$(NC)"
	@echo ""
	@git status

config:
	@git config --global user.email "mohabmamdouh22@gmail.com"
	@git config --global user.name "Mohab2Mamdouh"
	@git config --global credential.helper store

commit:
ifndef msg
	@echo "$(RED)Error: Commit message is required$(NC)"
	@echo "$(YELLOW)Usage: make commit msg='Your commit message'$(NC)"
	@exit 1
endif
	@echo "$(BLUE)Committing changes with message: '$(msg)'...$(NC)"
	@git add . && \
	git commit -m "$(msg)" && \
	git push && \
	echo "$(GREEN)✓ Changes committed and pushed successfully$(NC)" || \
	echo "$(RED)✗ Commit failed$(NC)"

#=============================================================================
# ADDITIONAL UTILITIES
#=============================================================================
shell:
	@docker exec -it $(APP_CONTAINER) bash

logs-app:
	@docker compose logs -f $(APP_CONTAINER)

logs-nginx:
	@docker compose logs -f $(NGINX_CONTAINER)

logs-db:
	@docker compose logs -f $(DB_CONTAINER)

logs-all:
	@docker compose logs -f

#=============================================================================
# TRANSLATION AUTOMATION
#=============================================================================
translate:
	@echo "$(BLUE)Running translation automation...$(NC)"
	@php master-translate.php && \
	echo "$(GREEN)✓ Translations updated successfully$(NC)" || \
	echo "$(RED)✗ Translation failed$(NC)"

translate-scan:
	@echo "$(BLUE)Scanning for untranslated strings...$(NC)"
	@php find-untranslated.php

translate-apply:
	@echo "$(BLUE)Applying translations to blade files...$(NC)"
	@php apply-translations.php && \
	echo "$(GREEN)✓ Translations applied$(NC)" || \
	echo "$(RED)✗ Application failed$(NC)"
