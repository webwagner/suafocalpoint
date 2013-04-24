<script type="text/javascript">
$(document).ready(function(){
    $('#set_checkboxs').click(function(){ 
        if(this.checked == true){
            $('.checks').each(function(){
                this.checked = true;
            })
        }
        else if(this.checked == false){
           $('.checks').each(function(){
                this.checked = false;
            }) 
        }
    })
    
    $(".marcar").click(function(){
        var type = $(this).attr("id");
        var ids = new Array;
        var i = 0;
        $('.checks').each(function(){
            if(this.checked == true){
                ids[i] = $(this).val();
                i++;
            }
        })
        if(ids.length > 0){
            var valores = ""+ids+"";
            if(type == 'excluir'){
                jConfirm('Tem certeza que deseja excluir ?', 'Excluir Mensagem', function(r) {
                    if(r){
                        $.getJSON('set_mensagens.php',{type: 'excluir', id : valores, id_corretor : "<?php echo $_SESSION['usuario_logado']->id;?>"} ,function(txt){
                            if(txt.valor == 'YES')
                                window.location.href = window.location.href;
                        })    
                    }                       
                })    
            }
            else{      
                $.getJSON('set_mensagens.php',{type: type, id : valores} ,function(txt){
                    if(txt.valor == 'YES'){
                        window.location.href = window.location.href;
                    }
                })
            }
        }
    })
})
</script>  
  
<div id="content">
    
    <div class="page page-contatos">
	
        <div class="breadcumbs">
        
            <span>Mensagens (<?php echo $total_recebidas_naolidas;?>)</span>
            
            <div class="notificacoes">
            
                <span class="exibir">Exibir:</span>
                <span class="mensagens"><a href="<?php echo $_SESSION['login'];?>/mensagens/recebidas">Mensagens</a> <font>(<?php echo $recebidas;?>)</font></span>
                <span class="solicitacoes"><a href="<?php echo $_SESSION['login'];?>/mensagens/solicitacoes">Solicita&ccedil;&otilde;es de Visitas</a> <font>(<?php echo $solicitacoes;?>)</font></span>
                <span class="enviadas"><a href="<?php echo $_SESSION['login'];?>/mensagens/enviadas">Enviadas</a> <font>(<?php echo $enviadas;?>)</font></span>
            
            </div>
            
        </div>
        
        <div class="marcacao">
        
            <a class="marcar" id="nao-lida-<?php echo $lida_env_rec;?>" href="javascript:void(0)">Marcar como não lida</a>        
            <a class="marcar" id="lida-<?php echo $lida_env_rec;?>" href="javascript:void(0)">Marcar como lida</a>     
            <a class="marcar" id="excluir" href="javascript:void(0)">Excluir</a>          
        
        </div>
        
        <div class="tabela-msg">
        
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr class="header">
                <td><input id="set_checkboxs" type="checkbox" name="id" /></td>
                <td><?php echo $pessoa;?></td>
                <td>ASSUNTO</td>
                <td>DATA</td>
              </tr>
              
              <?php echo $html_mensagens;?> 
             
            </table>
        
        </div>    
        
        <div style="width: auto; float: right;" class="pagination">
            <div style="padding: 0;" class="pag">
                <?php echo $html_paginacao;?>    
            </div>
        </div>
            
    </div>
            
    
    
</div>