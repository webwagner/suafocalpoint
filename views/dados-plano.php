<div id="content">
	
    <div class="page">
	
        <div class="breadcumbs">
            <span>Editar Perfil > Alterar Plano</span>
        </div>
        
        <p style="margin-top: 10px; float: left; width: 100%;"><?php echo $msgDesc;?></p>
        <?php echo $msgPlano;?>
        
        <form action="" method="post" id="formulario">
        
          <input name="id" type="hidden" value="<?php echo $dados->id;?>" />
          
          <div class="planos">
            	
                <span class="plano-escolhido">Plano Contratado: <strong><?php echo $plano->nome;?></strong></span>
	
                <br clear="all" />        
                
                <?php    
                foreach($planos as $row) :
                    $preco = $row->valor;
                
                    if($valor_desconto > 0){
                        //Desconto maximo possivel
                        if($row->nome == "MENSAL")
                            $desconto_max = $valor_desc_base;
                        else if($row->nome == "SEMESTRAL")
                            $desconto_max = ($valor_desc_base * 6);
                        else
                            $desconto_max = ($valor_desc_base * 12);
          
                        if($valor_desconto > $desconto_max)
                            $preco = $desconto_max;
                        else
                            $preco = ((int) $row->valor - $valor_desconto);
                        
                        $preco = number_format($preco,2,',','.');
                    }
                ?>
                    <input type="hidden" name="preco[<?php echo $row->id;?>]" value="<?php echo $preco;?>" />
                    
                    <div class="plano <?php echo ($row->id == $dados->plano_id ? 'plano-h' : '');?>">
                        <div class="plano-title"><?php echo $row->nome;?></div>
                        <span>R$ <?php echo $preco;?></span>
                        <input <?php echo ($row->id == $dados->plano_id ? 'checked="checked"' : '');?> type="radio" name="plano_id" value="<?php echo $row->id;?>" />
                    </div>
                
                <?php endforeach;?>  
            </div>
            
            <input type="submit" value="" class="enviar-senha salvar"/>
        
        </form>
    
    </div>

</div>
