# Use a imagem oficial do PHP como base
FROM php:8.2-fpm

# Instale as dependências do Laravel
RUN apt-get update && \
    apt-get install -y \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instale o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Extensões necessárias
RUN docker-php-ext-install pdo pdo_mysql

# Defina o diretório de trabalho
WORKDIR /var/www/html

# Instale as dependências do Laravel usando o Composer
COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-autoloader

# Copie o código-fonte do Laravel
COPY . .

# Configure as permissões e gere o autoload do Composer
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache \
    && composer dump-autoload
