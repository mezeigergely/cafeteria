## About Cafeteria
User can calculate cafeteria budget using the app.
The app allows user to generate XML and CSV files based on the calculation results.
User have the option to save the calculation results in a database.

### Tech stack:
- php 8.1.
- laravel 10.
- vue js.

### Sail:
- **git clone https://github.com/mezeigergely/cafeteria.git**
- **run the docker on your machine**
- **cd Cafeteria**
- **./vendor/bin/sail up**


### or Install:
- **git clone https://github.com/mezeigergely/cafeteria.git**
- **cd Cafeteria**
- **composer install**
- **npm install**
- **create .env file from .env.example and configure your db connection**
- **php artisan key:generate**
- **php artisan migrate**
- **npm run dev**
- **in new terminal: php artisan serve**
