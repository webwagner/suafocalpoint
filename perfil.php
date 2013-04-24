<?php
/**
* Destroy a sessao
*/
$tempo_sessao = (21600 * 60); //15 dias

if (!isset($_SESSION['start_time'])) 
    $_SESSION['start_time'] = time();

if((time() - $_SESSION['start_time']) > $tempo_sessao) 
    session_destroy();

/**
* Verifica se existe um perfil visitado se sim deleta as informações armazenadas
*/
if(isset($_SESSION['usuario_visitado']))
    unset($_SESSION['usuario_visitado']);

/**
* Verifica se existe um usuário logado 
*/
if(isset($_SESSION['login'])){   
    /**
    * Salva as informações do usuário logado
    */
    $mapper = new Mapper();
    $mapper->setDbTable(new Corretor());
    $mapper->setWhere('login = "'.$_SESSION['login'].'"');
    $_SESSION['usuario_logado'] = $mapper->getRow();
    
    /**
    * Pega a quantidade de imóveis
    */
    $mapper_imoveis = new Mapper();
    $mapper_imoveis->setDbTable(new Imovel());
    $mapper_imoveis->setWhere('vencimento_contrato = "" and id_corretor = '.$_SESSION['usuario_logado']->id);  
    $total_imoveis = $mapper_imoveis->getTotal();
    
    /**
    * Pega a quantidade de lembrete de imóveis
    */
    $mapper_lembrete_imoveis = new Mapper();
    $mapper_lembrete_imoveis->setDbTable(new Imovel());
    $mapper_lembrete_imoveis->setWhere('vencimento_contrato != "" and id_corretor = '.$_SESSION['usuario_logado']->id);  
    $total_lembrete_imoveis = $mapper_lembrete_imoveis->getTotal();
    
    /**
    * Pega a quantidade de alertas
    */
    $mapper_alerta = new Mapper();
    $mapper_alerta->setDbTable(new Alerta());
    $mapper_alerta->setWhere('id_corretor = '.$_SESSION['usuario_logado']->id);  
    $total_alerta = $mapper_alerta->getTotal();
    
    /**
    * Pega a quantidade de imóveis incompletos
    */
    $mapper_imoveis_incompletos = new Mapper();
    $mapper_imoveis_incompletos->setDbTable(new Imovel());
    $mapper_imoveis_incompletos->setWhere('id_corretor = '.$_SESSION['usuario_logado']->id.'');  
    $imoveis = $mapper_imoveis_incompletos->getRows();
    
    $mapper_album = new Mapper();
    $mapper_album->setDbTable(new ImovelAlbum());
    
    $imoveis_incompletos = array();
    
    if($imoveis){
        foreach($imoveis as $imov){
            $mapper_album->setWhere('imovel_id = '.$imov->id.'');
            if(!$mapper_album->getRow())
                $imoveis_incompletos[] = $imov->id."<br>";
        }
    }
    
    $imoveis_incompletos = array_unique($imoveis_incompletos);
    $imoveis_incompletos = count($imoveis_incompletos);
    
    /**
    * Pega a quantidade de solicitações de contato
    */
    $mapper_solicitacoes_contato = new Mapper();
    $mapper_solicitacoes_contato->setDbTable(new Contatos());
    $mapper_solicitacoes_contato->setWhere('aceitou = "NAO" and corretor_recebeu_id = "'.$_SESSION['usuario_logado']->id.'"');
    $solicitacoes_contato = $mapper_solicitacoes_contato->getTotal();
    
    /**
    * Pega a quantidade de novas mensagens
    */
    $mapper_mensagens = new Mapper();
    $mapper_mensagens->setDbTable(new Mensagens());
    $mapper_mensagens->setWhere('corretor_recebeu_id = "'.$_SESSION['usuario_logado']->id.'" and lida_recebeu = "NAO" and exclui_recebeu = "NAO"');
    $novas_mensagens = $mapper_mensagens->getTotal();
}

/**
* Verifica se está visitando um perfil e armazena as informações do perfil visitado
*/
$mapper = new Mapper();
$mapper->setDbTable(new Corretor());
$mapper->setWhere('login = "'.url().'"');
$row = $mapper->getRow();

