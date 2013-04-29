<script type="text/javascript" src="<?php echo URL;?>static/js/maskedinput-1.1.4.js"></script>	
<script type="text/javascript" src="<?php echo URL;?>static/js/estados.js"></script>	
<script type="text/javascript">
    
    fileInputs = function() {
      var $this = $(this),
              $val = $this.val(),
              valArray = $val.split('\\'),
              newVal = valArray[valArray.length-1],
              $button = $this.siblings('.button'),
              $fakeFile = $this.siblings('.file-holder');
      if(newVal !== '') {
            $button.text('Photo Chosen');
            if($fakeFile.length === 0) {
              $button.after('' + newVal + '');
            } else {
              $fakeFile.text(newVal);
            }
      }
    };

    $(document).ready(function() {
         
         $('.pessoa').click(function(){
             $("#form-cadastro").show('slow');
             
             var valor = $(this).val();
             
             if(valor == 'fisica'){
                 $("#campo_cnpj").hide();
                 $("#campo_cnpj input").attr('name','');
                 
                 $("#campo_pessoa_contato").hide();
                 $("#campo_pessoa_contato input").removeClass('required');
                 
                 $("#campo_cpf").show();
                 $("#campo_cpf input").attr("name","cpf");
                 
                 $("#campo_autonomo").show();
                 $("#campo_autonomo input").addClass('required');
                 
                 $("#campo_sexo").show();
                 $("#campo_sexo input").addClass('required');
                 
                 $("#txt-nascimento").show();
                 $("#txt-fundacao").hide();
             }
             else{
                 $("#campo_cpf").hide();
                 $("#campo_cpf input").attr('name','');
                 
                 $("#campo_autonomo").hide();
                 $("#campo_autonomo input").removeClass('required');
                  
                 $("#campo_sexo").hide();
                 $("#campo_sexo input").removeClass('required');
                 
                 $("#campo_cnpj").show();
                 $("#campo_cnpj input").attr("name","cnpj");
                 
                 $("#campo_pessoa_contato").show();
                 $("#campo_pessoa_contato input").addClass('required');
                 
                 $("#txt-fundacao").show();
                 $("#txt-nascimento").hide();
             }
         })
        
         $('.autonomo').click(function(){
             $('#info-corretor').show('slow');
             if($(this).val() == 'NAO')
                 $('#cad_empresa').show('slow');
             else
                 $('#cad_empresa').hide('slow');
         })
        
         $("#formulario").validate({
            rules: {
                'cpf': {
                    required: true,
                    verificaCPF: true
                },
                'cnpj': {
                    required: true,
                    verificaCNPJ: true
                },
                'email': {
                    required: true,
                    email: true
                },
                'login': {
                    verificaLogin: true
                }
            },
            messages: {
                cpf: {
                    required: "Campo obrigatório.",
                    verificaCPF: "CPF inválido"
                },
                cnpj: {
                    required: "Campo obrigatório.",
                    verificaCPF: "CNPJ inválido"
                },
                email: {
                    required: "Campo obrigatório.",
                    email: "Email inválido"
                },
                login: {
                    verificaLogin: "Só é permitido letras, underline e traço."
                }
            }
        });
        
        $("#cep").mask("99999-999"); 
        $("#telefone").mask("9999-9999");
        $("#celular").mask("9999-9999");
        $("#telefone2").mask("9999-9999");
        $("#celular2").mask("9999-9999");
        $("#ddd").mask("(99)");
        $("#ddd_celular").mask("(99)"); 
        $("#ddd2").mask("(99)");
        $("#ddd_celular2").mask("(99)"); 
        $("#nascimento").mask("99/99/9999"); 
        $("#cpf").mask("999.999.999-99"); 
        $("#cnpj").mask("99.999.999/9999-99");

        $('.file-wrapper input[type=file]').bind('change focus click', fileInputs);

        $("#login_cad").focusout(function() {
           if($(this).val() != ''){
               var login = $(this).val();
               $.getJSON('verifica-corretor.php',{campo : 'login', valor : login} ,function(txt){
                    if(txt.valor == 'YES'){
                        $("#campo_existe").show();
                        $('#login_cad').val('');
                        $('#login_cad').focus();
                    }
                    else{
                        $("#campo_existe").hide();
                    }
               })
           }
       }); 
       
       $("#email").focusout(function() {
           if($(this).val() != ''){
               var email = $(this).val();
               $.getJSON('verifica-corretor.php',{campo : 'email', valor : email} ,function(txt){
                    if(txt.valor == 'YES'){
                        $("#campo_existe2").show();
                        $('#email').val('');
                        $('#email').focus();
                    }
                    else{
                        $("#campo_existe2").hide();
                    }
               })
           }
       }); 
       
       $("#cpf").focusout(function() {
           if($(this).val() != ''){
               var cpf = $(this).val();
               $.getJSON('verifica-corretor.php',{campo : 'cpf', valor : cpf} ,function(txt){
                    if(txt.valor == 'YES'){
                        $("#campo_existe3").show();
                        $('#cpf').val('');
                        $('#cpf').focus();
                    }
                    else{
                        $("#campo_existe3").hide();
                    }
               })
           }
       });
       
       $("#cnpj").focusout(function() {
           if($(this).val() != ''){
               var cnpj = $(this).val();
               $.getJSON('verifica-corretor.php',{campo : 'cnpj', valor : cnpj} ,function(txt){
                    if(txt.valor == 'YES'){
                        $("#campo_existe4").show();
                        $('#cpf').val('');
                        $('#cpf').focus();
                    }
                    else{
                        $("#campo_existe4").hide();
                    }
               })
           }
       });

       $('#estado').change(function(){
        
            var uf = $(this).val();
            $.ajax({
                type: "GET",
                url: "estados.php",
                data: "acao=buscaCidade&uf="+uf,
                dataType: "xml",
                beforeSend: function () {
                    $('#cidade').html('<option value="">Aguarde...</option>');
                },
                success: function (xml) {
                    var html = '<option value="">Selecione</option>';
                    $(xml).find('cidades').each(function () {
                        $(xml).find('cidade').each(function () {
                            var cidade = $(this).find('nome').text();
                            var id_cidade = $(this).find('id').text();
                            html += "<option value='"+id_cidade+"'>"+cidade+"</option>";
                        });
                    });
                    $('#cidade').html(html);
                },
                error: function () {
                    alert("Ocorreu um erro inesperado durante o processamento.");
                }
            });
        
        })
        
        $("#cep").blur(function(){
            if($.trim($("#cep").val()) != ""){
                $.getScript("http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+$("#cep").val(), function(){
                    if(resultadoCEP["resultado"]){
                         if(resultadoCEP["resultado"] != 0){
                             var uf     = unescape(resultadoCEP["uf"]);
                             var cidade = unescape(resultadoCEP["cidade"]);
                             var bairro = unescape(resultadoCEP["bairro"]);
                             var tipo   = unescape(resultadoCEP["tipo_logradouro"]);
                             var logradouro = unescape(resultadoCEP["logradouro"]);
                             var qt_uf  = 0;
                                                         
                             $("#estado option").each(function(){
                                 if($(this).html() == uf){
                                     $(this).attr("selected","selected");
                                     qt_uf++;
                                 }
                             })
                             
                             if(qt_uf > 0){
                                $.ajax({
                                        type: "GET",
                                        url: "estados.php",
                                        data: "acao=buscaCidade&uf="+uf,
                                        dataType: "xml",
                                        beforeSend: function () {
                                            $('#cidade').html('<option value="">Aguarde...</option>');
                                        },
                                        success: function (xml) {
                                            var z = 0;
                                            var html = '<option value="">Selecione</option>';
                                            $(xml).find('cidades').each(function () {
                                                $(xml).find('cidade').each(function () {
                                                    var city = $(this).find('nome').text();
                                                    var id_cidade = $(this).find('id').text();

                                                    if(cidade == city){
                                                        html += "<option selected='selected' value='"+id_cidade+"'>"+city+"</option>";
                                                        z++;
                                                    }
                                                    else{
                                                        html += "<option value='"+id_cidade+"'>"+city+"</option>";
                                                    }
                                                });
                                            });
                                            
                                            if(z == 0)
                                                qt_cidade = 0;
                                            else
                                                qt_cidade = 1;
                                            
                                            if(qt_cidade == 0){
                                                $("#cidade").val("");
                                                $("#estado").val("");
                                                $("#cep").val("");
                                                $("#endereco").val("");
                                                $("#bairro").val("");
                                                alert("A Suafocalpoint ainda não atua nesta cidade. Entre em contato conosco que em breve estaremos em sua localidade.");
                                            }
                                            else{
                                                $("#endereco").val(tipo+" "+logradouro);
                                                $("#bairro").val(bairro); 
                                            }
                                            
                                            $('#cidade').html(html);
                                        },
                                        error: function () {
                                            alert("Ocorreu um erro inesperado durante o processamento.");
                                        }
                                     });
                                
                             }
                             else{
                                 $("#cidade").val("");
                                 $("#estado").val("");
                                 $("#cep").val("");
                                 $("#endereco").val("");
                                 $("#bairro").val("");
                                 alert("A Suafocalpoint ainda não atua neste estado. Entre em contato conosco que em breve estaremos em sua localidade.");
                             }
                             
                         }
                    }
                });
           }
       })

    });
               
