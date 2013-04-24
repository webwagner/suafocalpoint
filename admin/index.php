<?php 
include('../inc/init.inc.php');

$mens = '';

if($_POST){
    /**
    * Logon do administrador
    */
    $mapper = new Mapper();
    $mapper->setDbTable(new Admin());
    $mapper->setWhere('login = "'.$_POST['usuario'].'" and ativo = "SIM"');
    
    if($mapper->getRow()){
        $mapper->setWhere('senha = "'.md5($_POST['senha']).'" and ativo = "SIM"');
        if($mapper->getRow()){
            $_SESSION['admin'] = $mapper->getRow()->nome;
            echo "<script>location.href = 'manage.php?pg=estados'</script>";
        }
        else{
            $mens = '<div class="dados-incorretos"><img src="static/images/icone-erro.jpg" width="14" height="15" alt="icone erro" /><p><strong>SENHA INCORRETA</strong></p></div>';
        }
    }
    else{
        $mens = '<div class="dados-incorretos"><img src="static/images/icone-erro.jpg" width="14" height="15" alt="icone erro" /><p><strong>USUÁRIO NÃO EXISTE</strong></p></div>';
    }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>    
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    
    <title>Painel Click Designer</title>
        
    <link rel="stylesheet" type="text/css" href="static/css/index.css" />
</head>
<body>
    <div class="meio">
        <div class="meio">
            <div id="box-painel-topo"></div>
            <div id="box-painel-corpo">
                <img src="static/images/logo-focal-point.jpg" width="375" height="144" alt="Sua Focal Point" />
                <form name="login-painel" action="" method="post">
                    <span>Usuário</span><input type="text" name="usuario" size="20" class="hover" id="user" />
                        <span>Senha</span><input type="password" name="senha" size="20" class="hover3" id="pass"/>
                    <input type="submit" value="Entrar" class="bt-login" />
                </form>
                <?php echo $mens;?>
            </div>
            <div id="border-bottom"></div>
        </div>
    </div>
</body>
</html>

    