if($row){   
    $_SESSION['usuario_visitado'] = $row;
    
    /**
    * Pega a quantidade de contatos
    */
    $mapper = new Mapper();
    $mapper->setDbTable(new Contatos());
    $mapper->setWhere('(aceitou = "SIM" and corretor_enviou_id = "'.$_SESSION['usuario_visitado']->id.'") or (aceitou = "SIM" and corretor_recebeu_id = "'.$_SESSION['usuario_visitado']->id.'")');
    $total_contatos = $mapper->getTotal();   
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    
    <base src="<?php echo URL; ?>" href="<?php echo URL; ?>" />
        
    <link rel="stylesheet" type="text/css" href="<?php echo URL; ?>static/css/style.css" />
    
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js" type="text/javascript"></script>
    <script src="<?php echo URL;?>static/js/geral_perfil.js" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            $("#add_contato").click( function() {
                var contato = $(this).attr('rel');
                jConfirm('Tem certeza que deseja adicionar '+contato+' ?', 'Adicionar Contato', function(r) {
                if(r){
                    $.getJSON('add_del_contato.php',{type: 'add', id_enviou : '<?php echo $_SESSION["usuario_logado"]->id;?>', id_recebeu : '<?php echo $_SESSION["usuario_visitado"]->id;?>'} ,function(txt){
                        if(txt.valor == 'YES'){
                            jAlert("Aguardando confirmação de "+contato, 'Adicionar Contato');
                            window.location.href = window.location.href;
                        }
                    })           
                }
                });
            });
            
            $("#del_contato").click( function() {
                var contato = $(this).attr('rel');
                jConfirm('Tem certeza que deseja excluir '+contato+' ?', 'Excluir Contato', function(r) {
                if(r){
                    $.getJSON('add_del_contato.php',{type: 'del', id_enviou : '<?php echo $_SESSION["usuario_logado"]->id;?>', id_recebeu : '<?php echo $_SESSION["usuario_visitado"]->id;?>'} ,function(txt){
                        if(txt.valor == 'YES'){
                            jAlert("Contato "+contato+" excluido", 'Excluir Contato');
                            window.location.href = window.location.href;
                        }
                    })           
                }
                });
            });
       });
    </script>
    
    <title>Sua Focal Point</title>
    
</head>

