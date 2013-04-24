<?php

include('inc/init.inc.php');

/**
 * Se a url não for home inclui o perfil se for inclui a home
 */
if(url() == '' || url() == 'home' )
    include('home.php');
else
    include('perfil.php');

ob_end_flush();