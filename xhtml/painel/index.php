<?php 
	$page = $_GET['page'];
?>                                           	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/geral.js"></script>
	<script type="text/javascript" src="js/jquery.selectbox.js"></script>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    
    <title>Focal Point</title>
</head>

<body>

    <div id="header">
    
        <div class="meio">
        
            <?php include 'header.php';?>
            
        </div>
        
    </div>
    
    <div id="main">
    
        <div class="meio">
            
			<? 
                if($page && file_exists($page.'.php')){
                    include($page.'.php');
                }else{
                    include('primeiro-acesso.php');	
                }
            ?>                                           	
            
        </div>
            
    </div>
    
    <div id="footer">
    
    	<div class="meio">
        
            <?php include 'footer.php';?>
                        
        </div>
        
    </div>
    
</body>

</html>
