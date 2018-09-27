# Hackathonizer App

## Getting Started

*Prerequisites*
- Vagrant
- Docker

### Installing Vagrant
Follow the Vagrant [Getting Started](https://www.vagrantup.com/intro/getting-started/) guide to install Vagrant and Virtualbox for your OS.

### Installing Docker
- [Mac Installation](https://docs.docker.com/docker-for-mac/install/)
- [Windows Installation](https://docs.docker.com/docker-for-windows/install/)

## Tech Stack
- [Laravel 5.7](https://laravel.com/docs/5.7/)
- [Mysql 5.7](https://dev.mysql.com/doc/refman/5.7/en/)

## Provisioning a Local Environment
After installing any prerequisites, navigate to the project root from command line and run `vagrant up`.

The static ip address for the application is defined in [Vagrantfile](Vagranfile) as `192.168.99.100`. This needs to be added to your system's hosts configuration. The encouraged domain to use is `hackathon.local`.

Once the provisioning has finished, you should be able to navigate to [http://hackathon.local/](http://hackathon.local/) and see the application.

## Running Database Migrations
Migrations need to be run inside the vm to utilize Docker's networking.

To run migrations
- `vagrant ssh` from the root of the project
- `cd /vagrant`
- `docker-compose exec app php artisan migrate`

## Using artisan
Depending upon php's availability outside of the vm, 

