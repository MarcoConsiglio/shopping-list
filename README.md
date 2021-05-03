# Shopping List
Software web per liste della spesa

# Installazione
Clona la repository
`git clone https://github.com/MarcoConsiglio/shopping-list.git`
## Se utilizzi Docker
```
cd laradock
git submodule init
git submodule update
cd ..
```

Configurazione per docker
```
cp .env.laradock.example laradock/.env
cd laradock
```

Avvia i container con
```
docker-compose up -d nginx mysql phpmyadmin redis workspace
```
oppure con 
```
..\scripts\docker-compose.bat
```
*Se utilizzi Docker, entra nel container specificato di volta in volta.*

*Per accedere ad un container `docker-compose exec {container-name} bash`*
## Configurazione di Laravel
Il file `.env.example` contiene i valori di configurazione di default.
Vanno bene nella maggior parte dei casi, anche con Docker.
```
cp .env.example .env
```
Se necessario, modificare il file `.env`.

## Installazione delle dipendenze
*Entra nel container `shopping-list_workspace`*
```
composer install
```

*Entra nel container `shopping-list_php-fpm`*
```
php artisan key:generate
```

*Entra nel container `shopping-list_workspace`*
```
npm install
npm run dev
```
