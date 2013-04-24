<?php
/**
 * class Page
 * Faz o include das páginas
 * @author Wagner Ramos
 * @date 04/07/2011
 */
class Page
{	
    
        static function show( )
        {
            
            if(url(2) && !is_numeric(url(2)))
                $file = url(2);
            else if(url(1))
                $file = url(1);
            else
                $file = 'home';

            if( is_file( 'controllers/'.$file.'.php' ) )
                include( 'controllers/'.$file.'.php' );
            else
                include( 'controllers/perfil.php' );
            
        }
    

}