# Shopping List
Software web per liste della spesa

# Installazione per Docker
```
cp .env.laradock.example laradock/.env
cd laradock
docker-compose up -d nginx mysql phpmyadmin redis workspace 
```

Aggiungere le seguenti righe al file `./.env`
```
DB_HOST=mysql
REDIS_HOST=redis
QUEUE_HOST=beanstalkd
```

# Installazione del progetto
Entra nel container `shopping-list_workspace`
```
composer install
```

Entra nel container `shopping-list_php-fpm`
```
php artisan key:generate
```

Entra nel container `shopping-list_workspace`
```
npm install
npm run dev
```
