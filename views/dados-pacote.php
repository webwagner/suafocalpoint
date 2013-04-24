<div id="content">
	
    <div class="page">
	
        <div class="breadcumbs">
            <span>Editar Perfil > Comprar Pacote</span>
        </div>
                
        <form action="" method="post" id="formulario">
        
          <input name="id" type="hidden" value="<?php echo $dados->id;?>" />
          
          <div class="planos">
            		
                <br clear="all" />        
                
                <?php 
                foreach($pacotes as $row) :?>
                
                <div class="pacote">
                    <input type="radio" name="pacote_id" value="<?php echo $row->id;?>" />
                    <div class="box-pacote">
                        <h3><?php echo $row->titulo;?></h3>
                        <h4><?php echo $row->descricao;?></h4>
                        <p><span>R$ <strong><?php echo $row->valor;?></strong></span></p>
                    </div>
                </div>
                
                <?php endforeach;?>
                
            </div>
            
            <input type="submit" value="" class="enviar-senha salvar"/>
        
        </form>
    
    </div>

</div>
