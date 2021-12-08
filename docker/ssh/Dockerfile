FROM php:8.0-fpm

# Set working directory
WORKDIR /var/www

# -- Copy from PHP Dockerfile --
# Install dependencies
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
    libicu-dev
# -- Copy from PHP Dockerfile --

RUN apt-get update && apt-get install -y openssh-server \
    && mkdir /var/run/sshd \
    && echo 'root:secret' | chpasswd \
    && sed -i 's/PermitRootLogin prohibit-password/PermitRootLogin yes/' /etc/ssh/sshd_config \
    && sed -i 's/#PasswordAuthentication/PasswordAuthentication/' /etc/ssh/sshd_config \
    && sed -i 's/#PermitRootLogin/PermitRootLogin/' /etc/ssh/sshd_config \
    && sed 's@session\s*required\s*pam_loginuid.so@session optional pam_loginuid.so@g' -i /etc/pam.d/sshd \
    && apt-get clean \
    &&  rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# -- Copy from PHP Dockerfile --
# Install extensions
RUN docker-php-ext-install pdo_mysql \
    exif \
    pcntl \
    intl
# -- Copy from PHP Dockerfile --

# -- Copy from PHP Dockerfile --
# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# -- Copy from PHP Dockerfile --

ENV NOTVISIBLE "in users profile"
RUN echo "export VISIBLE=now" >> /etc/profile

EXPOSE 22
CMD ["/usr/sbin/sshd", "-D"]
