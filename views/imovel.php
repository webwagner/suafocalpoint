 <link rel="stylesheet" type="text/css" href="<?php echo URL; ?>static/css/jquery-lightbox-min-0.5.css" />

<script src="<?php echo URL;?>static/js/jquery.tinycarousel.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo URL;?>static/js/jquery-lightbox-min-0.5.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">   
    function mapa(){

        var geocoder = new google.maps.Geocoder();
        var address = $("#localizacao").val();

        if (geocoder) {
            geocoder.geocode( { 'address': address}, function(results, status) {

                var myLatlng = new google.maps.LatLng(results[0].geometry.location);
                var myOptions = {
                zoom: 20,
                center: myLatlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
                }
                map = new google.maps.Map(document.getElementById("map_canvas"), myOptions); 
                map.setZoom(14);
                map.setCenter(results[0].geometry.location);

            });
        }


    }

    $(document).ready(function(){

        <?php if($localizacao != "") :?>
            mapa();
        <?php endif;?>

        $('a.lightbox').lightBox({
            imageLoading:  'static/img/lightbox-ico-loading.gif', 
            imageBtnPrev:  'static/img/lightbox-btn-prev.gif',    
            imageBtnNext:  'static/img/lightbox-btn-next.gif',  
            imageBtnClose: 'static/img/lightbox-btn-close.gif',  
            imageBlank:    'static/img/lightbox-blank.gif'
        })

        $('.slideshow').each(function(x){
        $('#slide_imoveis_fotos_'+(x+1)+' .next').click(function(){
            var quant = $('#slide_imoveis_fotos_'+(x+1)+' li').length;
            var tag1 = $('#slide_imoveis_fotos_'+(x+1)+' .show').attr('rel'); 

            if(parseInt(tag1) + 1 > quant)
                tag2 = 1;
            else
                var tag2 = (parseInt(tag1)+ 1);

            $('#slide_imoveis_fotos_'+(x+1)+' .show').removeClass('show').addClass('hide');
            $('#slide_imoveis_fotos_'+(x+1)+' #ft_imov_'+tag2).removeClass('hide').addClass('show');
        })
        $('#slide_imoveis_fotos_'+(x+1)+' .prev').click(function(){
            var quant = $('#slide_imoveis_fotos_'+(x+1)+' li').length;
            var tag1 = $('#slide_imoveis_fotos_'+(x+1)+' .show').attr('rel'); 

            if(parseInt(tag1)- 1 < 1)
                tag2 = quant;
            else
                var tag2 = (parseInt(tag1)- 1);

            $('#slide_imoveis_fotos_'+(x+1)+' .show').removeClass('show').addClass('hide');
            $('#slide_imoveis_fotos_'+(x+1)+' #ft_imov_'+tag2.toString()).removeClass('hide').addClass('show');
        })
        })

        $("#enviar-email-imv").click(function(){
           
            var emails_env = $("#env_emails").val();
            var mensagem = "";
            
            if($("#mensagem_email").val() != "" && $("#mensagem_email").val() != "Mensagem")
                var mensagem = $("#mensagem_email").val();
            
            if(emails_env != "" && emails_env != "E-mail"){
                $.get('enviar_imovel.php',
                    {
                        login: '<?php echo $_SESSION['usuario_logado']->login;?>', 
                        login2: '<?php echo $_SESSION['usuario_visitado']->login;?>', 
                        nome: '<?php echo $_SESSION['usuario_logado']->nome;?>', 
                        email: '<?php echo $_SESSION['usuario_logado']->email;?>', 
                        tel: '<?php echo $_SESSION['usuario_logado']->telefone;?>', 
                        foto: '<?php echo $_SESSION['usuario_logado']->foto_perfil;?>', 
                        id_imovel : '<?php echo $imovel->id;?>',
                        mensagem : mensagem,
                        emails: emails_env
                    },
                    function(txt){
                        jAlert(txt, 'Enviar Imóvel');
                })
            }
            else{
                jAlert("Preencha o E-mail!", 'Enviar Imóvel');
            }

        })
        
        $("#env_emails, #mensagem_email").click(function(){
            if($(this).val() == "E-mail" || $(this).val() == "Mensagem")
                $(this).val("");
        })
        
        $("#bt-voltar-mercado").click(function(){
            jConfirm('Tem certeza que deseja fazer o imóvel voltar ao mercado?', 'Voltar ao mercado', function(r) {
            if(r){
                $("#form-voltar-mercado").submit();
            }
            });
        })

    })
