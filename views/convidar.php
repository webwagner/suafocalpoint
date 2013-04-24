<script>
    $(document).ready(function(){
    
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

    })
</script>

<div id="content">

    <div class="page page-contatos">

        <div class="breadcumbs">
            <span>Convide seus parceiros</span>
        </div>

        <div id="box-rede-contatos" class="busca-codigo-av busca-contatos convidar">
            <p class="all-green">Insira abaixo endere&ccedil;os de email de seus amigos e convide-os para a Sua Focal Point</p>

            <p class="normal">Na mensagem padr&atilde;o a ser enviada ter&aacute; um c&oacute;digo de identifica&ccedil;&atilde;o do seu perfil. No momento que seu contato realizar o cadastro e informar seu c&oacute;digo voc&ecirc; ganhar&aacute; 50% de desconto na próxima mensalidade! Aproveite que nosso programa de afiliados funcionar&aacute; por tempo limitado.</p>

            <p class="normal"><strong>Indicar corretores já cadastrados no sistema não o torna elegível a receber o desconto.</strong></p>

            <form action="" method="post" id="formulario_convidar">

                <span>*Nome</span><span>Email</span>

                <input type="hidden" name="codigo" value="<?php echo $_SESSION['usuario_logado']->sigla; ?>" />

                <div id="repetir" class="repetir-c">
                    <?php if (isset($_POST['email_convidar'])) :
                        for ($x = 0; $x < count($_POST['email_convidar']); $x++) :
                            ?>
                            <input type="text" value="<?php echo $_POST['nome_convidar'][$x]; ?>" name="nome_convidar[]"  class="input nome_convidar"/>
                            <input type="text" value="<?php echo $_POST['email_convidar'][$x]; ?>" name="email_convidar[]" id="mail1" class="input email_convidar" />
                        <?php endfor; ?>
<?php else : ?>
                        <input type="text" name="nome_convidar[]"  class="input nome_convidar"/>
                        <input type="text" name="email_convidar[]" id="mail1" class="input email_convidar" />
<?php endif; ?>
                </div>

                <div id="erro-nome-convida">
                    <font color="red">Nome não preenchido</font>
                </div>

                <div id="erro-email-convida">
                    <font color="red">Email não preenchido</font>
                </div>

                <div style="display: none;" id="campo_existe2">
                    <span style="color: red; width: 100%; font-size: 12px;">Este email já está cadastrado. Insira outro email.</span>
                </div>

                <div style="margin-right: 150px;" id="erro-emailvalido-convida">
                    <font color="red">Email inválido.</font>
                </div>

                <a style="width: 100%;" href="javascript:void(0)" id="add-campo" class="cc">+ Clique aqui para convidar mais amigos</a>

                <label class="cadastro-all textarea txt-all">
                    <span>Mensagem:</span>
                    <textarea name="mensagem"></textarea>           
                </label>

                <input type="submit" value="" class="bt bt-cc" />

            </form>

        </div>

    </div>
</div>
