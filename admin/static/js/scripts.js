$(document).ready(function(){
    
    $('.bt-excluir').click(function(e){
        e.preventDefault();
        var del = confirm("Tem certeza que deseja deletar esse registro?");
        if (del==true)
            window.location.href = $(this).attr('href');
        else
            return false;
    })
    
    $('.link-ativar').click(function(e){
        e.preventDefault();
        
        if($(this).html() == "Ativado")
            var msg = "desativar";
        else
            var msg = "ativar";
        
        var del = confirm("Tem certeza que deseja "+msg+" esse registro?");
        
        if (del==true)
            window.location.href = $(this).attr('href');
        else
            return false;
    })
    
    $(".id_checkbox").toggle(
        function () {
            $('.checks').each(function(){
                this.checked = true;
            })
        },
        function () {
            $('.checks').each(function(){
                this.checked = false;
            }) 
        }
    );
        
    $('#form_selecionados').submit(function(){
        if($('#selecionados').val() == 'excluir'){
            var x = 0;
            $('.checks').each(function(){
                 if(this.checked == true){
                    $('#form_selecionados').append('<input name="id_'+x+'" type="hidden" value="'+$(this).val()+'" />');
                    x++;
                 }
             })
        }
        else{
            return false;
        }
    })
  
    $('#link-corretores').toggle(function() {
        $("#submenu-corretores").show("slow");
    }, function() {
        $("#submenu-corretores").hide("slow");
    });
    
})
