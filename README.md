# Electric Miles Coding Test

This API is built in Laravel 8. It makes use of Laravel Passport to handle authentication.

## Requirements
1. PHP >= 7
2. MySql
3. Composer

## Installation and Set Up

1. Clone the repository from gitlab
```
$ git clone https://github.com/sobambela/Electric-Miles.git electric-miles
```
2. CD int into the project folder
```
$ cd electric-miles
```
3. Make sure the storage, bootstap/cache folders are writable
```
$ chmod -R +777 storage/ bootstap/cache/
```
4. Install all the dependencies with composer
```
$ composer install
```
5. Copy the .env.example and rename it to .env
```
$ cp .env.example .en
```
6. Change the following lines to reflect your database connection information
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```
7. Generate the application key
```
$ php artisan key:generate
```
8. Run the database migrations. This will also seed the tables with dummy data as well as a Test user
```
$ php artisan migrate --seed

Test user credential:
Username: test@test.com
Password: password
```
9. The following Passport command creates a client whose details details will be use to get an access_token, that is used to authenticate API calls.
```
$ php artisan passport:install

Password grant client created successfully.
Client ID: 2
Client secret: perGqXCubm8Q7mS6G5NKRO41Thv0PHuZ8Q92OUL7
```
We will use the grant Client ID and Secret to get an access token.

10. Running the API. The following command uses Laravel's build in Server to serve the API at http://127.0.0.1:8000/
```
$ php artisan serve
```

## Usage
### Inside the root of the project folder I have placed a POSTMAN collection that has all the endpoints with descriptive titles.

###  Example, Get access token.
An access token is obtained by making a POST request to the /oauth/token endpoint with post fields as the example below:
```
POST: http://127.0.0.1:8000/oauth/token
PostFields:
{
  "grant_type": "password",
  "client_id": "2",                           // From Step 9
  "client_secret": "from-step-9-above",       // From Step 9,
  "username":"test@test.com",
  "password":"password",
  "scope":""
}
```
The above call will return:
```
{
  "token_type": "Bearer"
  "expires_in": "31536000"
  "access_token": "long-token-to-be-sent-with-every-api-call"
  "refresh_token": "refresh-token-should-the-token-expire"
}
```
This must be added to the headers to authenticate API calls
```
Authorization: "Bearer access_token"
```
## Scheduled Task for Delayed orders
I have created a console command that hadles the checking for delayed orders and updating the delayed_orders table in ``` app/Console/Commands/UpdateDelayedOrders.php  ```. 
The command can be called at will on the console as below:
```
$ php artisan orders:update-delayed-orders
```
I have also scheduled the command to run every minute in ```app/Console/Kernel.php```

Normally you would have to add an entry in the cron table to invoke this tasks as follows:
```
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

We can mimick this locally with the following command:
```
$ php artisan schedule:work
```

## Testing

To run the feature test suite, located at ```tests/Feature/```, run the following command inside the project root.
```
$ vendor/bin/phpunit
``` 
 