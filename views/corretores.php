<script>
$(document).ready(function(){
    
    $('.link-letra').click(function(){
        var letra = $(this).html();
        location.href = "<?php echo url();?>/corretores/letra/"+letra;
    })  
    
    $('#especialidade').change(function(){
        var esp = $(this).val();
        location.href = "<?php echo url();?>/corretores/especialidade/"+esp;
    })  
    
    $(".add-contato").click( function() {
        var contato = $(this).attr('rel');
        var id = $(this).attr('id');
        jConfirm('Tem certeza que deseja adicionar '+contato+' ?', 'Adicionar Contato', function(r) {
        if(r){
            $.getJSON('add_del_contato.php',{type: 'add', id_enviou : '<?php echo $_SESSION["usuario_logado"]->id;?>', id_recebeu : id} ,function(txt){
                if(txt.valor == 'YES'){
                    jAlert("Aguardando confirmação de "+contato, 'Adicionar Contato');
                    window.location.href = window.location.href;
                }
            })           
        }
        });
    })

})
</script>

<div id="content">
    
    <div class="page page-contatos">
	
        <div class="breadcumbs">
            <span>Toda Rede</span>
        </div>
        
        <div id="busca-imoveis" class="busca-codigo-av busca-contatos">
                        
            <form>
                
                <label style="width: auto;" class="select select-l">
                    <span class="blue">Filtrar por</span>
                    <select id="especialidade">
                        <option value="0">Todas as Especialidades</option>
                        <?php foreach($especialidades as $row) :?>
                        <option value="<?php echo $row->id;?>"><?php echo $row->nome;?></option>
                        <?php endforeach;?>
                    </select>
                </label>
            
            </form>
            
            <div class="letras">           
                <a class="link-letra" href="javascript:void(0)">A</a>             
                <a class="link-letra" href="javascript:void(0)">B</a>               
                <a class="link-letra" href="javascript:void(0)">C</a>               
                <a class="link-letra" href="javascript:void(0)">D</a>                
                <a class="link-letra" href="javascript:void(0)">E</a>              
                <a class="link-letra" href="javascript:void(0)">F</a>               
                <a class="link-letra" href="javascript:void(0)">G</a>               
                <a class="link-letra" href="javascript:void(0)">H</a>               
                <a class="link-letra" href="javascript:void(0)">I</a>                
                <a class="link-letra" href="javascript:void(0)">J</a>               
                <a class="link-letra" href="javascript:void(0)">K</a>               
                <a class="link-letra" href="javascript:void(0)">L</a>                
                <a class="link-letra" href="javascript:void(0)">M</a>        
                <a class="link-letra" href="javascript:void(0)">N</a>       
                <a class="link-letra" href="javascript:void(0)">O</a>             
                <a class="link-letra" href="javascript:void(0)">P</a>               
                <a class="link-letra" href="javascript:void(0)">Q</a>               
                <a class="link-letra" href="javascript:void(0)">R</a>               
                <a class="link-letra" href="javascript:void(0)">S</a>                
                <a class="link-letra" href="javascript:void(0)">T</a>             
                <a class="link-letra" href="javascript:void(0)">U</a>     
                <a class="link-letra" href="javascript:void(0)">V</a>        
                <a class="link-letra" href="javascript:void(0)">W</a>      
                <a class="link-letra" href="javascript:void(0)">X</a>         
                <a class="link-letra" href="javascript:void(0)">Y</a>           
                <a class="link-letra" href="javascript:void(0)">Z</a>     
            </div>
        
        </div>
    
    </div>
    
    <div class="page">
        <?php echo $msg.$html_contatos;?>
    </div>
        
    <div class="pagination">
    
        <div class="pag">
        
            <?php echo $html_paginacao;?>
            
        </div> 

    </div>
    
</div>
