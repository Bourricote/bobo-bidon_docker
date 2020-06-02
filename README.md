### Docker ready from https://github.com/romaricp/kit-starter-symfony-4-docker

### Updated for symfony 4.4 + webpack encore by Anne Bourricote

## Containers :
- php (7.2)
- mysql
- phpmyadmin
- maildev
- apache
- node

## Setup commands :
- `docker-compose up` to mount and start containers (first time can be quite long as it builds containers) (add `-d` to run it in daemon)
- `docker exec -it -u dev sf4_php bash` to get in the php container 
- `composer install`
- `php bin/console d:s:u --force`


If error when `docker-compose up`: 

"ERROR: for sf4_apache  Cannot start service apache: driver failed programming external connectivity on endpoint sf4_apache (6b4e7e777e3f43e1847b60f845f2b32fcfff2730689ffd0664e002d4552eb359): Error starting userland proxy: listen tcp 0.0.0.0:80: bind: address already in use
"

Try 
- `sudo /etc/init.d/apache2 stop`

## Routine commands :
### To start working
- `docker-compose start` to start containers
- `docker exec -it -u dev sf4_php bash` to get in the php container (`exit` to get out)
- from there you can do the usual commands (`php bin/console make:controller` for example)
- the **app** is available on http://localhost/
- **phpmyadmin** is available on http://localhost:8081/
- **maildev** is available on http://localhost:8001/
- **git** commands must be performed outside the containers
- `php vendor/bin/codecept run --steps`to run tests with codeception

### When you're done
- `exit` to get out of a container
- `docker-compose stop` to stop containers

## Others commands :
- if you changed `docker-compose.yml` : `docker-compose down` to unmount containers and `docker-compose up` to remount them
- `docker ps` list containers and their ports (when outside a container)
- `docker rm <containername>` to remove a container (if they say container is already in use for example)
- `php vendor/bin/codecept generate:cest acceptance First` to create an acceptance test named First