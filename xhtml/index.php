<? 
	$page = $_GET['page'];
	if($page==''){
		$page='home';
	}
?>                                           	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="favicon.ico" type="image/x-icon" rel="icon" />
    <link rel="stylesheet" href="css/body.css" type="text/css" />
    <link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
	<script type="text/javascript" src="js/jquery-1.4.4.js" ></script>
	<script src="js/jquery.validate.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/jquery.tinycarousel.min.js"></script>
    <script src="js/jquery.validationEngine-pt.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <script language="javascript">
		$(document).ready(function(){
			$('.slideshow').tinycarousel();
			$("#login").validate();
		});
		jQuery(document).ready(function(){
			jQuery("#formulario").validationEngine('attach');
		});
		$(document).ready(function(){
		   $(".login").click(function(){
			  $(this).addClass("login-b"); 
		   }); 
		   $(".senha").click(function(){
			  $(this).addClass("senha-b"); 
		   }); 
		});
	</script>
    <title>SUA Focal Point</title>
    </head>
    
    <body>

        <!--HEADER SITE(LOGO, MENU)-->
        <div class="header">
        
        	<div class="center">
            
                <div class="login">
                	<img src="img/login-header.jpg" alt="Login" title="Login" width="42" height="43"/>
                    <form id="login" method="post" action="">
                        <div class="campo">
                            <input class="required login" type="text" name="login">
                        </div>
                        <div class="campo">
                            <input class="required senha" type="password" name="senha">
                        </div>
                        <input type="submit" value="">
                    </form>
                    <a href="?page=inscreva-se">- Cadastre-se</a>
                    <a href="?page=esqueci-minha-senha">- Esqueci a senha</a>
                </div>
                
            </div>
        
        </div>
        <!--HEADER SITE(LOGO, MENU)-->
      
        <!--CONTEUDO SITE-->        
        <div class="content">                	                      
            <? 
                if($page && file_exists($page.'.php')){
                    include($page.'.php');
                }else{
                    include('pagina-em-construcao.php');	
                }
            ?>                                           	
        </div>
        <!--CONTEUDO SITE-->
    
        <!--RODAPÉ SITE-->
        <div class="footer">
        
        	<div class="center">
        
                <div class="menu">
                    <ul>
                        <li class="first"><a href="?page=home">HOME</a></li>
                        <li><a href="?page=sua-focal-point">SUA FOCAL POINT</a></li>
                        <li><a href="?page=inscreva-se">INSCREVA-SE</a></li>
                        <li><a href="?page=convide-seu-corretor">CONVIDE SEU CORRETOR</a></li>
                        <li class="last"><a href="?page=fale-conosco">FALE CONOSCO</a></li>
                    </ul>
                </div>
                
                <div class="click-house">
                	<a href="?page=home" class="house"><img src="img/footer_10.png" /></a>
                	<a href="http://www.clickdesigner.com.br" target="_blank" class="click"><img src="img/footer_21.png" /></a>
                </div>
                
                <div class="copyright">
                	<p>© 2011 SUA Focal Point. Todos os direitos reservados.</p>
                </div>
            
			</div>
        </div>
        <!--RODAPÉ SITE-->
        
    </body>
    
</html>
