#Planes

## Requirements:
   - [docker compose](https://docs.docker.com/compose/install/)
   
## Installation:
   - To clone the project
   ```
   https://github.com/Fighter77777/planes.git
   ```
   - Go to the folder
   ```
   cd planes
   ```
   - Copy file .env.[same_env].dist to .env. The example for dev enviroment:
   ```
   cp .env.dev.dist .env'
   ```
   - Build docker services 
   ```
   docker-compose build
   ```
   - Run project 
   ```
   docker-compose up
   ```
   - Install vendors 
   ```
   docker-compose exec php-fpm composer install
   ```
   
## Project
### URLs:
* [Main page](http://localhost:11170/)
* [API Documentation](http://localhost:11170/api/doc)
   
### Change a hangar for a plane
   To change a hangar of a plane is needed:
   * Take out a plane from a hangar in which this plane is.
   * Add the plane to other hangar.
## Data base
### Data base structure
![DB Structure](http://dl4.joxi.net/drive/2020/09/10/0026/1186/1746082/82/e4114c5572.jpg)
## Run tests:
   - Project should be run. Execute next command if docker-compose is stopped.
   ```
   docker-compose up
   ```
   - To run all phpunit test use this command:
   ```
   docker-compose exec php-fpm bin/phpunit
   ```
   - To run a specific test use this command:
   ```
   docker-compose exec php-fpm bin/phpunit {path to the file with the test} 
   ```
