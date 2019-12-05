# Hackathonizer App

## Getting Started

*Prerequisites*
- Vagrant
- Docker
- Node 10 is the latest tested version

### Installing Vagrant
Follow the Vagrant [Getting Started](https://www.vagrantup.com/intro/getting-started/) guide to install Vagrant and Virtualbox for your OS.

### Installing Docker
- [Mac Installation](https://docs.docker.com/docker-for-mac/install/)
- [Windows Installation](https://docs.docker.com/docker-for-windows/install/)

### Installing Vagrant Docker Compose
- `vagrant plugin install vagrant-docker-compose`

## Tech Stack
- [Laravel 5.7](https://laravel.com/docs/5.7/)
- [Mysql 5.7](https://dev.mysql.com/doc/refman/5.7/en/)

## Provisioning a Local Environment
1. If you don't have this dependency installed, `vagrant plugin install vagrant-docker-compose`
2. Copy .env.example to the root and rename it to .env: `cp .env.example .env`
3. `vagrant up`
4. `composer install` - install php dependencies
5. `php artisan key:generate` - create unique laravel app key (inserts into .env)
6. `npm install` - install javascript dependencies
7. `npm run dev` or `npm run watch` - build vue app
8. `vagrant ssh` - terminal access vm
9. `cd /vagrant`
10. `docker-compose exec app php artisan migrate` - create/update database structure
11. `docker-compose exec app php artisan db:seed` - seed default data

## To Access the Database
1. `vagrant ssh`
2. `docker ps` to view the containers that were just created. For this particular project, you should see two containers, one named `vagrant_app` and one named `mysql:5.7`. Take note of the container ID hash for the container named `mysql:5.7`.
3. Using the container ID from the previous step, replace `<CONTAINER-ID-HASH>` in the following command `docker exec -it <CONTAINER-ID-HASH> bash`.
4. `mysql -u root -p`

The static ip address for the application is defined in [Vagrantfile](Vagranfile) as `192.168.99.100`. This needs to be added to your system's hosts configuration. The encouraged domain to use is `hackathon.local`.

Once the provisioning has finished, you should be able to navigate to [http://hackathon.local/](http://hackathon.local/) and see the application.



