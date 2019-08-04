# Node.js - Zero to Hero: Adding Account Security to your Stack

A Laravel (PHP) implementation demonstrating Twilio's Account Security APIs:

* [Lookup](https://www.twilio.com/docs/lookup/api) (phone number information)
* [Verify](https://www.twilio.com/docs/verify/api) (phone verification)
* [Authy](https://www.twilio.com/docs/authy/api) (two factor authentication)

## Setup

### Pre-Reqs

Minimum requirements to run a local instance of [Laravel](https://laravel.com/docs/5.8/installation#installation)  

**This project uses Laravel 5.8 (PHP >= 7.1.3)**

### Installation
Clone this repo
```
git clone git@code.hq.twilio.com:tneiderhiser/signal-2019-php-authy-verify.git
```

Install project dependencies
```
cd account-security-php-demo
composer install
```

Copy `.env.sample` to `.env`. This is where we'll store sensitive data in [environment variables](https://www.twilio.com/blog/2017/01/how-to-set-environment-variables.html). 

```
cp .env.sample .env
```

### Setup your Twilio Account

1. Login to [Twilio Console](https://www.twilio.com/console) and copy your `ACCOUNT SID` and `AUTH TOKEN` from the Dashboard into your `.env` file
2. Navigate to [Verify Services](https://www.twilio.com/console/verify/services) to create a Verify Service and name it appropriately.
3. Add the `SERVICE ID` of the new service to your `.env` file.
4. Navigate to [Authy Applications](https://www.twilio.com/console/authy/applications) to create an Authy Application.
5. Copy the `AUTHY ID` of the new application to your `.env` file.

### Configure the application

Create and migrate database
```
touch database/database.sqlite
php artisan migrate
```

Generate a new encryption key
```
php artisan key:generate
```

### Run the application
```
php artisan serve --port 8081
```
Navigate to [http://localhost:8081](http://localhost:8081)

### License
MIT
