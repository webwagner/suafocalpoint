<?php echo (isset($msg)) ? "<p class='txt-msg'>".$msg."</p>" : "";?>

<div class="tit">
    <img src="static/images/ico-usuarios.jpg" width="40" height="40" alt="Cidades" title="Cidades" />
    <span>Cidades</span>
</div>
<div class="busca">
    <form action="?pg=cidades&act=buscar" method="post">
        <input name="busca" value="Busca por cidades..." onBlur="if(this.value == ''){ this.value='Busca por cidades...' }" onFocus="if(this.value == 'Busca por cidades...'){ this.value='' }" />
        <input type="submit" class="busca-ok" value="" />
    </form>            
</div>

<div class="add">
    <a href="?pg=cidades&act=cadastrar"><img src="static/images/add_23.jpg" alt="NOVA CIDADE" title="NOVA CIDADE" />NOVA CIDADE</a>
</div>

<div id="listagem">
    
    <?php echo (isset($msg_busca)) ? "<p class='txt-busca'>Você buscou por: ".$msg_busca."</p>" : "";?>
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr class="cabecalho">
        <td width="5%" align="center" class="id"><input class="id_checkbox" type="checkbox" name="id"></td>
        <td width="16%">UF</td>
        <td width="63%">Cidade</td>
        <td width="16%" align="center">A&ccedil;&otilde;es</td>
      </tr>
      
      <?php
      $class = 'iten-a';

      foreach($rows as $row):    
        if($class == 'iten-b')
            $class = 'iten-a';
        else
            $class = 'iten-b';
        
        $mapper_uf->setWhere('id = "'.$row->id_uf.'"');
        $row_uf = $mapper_uf->getRow();
      ?>
      <tr class="<?php echo $class;?>">
        <td width="5%" align="center"><input type="checkbox" value="<?php echo $row->id;?>" class="checks" name="id"></td>
        <td width="16%"><?php echo $row_uf->uf; ?></td>
        <td width="63%"><?php echo $row->cidade; ?></td>
        <td width="16%" align="center" class="last">
            <a href="?pg=cidades&act=cadastrar&id=<?php echo $row->id;?>"><img src="static/images/editar.png" border="0" class="tTip" title="Editar" alt="Editar" id="editar1"/></a>
            <a class="bt-excluir" href="?pg=cidades&act=deletar&id=<?php echo $row->id;?>"><img src="static/images/excluir.png" border="0" title="Excluir" alt="Excluir" /></a>
        </td>
      </tr>
      
     <?php endforeach; ?>
      
     <tr class="pagination">
        <td colspan="6">
            <img src="static/images/info_03.jpg" />
            <span>MOSTRANDO 1-<?php echo $quantidade;?> ResultADOS DE <?php echo $total;?></span>
             <?php 
             if($total > 20)
                 echo $html_paginacao;
             ?>
        </td>      
    </tr>
    <tr class="selection">
        <td colspan="6">
            <img src="static/images/selection_03.jpg" width="23" height="35" class="seta" />
            <a href="javascript:void(0)" class="id_checkbox"><img src="static/images/noticias_06.jpg" class="sel-all" width="123" height="25" /></a>
            <img src="static/images/sp_05.jpg" width="11" height="36" />         
            <form action="?pg=cidades&act=deletar" id="form_selecionados" method="post">               
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