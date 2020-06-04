# Hackathonizer App

## Tech Stack
- PHP 7.4
- Node 10 (latest tested)
- [Laravel 5.7](https://laravel.com/docs/5.7/)
- [Mysql 5.7](https://dev.mysql.com/doc/refman/5.7/en/)

## Local Environment (Development)

### Requirements
- PHP 7.4
- Node 10
- VirtualBox
- Vagrant
- Pusher account

### Provisioning a Local Environment
- Add entry for hkr.local to host file: `192.168.99.100 hkr.local`
- Start Vagrant: `vagrant up` 
- Add your pusher account secret to the `.env` that should have been created during `vagrant up` process.

### Build and Develop
All commands can be run from host as long as you have the requirements outlined at the top. 
- Install JS dependencies: `npm install` 
- Build frontend assets (js): `npm run watch` if you are actively developing or `npm run prod` if you need a one off build
- Install PHP dependencies: `composer install`
- Run database migrations: `php artisan migrate`
- Seed database: `php artisan db:seed`

### Access the Database
- Ssh into Vagrant: `vagrant ssh`
- Access database via mysql client: `mysql -h192.168.99.100 -uroot -phkr`

## Production 

## Provisioning a Production Instance

### Create a New Amazon EC2 Instance
- AMI: Ubuntu 18.04
- Size: T2.Micro
- Protect against accidental termination
- Security Groups: Basic Webserver && Github Actions
- Click Launch > Choose an existing key pair. Select yours.

### SSHing into Server and Provisioning
- Copy the provisioning folder by running the following command:
  `scp -rp ./provisioning ubuntu@<public_ip>:/home/ubuntu/provisioning`
- `ssh ubuntu@<public_ip>`
- `cd /home/ubuntu/provisioning`
- Run the provisioning script by `./provision.sh [env]` (local, production) 
- Manually execute the following steps to enable SSL: https://certbot.eff.org/lets-encrypt/ubuntubionic-apache.html  t

## Deploying to Production
- Any commit to master will trigger a github action (`.github/workflows/production.yml`)





