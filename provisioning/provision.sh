#!/usr/bin/env bash

if [ ! ${1} ]
then
    echo "Please enter an environment (local, production)" >&2
    exit 1
fi

ENVIRONMENT=${1}

if [ ${ENVIRONMENT} == 'production' ]
then
    PROVISION_FILES_PATH="/home/ubuntu/provisioning"
    USER="app-user"
    APP_DOMAIN="hkr.bythepixel.com"
else
    PROVISION_FILES_PATH="/srv/www/provisioning"
    USER="vagrant"
    APP_DOMAIN="hkr.local"
fi

export DEBIAN_FRONTEND=noninteractive

echo "Update ubuntu"
sudo apt-get update -y > /dev/null
sudo DEBIAN_FRONTEND=noninteractive apt-get -o Dpkg::Options::="--force-confdef" -o Dpkg::Options::="--force-confold" upgrade -y > /dev/null

echo "Install NodeJS 10.x"
curl -sL https://deb.nodesource.com/setup_10.x | sudo -E bash - > /dev/null
sudo DEBIAN_FRONTEND=noninteractive apt-get install nodejs -y > /dev/null

echo "Install Apache"
sudo DEBIAN_FRONTEND=noninteractive apt-get install apache2 -y > /dev/null

echo "Install PHP 7.4"
sudo add-apt-repository ppa:ondrej/php -y > /dev/null
sudo apt-get update -y > /dev/null
sudo DEBIAN_FRONTEND=noninteractive apt-get install php7.4 -y > /dev/null
sudo DEBIAN_FRONTEND=noninteractive apt-get install php7.4-curl -y > /dev/null
sudo DEBIAN_FRONTEND=noninteractive apt-get install php7.4-mysql -y > /dev/null
sudo DEBIAN_FRONTEND=noninteractive apt-get install php7.4-mbstring -y > /dev/null
sudo DEBIAN_FRONTEND=noninteractive apt-get install php7.4-xml -y > /dev/null
sudo DEBIAN_FRONTEND=noninteractive apt-get install php7.4-bcmath -y > /dev/null
sudo DEBIAN_FRONTEND=noninteractive apt-get install unzip -y > /dev/null
sudo DEBIAN_FRONTEND=noninteractive apt-get install php7.4-zip -y > /dev/null
sudo DEBIAN_FRONTEND=noninteractive apt-get install php7.4-intl -y > /dev/null
sudo DEBIAN_FRONTEND=noninteractive apt-get install php7.4-gd -y > /dev/null

echo "Install composer globally"
curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer  > /dev/null

if [ ${ENVIRONMENT} != 'local' ]
then
    echo "Create Unix User"
    sudo adduser ${USER} --disabled-password --gecos "" > /dev/null

    echo "Add user to a suplementary/secondary group called 'sudo'"
    sudo usermod -a -G sudo ${USER} > /dev/null

    echo "Make sure sudoers can sudo without password by adding to sudoers"
    sudo sed -i -r "s/%sudo\t*\s*ALL=\(ALL:ALL\)\t*\s*ALL/%sudo ALL=\(ALL:ALL\) NOPASSWD: ALL/" /etc/sudoers  > /dev/null

    echo "Add our list of keys so we can login as specified user"
    sudo mkdir /home/${USER}/.ssh > /dev/null
    sudo cp ${PROVISION_FILES_PATH}/public_keys /home/${USER}/.ssh/authorized_keys > /dev/null
    sudo chown -R ${USER}:${USER} /home/${USER}/.ssh  > /dev/null

    echo "Disable root ssh access"
    sudo sed -i "s/PermitRootLogin prohibit-password/PermitRootLogin no/" /etc/ssh/sshd_config  > /dev/null
    sudo service ssh restart  > /dev/null
fi

echo "Copy php config files to /etc/php"
sudo cp ${PROVISION_FILES_PATH}/php/apache2-php.ini /etc/php/7.4/apache2/php.ini > /dev/null
sudo cp ${PROVISION_FILES_PATH}/php/cli-php.ini /etc/php/7.4/cli/php.ini > /dev/null

echo "Remove boilerplate site"
sudo rm /etc/apache2/sites-available/000-default.conf > /dev/null

echo "Copy apache config files to /etc/apache2"
sudo cp ${PROVISION_FILES_PATH}/apache2/apache2.conf /etc/apache2 > /dev/null
sudo sed -i -r "s/\{USER\}/$USER/" /etc/apache2/apache2.conf > /dev/null
sudo cp ${PROVISION_FILES_PATH}/apache2/000-default.conf /etc/apache2/sites-available > /dev/null
sudo sed -i -r "s/\{APP_DOMAIN\}/$APP_DOMAIN/" /etc/apache2/sites-available/000-default.conf > /dev/null

echo "Install MySQL Client"
sudo DEBIAN_FRONTEND=noninteractive apt-get install mysql-client -y > /dev/null

echo "Install MySQL Server"
echo "mysql-server mysql-server/root_password password hkr" | sudo debconf-set-selections
echo "mysql-server mysql-server/root_password_again password hkr" | sudo debconf-set-selections
sudo DEBIAN_FRONTEND=noninteractive apt-get install mysql-server -y > /dev/null
sudo cp ${PROVISION_FILES_PATH}/mysql/mysqld.cnf /etc/mysql/mysql.conf.d/mysqld.cnf > /dev/null
sudo mysql -uroot -phkr --execute="CREATE DATABASE hkr" > /dev/null

if [ ${ENVIRONMENT} == 'local' ]
then
    echo "Allow mysql access from host"
    sudo mysql -uroot -phkr --execute="UPDATE mysql.user SET Host='%' WHERE User='root';" > /dev/null
fi

echo "Enable apache mods"
sudo a2enmod \
    headers \
    rewrite > /dev/null

echo "Restart apache and mysql"
sudo systemctl reload apache2 > /dev/null
sudo service mysql restart

echo "PROVISIONING COMPLETE"
