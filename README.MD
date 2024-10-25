# Simple Login service with PHP 8.X

This is a simple example to test a backend service to login, using different log providers and password encryptions.

## Installation

If you get the full zip, just uncompress it and run some local web server or some dev web server (from root folder with command line, type)

```bash
php -S localhost:8000
```

You can also get the code using git:

```bash
git clone https://github.com/rodrigopaco1986/microservicios-arquitectura-login.git

#install
composer install
```
Give write permissions to storage folder
```bash
chmod -R 775 storage
```

## Usage
### Endpoints
1. To login  
- [http://localhost:8000/login.php](http://localhost:8000/login.php)
- Expected data: email, password
2. To register
- [http://localhost:8000/register.php](http://localhost:8000/register.php)
- Expected data: name, email, password
3. To update setting options
- [http://localhost:8000/settings.php](http://localhost:8000/settings.php)
- Expected data: logger, encryption

### Setting options
#### Log
1. file.- To save logs in a txt file
2. http.- To save logs in a remote http site
3. database.- To save logs in a local database (sqlite default)
4. none.- To avoid saving logs

#### Encryption
1. md5
2. crypt
3. bcrypt
4. none.- Password saved as plain text

## Updating default values
To update some default values, like the url for the http logger, make the changes in constants.php file.

## Dev notes
### Linter the code:
```bash
./vendor/bin/pint
```

### Run tests
```bash
./vendor/bin/phpunit --bootstrap vendor/autoload.php tests
```