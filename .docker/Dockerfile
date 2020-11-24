FROM debian:buster-slim

# Avoid warnings by switching to noninteractive
ENV DEBIAN_FRONTEND=noninteractive

# Configure apt and install packages
RUN apt-get update \
    && apt-get -y install --no-install-recommends apt-utils 2>&1 \
    && apt-get -y install --no-install-recommends apt-transport-https 2>&1 \
    #
    # Verify git and common are installed
    && apt-get -y install locales ca-certificates build-essential wget curl unzip lsb-release git procps net-tools nano htop iftop \
    #
    # mySQL client
    && apt-get install -y mariadb-client \
    #
    # Install PHP
    && echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | tee -a /etc/apt/sources.list.d/php.list \
    && curl https://packages.sury.org/php/apt.gpg | apt-key add - \
    && apt-get update -qq \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y php7.3 php7.3-common \
    php7.3-cli php7.3-json php7.3-mysql php7.3-opcache php7.3-readline \
    php7.3-curl php7.3-xml php7.3-mbstring php7.3-intl php7.3-zip \
    supervisor \
    #
    # Install apache2 
    && apt-get -y install apache2 libapache2-mod-php7.3 && a2enmod headers && a2enmod rewrite \
    && awk '/<Directory \/var\/www\/>/,/AllowOverride None/{sub("None", "All",$0)}{print}' /etc/apache2/apache2.conf > tmp.conf && mv tmp.conf /etc/apache2/apache2.conf 2>&1 \
    && apache2ctl -D BACKGROUND \
    && update-rc.d apache2 defaults \
    #
    # Reconfigure locales
    && DEBIAN_FRONTEND=noninteractive LANGUAGE=en_US.UTF-8 LANG=en_US.UTF-8 LC_ALL=en_US.UTF-8 && locale-gen en_US.UTF-8 && dpkg-reconfigure locales \
    #
    # Clean up
    && apt-get autoremove -y && apt-get autoclean -y && apt-get clean -y \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Switch back to dialog for any ad-hoc use of apt-get
ENV DEBIAN_FRONTEND=dialog

# Create volumn link to current directory
VOLUME /var/www/html

# Set environment vars
ENV TZ UTC

COPY entrypoint.sh /

#
ENTRYPOINT ["/entrypoint.sh"]

# comment out if you dont want to use .devcontainer.json
#CMD npm run dev
