# Tasyakur Website

## Getting Started
Please install docker and docker-compose first if it's not installed on your machine. [Click here](https://www.docker.com/get-started) !

Please download google analytics json credentials and put it inside `etc/php/env_files/google`

All magic happens within the [tasyakur-app plugin](./src/wp-content/plugins/tasyakur-app) which is under `wp-content/plugins/tasyakur-app` please refer to the folder for more [documentations](./src/wp-content/plugins/tasyakur-app).

### To Build
```bash
$ ./start.sh [ENVIRONMENT] build [OPTIONS...]
```

### To Run
```bash
$ ./start.sh [ENVIRONMENT] [OPTIONS...]
```

### Shut Down
```bash
$ ./stop.sh [ENVIRONMENT] [OPTIONS...]
```

Available commands:
- ENVIRONMENT:
    - prod | production : To run on production machine - Starts php, nginx, beanstalkd, and redis containers
    - local : To run on your local - Starts all available containers on `docker-compose.yml` (php, nginx, beanstalkd, redis, mysql, phpmyadmin)
    - staging : To run on staging machine - Starts same services as local
- OPTIONS:
    - --force-i : To force composer install
    - --sudo : To run the command in superadmin user (sudo) mode

## Local Environment
```$ cp ./local-sample.env ./.env```

Fill out all necessary env vars

Env vars:
    - PHP_OPCACHE_VALIDATE_TIMESTAMPS=1

## Production Environment
```$ cp ./production-sample.env ./.env```

Fill out all necessary env vars

Env vars:
    - PHP_OPCACHE_VALIDATE_TIMESTAMPS=0

### How-To`s
List of service ports:
- 80 : nginx
- 9000 : php-fpm
- 3306 : mysql
- 6379 : redis
- 306 : phpmyadmin
    
Depending on the ENVIRONMENT, but make sure the related service ports are not used.

You can also use `docker-compose` command to run particular tasks, but it's encouraged to use the installer bash script instead (start.sh and stop.sh).

Master branch is on the production server.

If there are updates on the app and is expected to be live then it should be on master branch.

To update the production/staging server, please ssh into the server, pull the master branch and if there are changes on the server side, then you need to restart the docker-compose.

---

That's all :)

*(P.S. Please refer to [Docker documentation](https://www.docker.com/get-started) to find out more how it works)*