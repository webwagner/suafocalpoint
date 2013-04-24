<script type="text/javascript" src="<?php echo URL;?>static/js/jquery.validate.js"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
    $('#select').change(function() {

       $('#form3').hide();

       $('#form' + $(this).find('option:selected').attr('id')).show();

    });
    
    $("#sigla").focusout(function() {
       if($(this).val() != ''){
           var sigla = $(this).val();
           $.getJSON('verifica-corretor.php',{campo : 'sigla', valor : sigla} ,function(txt){
                if(txt.valor == 'YES'){
                    $("#campo_existe").show();
                    $('#sigla').val('');
                    $('#sigla').focus();
                }
                else{
                    $("#campo_existe").hide();
                }
           })
       }
   });
   
   $("#formulario").submit(function(){
       var sigla = $("#sigla").val();
       if(sigla.length == 3){ 
           if(sigla != "" && /^[a-zA-Z0-9]*$/.test(sigla)){ 
               $("#campo_invalido").hide();
               return true;
           }
           else{
               $("#campo_invalido").show();
               return false;
           } 
       }
       else{
           $("#campo_invalido").show();
           return false;
       }
   });
   
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
    
    	<p class="blue">Fa�a seu cadastro em 4 passos simples <br />e comece a participar da nossa rede.</p>
        
        <ul class="cad-corretor">
        
            <li><a href="home/inscreva-se/dados-cadastro">Preencha o Formul�rio</a></li>

            <li class="hover">Termos de Uso</li>

            <li>Escolha seu Pacote</li>
            
            <li>Escolha seu Plano</li>

            <li>Pronto</li>
        
        </ul>
    
        <p>Procure preencher todos os campos para deixar seu perfil completo e ampliar suas possibilidades de gerar novos neg�cios atrav�s da nossa rede.</p>

    </div>
    
    <div class="box-right">
    
        <form action="home/inscreva-se/escolha-seu-pacote" method="post" id="formulario">
            
            <label class="cadastro-all">
            	<span>Como conheceu nossa rede?<br /></span>
            	<select name="como_conheceu" class="required" id="select">
                    <option value="">Selecione</option>
                    <?php 
                    $selected = "";
                    
                    foreach($rows_comoconheceu as $row_comoconheceu){
                        
                        if(isset($_SESSION['dados']['como_conheceu'])){
                            if($_SESSION['dados']['como_conheceu'] == $row_comoconheceu->titulo)
                                $selected = "selected = selected";
                            else
                                $selected = "";
                        }
                        
                        echo '<option '.$selected.' value="'.$row_comoconheceu->titulo.'">'.$row_comoconheceu->titulo.'</option>';
                    }
                    ?>
                </select>
            </label><br clear="all" />

            <label class="cadastro-m" id="form3" style="margin:0; width:250px; display:none;">
            	<span>&nbsp;</span>
                <input type="text" name="outros"/>           
            </label><br clear="all" />
        
            <label class="cadastro-all" style="height:40px;">
            	<span>Voc� aceita que seus dados sejam listados em nossa p�gina inicial no link Conhe�a Corretores?</span>
            </label><br clear="all" />
            
            <div class="radio">
                <label>
                    <input <?php echo (isset($_SESSION['dados']['dados_listados']) && $_SESSION['dados']['dados_listados'] == "SIM") ? 'checked=checked' : '';?> type="radio" name="dados_listados" checked="checked" value="SIM" />           
                    <span>Sim</span>
                </label>
            </div>
            
            <div class="radio">
                <label>
                    <input <?php echo (isset($_SESSION['dados']['dados_listados']) && $_SESSION['dados']['dados_listados'] == "NAO") ? 'checked=checked' : '';?> type="radio" name="dados_listados" value="NAO" /> 
                    <span>N�o</span>
                </label>
            </div><br clear="all" /><br clear="all" />
        
            <label class="cadastro-all" style="height:40px;">
            	<span>*Digite abaixo sua sigla com 3 caracteres (somente letras) que identificar� im�veis<br />cadastrados por voc�:<br /><em style="font-size:11px">Ex.: RRD</em></span>
            </label><br clear="all" />
        
            <label class="cadastro-m" style="margin:10px 0 0 0; width:100px;">
                <input value="<?php echo isset($_SESSION['dados']['sigla']) ? $_SESSION['dados']['sigla'] : '';?>" type="text" name="sigla" maxlength="3" class="required" id="sigla"/> 
                <span id="campo_existe">Sigla j� existe. Insira outra sigla.</span>
                <span id="campo_invalido">Sigla inv�lida, A sigla deve conter letras e n�meros.</span>
            </label>
        
            <label class="textarea termo">
            	<span>Termos de uso:</span>
                <span>
                    Declara��o de direitos e responsabilidades<br><br>

                    Esta Declara��o de direitos e responsabilidades (Declara��o) � baseada nos princ�pios b�sicos que orientam os neg�cios de Sua Focal Point e determina nosso relacionamento com os usu�rios e outras pessoas que interagem com o nosso site. Toda vez que voc�, Usu�rio, usar ou acessar o Nosso Site, voc� estar� concordando com esta Declara��o.<br><br>
                    1.	<strong>Acesso limitado</strong><br>

                    Nosso Site poder� ser acessado diretamente apenas por usu�rios cadastrados por Sua Focal Point, mas os usu�rios colocam nele o conte�do e as informa��es que desejam divulgar, contanto que cumpram os compromissos contidos nesta Declara��o. <br> 
                    Nosso Site n�o divulgar� a quaisquer terceiros qualquer conte�do ou informa��es colocados no site pelos usu�rios cadastrados, nem impedir� que os usu�rios possam divulgar essas informa��es.<br>
                    Sua Focal Point n�o aceita qualquer responsabilidade pelas informa��es colocadas no site pelos usu�rios, nem pelas informa��es divulgadas a outros usu�rios ou terceiros pelos usu�rios.<br><br>
                    2.	<strong>Compartilhar conte�do e informa��es</strong><br>

                    Voc�, como todos os demais usu�rios, � propriet�rio de todo o conte�do e informa��es que publica no website de Sua Focal Point. Assim, voc� pode controlar diretamente como suas informa��es e seu conte�do ser�o compartilhados com outros usu�rios. Al�m disso:<br>
                    a)	Para o conte�do coberto por direitos de propriedade intelectual, como por exemplo, fotos e v�deo (conte�do IP), voc� nos concede especificamente uma licen�a mundial n�o exclusiva, transfer�vel, sublicenci�vel, livre de royalties, para usar qualquer conte�do IP publicado por voc� no Nosso Site (Licen�a IP). Essa Licen�a IP termina quando voc� exclui seu conte�do IP ou sua conta, a menos que seu conte�do tenha sido compartilhado com outros e eles n�o o tenham exclu�do.<br>
                    b)	Ao excluir um conte�do IP, ele � exclu�do de maneira similar ao esvaziamento da lixeira do computador. No entanto, entenda que o conte�do removido pode permanecer em c�pias de backup por um per�odo razo�vel (mas n�o estar� dispon�vel para outros).<br>
                    c)	Ao usar um aplicativo, seu conte�do e as informa��es s�o compartilhados com o aplicativo. Exigimos que os aplicativos respeitem sua privacidade, e seu acordo com esse aplicativo controlar� como o mesmo poder� usar, armazenar e transferir esse conte�do e informa��es. <br>
                    d)	Publicar o conte�do ou informa��es usando a configura��o ?todos? significa que voc� permite que todos acessem e usem essas informa��es e as associem a voc�.<br><br>

                    3.	<strong>Seguran�a</strong><br>

                    N�s empenhamos nossos melhores esfor�os para manter o Nosso Site seguro, mas n�o h� como garantir isso. Para tanto, contamos com os seguintes compromissos de todos os nossos usu�rios:<br>
                    a)	N�o enviar ou publicar de outra forma comunica��es comerciais n�o autorizadas (como spam) no Nosso Site.<br>
                    b)	N�o enviar v�rus, malware ou outros c�digos maliciosos.<br>
                    c)	Nenhum usu�rio poder� solicitar informa��es de login nem poder� acessar uma conta que perten�a a qualquer outra pessoa.<br>
                    d)	N�o publicar conte�do que seja ofensivo, amea�ador ou pornogr�fico, que incite a viol�ncia ou que contenha nudez ou viol�ncia gr�fica.<br>
                    e)	N�o usar Sua Focal Point para praticar qualquer ato ilegal, equivocado, malicioso ou discriminat�rio.<br>
                    f)	N�o fazer nada que possa desabilitar, sobrecarregar ou impedir o funcionamento adequado do sistema de Sua Focal Point.<br><br>

                    4.	<strong>Registro e seguran�a da conta</strong><br>

                    Os usu�rios de Sua Focal Point fornecem seus nomes e informa��es reais, e precisamos da sua ajuda para que isso continue assim. Estes s�o alguns compromissos que voc� firma conosco em rela��o ao registro e � manuten��o da seguran�a de sua conta:<br>

                    a)	N�o fornecer qualquer informa��o pessoal falsa no Nosso Site, nem criar uma conta para ningu�m al�m de si mesmo sem permiss�o.<br>
                    b)	N�o criar mais de um perfil pessoal.<br>
                    c)	Se desativarmos sua conta, voc� n�o poder� criar outra sem nossa permiss�o.<br>
                    d)	Voc� dever� manter suas informa��es de contato precisas e atualizadas.<br>
                    e)	Voc� n�o deve compartilhar sua senha ou deixar algu�m acessar sua conta ou fazer qualquer outra coisa que possa comprometer a seguran�a de sua conta.<br>
                    f)	Voc� n�o poder� transferir sua conta para um terceiro sem antes obter nossa permiss�o por escrito.<br>
                    g)	Ao selecionar um nome de usu�rio para sua conta, n�s nos reservaremos o direito de remover ou modific�-lo se o considerarmos inadequado.<br><br>

                    5.	<strong>Prote��o dos direitos de outras pessoas</strong><br>

                    Sua Focal Point respeita os direitos de todos os usu�rios. Assim sendo:<br>
                    a)	N�s podemos remover qualquer conte�do ou informa��es publicadas por voc� em nosso site se julgarmos que isso viola seus compromissos assumidos nesta Declara��o.<br>
                    b)	Se removermos seu conte�do por infringir os direitos de propriedade intelectual de algu�m, e voc� acredita que o removemos por engano, forneceremos a voc� a oportunidade de recorrer.<br>
                    c)	Se voc� violar repetidamente os direitos de propriedade intelectual de outras pessoas ou os compromissos assumidos nesta Declara��o, desativaremos sua conta quando julgarmos apropriado, sem qualquer aviso pr�vio.<br>
                    d)	Voc� n�o deve publicar documentos de identifica��o ou informa��es financeiras confidenciais de ningu�m no Nosso Site.<br>
                    e)	Voc� n�o deve indicar quem s�o os usu�rios nem enviar convites por e-mail para n�o usu�rios sem o consentimento deles.<br><br>

                    6.	<strong>M�vel</strong><br>

                    a)	Al�m dos valores que cobramos, lembramos aos usu�rios que as taxas e os impostos normais de sua operadora, tais como taxas de mensagens de texto, acesso a internet, etc. ainda se aplicam.<br>
                    b)	Caso altere ou desative seu n�mero de telefone celular, voc� dever� atualizar as informa��es de sua conta no site de Sua Focal Point dentro de 48 horas para garantir que suas mensagens n�o sejam enviadas para a pessoa que adquirir seu n�mero antigo.<br>
                    c)	Voc� fornece todos os direitos necess�rios para permitir que os usu�rios sincronizem (inclusive atrav�s de um aplicativo) suas listas de contatos com as informa��es b�sicas vis�veis para eles no nosso site, bem como seu nome e foto do perfil. <br><br>

                    7.	<strong>Pagamentos</strong><br>
                    a)	Ao efetuar um pagamento no site de Sua Focal Point ou usar os Cr�ditos do nosso site, voc� concorda com nossos Termos de pagamento. <br><br>

                    8.	<strong>Altera��es</strong><br>
                    a)	??N�s podemos alterar esta Declara��o se fornecermos a voc� uma notifica��o e uma oportunidade para coment�rio.<br>
                    b)	Para as altera��es da cl�usula 7, relacionadas a pagamentos, enviaremos a voc� uma notifica��o com no m�nimo tr�s dias de anteced�ncia. Para todas as outras mudan�as, enviaremos uma notifica��o com, no m�nimo, sete dias de anteced�ncia. <br>
                    c)	N�s podemos fazer mudan�as por raz�es legais ou administrativas, ou para corrigir uma declara��o imprecisa, mediante notifica��o, sem oportunidade para coment�rio<br><br>

                    9.	<strong>Rescis�o</strong><br>

                    Se voc� violar os termos e condi��es desta Declara��o, ou nos criar poss�vel risco ou exposi��o judicial, podemos deixar de fornecer todo ou parte do dos servi�os de Sua Focal Point para voc�. Voc� ser� notificado por e-mail ou na pr�xima vez que voc� tentar acessar sua conta. Voc� tamb�m pode excluir sua conta ou desativar seu aplicativo a qualquer momento. Em todos esses casos, esta Declara��o perder� sua vig�ncia, mas os compromissos contidos nas cl�usulas 2, 3 e 5 acima continuar�o a vigorar,<br><br>

                    10.	<strong>Disputas</strong><br>
                    a)	Toda e qualquer controv�rsia que possa surgir da interpreta��o ou da execu��o desta Declara��o ser� resolvida por um ou mais �rbitros, de acordo com os termos do Regulamento da C�mara FGV de Concilia��o e Arbitragem da Funda��o Getulio Vargas. O local da arbitragem ser� a Cidade de Rio de Janeiro. .<br>
                    b)	Se algu�m mover uma reclama��o contra n�s em rela��o a suas a��es, conte�do ou informa��es no site de Sua Focal Point, voc� nos isentar� da responsabilidade por todos os danos, perdas e despesas de qualquer esp�cie (incluindo as custas judiciais aplic�veis) em rela��o a essa reclama��o.<br>
                    c)	TENTAMOS MANTER O NOSSO SITE ATUALIZADO, SEGURO E LIVRE DE ERROS, MAS VOC� O USA POR SUA CONTA E RISCO. N�S FORNECEMOS O NOSSO SITE NO ESTADO EM QUE SE ENCONTRA SEM GARANTIAS EXPRESSAS OU IMPL�CITAS. N�O GARANTIMOS QUE O NOSSO SITE FICAR� SEGURO E PROTEGIDO. <br>

                    d)	NOSSO SITE N�O ASSUMIR� A RESPONSABILIDADE POR A��ES, CONTE�DO, INFORMA��ES OU DADOS DE TERCEIROS, E VOC� ISENTA A N�S, NOSSOS S�CIOS, ADMINISTRADORES, FUNCION�RIOS E AGENTES DE QUALQUER RECLAMA��O OU DANO, DECORRENTE DE OU RELACIONADO, DE QUALQUER FORMA, A QUALQUER RECLAMA��O QUE VOC� TENHA CONTRA TERCEIROS OU QUE TERCEIROS POSSAM TER CONTRA VOC�.<br><br>

                    11.	<strong>Defini��es</strong><br>
                    a)	O termo Nosso Site abrange os recursos e servi�os que disponibilizamos, incluindo por meio de (i) nosso site www.suafocalpoint.com e qualquer outro site da marca Sua Focal Point ou sites de marca compartilhada (incluindo subdom�nios, vers�es internacionais, widgets e vers�es para celulares); (ii) nossa plataforma; (iii) plug-ins sociais, como o bot�o Curtir, o bot�o Compartilhar e outras ofertas similares (d) e outras m�dias, softwares (como uma barra de ferramentas), dispositivos ou redes j� existentes ou desenvolvidos posteriormente.<br>
                    b)	O termo Plataforma abrange um conjunto de APIs e servi�os que permitem que outros, inclusive desenvolvedores de aplicativos e operadores de sites, recuperem dados do Nosso Site ou forne�am dados para n�s.<br>
                    c)	O termo informa��es abrange os fatos e outras informa��es sobre voc�, incluindo suas a��es executadas.<br>
                    d)	O termo conte�do abrange qualquer coisa que voc� publica no site de Sua Focal Point que n�o se encaixa na defini��o de informa��es.<br>
                    e)	O termo dados abrange o conte�do e as informa��es que terceiros podem recuperar do site ou fornecer ao site por meio da plataforma.<br>
                    f)	O termo publicar abrange publica��es no site de Sua Focal Point ou conte�do disponibilizado de outra forma para n�s (ex.: usando um aplicativo).<br>
                    g)	O termo uso abrange usar, copiar, agir ou divulgar publicamente, distribuir, modificar, traduzir e criar trabalhos derivados.<br>
                    h)	O termo aplicativo abrange qualquer aplicativo ou site que usa ou acessa a plataforma, bem como qualquer coisa que recebe ou tenha recebido dados de n�s. Se voc� n�o acessa mais a plataforma, mas n�o exclui os dados que tem conosco, o termo aplicativo se aplicar� at� que voc� exclua os dados.<br><br>

                    12.	<strong>Outros</strong><br>
                    a)	Esta Declara��o comp�e todo o acordo entre as partes em rela��o ao Nosso Site e tem preced�ncia sobre acordos anteriores.<br>
                    b)	Se qualquer parte desta Declara��o for considerada como n�o aplic�vel, a parte restante permanecer� em total vig�ncia legal.<br>
                    c)	Voc� n�o pode transferir seus direitos nem obriga��es sob esta Declara��o para qualquer outra pessoa sem nosso consentimento.<br>
                    d)	Esta Declara��o n�o confere direitos que possam beneficiar terceiros.<br>
                </span>     
            </label>
            
            <p class="confirm">Ao clicar em 'Avan�ar', voc� estar� aceitando os Termos de uso acima.</p>

            <br clear="all" />
            <input type="submit" value="" class="enviar-senha avancar"/>
        
        </form>
        
    </div>
    

</div>