</script>
<div id="content">
    
    <div class="page">
        
        <?php if($localizacao != "") :?>
            <input type="hidden" id="localizacao" value="<?php echo substr($localizacao,0,-2);?>" />
        <?php endif;?>
        
        <div class="breadcumbs">
            <span>Imóveis > <?php echo $imovel->codigo_imovel;?> - <?php echo $imovel->titulo;?></span>
        </div>
        
        <?php echo $voltar;?>
        
        <?php if(isset($_SESSION['login'])) :
            if($_SESSION['login'] == url()) :?>
                <a href="<?php echo $_SESSION['login'];?>/editar-imovel-dados/<?php echo $imovel->titulo_url;?>" class="editar">editar</a>
                <?php if($imovel->vencimento_contrato != "") :?>
                    <form id="form-voltar-mercado" style="margin: 0; float: none; width: auto;" action="" method="POST">
                        <input type="hidden" name="vencimento_contrato" value="<?php echo $imovel->vencimento_contrato;?>" />
                        <input type="hidden" name="id" value="<?php echo $imovel->id;?>" />
                        <input id="bt-voltar-mercado" type="button" style="float: left; cursor: pointer; padding: 5px; margin: 20px 0 0 30px; width: 125px; background-color: #86c8eb; color: #fff;" value="Voltar ao mercado" />
                    </form>
                <?php endif;?>
            <?php else :?>
                <a href="<?php echo $_SESSION['login'];?>/mensagem-enviar/<?php echo $_SESSION['usuario_visitado']->id;?>/solicitacao/<?php echo $imovel->id;?>" style="margin:20px 50% 10px 0;" class="sol-visita">solicitar visita</a>
            <?php endif;?>
        <?php endif;?>

        <div class="imoveis-fotos">
            
            <div class="fotos">            
                <?php echo $html_fotos;?> 
            </div>

        </div>
        
        <div class="imoveis-descricao">
            
            <p>Data de Cadastro: <font><?php echo converteData($imovel->data_cadastro).' '.  substr($imovel->data_cadastro, 10);?></font></p>
            
            <?php if(isset($_SESSION['login']) && $_SESSION['login'] == url()) :?>
                <?php if($imovel->vencimento_contrato != "") :?><p><strong>Data de vencimento do contrato</strong><br /><font><?php echo $imovel->vencimento_contrato;?></font></p><?php endif;?>
            <?php else :?>
                <p><strong>Corretor(a): </strong><br />
                <font><a href="<?php echo URL.$_SESSION['usuario_visitado']->login;?>" class="link_corretor"><?php echo $_SESSION['usuario_visitado']->nome;?></a></font></p>
            <?php endif;?>

            <?php if($imovel->data_volta_mercado != "") :?>
                <p><strong>Volta ao Mercado</strong><br /><font><?php echo $imovel->data_volta_mercado;?></font></p>
            <?php endif;?>
                
            <p><?php echo $bairro;?> - <?php echo $city;?>/<?php echo $uf;?><br /><?php echo ($imovel->nome_condominio != "") ? 'Condomínio : <font>'.$imovel->nome_condominio.'</font>' : '';?></p>
            
            <p>Tipo: <font><?php echo $tipo->nome;?></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                
            <?php if($imovel->residencial == 'SIM') :?>
                Residencial:
                <?php if($imovel->aluguel == 'SIM' && $imovel->compra == 'SIM') {?>
                    <font>Aluguel e Venda</font><br />
                <?php } elseif($imovel->aluguel == 'SIM') {?>
                    <font>Aluguel</font><br />
                <?php } else {?>
                    <font>Venda</font><br />
                <?php } ?>    
            <?php endif;?>
                
            <?php if($imovel->comercial == 'SIM') :?>
                Comercial:
                <?php if($imovel->aluguel == 'SIM' && $imovel->compra == 'SIM') {?>
                    <font>Aluguel e Venda</font><br />
                <?php } elseif($imovel->aluguel == 'SIM') {?>
                    <font>Aluguel</font><br />
                <?php } else {?>
                    <font>Venda</font><br />
                <?php } ?>    
            <?php endif;?>
            
            Quartos: <font><?php echo $imovel->quartos_atual;?></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
            
            <p>
                Área Construída: <font><?php echo $imovel->area_construida;?> m²</font><br />
                Área Externa: <font><?php echo $imovel->area_externa;?> m²</font><br />
                Terreno: <font><?php echo $imovel->terreno;?> m²</font><br />
                Piscina: <font><?php echo $imovel->piscina;?></font><br />
                Mobiliado: <font><?php echo $imovel->mobiliado;?></font><br />
                Portaria 24h: <font><?php echo $imovel->portaria_24h;?></font><br />
                Varanda: <font><?php echo $imovel->varanda;?></font>
            </p>
            
            <?php if($imovel->valor_aluguel != "") :?>
                <p><strong>Para Aluguel</strong><br /><font>Aluguel em Reais - R$ <?php echo number_format($imovel->valor_aluguel,2,',','.');?></font></p>
            <?php endif;?>
              
            <?php if($imovel->valor_venda != "") :?>
                <p><strong>Para Venda</strong><br /><font>Preço em Reais - R$ <?php echo number_format($imovel->valor_venda,2,',','.');?></font></p>
            <?php endif;?>
            
            <?php if($imovel->valor_iptu != "") :?>
                <p><strong>Valor do IPTU</strong><br /><font>Preço em Reais - R$ <?php echo number_format($imovel->valor_iptu,2,',','.');?></font></p>
            <?php endif;?>
            
            <?php if($imovel->valor_condominio != "") :?>
                <p><strong>Valor do Condomínio</strong><br /><font>Preço em Reais - R$ <?php echo number_format($imovel->valor_condominio,2,',','.');?></font></p>
            <?php endif;?>
            
            <?php if($imovel->informacoes_adicionais != "") :?>
                <p>
                    <strong>Informações Adicionais:</strong><br />
                    <font><?php echo $imovel->informacoes_adicionais;?></font>
                </p>
            <?php endif;?>
                
            <?php if($imovel->informacoes_adicionais_corretores != "") :?>
                <p>
                    <strong>Informações Adicionais para Corretores:</strong><br />
                    <font><?php echo $imovel->informacoes_adicionais_corretores;?></font>
                </p>
            <?php endif;?>
                
            <p>
                <strong>Enviar por E-mail:</strong><br />
                <label style="float: left; width: auto; height: auto;" />
                    <input style="width: 235px; color: #999999;" value="E-mail" type="text" id="env_emails" name="env_emails" />
                </label>
                <span style="float: left; margin: 2px 0 5px 0; color:#999; font-size: 11px;">*Separe os e-mails por vírgula.</span>
                <label>
                    <textarea style="height: 60px; color: #999999; width: 235px;" id="mensagem_email">Mensagem</textarea>
                </label>
                <input id="enviar-email-imv" style="float: right; cursor: pointer; height: 30px; margin-top: 5px; width: 55px; background-color: #86c8eb; color: #fff;" type="button" value="Enviar" />
            </p>
            
        </div>
        
        <?php if($localizacao != "") :?>
        <div class="imoveis-mapa">
            <p style="margin-bottom: 10px;">Área Aproximada do Imóvel</p>
            <div style="width: 425px; height: 350px;" id="map_canvas"></div>
        </div>
        <?php endif;?>
                
        <?php if(isset($_SESSION['login']) && $_SESSION['login'] == url()) :?>
            <div class="imoveis-descricao imoveis-d">

                <p><strong>Corretor: </strong>
                <a href="<?php echo $_SESSION['login'];?>" class="link_corretor"><?php echo $_SESSION['usuario_logado']->nome;?></a>
                </p>
                <p><strong>Dados Privados</strong></p><br /><br />

                <?php if($imovel->endereco != "") :?>
                <p>
                    <strong>Endereço do Imóvel:</strong><br />
                    <?php echo $imovel->endereco;?><br />
                    <?php echo ($imovel->cep != "") ? 'CEP : '.$imovel->cep : '';?><br />
                </p>
                <?php endif;?>

                <p>
                    <?php echo ($imovel->nome_proprietario != "") ? '<strong>Nome Proprietário: </strong><font>'.$imovel->nome_proprietario.'</font><br />' : '';?>
                    <?php echo ($imovel->telefone_proprietario != "") ? '<strong>Telefone Proprietário: </strong><font>'.$imovel->telefone_proprietario.'</font><br />' : '';?>
                    <?php echo ($imovel->email_proprietario != "") ? '<strong>Email Proprietário: </strong><font>'.$imovel->email_proprietario.'</font><br />' : '';?>
                </p>

                <?php if($imovel->endereco_proprietario != "") :?>
                <p>
                    <strong>Endereço do Proprietário:</strong><br />
                    <?php echo $imovel->endereco_proprietario;?><?php echo ($imovel->cep != "") ? ' - '.$imovel->bairro_proprietario : '';?><br />
                    <?php echo ($imovel->cidade_proprietario != "") ? $imovel->cidade_proprietario : '';?><?php echo ($imovel->cep != "") ? ' CEP : '.$imovel->cep_proprietario : '';?><br />
                </p>
                <?php endif;?>

            </div>

            <?php if($imovel->observacoes != "") :?>
            <div class="imoveis-descricao">
                <p>
                    <strong><font>Observações</font></strong><br />
                    <?php echo $imovel->observacoes;?>
                </p>
            </div>
            <?php endif;?>
              
        <?php endif;?>
                
        <?php if(isset($_SESSION['login'])) :
            if($_SESSION['login'] == url()) :?>
                <a href="<?php echo $_SESSION['login'];?>/editar-imovel-dados/<?php echo $imovel->titulo_url;?>" class="editar">editar</a>
            <?php else :?>
                <a href="<?php echo $_SESSION['login'];?>/mensagem-enviar/<?php echo $_SESSION['usuario_visitado']->id;?>/solicitacao/<?php echo $imovel->id;?>" style="margin:20px 0 0 15px;" class="sol-visita">solicitar visita</a>
            <?php endif;?>
        <?php endif;?>
   
    </div>

    
</div>
