<link rel="stylesheet" type="text/css" href="<?php echo URL; ?>static/css/jquery-lightbox-min-0.5.css" />
<script type="text/javascript" src="<?php echo URL;?>static/js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo URL;?>static/js/jquery-lightbox-min-0.5.js"></script>
<script type="text/javascript" src="<?php echo URL;?>static/js/maskedmoney.js"></script>
<script>
$(document).ready(function(){
    
    $("#valor_aluguel").maskMoney({thousands:'.', decimal:'', precision:0});
    $("#valor_venda").maskMoney({thousands:'.', decimal:'', precision:0});
    $("#valor_minimo_aluguel").maskMoney({thousands:'.', decimal:'', precision:0});
    $("#valor_minimo_venda").maskMoney({thousands:'.', decimal:'', precision:0});
     
    $('.tipo_busca').click(function(){
        if($(this).val() == 2){
            $('#box-busca-caracteristicas').show('slow');
            $('#box-busca-codigo').hide('slow');
            $('#box-busca-titulo').hide('slow');
        } else if($(this).val() == 3){
            $('#box-busca-titulo').show('slow');
            $('#box-busca-codigo').hide('slow');
            $('#box-busca-caracteristicas').hide('slow');
        } else{
            $('#box-busca-codigo').show('slow');
            $('#box-busca-caracteristicas').hide('slow');
            $('#box-busca-titulo').hide('slow');
        }    
    })
    
    <?php if($uf_corretor->uf == "SP") :?>
    $("#cidade").change(function(){
        
        var cidade = $(this).val();

        $.ajax({
            type: "GET",
            url: "estados_imovel.php",
            data: "acao=buscaBairro&cidade="+cidade+"&id_corretor="+<?php echo $_SESSION['usuario_logado']->id;?>,
            dataType: "xml",
            beforeSend: function () {
                $('.bairro').html('<option value="">Aguarde...</option>');
            },
            success: function (xml) {
                var html = '<option value="">Selecione</option>';
                $(xml).find('bairros').each(function () {
                    $(xml).find('bairro').each(function () {
                        var bairro = $(this).find('nome').text();
                        var id_bairro = $(this).find('id').text();
                        html += "<option value='"+id_bairro+"'>"+bairro+"</option>";
                    });
                });
                $('.bairro').html(html);
            },
            error: function () {
                alert("Ocorreu um erro inesperado durante o processamento.");
            }
        });
        
    })
    <?php else:?>
        var cidade = <?php echo $cidade->id;?>;

        $.ajax({
            type: "GET",
            url: "estados_imovel.php",
            data: "acao=buscaBairro&cidade="+cidade+"&id_corretor="+<?php echo $_SESSION['usuario_logado']->id;?>,
            dataType: "xml",
            beforeSend: function () {
                $('.bairro').html('<option value="">Aguarde...</option>');
            },
            success: function (xml) {
                var html = '<option value="">Selecione</option>';
                $(xml).find('bairros').each(function () {
                    $(xml).find('bairro').each(function () {
                        var bairro = $(this).find('nome').text();
                        var id_bairro = $(this).find('id').text();
                        html += "<option value='"+id_bairro+"'>"+bairro+"</option>";
                    });
                });
                $('.bairro').html(html);
            },
            error: function () {
                alert("Ocorreu um erro inesperado durante o processamento.");
            }
        });
    <?php endif;?>
            
    $('.add-bairro').live("click", function(event){
        
        $('.add-bairro').html('<img src="static/img/bt-menos.gif" alt="- Bairros" />');
        $('.add-bairro').removeClass('add-bairro').addClass('remove-bairro');
        
        if($("#cidade").size() > 0)
            var cidade = $("#cidade").val();
        else
            var cidade = <?php echo $cidade->id;?>;
        
        $.ajax({
            type: "GET",
            url: "estados_imovel.php",
            data: "acao=buscaBairro&cidade="+cidade+"&id_corretor="+<?php echo $_SESSION['usuario_logado']->id;?>,
            dataType: "xml",
            beforeSend: function () {
                var html = '<option value="">Aguarde...</option>';
                $('#label-bairro').append('<select id="bairro_aguarde" class="bairro" style="margin: 0 0 15px 0; float: right;" name="bairro[]">'+html+'</select>' );
            },
            success: function (xml) {
                $('#bairro_aguarde').remove();
                var html = '<option value="">Selecione</option>';
                $(xml).find('bairros').each(function () {
                    $(xml).find('bairro').each(function () {
                        var bairro = $(this).find('nome').text();
                        var id_bairro = $(this).find('id').text();
                        html += "<option value='"+id_bairro+"'>"+bairro+"</option>";
                    });
                });
                $('#label-bairro').append('<span class="bloco" style="width: 105px;"></span><select style="margin: 0 0 15px 0; float: left;" class="bairro" name="bairro[]">'+html+'</select><a style="float: left; margin: 5px 0 0 10px;" class="add-bairro" style="text-decoration: underline; color: #999999; font-size: 15px; " href="javascript:void(0)"><img src="static/img/bt-mais.gif" alt="+ Bairros" /></a>' );
            },
            error: function () {
                alert("Ocorreu um erro inesperado durante o processamento.");
            }
        });
    })
    
    $('.remove-bairro').live("click", function(event){
        $(this).prev().remove();
        $(this).prev('span.bloco').remove();
        $(this).remove();
    })
    
    $('a.lightbox').lightBox({
	imageLoading:  'static/img/lightbox-ico-loading.gif', 
	imageBtnPrev:  'static/img/lightbox-btn-prev.gif',    
	imageBtnNext:  'static/img/lightbox-btn-next.gif',  
	imageBtnClose: 'static/img/lightbox-btn-close.gif',  
	imageBlank:    'static/img/lightbox-blank.gif'
    })
    
    $("#formulario_convidar").submit(function(){  
        var n = 0;
        var e = 0; 
        var i = 0;
        var er = new RegExp(/^[A-Za-z0-9_\-\.]+@[A-Za-z0-9_\-\.]{2,}\.[A-Za-z0-9]{2,}(\.[A-Za-z0-9])?/);
        
        $(".nome_convidar").each(function(){
            if($(this).val() == "")
                n++
        })
        
        $(".email_convidar").each(function(){
            if($(this).val() == "")
                e++
            if(!er.test($(this).val()))
                i++;
        })
        
        if(n > 0){
            $("#erro-nome-convida").show();
            return false;
        }
        else{
            $("#erro-nome-convida").hide();
        }
        
        if(e > 0){
            $("#erro-email-convida").show();
            return false;
        }
        else{
           $("#erro-email-convida").hide(); 
        }
        
        if(i > 0){
            $("#erro-emailvalido-convida").show();
            return false;
        }
        else{
            $("#erro-emailvalido-convida").hide();
        }
    })
    
    $('.add-tipo').live("click", function(event){
        $('.add-tipo').html('<img src="static/img/bt-menos.gif" alt="- Bairros" />');
        $('.add-tipo').removeClass('add-tipo').addClass('remove-tipo');

        var htm = '<span class="bloco2" style="width: 105px;"></span><select style="margin: 0 0 15px 0; float: left;" name="tipo[]">'+$(this).prev('select').html()+'</select><a style="float: left; margin: 5px 0 0 10px;" class="add-tipo" href="javascript:void(0)"><img src="static/img/bt-mais.gif" alt="+ Tipos" /></a>';

        html = $(".tipo").html();
        $(".tipo").html(html+htm);
    })

    $('.remove-tipo').live("click", function(event){
        $(this).prev().remove();
        $(this).prev('span.bloco2').remove();
        $(this).remove();
    })

})
</script>

