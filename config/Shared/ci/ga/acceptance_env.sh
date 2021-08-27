#!/bin/bash -e

# Install mail catcher
sudo gem install mailcatcher --no-document > /dev/null
mailcatcher > /dev/null
sudo apt-get -qqy install apache2 apache2-utils

config/Shared/ci/ga/install_mod_fastcgi.sh

sudo chmod -R 755 $HOME
sudo chmod 600 config/Zed/dev_only_private.key
sudo chmod 600 config/Zed/dev_only_public.key

PHP_VERSION=$(php -r "echo PHP_MAJOR_VERSION . '.' .  PHP_MINOR_VERSION;")

# setup php-fpm

echo "cp config/Shared/ci/ga/www.conf.php7 /etc/php/$PHP_VERSION/fpm/pool.d/www.conf"
sudo cp config/Shared/ci/ga/www.conf.php7 /etc/php/$PHP_VERSION/fpm/pool.d/www.conf

echo "add ini config"
sudo echo "session.save_path = '/tmp'" >> /etc/php/$PHP_VERSION/cli/php.ini
sudo echo "cgi.fix_pathinfo = 1" >> /etc/php/$PHP_VERSION/cli/php.ini
echo "Restart php-fpm"
sudo service php$PHP_VERSION-fpm restart

# apache: modules and rewrite configuration
sudo a2enmod rewrite actions fastcgi alias
sudo cp -f config/Shared/ci/ga/.htaccess public/Backoffice/.htaccess
sudo cp -f config/Shared/ci/ga/.htaccess public/BackendApi/.htaccess
sudo cp -f config/Shared/ci/ga/.htaccess public/BackendGateway/.htaccess
sudo cp -f config/Shared/ci/ga/.htaccess public/Glue/.htaccess
sudo cp -f config/Shared/ci/ga/.htaccess public/Yves/.htaccess

# apache: virtual hosts configuration
sudo cp -f config/Shared/ci/ga/ga-ci-apache-backend-api /etc/apache2/sites-available/backend-api.conf
sudo cp -f config/Shared/ci/ga/ga-ci-apache-backend-gateway /etc/apache2/sites-available/backend-gateway.conf
sudo cp -f config/Shared/ci/ga/ga-ci-apache-backoffice /etc/apache2/sites-available/backoffice.conf
sudo cp -f config/Shared/ci/ga/ga-ci-apache-glue /etc/apache2/sites-available/glue.conf
sudo cp -f config/Shared/ci/ga/ga-ci-apache-yves /etc/apache2/sites-available/yves.conf
sudo sed -e "s?%GITHUB_WORKSPACE%?$(pwd)?g" --in-place /etc/apache2/sites-available/backend-api.conf
sudo sed -e "s?%GITHUB_WORKSPACE%?$(pwd)?g" --in-place /etc/apache2/sites-available/backend-gateway.conf
sudo sed -e "s?%GITHUB_WORKSPACE%?$(pwd)?g" --in-place /etc/apache2/sites-available/backoffice.conf
sudo sed -e "s?%GITHUB_WORKSPACE%?$(pwd)?g" --in-place /etc/apache2/sites-available/glue.conf
sudo sed -e "s?%GITHUB_WORKSPACE%?$(pwd)?g" --in-place /etc/apache2/sites-available/yves.conf
sudo sed -e "s?%APPLICATION_ENV%?$APPLICATION_ENV?g" --in-place /etc/apache2/sites-available/backend-api.conf
sudo sed -e "s?%APPLICATION_ENV%?$APPLICATION_ENV?g" --in-place /etc/apache2/sites-available/backend-gateway.conf
sudo sed -e "s?%APPLICATION_ENV%?$APPLICATION_ENV?g" --in-place /etc/apache2/sites-available/backoffice.conf
sudo sed -e "s?%APPLICATION_ENV%?$APPLICATION_ENV?g" --in-place /etc/apache2/sites-available/glue.conf
sudo sed -e "s?%APPLICATION_ENV%?$APPLICATION_ENV?g" --in-place /etc/apache2/sites-available/yves.conf
sudo sed -e "s?%DB_PASSWORD%?$DB_PASSWORD?g" --in-place /etc/apache2/sites-available/backoffice.conf
sudo sed -e "s?%POSTGRES_PORT%?$POSTGRES_PORT?g" --in-place /etc/apache2/sites-available/backend-api.conf
sudo sed -e "s?%POSTGRES_PORT%?$POSTGRES_PORT?g" --in-place /etc/apache2/sites-available/backend-gateway.conf
sudo sed -e "s?%POSTGRES_PORT%?$POSTGRES_PORT?g" --in-place /etc/apache2/sites-available/backoffice.conf
sudo ln -s /etc/apache2/sites-available/backend-api.conf /etc/apache2/sites-enabled/backend-api.conf
sudo ln -s /etc/apache2/sites-available/backend-gateway.conf /etc/apache2/sites-enabled/backend-gateway.conf
sudo ln -s /etc/apache2/sites-available/backoffice.conf /etc/apache2/sites-enabled/backoffice.conf
sudo ln -s /etc/apache2/sites-available/glue.conf /etc/apache2/sites-enabled/glue.conf
sudo ln -s /etc/apache2/sites-available/yves.conf /etc/apache2/sites-enabled/yves.conf

# apache: fastcgi/php-fpm configuration
sudo cp -f config/Shared/ci/ga/php7-fpm.conf /etc/apache2/conf-enabled/php7-fpm.conf

###################### ADD HOSTS ############################
echo "ADD HOSTS"
echo "127.0.0.1 backoffice.de.spryker.test" | sudo tee -a /etc/hosts
echo "127.0.0.1 glue.de.spryker.test" | sudo tee -a /etc/hosts
echo "127.0.0.1 www.de.spryker.test" | sudo tee -a /etc/hosts
echo "127.0.0.1 backend-api.de.spryker.test" | sudo tee -a /etc/hosts
echo "127.0.0.1 backend-gateway.de.spryker.test" | sudo tee -a /etc/hosts
echo "127.0.0.1 backoffice.de.spryker.test" | sudo tee -a /etc/hosts

echo "RESTART APACHE"
# apache: check configuration and start service
sudo apachectl configtest
sudo service apache2 restart

# install Chromium and Chromedriver symlinks
mkdir $HOME/chromium-ecosystem
curl -L "https://github.com/spryker/docker-chromedriver/archive/master.zip" -o $HOME/chromium-ecosystem/docker-chromedriver.zip
rm -rf $HOME/chromium-ecosystem/docker-chromedriver-master
unzip -o $HOME/chromium-ecosystem/docker-chromedriver.zip -d $HOME/chromium-ecosystem/
rm -rf $HOME/chromium-ecosystem/*.zip
export CHROMEDRIVER_REVISION=814168
export COMPOSER_IGNORE_CHROMEDRIVER=1

. $HOME/chromium-ecosystem/docker-chromedriver-master/chromium-installer $CHROMEDRIVER_REVISION $HOME/chromium-ecosystem false

sudo ln -s -f "$CHROMIUM_BINARY" /usr/local/bin/chrome

# codeception
wget https://raw.github.com/Codeception/c3/2.0/c3.php > /dev/null
