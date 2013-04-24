<?php echo (isset($msg)) ? "<p class='txt-msg'>".$msg."</p>" : "";?>

<div class="tit">
    <img src="static/images/ico-usuarios.jpg" width="40" height="40" alt="corretores" title="corretores" />
    <span>Corretores</span>
</div>
<div class="busca">
    <form style="width: 330px;" action="?pg=corretores&act=buscar" method="post">
        <input style="width: 240px;" name="busca" value="Busca por nome, sigla, UF ou cidade..." onBlur="if(this.value == ''){ this.value='Busca por nome, sigla, UF ou cidade...' }" onFocus="if(this.value == 'Busca por nome, sigla, UF ou cidade...'){ this.value='' }" />
        <input type="submit" class="busca-ok" value="" />
    </form>            
</div>

<div id="listagem">
    
    <?php echo (isset($msg_busca)) ? "<p class='txt-busca'>Você buscou por: ".$msg_busca."</p>" : "";?>
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr class="cabecalho">
        <td width="5%" align="center" class="id"><input class="id_checkbox" type="checkbox" name="id"></td>
        <td width="42%">Nome</td>
        <td width="18%">Data de Cadastro</td>
        <td width="10%">Autônomo?</td>
        <td width="10%" align="center">Visualizar</td>
        <td width="10%" align="center">Ativar/Desativar</td>
        <td width="10%" align="center">Excluir</td>
      </tr>
      
      <?php
      $class = 'iten-a';

      foreach($rows as $row):    
        if($class == 'iten-b')
            $class = 'iten-a';
        else
            $class = 'iten-b';
      ?>
      <tr class="<?php echo $class;?>">
        <td width="5%" align="center"><input type="checkbox" value="<?php echo $row->id;?>" class="checks" name="id"></td>
        <td width="42%"><?php echo $row->nome; ?></td>
        <td width="18%"><?php echo $row->data_cadastro; ?></td>
        <td width="10%" align="center"><?php echo $row->autonomo; ?></td>
        <td width="10%" align="center">
            <a href="?pg=corretores&act=cadastrar&id=<?php echo $row->id;?>"><img src="static/images/editar.png" border="0" class="tTip" title="Editar" alt="Editar" id="editar1"/></a>
        </td>
        <td width="10%" align="center">
            <a class="link-ativar" href="?pg=corretores&act=<?php echo ($row->ativado == "SIM") ? "desativar" : "ativar" ?>&id=<?php echo $row->id;?>"><?php echo ($row->ativado == 'SIM') ? 'Ativado' : 'Desativado'; ?></a>
        </td>
        <td width="10%" align="center" class="last">
            <a class="bt-excluir" href="?pg=corretores&act=deletar&id=<?php echo $row->id;?>"><img src="static/images/excluir.png" border="0" title="Excluir" alt="Excluir" /></a>
        </td>
      </tr>
      
     <?php endforeach; ?>
      
     <tr class="pagination">
        <td colspan="7">
            <img src="static/images/info_03.jpg" />
            <span>MOSTRANDO 1-<?php echo $quantidade;?> ResultADOS DE <?php echo $total;?></span>
             <?php 
             if($total > 30)
                 echo $html_paginacao;
             ?>
        </td>      
    </tr>
    <tr class="selection">
        <td colspan="7">
            <img src="static/images/selection_03.jpg" width="23" height="35" class="seta" />
            <a href="javascript:void(0)" class="id_checkbox"><img src="static/images/noticias_06.jpg" class="sel-all" width="123" height="25" /></a>
            <img src="static/images/sp_05.jpg" width="11" height="36" />         
            <form action="?pg=corretores&act=deletar" id="form_selecionados" method="post">               
                <select id="selecionados">
                        <option value="">Ações para os selecionados...</option>
                        <option value="excluir">Excluir</option>
                </select>
                <input type="submit" class="ok" value="" />               
            </form>           
        </td>
    </tr>
   </table>
</div>