</script>

<div class="center">

    <div class="desc">
        <a href="home"><img src="static/img/logo.jpg" /></a>
    </div>
    
    <div class="bread">
    	<a href="home">Home > </a><span>Cadastro</span>
    </div>
    
    <div class="box-left">
    
    	<p class="blue">Faça seu cadastro em 4 passos simples <br />e comece a participar da nossa rede.</p>
        
        <ul class="cad-corretor">
        
            <li class="hover">Preencha o Formulário</li>

            <li>Termos de Uso</li>

            <li>Escolha seu Pacote</li>
            
            <li>Escolha seu Plano</li>

            <li>Pronto</li>
        
        </ul>
    
        <p>Procure preencher todos os campos para deixar seu perfil completo e ampliar suas possibilidades de gerar novos negócios atravás da nossa rede.</p>

    </div>
    
    <div class="box-right">
    
        <form action="home/inscreva-se/termo-de-uso" method="post" id="formulario" enctype="multipart/form-data">
            
            <input type="hidden" name="indicacao" value="<?php echo $indicacao;?>" />
            
            <div class="alinha-radio" style="width: 100%;">
                <label style="height:15px;">
                    <span><b>Tipo de Cadastro:</b></span>
                </label><br clear="all" />

                <div class="radio">
                    <label style="width: 150px;">
                        <input type="radio" name="pessoa" class="pessoa" value="fisica" class="required" />           
                        <span class="span-abs">Pessoa Física</span>
                    </label>
                </div>

                <div class="radio">
                    <label style="width: 150px;">
                        <input type="radio" name="pessoa" class="pessoa" value="juridica" class="required" /> 
                        <span>Pessoa Jurídica</span>
                    </label>
                </div>
            </div>
            
            <div style="display: none;" id="form-cadastro">
                
                <label class="cadastro">
                    <span>*Nome:</span>
                    <input value="<?php echo isset($_SESSION['dados']['nome']) ? $_SESSION['dados']['nome'] : '';?>" type="text" class="required" name="nome" id="nome" />           
                </label>

                <label class="cadastro-m">
                    <span>Nº CRECI:</span>
                    <input value="<?php echo isset($_SESSION['dados']['creci']) ? $_SESSION['dados']['creci'] : '';?>" type="text" name="creci" />           
                </label>

                <label class="cadastro">
                    <span>*Login:</span>
                    <input value="<?php echo isset($_SESSION['dados']['login_corretor']) ? $_SESSION['dados']['login_corretor'] : '';?>" type="text" class="required" name="login" id="login_cad" />
                    <span id="campo_existe">Login já existe. Insira um outro login.</span>
                </label>

                <label class="cadastro-m">
                    <span id="txt-nascimento">Nascimento:</span>
                    <span id="txt-fundacao">Fundação:</span>
                    <input value="<?php echo isset($_SESSION['dados']['data_nascimento']) ? $_SESSION['dados']['data_nascimento'] : '';?>" type="text" name="data_nascimento" id="nascimento" />           
                </label>

                <label id="campo_cpf" class="cadastro">
                    <span>*CPF:</span>
                    <input value="<?php echo isset($_SESSION['dados']['cpf']) ? $_SESSION['dados']['cpf'] : '';?>" type="text" name="cpf" class="text-input" id="cpf"/>    
                    <span id="campo_existe3">CPF já existe. Insira um outro CPF.</span>
                </label>
                
                <label id="campo_cnpj" class="cadastro">
                    <span>*CNPJ:</span>
                    <input value="<?php echo isset($_SESSION['dados']['cnpj']) ? $_SESSION['dados']['cnpj'] : '';?>" type="text" name="cnpj" class="text-input" id="cnpj"/>    
                    <span id="campo_existe4">CNPJ já existe. Insira um outro CNPJ.</span>
                </label>

                <label class="cadastro-m">
                    <span>*Senha:</span>
                    <input value="<?php echo isset($_SESSION['dados']['senha']) ? $_SESSION['dados']['senha'] : '';?>" type="password" name="senha" class="required" id="senha"/>           
                </label>

                <label class="cadastro">
                    <span>*Email:</span>
                    <input value="<?php echo isset($_SESSION['dados']['email']) ? $_SESSION['dados']['email'] : '';?>" type="text" name="email" class="text-input" id="email"/>  
                    <span id="campo_existe2">Email já existe. Insira um outro login.</span>
                </label>

                <label class="cadastro-m">
                    <span>*Confirme sua Senha:</span>
                    <input value="<?php echo isset($_SESSION['dados']['senha']) ? $_SESSION['dados']['senha'] : '';?>" type="password" name="c_senha" equalTo="#senha" class="required" id="c_senha" />           
                </label>
                
                <label id="campo_pessoa_contato" style="margin-bottom: 10px;" class="cadastro">
                    <span>*Pessoa de Contato:</span>
                    <input class="required" value="<?php echo isset($_SESSION['dados']['pessoa_contato']) ? $_SESSION['dados']['pessoa_contato'] : '';?>" type="text" name="pessoa_contato" class="text-input" />  
                </label>

                <label style="margin-bottom: 10px;" class="cadastro">
                    <span>Website:</span>
                    <input value="<?php echo isset($_SESSION['dados']['website']) ? $_SESSION['dados']['website'] : '';?>" type="text" name="website" class="text-input" />  
                </label>
                
                <div id="campo_sexo" class="alinha-radio">
                    <label style="height:15px;">
                        <span>*Sexo:</span>
                    </label><br clear="all" />

                    <div class="radio">
                        <label>
                            <input <?php echo (isset($_SESSION['dados']['sexo']) && $_SESSION['dados']['sexo'] == "Masculino") ? "checked=checked" : '';?> type="radio" name="sexo" value="Masculino" class="required" />           
                            <span class="span-abs">Masculino</span>
                        </label>
                    </div>

                    <div class="radio">
                        <label>
                            <input type="radio" <?php echo (isset($_SESSION['dados']['sexo']) && $_SESSION['dados']['sexo'] == "Feminino") ? "checked=checked" : '';?> name="sexo" value="Feminino" class="required" /> 
                            <span>Feminino</span>
                        </label>
                    </div>
                </div>

                <div id="campo_autonomo" class="alinha-radio">
                    <label style="height:15px;">
                        <span>*É corretor autônomo?</span>
                    </label><br clear="all" />

                    <div class="radio">
                        <label>
                            <input <?php echo (isset($_SESSION['dados']['autonomo']) && $_SESSION['dados']['autonomo'] == "SIM") ? "checked=checked" : '';?> class="autonomo required" type="radio" name="autonomo" value="SIM" />           
                            <span class="span-abs">Sim</span>
                        </label>
                    </div>

                    <div class="radio">
                        <label>
                            <input <?php echo (isset($_SESSION['dados']['autonomo']) && $_SESSION['dados']['autonomo'] == "NAO") ? "checked=checked" : '';?> class="autonomo required" type="radio" name="autonomo" value="NAO" /> 
                            <span>Não</span>
                        </label>
                    </div>
                </div>

                <div id="info-corretor">

                    <label <?php echo isset($_SESSION['dados']['autonomo']) && $_SESSION['dados']['autonomo'] == 'NAO' ? '' : 'style="display:none;"';?> id="cad_empresa" class="cadastro-all">
                        <span>Empresa:</span>
                        <input type="text" value="<?php echo isset($_SESSION['dados']['empresa']) ? $_SESSION['dados']['empresa'] : '';?>" name="empresa" class="text-input" id="empresa"/>           
                    </label>

                    <div style="width: 100%; float: left;">
                        <label class="cadastro-small" style="margin-right: 20px;">
                            <span>CEP:</span>
                            <input value="<?php echo isset($_SESSION['dados']['cep']) ? $_SESSION['dados']['cep'] : '';?>" type="text" name="cep" id="cep" /> 
                            <a style="font-size: 11px; color: blue;" href="http://correios.com.br/" target="_BLANK">Busque o CEP</a>
                        </label>

                        <label class="cadastro" style="margin-bottom: 10px; width: 470px;">
                            <span>Endereço: <font size="1">(Esta informação estará disponível publicamente)</font></span>
                            <input type="text" value="<?php echo isset($_SESSION['dados']['rua']) ? $_SESSION['dados']['rua'] : '';?>" name="rua" id="endereco" /> 
                        </label>
                    </div>  

                    <label class="cadastro-small">
                        <span>Número:</span>
                        <input type="text" name="numero" value="<?php echo isset($_SESSION['dados']['numero']) ? $_SESSION['dados']['numero'] : '';?>" id="numero" />           
                    </label>

                    <label class="cadastro-m" style="width:250px;">
                        <span>Complemento:</span>
                        <input type="text" value="<?php echo isset($_SESSION['dados']['complemento']) ? $_SESSION['dados']['complemento'] : '';?>" name="complemento" />           
                    </label>

                    <label class="cadastro-m">
                        <span>Bairro:</span>
                        <input type="text" value="<?php echo isset($_SESSION['dados']['bairro']) ? $_SESSION['dados']['bairro'] : '';?>" name="bairro" id="bairro"/>           
                    </label>

                    <div class="est-cidade">
                        <label class="cadastro-small" style="margin-right:10px;">
                            <span>*Estado:</span>
                            <select name="uf" <?php echo !isset($_SESSION['dados']['uf']) ? 'class="required"' : '';?> id="estado">
                                <option value="">Selecione</option>
                                <?php foreach($rows as $row) :?>
                                <option value="<?php echo $row->id;?>"><?php echo $row->uf;?></option>
                                <?php endforeach ;?>
                            </select>
                        </label>
                        <?php echo isset($_SESSION['dados']['uf']) ? '<span style="float: left; color:red; margin: 25px 20px 0 0;">'.$_SESSION['dados']['uf'].'</span>' : '';?>

                        <label class="cadastro-m" style="margin:0; width:250px;">
                            <span>*Cidade:</span>
                            <select name="cidade" <?php echo !isset($_SESSION['dados']['cidade']) ? 'class="required"' : '';?> id="cidade">
                                <option value="">Selecione</option>
                            </select>
                        </label>
                        <?php echo isset($_SESSION['dados']['cidade']) ? '<span style="float: left; color:red; margin: 25px 0 0 10px;">'.$_SESSION['dados']['cidade'].'</span>' : '';?>

                        <br clear="all" />
                    </div>

                    <div style="margin-bottom: 10px; float: left;">
                        <label class="cadastro-ddd">
                            <span>*Telefone:</span>
                            <input type="text" value="<?php echo isset($_SESSION['dados']['telefone']) ? substr($_SESSION['dados']['telefone'],0,4) : '';?>" name="ddd" class="required" id="ddd" />           
                        </label>

                        <label class="cadastro-m-ddd">
                            <span>&nbsp;</span>
                            <input type="text" name="telefone" value="<?php echo isset($_SESSION['dados']['telefone']) ? substr($_SESSION["dados"]["telefone"],4) : '';?>" class="required" id="telefone"/>           
                        </label>

                        <label class="cadastro-ddd">
                            <span>celular:</span>
                            <input type="text" value="<?php echo isset($_SESSION['dados']['celular']) ? substr($_SESSION['dados']['celular'],0,4) : '';?>" name="ddd_celular" id="ddd_celular" />           
                        </label>

                        <label class="cadastro-m-ddd" style="margin-right:0">
                            <span>&nbsp;</span>
                            <input type="text" value="<?php echo isset($_SESSION['dados']['celular']) ? substr($_SESSION['dados']['celular'],4) : '';?>" name="celular" id="celular"/>           
                        </label>
                    </div>
                    
                    <div>
                        <label class="cadastro-ddd">
                            <span>Telefone:</span>
                            <input type="text" value="<?php echo isset($_SESSION['dados']['telefone2']) ? substr($_SESSION['dados']['telefone2'],0,4) : '';?>" name="ddd2" id="ddd2" />           
                        </label>

                        <label class="cadastro-m-ddd">
                            <span>&nbsp;</span>
                            <input type="text" name="telefone2" value="<?php echo isset($_SESSION['dados']['telefone2']) ? substr($_SESSION["dados"]["telefone2"],4) : '';?>" id="telefone2"/>           
                        </label>

                        <label class="cadastro-ddd">
                            <span>celular:</span>
                            <input type="text" value="<?php echo isset($_SESSION['dados']['celular2']) ? substr($_SESSION['dados']['celular2'],0,4) : '';?>" name="ddd_celular2" id="ddd_celular2" />           
                        </label>

                        <label class="cadastro-m-ddd" style="margin-right:0">
                            <span>&nbsp;</span>
                            <input type="text" value="<?php echo isset($_SESSION['dados']['celular2']) ? substr($_SESSION['dados']['celular2'],4) : '';?>" name="celular2" id="celular2"/>           
                        </label>
                    </div>
                    
                    <div id="cad-imagens">
                        <div class="foto">
                            <span>Envie sua foto:</span>
                            <?php 
                            if(isset($_SESSION['dados']['foto_perfil']) && $_SESSION['dados']['foto_perfil'] != ""){
                                $img = URL_ABSOLUTE.'static/uploads/fotos/'.$_SESSION['dados']['login_corretor'].'/'.$_SESSION['dados']['foto_perfil'];
                                echo ImgRender($img, 92, 92, $_SESSION['dados']['nome']);
                            }
                            else{
                                echo '<img src="static/img/foto.jpg" width="92" height="92" alt="Sua Foto" title="Sua Foto" />';
                            }
                            ?>
                            <span class="tx">Selecione um arquivo de imagem de seu computador <font>(No máximo 2MB)</font></span>
                            <span class="file-wrapper">
                            <input type="file" name="foto" class="photo" />
                            <span class="button">Choose a Photo</span>
                            </span>
                        </div> 
                        <div class="foto">
                            <span>Envie seu logotipo:</span>
                            <?php 
                            if(isset($_SESSION['dados']['logotipo']) && $_SESSION['dados']['logotipo'] != ""){
                                $img = URL_ABSOLUTE.'static/uploads/logotipos/'.$_SESSION['dados']['login_corretor'].'/'.$_SESSION['dados']['logotipo'];
                                echo ImgRender($img, 92, 92, $_SESSION['dados']['nome']);
                            }
                            else{
                                echo '<img src="static/img/foto.jpg" width="92" height="92" alt="Sua Foto" title="Sua Foto" />';
                            }
                            ?>
                            <span class="tx">Selecione um arquivo de imagem de seu computador <font>(No máximo 2MB)</font></span>
                            <span class="file-wrapper">
                            <input type="file" name="logotipo" class="photo" />
                            <span class="button">Choose a Photo</span>
                            </span>
                        </div> 
                    </div>
                </div>

                <br clear="all" />
                <input type="submit" value="" class="enviar-senha avancar"/>
        
            </div>
               
        </form>
        
    </div>
    

</div>