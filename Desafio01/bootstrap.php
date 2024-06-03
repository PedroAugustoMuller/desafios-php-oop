<?php

/*Constantes*/
define('HOST','db');
define('DB', 'clima');
define('USER', 'root');
define('SENHA', 'root');

define('DS', DIRECTORY_SEPARATOR);
define('DIR_APP', __DIR__);
define('DIR_PROJECT','api');

if(file_exists('autoload.php'))
{
    include 'autoload.php';
}
else
{
    echo "Erro ao incluir bootstrap";
}