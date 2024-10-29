#!/bin/bash

#ubuntu 22.04
#php8.1

# install php ppa
apt -y install software-properties-common
add-apt-repository ppa:ondrej/php -y
apt update

# install php w/o apache
apt -y install php8.1-cli php8.1-mbstring php-pear php8.1-dev php8.1-curl php8.1-gd php8.1-zip php8.1-xml

# install sqlcmd
#curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add -
#curl https://packages.microsoft.com/config/ubuntu/22.04/prod.list | tee /etc/apt/sources.list.d/mssql-tools.list
#apt update
ACCEPT_EULA=Y apt -y install msodbcsql18
echo 'export PATH="$PATH:/opt/mssql-tools/bin"' >> ~/.bash_profile
echo 'export PATH="$PATH:/opt/mssql-tools/bin"' >> ~/.bashrc
source ~/.bashrc
apt -y install unixodbc-dev

# install sqlsrv driver
# if this fails install sqlsrv-5.5.0preview & pdo_sqlsrv-5.5.0preview
pecl install sqlsrv pdo_sqlsrv
printf "; priority=20\nextension=sqlsrv.so\n" > /etc/php/8.1/mods-available/sqlsrv.ini
printf "; priority=30\nextension=pdo_sqlsrv.so\n" > /etc/php/8.1/mods-available/pdo_sqlsrv.ini
phpenmod -v 8.1 sqlsrv pdo_sqlsrv
