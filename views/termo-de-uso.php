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
    
    	<p class="blue">Faça seu cadastro em 4 passos simples <br />e comece a participar da nossa rede.</p>
        
        <ul class="cad-corretor">
        
            <li><a href="home/inscreva-se/dados-cadastro">Preencha o Formulário</a></li>

            <li class="hover">Termos de Uso</li>

            <li>Escolha seu Pacote</li>
            
            <li>Escolha seu Plano</li>

            <li>Pronto</li>
        
        </ul>
    
        <p>Procure preencher todos os campos para deixar seu perfil completo e ampliar suas possibilidades de gerar novos negócios através da nossa rede.</p>

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
            	<span>Você aceita que seus dados sejam listados em nossa página inicial no link Conheça Corretores?</span>
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
                    <span>Não</span>
                </label>
            </div><br clear="all" /><br clear="all" />
        
            <label class="cadastro-all" style="height:40px;">
            	<span>*Digite abaixo sua sigla com 3 caracteres (somente letras) que identificará imóveis<br />cadastrados por você:<br /><em style="font-size:11px">Ex.: RRD</em></span>
            </label><br clear="all" />
        
            <label class="cadastro-m" style="margin:10px 0 0 0; width:100px;">
                <input value="<?php echo isset($_SESSION['dados']['sigla']) ? $_SESSION['dados']['sigla'] : '';?>" type="text" name="sigla" maxlength="3" class="required" id="sigla"/> 
                <span id="campo_existe">Sigla já existe. Insira outra sigla.</span>
                <span id="campo_invalido">Sigla inválida, A sigla deve conter letras e números.</span>
            </label>
        
            <label class="textarea termo">
            	<span>Termos de uso:</span>
                <span>
                    Declaração de direitos e responsabilidades<br><br>

                    Esta Declaração de direitos e responsabilidades (Declaração) é baseada nos princípios básicos que orientam os negócios de Sua Focal Point e determina nosso relacionamento com os usuários e outras pessoas que interagem com o nosso site. Toda vez que você, Usuário, usar ou acessar o Nosso Site, você estará concordando com esta Declaração.<br><br>
                    1.	<strong>Acesso limitado</strong><br>

                    Nosso Site poderá ser acessado diretamente apenas por usuários cadastrados por Sua Focal Point, mas os usuários colocam nele o conteúdo e as informações que desejam divulgar, contanto que cumpram os compromissos contidos nesta Declaração. <br> 
                    Nosso Site não divulgará a quaisquer terceiros qualquer conteúdo ou informações colocados no site pelos usuários cadastrados, nem impedirá que os usuários possam divulgar essas informações.<br>
                    Sua Focal Point não aceita qualquer responsabilidade pelas informações colocadas no site pelos usuários, nem pelas informações divulgadas a outros usuários ou terceiros pelos usuários.<br><br>
                    2.	<strong>Compartilhar conteúdo e informações</strong><br>

                    Você, como todos os demais usuários, é proprietário de todo o conteúdo e informações que publica no website de Sua Focal Point. Assim, você pode controlar diretamente como suas informações e seu conteúdo serão compartilhados com outros usuários. Além disso:<br>
                    a)	Para o conteúdo coberto por direitos de propriedade intelectual, como por exemplo, fotos e vídeo (conteúdo IP), você nos concede especificamente uma licença mundial não exclusiva, transferível, sublicenciável, livre de royalties, para usar qualquer conteúdo IP publicado por você no Nosso Site (Licença IP). Essa Licença IP termina quando você exclui seu conteúdo IP ou sua conta, a menos que seu conteúdo tenha sido compartilhado com outros e eles não o tenham excluído.<br>
                    b)	Ao excluir um conteúdo IP, ele é excluído de maneira similar ao esvaziamento da lixeira do computador. No entanto, entenda que o conteúdo removido pode permanecer em cópias de backup por um período razoável (mas não estará disponível para outros).<br>
                    c)	Ao usar um aplicativo, seu conteúdo e as informações são compartilhados com o aplicativo. Exigimos que os aplicativos respeitem sua privacidade, e seu acordo com esse aplicativo controlará como o mesmo poderá usar, armazenar e transferir esse conteúdo e informações. <br>
                    d)	Publicar o conteúdo ou informações usando a configuração ?todos? significa que você permite que todos acessem e usem essas informações e as associem a você.<br><br>

                    3.	<strong>Segurança</strong><br>

                    Nós empenhamos nossos melhores esforços para manter o Nosso Site seguro, mas não há como garantir isso. Para tanto, contamos com os seguintes compromissos de todos os nossos usuários:<br>
                    a)	Não enviar ou publicar de outra forma comunicações comerciais não autorizadas (como spam) no Nosso Site.<br>
                    b)	Não enviar vírus, malware ou outros códigos maliciosos.<br>
                    c)	Nenhum usuário poderá solicitar informações de login nem poderá acessar uma conta que pertença a qualquer outra pessoa.<br>
                    d)	Não publicar conteúdo que seja ofensivo, ameaçador ou pornográfico, que incite a violência ou que contenha nudez ou violência gráfica.<br>
                    e)	Não usar Sua Focal Point para praticar qualquer ato ilegal, equivocado, malicioso ou discriminatório.<br>
                    f)	Não fazer nada que possa desabilitar, sobrecarregar ou impedir o funcionamento adequado do sistema de Sua Focal Point.<br><br>

                    4.	<strong>Registro e segurança da conta</strong><br>

                    Os usuários de Sua Focal Point fornecem seus nomes e informações reais, e precisamos da sua ajuda para que isso continue assim. Estes são alguns compromissos que você firma conosco em relação ao registro e à manutenção da segurança de sua conta:<br>

                    a)	Não fornecer qualquer informação pessoal falsa no Nosso Site, nem criar uma conta para ninguém além de si mesmo sem permissão.<br>
                    b)	Não criar mais de um perfil pessoal.<br>
                    c)	Se desativarmos sua conta, você não poderá criar outra sem nossa permissão.<br>
                    d)	Você deverá manter suas informações de contato precisas e atualizadas.<br>
                    e)	Você não deve compartilhar sua senha ou deixar alguém acessar sua conta ou fazer qualquer outra coisa que possa comprometer a segurança de sua conta.<br>
                    f)	Você não poderá transferir sua conta para um terceiro sem antes obter nossa permissão por escrito.<br>
                    g)	Ao selecionar um nome de usuário para sua conta, nós nos reservaremos o direito de remover ou modificá-lo se o considerarmos inadequado.<br><br>

                    5.	<strong>Proteção dos direitos de outras pessoas</strong><br>

                    Sua Focal Point respeita os direitos de todos os usuários. Assim sendo:<br>
                    a)	Nós podemos remover qualquer conteúdo ou informações publicadas por você em nosso site se julgarmos que isso viola seus compromissos assumidos nesta Declaração.<br>
                    b)	Se removermos seu conteúdo por infringir os direitos de propriedade intelectual de alguém, e você acredita que o removemos por engano, forneceremos a você a oportunidade de recorrer.<br>
                    c)	Se você violar repetidamente os direitos de propriedade intelectual de outras pessoas ou os compromissos assumidos nesta Declaração, desativaremos sua conta quando julgarmos apropriado, sem qualquer aviso prévio.<br>
                    d)	Você não deve publicar documentos de identificação ou informações financeiras confidenciais de ninguém no Nosso Site.<br>
                    e)	Você não deve indicar quem são os usuários nem enviar convites por e-mail para não usuários sem o consentimento deles.<br><br>

                    6.	<strong>Móvel</strong><br>

                    a)	Além dos valores que cobramos, lembramos aos usuários que as taxas e os impostos normais de sua operadora, tais como taxas de mensagens de texto, acesso a internet, etc. ainda se aplicam.<br>
                    b)	Caso altere ou desative seu número de telefone celular, você deverá atualizar as informações de sua conta no site de Sua Focal Point dentro de 48 horas para garantir que suas mensagens não sejam enviadas para a pessoa que adquirir seu número antigo.<br>
                    c)	Você fornece todos os direitos necessários para permitir que os usuários sincronizem (inclusive através de um aplicativo) suas listas de contatos com as informações básicas visíveis para eles no nosso site, bem como seu nome e foto do perfil. <br><br>

                    7.	<strong>Pagamentos</strong><br>
                    a)	Ao efetuar um pagamento no site de Sua Focal Point ou usar os Créditos do nosso site, você concorda com nossos Termos de pagamento. <br><br>

                    8.	<strong>Alterações</strong><br>
                    a)	??Nós podemos alterar esta Declaração se fornecermos a você uma notificação e uma oportunidade para comentário.<br>
                    b)	Para as alterações da cláusula 7, relacionadas a pagamentos, enviaremos a você uma notificação com no mínimo três dias de antecedência. Para todas as outras mudanças, enviaremos uma notificação com, no mínimo, sete dias de antecedência. <br>
                    c)	Nós podemos fazer mudanças por razões legais ou administrativas, ou para corrigir uma declaração imprecisa, mediante notificação, sem oportunidade para comentário<br><br>

                    9.	<strong>Rescisão</strong><br>

                    Se você violar os termos e condições desta Declaração, ou nos criar possível risco ou exposição judicial, podemos deixar de fornecer todo ou parte do dos serviços de Sua Focal Point para você. Você será notificado por e-mail ou na próxima vez que você tentar acessar sua conta. Você também pode excluir sua conta ou desativar seu aplicativo a qualquer momento. Em todos esses casos, esta Declaração perderá sua vigência, mas os compromissos contidos nas cláusulas 2, 3 e 5 acima continuarão a vigorar,<br><br>

                    10.	<strong>Disputas</strong><br>
                    a)	Toda e qualquer controvérsia que possa surgir da interpretação ou da execução desta Declaração será resolvida por um ou mais árbitros, de acordo com os termos do Regulamento da Câmara FGV de Conciliação e Arbitragem da Fundação Getulio Vargas. O local da arbitragem será a Cidade de Rio de Janeiro. .<br>
                    b)	Se alguém mover uma reclamação contra nós em relação a suas ações, conteúdo ou informações no site de Sua Focal Point, você nos isentará da responsabilidade por todos os danos, perdas e despesas de qualquer espécie (incluindo as custas judiciais aplicáveis) em relação a essa reclamação.<br>
                    c)	TENTAMOS MANTER O NOSSO SITE ATUALIZADO, SEGURO E LIVRE DE ERROS, MAS VOCÊ O USA POR SUA CONTA E RISCO. NÓS FORNECEMOS O NOSSO SITE NO ESTADO EM QUE SE ENCONTRA SEM GARANTIAS EXPRESSAS OU IMPLÍCITAS. NÃO GARANTIMOS QUE O NOSSO SITE FICARÁ SEGURO E PROTEGIDO. <br>

                    d)	NOSSO SITE NÃO ASSUMIRÁ A RESPONSABILIDADE POR AÇÕES, CONTEÚDO, INFORMAÇÕES OU DADOS DE TERCEIROS, E VOCÊ ISENTA A NÓS, NOSSOS SÓCIOS, ADMINISTRADORES, FUNCIONÁRIOS E AGENTES DE QUALQUER RECLAMAÇÃO OU DANO, DECORRENTE DE OU RELACIONADO, DE QUALQUER FORMA, A QUALQUER RECLAMAÇÃO QUE VOCÊ TENHA CONTRA TERCEIROS OU QUE TERCEIROS POSSAM TER CONTRA VOCÊ.<br><br>

                    11.	<strong>Definições</strong><br>
                    a)	O termo Nosso Site abrange os recursos e serviços que disponibilizamos, incluindo por meio de (i) nosso site www.suafocalpoint.com e qualquer outro site da marca Sua Focal Point ou sites de marca compartilhada (incluindo subdomínios, versões internacionais, widgets e versões para celulares); (ii) nossa plataforma; (iii) plug-ins sociais, como o botão Curtir, o botão Compartilhar e outras ofertas similares (d) e outras mídias, softwares (como uma barra de ferramentas), dispositivos ou redes já existentes ou desenvolvidos posteriormente.<br>
                    b)	O termo Plataforma abrange um conjunto de APIs e serviços que permitem que outros, inclusive desenvolvedores de aplicativos e operadores de sites, recuperem dados do Nosso Site ou forneçam dados para nós.<br>
                    c)	O termo informações abrange os fatos e outras informações sobre você, incluindo suas ações executadas.<br>
                    d)	O termo conteúdo abrange qualquer coisa que você publica no site de Sua Focal Point que não se encaixa na definição de informações.<br>
                    e)	O termo dados abrange o conteúdo e as informações que terceiros podem recuperar do site ou fornecer ao site por meio da plataforma.<br>
                    f)	O termo publicar abrange publicações no site de Sua Focal Point ou conteúdo disponibilizado de outra forma para nós (ex.: usando um aplicativo).<br>
                    g)	O termo uso abrange usar, copiar, agir ou divulgar publicamente, distribuir, modificar, traduzir e criar trabalhos derivados.<br>
                    h)	O termo aplicativo abrange qualquer aplicativo ou site que usa ou acessa a plataforma, bem como qualquer coisa que recebe ou tenha recebido dados de nós. Se você não acessa mais a plataforma, mas não exclui os dados que tem conosco, o termo aplicativo se aplicará até que você exclua os dados.<br><br>

                    12.	<strong>Outros</strong><br>
                    a)	Esta Declaração compõe todo o acordo entre as partes em relação ao Nosso Site e tem precedência sobre acordos anteriores.<br>
                    b)	Se qualquer parte desta Declaração for considerada como não aplicável, a parte restante permanecerá em total vigência legal.<br>
                    c)	Você não pode transferir seus direitos nem obrigações sob esta Declaração para qualquer outra pessoa sem nosso consentimento.<br>
                    d)	Esta Declaração não confere direitos que possam beneficiar terceiros.<br>
                </span>     
            </label>
            
            <p class="confirm">Ao clicar em 'Avançar', você estará aceitando os Termos de uso acima.</p>

            <br clear="all" />
            <input type="submit" value="" class="enviar-senha avancar"/>
        
        </form>
        
    </div>
    

</div>