<body>

    <div id="header">
    
        <div class="meio">
        
            <div id="logo">
                <a href="<?php echo (isset($_SESSION['login'])) ? $_SESSION['login'] : 'home';?>" title="Sua Focal Point - Rede de Ferramentas Para Corretores">
                    <img src="static/img/logo_02.gif" alt="Sua Focal Point - Rede de Ferramentas Para Corretores" border="0" />
                </a>
            </div>
            <?php if(isset($_SESSION['login'])) :?>
            <div id="login">
                <p>
                    <span>Olá,
                    <span class="nome"><strong><?php echo ($_SESSION['usuario_logado']->nome) ? $_SESSION['usuario_logado']->nome : '';?></strong></span>
                    </span>
                </p>
                <a href="javascript:void(0)" id="editar-perfil"></a>
                <ul id="aparece-perfil">
                    <li style="margin-top: 22px;"><a href="<?php echo $_SESSION['login'];?>/editar-perfil/dados-perfil"><span>Editar Perfil</span></a></li>
                    <li><a href="home/nova-senha/<?php echo $_SESSION['usuario_logado']->id;?>"><span>Alterar Senha</span></a></li>
                    <li><a href="<?php echo $_SESSION['login'];?>/sair"><span>Sair</span></a></li>
                 </ul>
            </div>
            <ul id="menu">
                <li>
                    <a href="<?php echo $_SESSION['login'];?>/cadastro-imovel" id="bg-menu-1" class="clicado1" >
                    <img src="static/img/add-imoveis.png" alt="Adicionar Imóveis" />
                        <span>ADICIONAR IMÓVEIS<br />
                        Cadastre seus imóveis
                        </span> 
                    </a>
                </li>
                <li >
                    <a href="<?php echo $_SESSION['login'];?>/imoveis-contato/todos" id="bg-menu-2" class="clicado1">
                    <img src="static/img/imoveis.png" alt="Imóveis" />
                        <span>IMÓVEIS<br />
                        Seus imóveis e imóveis da rede
                        </span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $_SESSION['login'];?>/corretores" id="bg-menu-3" class="clicado2">
                    <img src="static/img/contatos.png" alt="Contatos" />
                        <span>PARCEIROS<br />
                        Conheça a rede
                        </span>
                    </a>
                </li>
                <li >
                    <a href="home/fale-conosco" id="bg-menu-4">
                    <img src="static/img/fale-conosco.png" alt="Fale Conosco" />
                        <span>FALE CONOSCO<br />
                        Tire suas dúvidas
                        </span>
                    </a>
                </li>
            </ul>
            <?php endif;?>
        </div>
        
    </div>
    
    <div id="main">
        
        <div class="meio">
            
            <div id="nav">
                <div id="foto">

                    <?php
                    if(isset($_SESSION['usuario_visitado']->foto_perfil) ) : 
                        if( $_SESSION['usuario_visitado']->foto_perfil != '' ) :?>
                            <a href="<?php echo $_SESSION['usuario_visitado']->login;?>"><img src="library/phpthumb/phpThumb.php?src=<?php echo URL_ABSOLUTE;?>static/uploads/fotos/<?php echo $_SESSION['usuario_visitado']->login.'/'.$_SESSION['usuario_visitado']->foto_perfil.'&w=169';?>" alt="<?php echo $_SESSION['usuario_visitado']->nome;?>"  /></a>
                        <?php else :?>
                            <a href="<?php echo $_SESSION['usuario_visitado']->login;?>"><img src="static/img/perfil-focalpoint.jpg" alt="<?php (isset($_SESSION['usuario_visitado']->nome)) ? $_SESSION['usuario_visitado']->nome : '' ;?>"  /></a>
                        <?php endif;
                    endif;
                    ?>
                        
                    <?php if(isset($_SESSION['login']) && isset($_SESSION['usuario_visitado'])) :?>
                    <p>
                        <span><?php echo (isset($_SESSION['usuario_visitado']->nome)) ? $_SESSION['usuario_visitado']->nome : '';?></span>
                        <?php echo ($_SESSION['usuario_visitado']->cnpj != "") ? $_SESSION['usuario_visitado']->pessoa_contato : $_SESSION['usuario_visitado']->empresa;?>
                    </p>
                    <?php endif;?>
                        
                </div>
                <?php if(isset($_SESSION['login']) && isset($_SESSION['usuario_visitado'])) :

                    /**
                    * Usuário visitando o próprio perfil
                    */
                    if($_SESSION['usuario_visitado']->login == $_SESSION['login']) :                   
                        echo ($_SESSION['usuario_visitado']->creci != "") ? '<div id="num-creci"><p>CRECI Nº '.$_SESSION['usuario_visitado']->creci.'</p></div>' : '';
                        
                        if(url(2) == 'editar-perfil') : ?>  
                        <ul class="menu-dados">
                            <li <?php echo (url(3) == 'dados-perfil' ? 'class="hover"' : '');?>><a href="<?php echo $_SESSION['login'];?>/editar-perfil/dados-perfil">Dados Gerais</a></li>
                            <li <?php echo (url(3) == 'dados-contato' ? 'class="hover"' : '');?>><a href="<?php echo $_SESSION['login'];?>/editar-perfil/dados-contato">Dados de Contato</a></li>                           
                            <li <?php echo (url(3) == 'dados-imagem' ? 'class="hover"' : '');?>><a href="<?php echo $_SESSION['login'];?>/editar-perfil/dados-imagem">Imagem de Exibi&ccedil;&atilde;o</a></li>                          
                            <li <?php echo (url(3) == 'dados-pacote' ? 'class="hover"' : '');?>><a href="<?php echo $_SESSION['login'];?>/editar-perfil/dados-pacote">Comprar Pacote</a></li>
                            <li <?php echo (url(3) == 'dados-plano' ? 'class="hover"' : '');?>><a href="<?php echo $_SESSION['login'];?>/editar-perfil/dados-plano">Alterar Plano</a></li>
                        </ul>
                        
                        <?php elseif(url(2) == 'editar-imovel-dados' || url(2) == 'editar-imovel-fotos'|| url(2) == 'editar-imovel-observacoes'):?>
                        <ul class="menu-dados">
                            <li <?php echo (url(2) == 'editar-imovel-dados' ? 'class="hover"' : '');?>><a href="<?php echo $_SESSION['login'];?>/editar-imovel-dados/<?php echo url(3);?>">Dados Públicos</a></li>
                            <li <?php echo (url(2) == 'editar-imovel-fotos' ? 'class="hover"' : '');?>><a href="<?php echo $_SESSION['login'];?>/editar-imovel-fotos/<?php echo url(3);?>">Fotos do Imóvel</a></li>         
                            <li <?php echo (url(2) == 'editar-imovel-observacoes' ? 'class="hover"' : '');?>><a href="<?php echo $_SESSION['login'];?>/editar-imovel-observacoes/<?php echo url(3);?>">Informações privadas</a></li>                          
                        </ul>
                
