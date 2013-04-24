<script type="text/javascript" src="<?php echo URL;?>static/js/maskedmoney.js"></script>
<script type="text/javascript" src="<?php echo URL;?>static/js/jquery.validate.js"></script>
<script>
    $(document).ready(function(){
        
        $(".nome_alerta").click(function(e){
            e.preventDefault();    
            
            var id = $(this).attr("href");
            $("#form_alerta_"+id).submit();
        })
    
        $("#formulario").validate();

        $(".bt-new-alerta").toggle(function(e){
            e.preventDefault();
            $("#busca-imoveis").show("slow");
        },function(){
            $("#busca-imoveis").hide("slow");
        })

        $("#valor_aluguel").maskMoney({thousands:'.', decimal:'', precision:0});
        $("#valor_venda").maskMoney({thousands:'.', decimal:'', precision:0});
        $("#valor_minimo_aluguel").maskMoney({thousands:'.', decimal:'', precision:0});
        $("#valor_minimo_venda").maskMoney({thousands:'.', decimal:'', precision:0});

        $('.add-bairro').live("click", function(event){
            $('.add-bairro').html('<img src="static/img/bt-menos.gif" alt="- Bairros" />');
            $('.add-bairro').removeClass('add-bairro').addClass('remove-bairro');

            var cidade = <?php echo $cidade_corretor->id;?>;

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
                    $('#label-bairro').append('<span class="bloco" style="width: 40px;"></span><select style="margin: 0 0 15px 0; float: left;" class="bairro" name="bairro[]">'+html+'</select><a style="float: left; margin: 5px 0 0 10px;" class="add-bairro" style="text-decoration: underline; color: #999999; font-size: 15px; " href="javascript:void(0)"><img src="static/img/bt-mais.gif" alt="+ Bairros" /></a>' );
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

        $('.add-tipo').live("click", function(event){
            $('.add-tipo').html('<img src="static/img/bt-menos.gif" alt="- Bairros" />');
            $('.add-tipo').removeClass('add-tipo').addClass('remove-tipo');
            
            var htm = '<span class="bloco2" style="width: 23px;"></span><select style="margin: 0 0 15px 0; float: left;" name="tipo_imovel_id[]">'+$(this).prev('select').html()+'</select><a style="float: left; margin: 5px 0 0 10px;" class="add-tipo" href="javascript:void(0)"><img src="static/img/bt-mais.gif" alt="+ Tipos" /></a>';
            
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

    <div class="page">

        <div class="breadcumbs">
            <span>Alerta</span>
        </div>

        <?php if(isset($alerta)) :?>
        <a id="bt-new-alerta" href="<?php echo $_SESSION['login'];?>/alerta">
            <span>Voltar</span>
        </a>
        <?php else:?>
        <a id="bt-new-alerta" class="bt-new-alerta" href="">
            <span>Novo Alerta</span>
        </a>
        <?php endif;?>

        <?php if($msg != "") :?>
        <p style="float: left; width: 100%; margin-top: 15px;"><?php echo $msg;?></p>
        <?php endif;?>

        <div id="busca-imoveis" style="width:670px; <?php echo (isset($alerta) ? '' : 'display:none;');?> 'padding-bottom: 0px;'" class="busca-codigo-av">

            <form id="formulario" style="margin: 15px 0;" action="<?php echo $_SESSION['login'];?>/alerta" method="post">

                <div id="box-busca-caracteristicas">
                    
                    <?php if(isset($alerta)) :?>
                    <input type="hidden" name="id_alerta" value="<?php echo $alerta->id;?>" />
                    <?php endif;?>
                    
                    <input type="hidden" name="id_corretor" value="<?php echo $id_corretor;?>" />
                    
                    <label style="padding-left: 25px; height: auto; width: 700px;">
                        <span style="margin-right: 7px; display: block;">*Informações de Contato (Nome, telefone e email)</span>
                        <input style="width: 350px;" value="<?php echo (isset($alerta->titulo_alerta) ? $alerta->titulo_alerta : '');?>" class="required" type="text"  name="titulo_alerta" />
                    </label>

                    <div style="float: left;">
                        <div class="select" style="padding: 0; width: 345px; margin: 20px 0 0 5px; height: auto;" id="label-bairro">
                            <span>Bairro</span>
                            <?php 
                            if(count($arr_bairros) > 0) :
                                $i = 1;
                                foreach($arr_bairros as $arr_bairro) :
                                if($i > 1) :?>
                                <span class="bloco" style="width: 40px;"></span>
                                <?php endif;?>
                                <select style="margin: 0 0 15px 0; float: left;" class="bairro" name="bairro[]">                                    
                                    <option value="">Selecione</option>
                                    <?php foreach($bairros as $bairro) :
                                    if($bairro->id == $arr_bairro) :?>
                                    <option selected="selected" value="<?php echo $bairro->id;?>"><?php echo $bairro->bairro;?></option>
                                    <?php else:?>
                                    <option value="<?php echo $bairro->id;?>"><?php echo $bairro->bairro;?></option>                                
                                    <?php endif;?>
                                    <?php endforeach;?>
                                </select>
                                <?php if($i < count($arr_bairros)) :?>
                                <a style="float: left; margin: 5px 0 0 10px;" class="remove-bairro" style="text-decoration: underline; color: #999999; font-size: 15px; " href="javascript:void(0)"><img src="static/img/bt-menos.gif" alt="- Bairros" /></a> 
                                <?php endif; $i++; 
                                endforeach;
                            else : ?>
                                <select style="margin: 0 0 15px 0; float: left;" class="bairro" name="bairro[]">
                                    <option value="">Selecione</option>
                                    <?php foreach($bairros as $bairro) :?>
                                    <?php if($bairro->id == $arr_bairro) :?>
                                    <option selected="selected" value="<?php echo $bairro->id;?>"><?php echo $bairro->bairro;?></option>
                                    <?php else:?>
                                    <option value="<?php echo $bairro->id;?>"><?php echo $bairro->bairro;?></option>                                
                                    <?php endif;?>
                                    <?php endforeach;?>
                                </select>
                            <?php endif;?>
                            <a style="float: left; margin: 5px 0 0 10px;" class="add-bairro" style="text-decoration: underline; color: #999999; font-size: 15px; " href="javascript:void(0)"><img src="static/img/bt-mais.gif" alt="+ Bairros" /></a> 
                        </div>
                    
                        <br clear="all" />

                        <div class="select tipo" style="width: 330px; height: auto;">
                            <span style="padding-left: 5px; text-align: right; width: 38px;">Tipo</span>
                            <?php 
                            if(count($arr_tipos) > 0) :
                                $i = 1;
                                foreach($arr_tipos as $arr_tipo) :
                                if($i > 1) :?>
                                <span class="bloco2" style="width: 12px;"></span>
                                <?php endif;?>
                                <select style="margin: 0 0 15px 0; float: left;" name="tipo_imovel_id[]">                                    
                                    <option value="">Selecione</option>
                                    <?php foreach($rows_tipo as $row_tipo) :
                                    if($row_tipo->id == $arr_tipo) :?>
                                    <option selected="selected" value="<?php echo $row_tipo->id;?>"><?php echo $row_tipo->nome;?></option>
                                    <?php else:?>
                                    <option value="<?php echo $row_tipo->id;?>"><?php echo $row_tipo->nome;?></option>                                
                                    <?php endif;?>
                                    <?php endforeach;?>
                                </select>
                                <?php if($i < count($arr_tipos)) :?>
                                <a style="float: left; margin: 5px 0 0 10px;" class="remove-tipo" style="text-decoration: underline; color: #999999; font-size: 15px; " href="javascript:void(0)"><img src="static/img/bt-menos.gif" alt="- Bairros" /></a> 
                                <?php endif; $i++; 
                                endforeach;
                            else : ?>
                                <select style="margin: 0 0 15px 0;" name="tipo_imovel_id[]">
                                    <option value="">Selecione</option>
                                    <?php foreach ($rows_tipo as $row_tipo) : ?>
                                    <option value="<?php echo $row_tipo->id; ?>"><?php echo $row_tipo->nome; ?></option>
                                    <?php endforeach;?>
                                </select>
                            <?php endif;?>
                            <a style="float: left; margin: 5px 0 0 10px;" class="add-tipo" style="text-decoration: underline; color: #999999; font-size: 15px; " href="javascript:void(0)"><img src="static/img/bt-mais.gif" alt="+ Tipos" /></a> 
                        </div>
                    </div>
                    
                    <div style="float: right;">
                        <div style="margin-top: 10px;" class="check">
                            <label style="width: 105px;">
                                <input type="checkbox" <?php echo (isset($alerta) && $alerta->residencial == 'SIM' ? 'checked="checked"' : '');?> value="SIM" name="residencial" />
                                <span>Residencial</span>
                            </label>

                            <label>
                                <input type="checkbox" <?php echo (isset($alerta) && $alerta->aluguel == 'SIM' ? 'checked="checked"' : '');?> value="SIM" name="aluguel" />
                                <span>Aluguel</span>
                            </label>
                        </div>

                        <div style="margin-top: 10px;" class="check">
                            <label style="width: 105px;">
                                <input type="checkbox" value="SIM" <?php echo (isset($alerta) && $alerta->comercial == 'SIM' ? 'checked="checked"' : '');?> name="comercial" />
                                <span>Comercial</span>
                            </label>

                            <label>
                                <input type="checkbox" <?php echo (isset($alerta) && $alerta->compra == 'SIM' ? 'checked="checked"' : '');?> value="SIM" name="compra" />
                                <span>Venda</span>
                            </label>
                        </div>    
                    </div>
                    
                    <div class="busca-avancada">

                        <div id="busca-avancada-display">

                            <label>
                                <span>Valor do Aluguel até R$</span>
                                <input type="text" value="<?php echo (isset($alerta) ? number_format($alerta->valor_aluguel,2,',','.') : '');?>" id="valor_aluguel" name="valor_aluguel" />
                            </label>

                            <label>
                                <span>Valor de Venda até R$</span>
                                <input type="text" id="valor_venda" value="<?php echo (isset($alerta) ? number_format($alerta->valor_venda,2,',','.') : '');?>" name="valor_venda" />
                            </label>

                            <label>
                                <span>Valor Mínimo de Aluguel R$</span>
                                <input type="text" id="valor_minimo_aluguel" value="<?php echo (isset($alerta) ? number_format($alerta->valor_minimo_aluguel,2,',','.') : '');?>" name="valor_minimo_aluguel" />
                            </label>

                            <label>
                                <span>Valor Mínimo de Venda R$</span>
                                <input type="text" id="valor_minimo_venda" value="<?php echo (isset($alerta) ? number_format($alerta->valor_minimo_venda,2,',','.') : '');?>" name="valor_minimo_venda" />
                            </label>
                            
                            <label>
                                <span>Número Atual de Quartos</span>
                                <input type="text" value="<?php echo (isset($alerta) ? $alerta->quartos_atual : '');?>" name="quartos_atual" />
                            </label>

                            <label>
                                <span>Nome do Condomínio</span>
                                <input type="text" value="<?php echo (isset($alerta) ? $alerta->nome_condominio : '');?>" name="nome_condominio" />
                            </label>

                            <label>
                                <span>Área construída maior que:<br /><font>(não incluindo varandas)</font></span>
                                <input type="text" value="<?php echo (isset($alerta) ? $alerta->area_construida_maior : '');?>" name="area_construida_maior" /> m²
                            </label>
                            <label>
                                <span>Área construída menor que:<br /><font>(não incluindo varandas)</font></span>
                                <input type="text" value="<?php echo (isset($alerta) ? $alerta->area_construida_menor : '');?>" name="area_construida_menor" /> m² 
                            </label>


                            <label class="av-check av-check-f">
                                <input <?php echo (isset($alerta) && $alerta->mobiliado == 'SIM' ? 'checked="checked"' : '');?> type="checkbox" value="SIM" name="mobiliado" />
                                <span>Mobiliado</span>
                            </label>

                            <label class="av-check">
                                <input <?php echo (isset($alerta) && $alerta->portaria_24h == 'SIM' ? 'checked="checked"' : '');?> type="checkbox" value="SIM" name="portaria_24h" />
                                <span>Portaria 24h</span>
                            </label>

                            <label class="av-check">
                                <input <?php echo (isset($alerta) && $alerta->varanda == 'SIM' ? 'checked="checked"' : '');?> type="checkbox" value="SIM" name="varanda" />
                                <span>Varanda</span>
                            </label>

                            <label class="av-check">
                                <input <?php echo (isset($alerta) && $alerta->piscina == 'SIM' ? 'checked="checked"' : '');?>  type="checkbox" value="SIM" name="piscina" />
                                <span>Piscina</span>
                            </label>

                            <br clear="all" />

                            <input type="submit" value="Salvar" class="b-av"/>                     	                        

                        </div>

                    </div>

                </div>

            </form>

        </div>
        
        <?php if(count($rows) > 0) :?>
        <div style="margin-top: 20px;" class="tabela-msg">
        
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr class="header">
                <td width="45%">TÍTULO</td>
                <td align="center" width="20%">DATA</td>
                <td align="center" width="20%">DATA EXPIRAÇÃO</td>
                <td align="center" width="15%">AÇÃO</td>
              </tr>
              
              <?php 
              $x = 0;
              foreach($rows as $row) :
                  $data = explode("-", substr($row->data_cadastro_alerta,0,10));
                  $data_expiracao = date("d/m/Y", mktime(0, 0, 0, $data[1]+3,$data[2], $data[0]) );
              ?>
              <tr class="iten">
                <td width="45%"><a class="nome_alerta" href="<?php echo $x;?>"><?php echo $row->titulo_alerta;?></a></td>
                <td align="center" width="20%"><?php echo converteData(substr($row->data_cadastro_alerta,0,10));?></td>
                <td align="center" width="20%"><?php echo $data_expiracao;?></td>
                <td align="center" width="15%">
                    <form id="form_alerta_<?php echo $x;?>" style="margin: 0 5px 0 25px; width: auto;" action="<?php echo $_SESSION['login'];?>/alerta" method="post">
                        <input type="hidden" name="acao" value="editar" />
                        <input type="hidden" name="id" value="<?php echo $row->id;?>" />
                        <input type="image" src="<?php echo URL;?>static/img/editar.png" />
                    </form>
                    <form style="margin: 0; width: auto;" action="<?php echo $_SESSION['login'];?>/alerta" method="post">
                        <input type="hidden" name="acao" value="excluir" />
                        <input type="hidden" name="id" value="<?php echo $row->id;?>" />
                        <input type="image" src="<?php echo URL;?>static/img/bt-excluir-foto.png" />
                    </form>
                </td>
              </tr>
              <?php
              $x++;
              endforeach;
              ?>
             
            </table>
        
        </div>    
        <?php endif;?>

    </div>

</div>
