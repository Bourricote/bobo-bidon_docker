### Docker ready from https://github.com/romaricp/kit-starter-symfony-4-docker

### Updated for symfony 4.4 + webpack encore by Anne Bourricote

## Containers :
- php (7.2)
- mysql
- phpmyadmin
- maildev
- apache
- node

## First commands :
- `docker-compose up`
- `docker exec -it -u dev sf4_php bash`
- `cd sf4`
- `composer install`


If error when `docker-compose up`: 

"ERROR: for sf4_apache  Cannot start service apache: driver failed programming external connectivity on endpoint sf4_apache (6b4e7e777e3f43e1847b60f845f2b32fcfff2730689ffd0664e002d4552eb359): Error starting userland proxy: listen tcp 0.0.0.0:80: bind: address already in use
"

Try 
- `sudo /etc/init.d/apache2 stop`

## Routine commands :
### To start working
- `docker-compose up` to mount and start containers
- `docker exec -it -u dev sf4_php bash` to get in the php container 
- `cd sf4` to get in the working directory
- from there you can do the usual commands (`php bin/console make:controller` for example)
- the app is available on http://localhost/
- git commands must be performed outside the containers

### When you're done
- `exit`
- `docker exec -it -u dev sf4_php bash`
- `docker-compose stop`

## Others commands :
- `docker ps` list containers and their ports (when outside a container)
- `docker rm <containername>` to remove a container (if they say container is already in use for example)