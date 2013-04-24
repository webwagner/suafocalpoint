<?php
/**
 * Define o BASE_PATH
 */
define('BASE_PATH', realpath(dirname(__FILE__)).'/');

/**
 * Define a URL ABSOLUTA
 */
define('URL_ABSOLUTE',realpath(substr(BASE_PATH,0,-4)).'/');

/**
 * Seta os erros do PHP
 */
error_reporting( E_ALL );
ini_set('display_errors', TRUE);

/**
 * Seta o local
 */
setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
date_default_timezone_set('America/Sao_Paulo');

/**
 * Faz o include include path da pasta class
 */
set_include_path(implode(PATH_SEPARATOR, array(BASE_PATH.'class',get_include_path())));

/**
 * Faz o include include path da pasta library
 */
set_include_path(implode(PATH_SEPARATOR, array(URL_ABSOLUTE.'library',get_include_path())));

/**
 * Faz o require do arquivo de configuração
 */
if( !file_exists(BASE_PATH.'config.inc.php') ){
        exit('Erro config.php nao encontrado');
} 
else {
        require BASE_PATH.'config.inc.php';
}

/**
 * Faz o include do arquivo de funções
 */
include('functions.php');

/**
 * Faz a conexão com o Bd
 */
include('Zend/Db/Table.php');
$db = Zend_Db::factory('mysqli',
            array('host'=>SERVER,
                'username'=>USER,
                'password'=>PASS,
                'dbname'=>DB
            )
        );
$db->setFetchMode(Zend_Db::FETCH_OBJ);
Zend_Db_Table_Abstract::setDefaultAdapter($db);

/**
 * Faz o autoload das classes
 */
function __autoload( $class ){
    if( is_file( BASE_PATH.'class/'.$class.'.class.php' ) )
        include $class.'.class.php';
    else if( is_file( URL_ABSOLUTE.'models/'.$class.'.class.php' ) )
        include URL_ABSOLUTE.'models/'.$class.'.class.php';       
}

/**
 * Define a url para puxar arquivos estáticos
 */
$urlHttp = "http://" . $_SERVER['SERVER_NAME'] .'/focalpoint/';
define('URL',$urlHttp);


