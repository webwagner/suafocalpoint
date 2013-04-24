<?php echo (isset($msg)) ? "<p class='txt-msg'>".$msg."</p>" : "";?>

<div class="tit">
    <img src="static/images/ico-usuarios.jpg" width="40" height="40" alt="Como conheceu a rede" title="Como conheceu a rede" />
    <span>Como conheceu a rede</span>
</div>
<div class="busca">
    <form action="?pg=como-conheceu-a-rede&act=buscar" method="post">
        <input name="busca" value="Busca por como conheceu a rede..." onBlur="if(this.value == ''){ this.value='Busca por como conheceu a rede...' }" onFocus="if(this.value == 'Busca por como conheceu a rede...'){ this.value='' }" />
        <input type="submit" class="busca-ok" value="" />
    </form>            
</div>

<div class="add">
    <a href="?pg=como-conheceu-a-rede&act=cadastrar"><img src="static/images/add_23.jpg" alt="NOVO COMO CONHECEU A REDE" title="NOVO COMO CONHECEU A REDE" />NOVO COMO CONHECEU A REDE</a>
</div>

<div id="listagem">
    
    <?php echo (isset($msg_busca)) ? "<p class='txt-busca'>Você buscou por: ".$msg_busca."</p>" : "";?>
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr class="cabecalho">
        <td width="5%" align="center" class="id"><input class="id_checkbox" type="checkbox" name="id"></td>
        <td width="79%">Título</td>
        <td width="16%" align="center">A&ccedil;&otilde;es</td>
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
        <td width="25%"><?php echo $row->titulo; ?></td>
        <td width="16%" align="center" class="last">
            <a href="?pg=como-conheceu-a-rede&act=cadastrar&id=<?php echo $row->id;?>"><img src="static/images/editar.png" border="0" class="tTip" title="Editar" alt="Editar" id="editar1"/></a>
            <a class="bt-excluir" href="?pg=como-conheceu-a-rede&act=deletar&id=<?php echo $row->id;?>"><img src="static/images/excluir.png" border="0" title="Excluir" alt="Excluir" /></a>
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
            <form action="?pg=como-conheceu-a-rede&act=deletar" id="form_selecionados" method="post">               
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