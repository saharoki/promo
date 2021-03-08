# Promo

I didn't write test because I start make that project just yesterday and today I need to send it.

## Requirement

ffmpeg must be instaled.

## Installation

Clone git project

Run composer install

edit .env file to set MySql connection

run command: php artisan migrate

make sure that storage/converted directory is writable.

run local server: php -S localhost:8000 -t public

request example: http://localhost:8000/api/mp3/7868687687

## Improvment

Instead of directly convert mp4 to mp3 the better way to keep convert request in DB/AWS SQS/something else.

Microservice will convert file. So request will be return more quickly.
