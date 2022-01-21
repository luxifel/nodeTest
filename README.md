## SCALAPAY FULLSTACK TASK

###How to run the application
1. Install PHP dependencies with ``composer install``
2. Get configurations with ``cp configs.local.ini configs.ini``
3. (Optional) Only if you need xdebug and you are on a Linux machine in ./docker/docker-compose.yml change host.docker.internal with your machine private IP 
4. Run docker containers with ``cd .docker/ && docker-compose up --build``
5. Restore DB with 
   ``cat ./dumps/backup.sql | docker exec -i docker_mariadb_1 /usr/bin/mysql -u root --password=root scalapay
   ``
6. Enjoy you applicationn at http://localhost   