<!--                    <a href="<?php //echo $_SESSION['login'];?>/busca-mapa" class="busque-mapa"><img src="static/img/lembrete-imoveis_03.jpg" width="169" height="144" alt="Busque no Mapa" title="Busque no Mapa" /></a>-->

                        <?php else :?>
                        <ul id="menu-nav">
                            <li id="bt-editar-perfil"> <a href="<?php echo $_SESSION['login'];?>/editar-perfil/dados-perfil">Editar Perfil</a></li>      
                            <li id="bt-minha-pagina"> <a href="<?php echo $_SESSION['login'];?>/minha-pagina">Minha Página</a></li>
                            <li id="bt-minha-pagina"> <a href="<?php echo $_SESSION['login'];?>/editar-perfil/dados-plano">Alterar Plano</a></li>
                            <li id="bt-minha-pagina"> <a href="<?php echo $_SESSION['login'];?>/editar-perfil/dados-pacote">Comprar Pacote</a></li>
                            <?php if($solicitacoes_contato > 0 || $novas_mensagens > 0 || $imoveis_incompletos > 0) :?>
                            <li id="bt-notificacoes">  
                                <div id="notificacoes">
                                    <h3>Notificações</h3>
                                    <?php if($solicitacoes_contato > 0) :?>
                                    <div class="notificacao">
                                        <span><?php echo $solicitacoes_contato;?></span>
                                        <p><a href="<?php echo $_SESSION['login'];?>/solicitacoes-contato">Solicitações de Contato</a></p>
                                    </div>
                                    <?php endif;
                                    if($novas_mensagens > 0) :?>
                                    <div class="notificacao">
                                        <span><?php echo $novas_mensagens;?></span>
                                        <p><a href="<?php echo $_SESSION['login'];?>/mensagens/recebidas">Novas Mensagens</a></p>
                                    </div>
                                    <?php endif;
                                    if($imoveis_incompletos > 0) :?>
                                    <div class="notificacao">
                                        <span><?php echo $imoveis_incompletos;?></span>
                                        <p><a href="<?php echo $_SESSION['login'];?>/imoveis-incompletos">Imóveis Incompletos</a></p>
                                    </div>
                                    <?php endif;?>
                                    <p class="traco">&nbsp;</p>
                                </div>
                            </li>
                            <?php endif;?>
                            <li id="bt-mensagens"><a href="<?php echo $_SESSION['login'];?>/mensagens/recebidas"><img src="static/img/icon-mensagens_14.jpg" alt="Mensagens" /><span>Mensagens</span></a></li>
                            <li id="bt-contatos"><a href="<?php echo $_SESSION['login'];?>/contatos"><img src="static/img/icon-contato_18.jpg" alt="Contatos" /><span>Parceiros</span></a></li>
                        </ul>

                        <a href="<?php echo $_SESSION['login'];?>/cadastro-imovel" id="bt-add-imoveis"><span>Adicionar Imóveis</span></a>

                        <ul id="menu-nav-2">
                            <li><a href="<?php echo $_SESSION['login'];?>/meus-imoveis" id="bt-meus-imv"><span>Meus Imóveis</span></a><span class="num"><?php echo $total_imoveis;?></span></li>
                            <li><a href="<?php echo $_SESSION['login'];?>/lembrete-imoveis" id="bt-imv-a-vencer"><span>LEMBRETE DE IMÓVEIS</span></a><span class="num"><?php echo $total_lembrete_imoveis;?></span></li>
                            <li><a href="<?php echo $_SESSION['login'];?>/contatos"><span>Meus Parceiros</span></a><span class="num"><?php echo $total_contatos;?></span></li>
                            <li><a href="<?php echo $_SESSION['login'];?>/alerta"><span>Alerta</span></a><span class="num"><?php echo $total_alerta;?></span></li>
                        </ul>

                        <a href="<?php echo $_SESSION['login'];?>/contatos" id="ver-todos"></a>
                        <a href="<?php echo $_SESSION['login'];?>/amplie-sua-rede" id="convidar"></a>
                    
                     <?php 
                        endif;
                     /**
                     * Usuário visitando outro perfil
                     */
                     else :                      
                         /**
                         * Verifica se são amigos
                         */
                         $mapper_contatos = new Mapper();
                         $mapper_contatos->setDbTable(new Contatos());
                         $mapper_contatos->setWhere('aceitou = "SIM" and corretor_enviou_id = "'.$_SESSION['usuario_logado']->id.'" and corretor_recebeu_id = "'.$_SESSION['usuario_visitado']->id.'" or aceitou = "SIM" and corretor_enviou_id = "'.$_SESSION['usuario_visitado']->id.'" and corretor_recebeu_id = "'.$_SESSION['usuario_logado']->id.'"');
                         $row3 = $mapper_contatos->getRow();
                         
                         if($row3) :
                            $acao = '<li id="bt-contatos"><a href="javascript:void(0)" id="del_contato" rel="'.$_SESSION['usuario_visitado']->nome.'" class="nav-perfil"><img src="static/img/icon-contato_18.jpg" alt="Excluir Contato" /><span>Excluir Contato</span></a></li>';
                         else :
                            /**
                            * Verifica se tem pedido de amizade
                            */
                            $mapper_contatos = new Mapper();
                            $mapper_contatos->setDbTable(new Contatos());
                            $mapper_contatos->setWhere('aceitou = "NAO" and corretor_enviou_id = "'.$_SESSION['usuario_logado']->id.'" and corretor_recebeu_id = "'.$_SESSION['usuario_visitado']->id.'" or aceitou = "NAO" and corretor_enviou_id = "'.$_SESSION['usuario_visitado']->id.'" and corretor_recebeu_id = "'.$_SESSION['usuario_logado']->id.'"');
                            $row4 = $mapper_contatos->getRow();                           
                            if($row4) :
                                $acao = '<li id="bt-contatos"><a href="javascript:void(0)" class="nav-perfil"><img src="static/img/icon-contato_18.jpg" alt="Aguardando confirmação" /><span>Aguardando Confirmação</span></a></li>';                            
                            else :
                                $acao = '<li id="bt-contatos"><a href="javascript:void(0)" id="add_contato" class="nav-perfil" rel="'.$_SESSION['usuario_visitado']->nome.'"><img src="static/img/icon-contato_18.jpg" alt="Adicionar Contato" /><span>Adicionar Contato</span></a></li>';
                            endif;
                         endif; ?>
                        
                         <ul id="menu-nav">
                             <?php echo $acao;?>
                            <li id="bt-mensagens"><a href="<?php echo $_SESSION['login'];?>/mensagem-enviar/<?php echo $_SESSION['usuario_visitado']->id;?>" class="nav-perfil"><img src="static/img/icon-mensagens_14.jpg" alt="Enviar Mensagem" /><span>Enviar Mensagem</span></a></li>    
                         </ul>
                        
                         <ul id="menu-nav-2">
                            <li><a href="javascript:void(0)" style="cursor: default;" id="bt-meus-contatos"><span>Parceiros</span></a><span class="num"><?php echo $total_contatos;?></span></li>
                         </ul>
                        
                     <?php endif;
                     endif; ?>
                    
            </div>
            
            <?php Page::show(); ?>    

        </div>
            
    </div>
    
    <div id="footer">
    
    	<div class="meio">
        
            <ul id="links-footer">
                <li><a href="<?php echo $_SESSION['login'];?>">HOME</a></li>
                <li>|</li>
                <li><a href="<?php echo $_SESSION['login'];?>/sua-focal-point">SUA FOCAL POINT</a></li>
                <li>|</li>
                <li><a href="<?php echo $_SESSION['login'];?>/duvidas-frequentes">DÚVIDAS FREQUENTES</a></li>
                <li>|</li>
                <li><a href="<?php echo $_SESSION['login'];?>/amplie-sua-rede">CONVIDE SEU CORRETOR</a></li>
                <li>|</li>
                <li><a href="<?php echo $_SESSION['login'];?>/fale-conosco">FALE CONOSCO</a></li>
            </ul>

            <div id="linha"></div>

            <div id="img-footer"></div>

            <p id="copyright">© 2011 SUA Focal Point. Todos os direitos reservados.</p>

            <div id="creditos-click">
                <a href="http://www.clickdesigner.com" rel="partner" title="Desenvolvido pela Click Designer">
                    <img src="static/img/creditos-click.png" alt="Créditos Click designer" border="0"/>
                </a>
            </div>

                        
        </div>
        
    </div>
    
</body>

</html>
