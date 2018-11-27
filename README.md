# REX Serialization Service api

## Installing

1. git clone [https://gitlab.com/rex3/product-serialization-service.git] (https://gitlab.com/rex3/product-serialization-service.git)
2. create database 
3. .env file 
4. composer install 
5. php artisan key:generate
6. php artisan migrate 
7. php artisan db:seed - *Adds REX3 as __customer__ #1. If APP_ENV != production faker adds 9 more.*
8. php artisan passport:keys

## Use

### Register 

Goto the site root URL, click on the register link to add users. 
You **must** enter at least one *__customer__* before registering a user.

### Login 

this returns your bearer token 
```
POST /api/login 
Header: Accept: application/json 
Parameters: username (username) password (password)
```

### Create 

creates a new product 
```
POST /api/v1/products/create 
Header: Accept: application/json Authorization: Bearer (token) 
Parameters: product (product number) max_serial (maximum serial #)
```

### Reserve 

reserves first available serial number, or optional specified number if available 
```
POST /api/v1/serial_numbers/{product number}/reserve 
Headers: Accept: application/json Authorization: Bearer (token) 
Parameters: serial_number (optional # - if missing will reserve first available)
```

### Release 

releases serial number back into pool of available numbers 
```
POST /api/v1/serial_numbers/{product number}/{number to release}/release 
Header: Accept: application/json Authorization: Bearer (token) 
Parameters: none
```

### Status 

provides the current status of a serial number 
```
GET /api/v1/serial_numbers/{product number}/{number to query}/status 
Header: Accept: application/json Authorization: Bearer (token) 
Parameters: none
```

[cURL Samples](SAMPLES.md)
