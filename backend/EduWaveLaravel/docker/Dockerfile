FROM php:8.3-apache

ARG UID=${HOST_UID}
ARG GID=${HOST_GID}

# Modify existing www-data user and group to match host UID and GID
RUN usermod -u ${UID} www-data && \
    groupmod -g ${GID} www-data

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libicu-dev \
    libxslt-dev \
    libpq-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        gd \
        pdo \
        pdo_mysql \
        intl \
        mbstring \
        xml \
        zip \
        bcmath \
        sockets \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer


# Configure Apache
WORKDIR /var/www/html
RUN a2enmod rewrite
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf


# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html

# We don't copy application code or install dependencies here
# because we'll mount the code as a volume

USER www-data

# These ensure Laravel runs in development mode
ENV APP_ENV=local
ENV APP_DEBUG=true