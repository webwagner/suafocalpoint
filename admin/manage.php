<?php 
include('../inc/init.inc.php');

if(!isset($_SESSION['admin']))
    echo "<script>location.href = 'index.php';</script>";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
            
    <link rel="stylesheet" type="text/css" href="static/css/manage.css" />
       
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js" type="text/javascript"></script>    
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.8.1/jquery.validate.min.js" type="text/javascript"></script>   
    <script src="static/js/scripts.js" type="text/javascript"></script>    
     
    <title>Sua Focal Point</title>   
</head>

<body>
    <div id="header">   
        <div class="meio">     
            <div id="logo">
                <a href="manage.php?pg=estados" title="Sua Focal Point - Rede de Ferramentas Para Corretores">
                    <img src="static/images/logo_02.gif" alt="Sua Focal Point - Rede de Ferramentas Para Corretores" border="0" />
                </a>
            </div>
            <div id="login">
                <span>Olá <strong><?php echo (isset($_SESSION['admin'])) ? $_SESSION['admin'] : ""; ?></strong></span>
                <a id="bt-logout" href="?pg=logout" title="logout">logout</a>
            </div>
        </div>      
    </div>   
    <div id="breadcumbs">
    	<div class="meio">
           <div class="page">
            	<a href="#"><img src="static/images/home.jpg" width="18" height="18" alt="Home" title="Home"/></a>
                <img src="static/images/brd_07.jpg" width="16" height="18" />
                <span>HOME</span>   
            </div>
        </div>   
    </div>
    <div id="content">
        <div class="meio">
            <div class="nav">                
                <ul class="menu">
                    <li>
                        <a href="?pg=estados" class="click" >
                            <img src="static/images/icon-paper.png" width="16" height="16" alt="estados" title="estados"/>
                            <span>Estados</span>
                        </a>
                        <a href="?pg=cidades" class="click" >
                            <img src="static/images/icon-paper.png" width="16" height="16" alt="cidades" title="cidades"/>
                            <span>Cidades</span>
                        </a>
                        <a href="?pg=bairros" class="click" >
                            <img src="static/images/icon-paper.png" width="16" height="16" alt="bairros" title="bairros"/>
                            <span>Bairros</span>
                        </a>
                        <a href="?pg=como-conheceu-a-rede" class="click" >
                            <img src="static/images/icon-paper.png" width="16" height="16" alt="Como conheceu a rede" title="Como conheceu a rede"/>
                            <span>Como conheceu a rede</span>
                        </a>
                        <a href="javascript:void(0)" id="link-corretores" class="click" >
                            <img src="static/images/icon-paper.png" width="16" height="16" alt="Corretores" title="Corretores"/>
                            <span>Corretores</span>
                        </a>
                        <ul style="display: none;" id="submenu-corretores" class="submenu">
                            <li>- <a href="?pg=corretores">Todos</a></li>
                        </ul>
                        <a href="?pg=imoveis" class="click" >
                            <img src="static/images/icon-paper.png" width="16" height="16" alt="Imóveis" title="Imóveis"/>
                            <span>Imóveis</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div id="main">
                <?php PageAdmin::show();?>
            </div>  
        </div>       
    </div>
    <div id="footer">   
    	<div class="meio">       
            <div id="img-footer"></div>
            <p id="copyright">© 2011 SUA Focal Point. Todos os direitos reservados.</p>
            <div id="creditos-click">
                <a href="http://www.clickdesigner.com" rel="partner" title="Desenvolvido pela Click Designer">
                    <img src="static/images/creditos-click.png" alt="Créditos Click designer" border="0"/>
                </a>
            </div>                 
        </div> 
    </div>
</body>
</html>