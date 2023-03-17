# Wishten
## Cómo configurar el proyecto en tu máquina local
1. Instalar PHP y [Composer](https://getcomposer.org/doc/00-intro.md)
2. Descargar la carpeta [wishten](/wishten/) que contiene el proyecto.
3. Moverse a la carpeta en la que se encuentra el proyecto
     ```
    cd wishten
    ```
4. Instalar las dependencias de Composer y NPM necesarias con los comandos:
    ```
    composer install
    ```
5. Crear el fichero *.env* que define variables importantes para la configuración del proyecto, como por ejemplo las credenciales de la base de datos. Para ello crear una copia del fichero *.env.example* y llamarla *.env*.
6. Generar una clave de encriptación para la aplicación. Laravel genera esta clave al crear un proyecto y la almacena en el fichero *.env*. Esta clave se usa para cifrar algunos elementos de la aplicación, como cookies, hashes de contraseñas, etc. Para ello, simplemente ejecutar el comando:
    ```
    php artisan key:generate
    ```
    Comprobar que la clave se generó correctamente observando el campo *APP_KEY* en el fichero *.env*.

7. Crear una base de datos vacía para el proyecto y añadir las credenciales para conectarse en el fichero *.env*. Simplemente hay que rellenar los campos *DB_HOST*, *DB_PORT*, *DB_DATABASE*, *DB_USERNAME* y *DB_PASSWORD*.
8. Migrar la base de datos para que se creen todas las tablas a partir de los ficheros de migraciones. Para ello basta con ejecutar el comando:
    ```
    php artisan migrate
    ```
    Comprobar que las tablas se crearon correctamente.
9. Ya está lista la configuración y únicamente faltaría desplegar la aplicación en local con el comando:
    ```
    php artisan serve
    ```
    
## Paleta de colores
    
    https://colorhunt.co/palette/22577a38a3a557cc9980ed99
    
