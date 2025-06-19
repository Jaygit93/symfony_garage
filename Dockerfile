# Utiliser une image officielle PHP 8.3 avec FPM
FROM php:8.3-fpm

# Mettre à jour les paquets et installer les dépendances de base
RUN apt-get update && apt-get install -y \
    curl \
    unzip \
    libpq-dev \
    libzip-dev \
    libonig-dev \
    libicu-dev \
    libxml2-dev \
    libjpeg-dev \
    libpng-dev \
    libfreetype6-dev \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        intl \
        opcache \
        pdo \
        pdo_mysql \
        zip \
        gd \
        xml \
    && apt-get clean

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurer un utilisateur non-root pour la sécurité
RUN useradd -m -u 1000 symfony && \
    mkdir -p /var/www && \
    chown -R symfony:symfony /var/www

USER symfony

# Définir le répertoire de travail
WORKDIR /var/www

# Copier les fichiers de configuration PHP personnalisés (si nécessaires)
# COPY php.ini /usr/local/etc/php/

# Exposer le port utilisé par php-fpm
EXPOSE 9000

# Commande par défaut pour php-fpm
CMD ["php-fpm"]
