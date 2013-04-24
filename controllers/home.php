<?php

if($_POST){
    $login = getPost('login');
    $senha = getPost('senha');
}

include('views/home.php');
