FROM php:7.4-fpm

# Copy composer.lock and composer.json
COPY composer.lock composer.json /var/www/

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y apt-transport-https

RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libfontconfig1 \
    libxrender1 \
    libssl1.1 \
    sudo \
    wget \
    build-essential

RUN apt-get clean && apt-get update
RUN apt-get install -y nodejs npm python3 python3-pip

RUN pip install virtualenv

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql exif pcntl

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN git clone https://github.com/aws/aws-elastic-beanstalk-cli-setup.git
RUN python3 ./aws-elastic-beanstalk-cli-setup/scripts/ebcli_installer.py

RUN apt-get install python-is-python3


# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www
RUN passwd -d www
RUN echo "www:pass"|chpasswd
RUN adduser www sudo

# Copy existing application directory contents
COPY . /var/www

# Copy existing application directory permissions
COPY --chown=www:www . /var/www

RUN sudo apt update
RUN dpkg -i /var/www/wkhtmltox_0.12.5-1.stretch_amd64.deb || true
RUN apt-get install -f -y

# Change current user to www
USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
