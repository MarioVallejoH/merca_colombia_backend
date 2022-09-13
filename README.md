<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

# MercaColombia REST-API

## Requerimientos

    - PHP 7.3+
    - Composer installed

# Instalación en un servidor con Apache

## 1. Copiar archivos a la ruta `home/`, puede hacerse usando git o por FTP (proceso lento).

### Usando GIT
Mediante SHH o mediante cPanel, clonar los archivos del repositorio a la ruta `home/`.

## 2. Instalar las librerias requeridas por el proyecto usando composer

Mediante terminal (SSH o WHM) como el usuario web, ir a la carpeta raiz del proyecto y ejecutar el siguiente comando:

    $ composer install

## 3. Ejecutar las migraciones de ser necesario

Para la creación de las tablas necesarias para el funcionamiento del proyecto ejecutar este comando en la carpeta raiz del proyecto:

    $ php artisan migrate

## 4. Generacion de llaves de encriptación (necesarias para generar tokens de acceso seguros)

En la carpeta raiz del proyecto, ejecutar el siguiente comando

    $ php artisan passport:install

Esto generara un client Id y un Client secret, debemos guardar estas credenciales para su posterior uso para el cliente que consumira el servicio REST.

## 5. Generar llaves de encriptación para las librerias usadas para la autenticación de usuarios

En la carpeta raiz del proyecto ejecutar el siguiente comando

    $ php artisan passport:keys

## 6. Crear archivo `.htacces` dentro de la carpeta `public/` del proyecto

Usando cualquier metodo para crear y editar archivos, crear el archivo `.htacces` y copiar el siguiente contenido dentro

    RewriteEngine On
    RewriteCond %{HTTP:Authorization} ^(.*)
    RewriteRule .* - [e=HTTP_AUTHORIZATION:%1]
    RewriteBase /nombre_del_proyecto/
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php?request=%{REQUEST_URI} [NE,L,QSA]

### Nota: `nombre_del_proyecto` corresponde al nombre que se le quiera dar a la ruta al proyecto.


## 7. Crear enlace simbolico de la carpeta public del proyecto a la ruta `home/public_html/nombre_del_proyecto/`


## Nota
Si la carpeta `nombre_del_proyecto/` no existe, es necesario crearla usando el siguiente comando (o el metodo que se facilite mas como FTP, cPanel, WHM) en el directorio `home/`..

    mkdir public_html/nombre_del_proyecto

Para crear el enlace simbolico usando terminal, usar el siguiente comando

    ln -s ruta_a_la_carpeta_public_del_proyecto ~/public_html/nombre_del_proyecto
