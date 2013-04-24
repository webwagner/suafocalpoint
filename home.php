<?php
$retorno = '';

if (getPost('login_topo')) {
    $mapper = new Mapper();
    $mapper->setDbTable(new Corretor());

    /**
     * Verifica se existe o email digitado no bd
     */
    $mapper->setWhere('email = "' . getPost('login_topo') . '"');
    $row_email = $mapper->getRow();

    /**
     * Verifica se existe o login digitado no bd
     */
    $mapper->setWhere('login = "' . getPost('login_topo') . '"');
    $row_login = $mapper->getRow();

    if (!$row_email && !$row_login) {
        $retorno = '<label class=error>Usuário não existe.</label>';
    } else {
        /**
         * Verifica se existe o usuario e senha
         */
        if ($row_login) {
            $mapper->setWhere('login = "' . getPost('login_topo') . '" AND senha = "' . md5(getPost('senha')) . '"');
            $row = $mapper->getRow();
        } else {
            $mapper->setWhere('email = "' . getPost('login_topo') . '" AND senha = "' . md5(getPost('senha')) . '"');
            $row = $mapper->getRow();
        }

        if ($row) {
            /**
             * Verifica se o usuario esta ativado
             */
            if ($row->ativado == "SIM") {
                $_SESSION['login'] = $row->login;
                header("Location: " . URL . $_SESSION['login'] . "");
            } else {
                session_destroy();
                header("Location: " . URL . "home/renovar-plano/" . $row->login);
            }
        } else {
            $retorno = '<label class=error>Senha incorreta.</label>';
        }
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>      
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />

        <link href="favicon.ico" type="image/x-icon" rel="icon" />
        <link rel="stylesheet" href="<?php echo URL; ?>static/css/body.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo URL; ?>static/css/interna.css" type="text/css" />

        <base src="<?php echo URL; ?>" href="<?php echo URL; ?>" />

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js" type="text/javascript"></script>
        <script src="<?php echo URL; ?>static/js/jquery.validate.js" type="text/javascript"></script>
        <script src="<?php echo URL; ?>static/js/jquery.tinycarousel.min.js" type="text/javascript"></script>
        <script src="<?php echo URL; ?>static/js/geral_home.js" type="text/javascript"></script>

        <title>SUA Focal Point</title>   

    </head>

    <body>
        <!--HEADER SITE(LOGO, MENU)-->
        <div class="header">

            <div class="center">

                <div class="login">
                    <?php if (isset($_SESSION['login'])) : ?>
                        <div id="box-bt-entrar">
                            <a title="Entrar" href="<?php echo URL . $_SESSION['login']; ?>"><img alt="Entrar" src="static/img/bt-entrar.jpg" /></a>    
                        </div>
                    <?php else : ?>
                        <img src="static/img/login-header.jpg" alt="Login" title="Login" width="42" height="43"/>
                        <form id="login" method="post" action="">
                            <div class="campo">
                                <input id="input_login" class="required login" type="text" name="login_topo" />
                                <?php echo $retorno; ?>
                            </div>
                            <div class="campo">
                                <input class="required senha" type="password" name="senha" value="" />
                            </div>
                            <input type="submit" value="">
                        </form>
                        <a href="home/inscreva-se/dados-cadastro">- Cadastre-se</a>
                        <a href="home/esqueci-minha-senha">- Esqueci a senha</a>
                    <?php endif; ?>
                </div>

            </div>

        </div>
        <!--HEADER SITE(LOGO, MENU)-->

        <!--CONTEUDO SITE-->        
        <div class="content">                	                      
            <?php Page::show(); ?>
        </div>
        <!--CONTEUDO SITE-->

        <!--RODAPÉ SITE-->
        <div class="footer">

            <div class="center">

                <div class="menu" style="width: 835px;">
                    <ul>
                        <li class="first"><a href="home">HOME</a></li>
                        <li><a href="home/sua-focal-point">SUA FOCAL POINT</a></li>
                        <li><a href="home/inscreva-se/dados-cadastro">INSCREVA-SE</a></li>
                        <li><a href="home/convide-seu-corretor">CONVIDE SEU CORRETOR</a></li>
                        <li><a href="home/conheca-corretores">CONHEÇA CORRETORES</a></li>
                        <li><a href="home/duvidas-frequentes">DÚVIDAS FREQUENTES</a></li>
                        <li class="last"><a href="home/fale-conosco">FALE CONOSCO</a></li>
                    </ul>
                </div>

                <div class="click-house" style="width: 115px;">
                    <a href="home" class="house"><img src="static/img/footer_10.png" /></a>
                    <a href="http://www.clickdesigner.com" target="_blank" class="click"><img src="static/img/footer_21.png" /></a>
                </div>

                <div class="copyright">
                    <p>© 2011 SUA Focal Point. Todos os direitos reservados.</p>
                    <p id="ie7" style="display: none; text-decoration: underline;">Página melhor visualizada nos navegadores: firefox, safari, chrome e IE 8 ou superior.</p>
                </div>

            </div>
        </div>
        <!--RODAPÉ SITE-->

    </body>

</html>

