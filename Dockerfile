FROM php:8.2-fpm

ARG UID=1000
ARG GID=1000

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    git curl zip unzip \
    libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create a non-root user matching the host user's UID/GID
RUN groupadd -g ${GID} appuser || true \
    && useradd -u ${UID} -g ${GID} -m appuser \
    && chown -R appuser:appuser /var/www

COPY . .

RUN chown -R appuser:appuser /var/www

USER appuser
