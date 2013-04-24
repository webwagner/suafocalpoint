<?php
/**
 * class Page
 * Faz o include das páginas
 * @author Wagner Ramos
 * @date 04/07/2011
 */
class PageAdmin{	   
    static function show(){
        
        if(isset($_GET['pg']))
             if( is_file( 'controllers/'.$_GET['pg'].'.php' ) )
                 include('controllers/'.$_GET['pg'].'.php');
             else
                 echo "<p style='color:red;'>Página não Existe!</p>";
        else
           echo "<p style='color:red;'>Página não Existe!</p>";
       
    }
}