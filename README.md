# HB_Future_base
# Setup with docker UNIX

- docker-compose up -d


# Set up set in server docker:

- docker exec -it team-1_php_1 bash
- composer install
- cp .env.example .env
- php artisan config:clear
- php artisan key:generate
- php artisan migrate
