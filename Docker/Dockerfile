FROM php:8-apache

ENV ACCEPT_EULA=Y

RUN a2enmod rewrite

# Install system dependencies
RUN DEBIAN_FRONTEND=noninteractive apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libxslt-dev \
    gnupg \
    zsh \
    apt-transport-https \
    libldap2-dev

RUN docker-php-ext-configure ldap && \
  docker-php-ext-install ldap