<div id="content">
    
    <?php if(isset($dias) && $dias < 11) :?>
    <div id="box-vencimento">
        <a href="javascript:void(0)" id="bt-close-vencimento">fechar</a>
        <p>Seu Plano vence<?php echo ($dias != 0 ? ' em '.$dias.' dia(s)' : ' Hoje' );?>.</p>
        <a href="<?php echo URL.'home/renovar-plano/'.$_SESSION['login'];?>" id="bt-renovar">Renovar</a>
    </div>
    <?php endif;?>
    
    <div id="box-imoveis">
    
        <ul id="lista-abas">
            <li><a class="clicado" href="javascript:void(0)"><span>Meus Imóveis</span></a></li>
            <li><a href="javascript:void(0)"><span>Imóveis a Vencer</span></a></li>
            <li><a href="javascript:void(0)" class="link-imoveis-da-minha-rede"><span>Imóveis da Minha Rede</span></a></li>
        </ul>
        
        <div style="display:block;" id="meus-imoveis" class="abas-imoveis">
            <?php echo listaImoveis('meus_imoveis');?>
            <a href="<?php echo $_SESSION['login'];?>/meus-imoveis" id="imv-rede2"><span>Ver todos os Imóveis</span></a>           
         </div>
        
        <div id="imoveis-a-vencer" class="abas-imoveis">
            <?php echo listaImoveis('imoveis_a_vencer');?>
            <a href="<?php echo $_SESSION['login'];?>/lembrete-imoveis" id="imv-rede2"><span>Ver todos os Imóveis</span></a>
        </div>
        
        <div id="imoveis-da-minha-rede" class="abas-imoveis">
            <?php echo listaImoveis('imoveis_minha_rede');?>
            <a href="<?php echo $_SESSION['login'];?>/imoveis-contato/todos" id="imv-rede"><span>Ver todos os Imóveis da Minha Rede</span></a>
        </div>
        
    </div>
    
    <div id="busca-imoveis">
        
        <h2>Busca de Imóveis</h2>
                
        <form action="<?php echo $_SESSION['login'];?>/busca-imoveis/todos" method="post" id="formulario_b">
        
            <label style="width: auto;" class="radio">
                <input checked="checked" class="tipo_busca" type="radio" name="tipo_busca" value="1" />
                <span>Por Código</span>
            </label>
            
            <label style="width: auto;" class="radio">
                <input class="tipo_busca" type="radio" name="tipo_busca" value="3" />
                <span>Por Título</span>
            </label>
        
            <label class="radio">
                <input type="radio" class="tipo_busca" name="tipo_busca" value="2" />
                <span>Por Características</span>
            </label>
        
            <br clear="all" />
            
            <div id="box-busca-codigo">
            
                <label class="codigo">
                    <span>Código do Imóvel <em>(Ex: RRD11)</em></span>
                    <input class="text-codigo" name="codigo" type="text" />
                    <input type="submit" value="Buscar" class="b-av"/>        
                </label>
            
            </div> 
            
            <div id="box-busca-titulo" style="display: none;">
            
                <label class="codigo">
                    <span>Título do Imóvel</span>
                    <input class="text-codigo" name="titulo" type="text" />
                    <input type="submit" value="Buscar" class="b-av"/>        
                </label>
            
            </div> 
                
            <div id="box-busca-caracteristicas" style="display: none;">
            
                <input type="hidden" name="uf" value="<?php echo $uf_corretor->id;?>" />
                
                <?php if($uf_corretor->uf == "SP") :?>
                    <div class="select" style="padding: 0; width: 382px; margin: 0 2px 0 0; height: auto;" id="label-cidade">
                        <span>Filtrar por Cidade</span>
                        <select style="margin: 0 0 15px 0; float: right;" id="cidade" name="cidade">
                            <option value="">Selecione</option>
                            <?php foreach($cidades_sp as $cidade_sp) :?>
                            <option value="<?php echo $cidade_sp->id;?>"><?php echo $cidade_sp->cidade;?></option>   
                            <?php endforeach;?>
                        </select>
                    </div>
                <?php else: ?>
                    <input type="hidden" name="cidade" value="<?php echo $cidade->id;?>" />
                <?php endif;?>

                <div style="float: left;">
                    <div class="select" style="padding: 0; width: 410px; margin: 0 2px 0 0; height: auto;" id="label-bairro">
                        <span>Filtrar por Bairro</span>
                        <select style="margin: 0 0 15px 0; float: left;" class="bairro" name="bairro[]">
                            <option value="">Selecione</option>
                        </select>
                        <a style="float: left; margin: 5px 0 0 10px;" class="add-bairro" style="text-decoration: underline; color: #999999; font-size: 15px; " href="javascript:void(0)"><img src="static/img/bt-mais.gif" alt="+ Bairros" /></a> 
                    </div>

                    <br clear="all" />

                    <div class="select tipo" style="padding: 0; width: 410px; margin: 0 2px 0 0; height: auto;">
                        <span style="text-align: right; width: 105px;">Tipo</span>
                        <select style="margin: 0 0 15px 0;" id="tipo" name="tipo[]">
                            <option value="">Selecione</option>
                            <?php foreach($rows_tipo as $row_tipo) :?>
                            <option value="<?php echo $row_tipo->id;?>"><?php echo $row_tipo->nome;?></option>
                            <?php endforeach;?>
                        </select>
                        <a style="float: left; margin: 5px 0 0 10px;" class="add-tipo" style="text-decoration: underline; color: #999999; font-size: 15px; " href="javascript:void(0)"><img src="static/img/bt-mais.gif" alt="+ Tipos" /></a> 
                    </div>
                </div>

                <div style="float: right;">
                    <div class="check">
                        <p>Residencial</p>

                        <label>
                            <input type="checkbox" value="SIM" name="residencial_aluguel" />
                            <span>Aluguel</span>
                        </label>

                        <label>
                            <input type="checkbox" value="SIM" name="residencial_compra" />
                            <span>Venda</span>
                        </label>
                    </div>

                    <div class="check">
                        <p>Comercial</p>

                        <label>
                            <input type="checkbox" value="SIM" name="comercial_aluguel" />
                            <span>Aluguel</span>
                        </label>

                        <label>
                            <input type="checkbox" value="SIM" name="comercial_compra" />
                            <span>Venda</span>
                        </label>
                    </div>    
                </div>
                
                <div class="busca-avancada">

                    <h3>BUSCA AVANÇADA</h3>

                    <div id="b-avancada">&nbsp;</div>

                    <div id="busca-avancada-display">

                        <label>
                            <span>Valor do Aluguel até R$</span>
                            <input type="text" id="valor_aluguel" name="valor_aluguel" />
                        </label>
                        
                        <label>
                            <span>Valor de Venda até R$</span>
                            <input type="text" id="valor_venda" name="valor_venda" />
                        </label>
                        
                        <label>
                            <span>Valor Mínimo de Aluguel R$</span>
                            <input type="text" id="valor_minimo_aluguel" name="valor_minimo_aluguel" />
                        </label>
                        
                        <label>
                            <span>Valor Mínimo de Venda R$</span>
                            <input type="text" id="valor_minimo_venda" name="valor_minimo_venda" />
                        </label>

                        <label>
                            <span>Número Atual de Quartos</span>
                            <input type="text" name="n_quartos" />
                        </label>

                        <label>
                            <span>Nome do Condomínio</span>
                            <input type="text"  name="nome_condominio" />
                        </label>

                        <label>
                            <span>Área construída maior que:<br /><font>(não incluindo varandas)</font></span>
                            <input type="text" name="area_construida_maior" /> m²
                        </label>
                        <label>
                            <span>Área construída menor que:<br /><font>(não incluindo varandas)</font></span>
                            <input type="text" name="area_construida_menor" /> m² 
                        </label>
                        <label class="av-check av-check-f">
                            <input type="checkbox" name="mobiliado" />
                            <span>Mobiliado</span>
                        </label>

                        <label class="av-check">
                            <input type="checkbox" name="portaria_h" />
                            <span>Portaria 24h</span>
                        </label>

                        <label class="av-check">
                            <input type="checkbox" name="varanda" />
                            <span>Varanda</span>
                        </label>

                        <label class="av-check">
                            <input type="checkbox" name="piscina" />
                            <span>Piscina</span>
                        </label>

                        <br clear="all" />

                        <input type="submit" value="Buscar" class="b-av"/>                     	                        

                    </div>

                </div>
       
            </div>
                
        </form>

    </div>
    
    <div id="box-rede-contatos">
    
        <p>Amplie sua rede de parceiros</p>
        
        <form name="rede_contatos" action="<?php echo $_SESSION['login'];?>/amplie-sua-rede" id="formulario_convidar" method="post" >
        
            <span>*Nome</span><span>Email</span>
        
            <div id="repetir">
        
               <input type="text" name="nome_convidar[]"  class="input nome_convidar"/>
        
               <input type="text" name="email_convidar[]" id="mail1" class="input email_convidar" />
                
            </div>
            
            <div id="erro-nome-convida">
                <font color="red">Nome não preenchido</font>
            </div>
            
            <div id="erro-email-convida">
                <font color="red">Email não preenchido</font>
            </div>
            
            <div id="erro-emailvalido-convida">
                <font color="red">Email inválido.</font>
            </div>
            
            <div style="display: none;" id="campo_existe2">
                <span style="color: red; width: 100%; font-size: 12px;">Este email já está cadastrado. Insira outro email.</span>
            </div>
            
            <a href="javascript:void(0)" id="add-campo">+ Clique aqui para convidar mais amigos</a>
        
            <input type="submit" value="" class="bt" />
       
        </form>
        
    </div>
    
    <div id="banner-imoveis"><a href="#"></a></div>
    
    </div>
    
</div>
