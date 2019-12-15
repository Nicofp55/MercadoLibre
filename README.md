!----------------------------------  Documentación ----------------------------------!

Explicación del script:
El script index.php genera un archivo LOG sobre los datos de los items en venta de un usuario de la plataforma de Mercado Libre. Estos datos son consultados a la api de Mercado libre y volcados sobre el archivo. Es posible hacer la búsqueda sin usuario, que traerá por defecto el usuario pedido por el examen, como también indicar uno o múltiples usuarios a los que se consultarán sus datos.


Modo de uso:

1) Descargue el script y abra la Consola de comandos de su sistema operative.
2) Ejecute el script php y pase el id del usuario del que necesite el listado de productos bajo la opción -u
Por Ejemplo :
    php C:\directory\index.php -u179571326
Si es necesario el listado de varios usuarios, siga agregándolos bajo la opción -u
Ejemplo:
    php C:\directory\index.php -u179571326 -u15248621
El archivo de output se generará en la carpeta llamada logs teniendo como parte de su nombre la fecha del día y el id del usuario requerido.

