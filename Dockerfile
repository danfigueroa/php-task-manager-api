FROM php:8.2-cli

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    sqlite3 \
    libsqlite3-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo_sqlite \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/html

# Copiar composer.* e instalar dependências
COPY composer.json composer.lock ./
RUN if [ -f composer.json ]; then composer install --optimize-autoloader; fi

# Copiar o restante do código
COPY . ./

# Gerar a documentação OpenAPI
RUN php generate-docs.php

EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
