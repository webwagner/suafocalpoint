<?php	
//buffer
ob_start("ob_gzhandler");

//inicializa o uso de sessões
header("Content-Type: text/html; charset=ISO-8859-1");

//Evitando cache de arquivo
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Last Modified: '. gmdate('D, d M Y H:i:s') .' GMT');
header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
header('Pragma: no-cache');
header('Expires: 0');

//inicia sessão
if(!isset($_SESSION))
    session_start();

//Endereço do servidor de SMTP
define('HOST','localhost');
//Email de SMTP
define('EMAIL','site@suafocalpoint.com');

//Nome do Site
define('SITE','Sua Focal Point');  

//Cofigurações BD
define('SERVER','localhost');
define('USER','root');
define('PASS','');
define('DB','focalpoint');

        
        
