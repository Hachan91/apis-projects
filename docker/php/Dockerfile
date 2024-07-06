# Utiliser une image PHP comme base
FROM php:8.2-fpm
# Définir la variable d'environnement COMPOSER_ALLOW_SUPERUSER
ENV COMPOSER_ALLOW_SUPERUSER=1

# Mettre à jour le système et installer les dépendances nécessaires
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libicu-dev \
    libzip-dev \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Installer les extensions PHP nécessaires
RUN docker-php-ext-install pdo_mysql intl zip

# Installer Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copier le code de l'application Symfony dans le conteneur
COPY . /var/www/html

# Définir le répertoire de travail
WORKDIR /var/www/html

# Installer les dépendances PHP avec Composer
RUN composer install --no-scripts --no-autoloader

# Charger l'autoloader et exécuter tout script post-install
RUN composer dump-autoload --optimize && composer run-script post-install-cmd

# Exposer le port 9000 pour PHP-FPM
EXPOSE 9000

# Commande pour démarrer PHP-FPM
CMD ["php-fpm"]