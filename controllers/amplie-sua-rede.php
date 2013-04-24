<?php

if(!isset($_SESSION['login']))
    echo "<script>location.href = 'home'</script>";

if(isset($_POST['mensagem'])){    
    $total = count($_POST['email_convidar']) - 1;
    
    $msg = '';
    
    if(isset($_POST['mensagem']))
        $mensagem = $_POST['mensagem'];
    else
        $mensagem = '';
    
    if(isset($_POST['codigo']))
        $codigo = $_POST['codigo'];
    else
        $codigo = '';
    
    if($_SESSION['usuario_visitado']->foto_perfil != "")
        $img = URL_ABSOLUTE.'static/uploads/fotos/'.$_SESSION['usuario_visitado']->login.'/'.$_SESSION['usuario_visitado']->foto_perfil;
    else
        $img = URL_ABSOLUTE.'static/img/perfil-focalpoint.jpg';

    $imagem = ImgRender($img, 98, 98, $_SESSION['usuario_visitado']->nome);
    
    $text = "<table cellpadding='0' cellspacing='0' border='0' style='background-color: #0B3458; width: 600px; height: 40px; padding-left: 14px;'>
        <tr>
            <td style='color: #fff; font-family: Arial; font-size: 18px; font-weight: bold;'>Venha Participar da Sua Focal Point</td>
        </tr>
    </table>
    <table cellpadding='0' cellspacing='0' border='0' style='border: 4px solid #0B3458; padding: 10px; width: 600px; margin-bottom: 50px;'>   
        <tr>
            <td>".$imagem."</td>
            <td style='font-family: Arial; font-size: 13px;'>
                <span>Seu amigo ".$_SESSION['usuario_visitado']->nome." lhe convidou para participar da Sua Focal Point<br /><br />
                <a href='".URL."home/inscreva-se/dados-cadastro/".$codigo."' target='_BLANK'><img src='".URL."static/img/bt-entrar.gif' /></a></span>
            </td>
        </tr>
        <tr><td colspan='2'>&nbsp;</td></tr>
        <tr>
            <td colspan='2' style='margin-top:10px; font-family: Arial; font-size: 13px; color: #251F45;'>".$mensagem."</td>
        </tr>
    </table>
   <table style='width: 960px; margin: 0 auto; background: #e6f3fc url(http://www.suafocalpoint.com/new/static/img/top-email-bg.jpg) repeat-x; height: 212px;' cellspacing='0' cellpadding='0' border='0'>
    <tr>
        <td>
            <table style='width: 960px; margin: auto; background: url(http://www.suafocalpoint.com/new/static/img/top-email-frase.png) top left no-repeat;' cellspacing='0' cellpadding='0' border='0'>
                <tr>
                    <td align='center' style='float: left; width:  100%; text-align: center;'>
                        <img src='http://www.suafocalpoint.com/new/static/img/top-email-logo.jpg' alt='SuaFocalpoint' />
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td align='center' style='float: left; width:  100%; text-align: center;'>
                        <img src='http://www.suafocalpoint.com/new/static/img/top-email-frase2.jpg' alt='Apresentando uma nova e poderosa ferramenta para corretores de im�veis!' />
                    </td>
                </tr>    
            </table>    
        </td>
    </tr>
</table>
<table style='background-color: #e6f3fc; width: 960px; margin: auto;' cellspacing='0' cellpadding='0' border='0'>
    <tr>
        <td>
            <table width='920' style='height: 525px; margin: 20px auto 30px auto; text-align: justify; border: 1px solid #e1dfdd; background-color: #fff; padding: 0 30px;' cellspacing='0' cellpadding='0' border='0'>
                <tr>
                    <td style='color: #251f45; font-family: Arial; font-size: 17px; line-height: 23px;'>
                        <p style='margin: 30px 0 10px 0;'>Para ajud�-lo a</p>
                        <ul style='margin: 0 0 40px 35px; font-weight: bold; padding: 0;'>
                            <li>Encontrar o im�vel que seu cliente procura de forma f�cil e r�pida.</li>
                            <li>Conseguir mais im�veis exclusivos.</li>  
                            <li>Registrar e compartilhar im�veis com <span style='font-style: italic;'>Parceiros</span> de maneira r�pida e eficiente, usando smartphone, tablet ou computador.</li>
                            <li>Desenvolver uma lista de <span style='font-style: italic;'>Parceiros</span> de confian�a aumentando as op��es dos clientes e as possibilidades de fechar um bom neg�cio.</li>
                            <li>Mostrar im�veis - seus e de <span style='font-style: italic;'>Parceiros</span> - a clientes, com efici�ncia e baixo custo.</li>
                            <li>Mostrar mais organiza��o e profissionalismo.</li>
                            <li>Ser lembrado de quando im�veis alugados voltar�o ao mercado.</li>
                            <li>Lucrar mais.</li>
                        </ul>
                        <p style='margin-bottom: 40px;'>
                            <img align='right' style='margin-left: 20px;' src='http://www.suafocalpoint.com/new/static/img/img1.jpg' alt='Sua Focalpoint' />
                            <span style='font-style: italic;'>&nbsp;&nbsp;&nbsp;Sua Focal Point</span> � uma nova e poderosa ferramenta desenvolvida especificamente para o profissional do 
                            ramo imobili�rio que pode ser utilizada em conjunto com <span style='font-style: italic;'>websites</span>, propagandas, classificados e quaisquer
                            outras formas de divulga��o. Utilizando <span style='font-style: italic;'>Sua Focal Point</span>, voc� mostrar� aos clientes 
                            (compradores, vendedores, locat�rios ou propriet�rios) que disp�e de v�rias ferramentas, 
                            est� atualizado e deseja cuidar de suas necessidades com seguran�a, qualidade e profissionalismo, 
                            no menor tempo poss�vel. Voc� pode demonstrar isso no primeiro encontro com o cliente, 
                            apresentando-lhes o sistema de <span style='font-style: italic;'>Sua Focal Point</span>!
                        </p>
                        <p style='margin-bottom: 40px;'>
                            <img style='margin-right: 20px;' align='left' src='http://www.suafocalpoint.com/new/static/img/img2.jpg' alt='Sua Focalpoint' />
                            <strong style='display: block; margin-bottom: 10px;'>COMO <span style='font-style: italic;'>SUA FOCAL POINT</span> FUNCIONA?</strong>
                            <span style='font-style: italic;'>&nbsp;&nbsp;&nbsp;Sua Focal Point</span> � um sistema online para voc� arquivar infoma��es 
                            sobre im�veis dispon�veis para venda ou aluguel. Voc�, usu�rio de <span style='font-style: italic;'>Sua Focal Point</span>, pode registrar im�veis usando <span style='font-style: italic;'>iPhone</span>, <span style='font-style: italic;'>iPad</span>, qualquer aparelho com plataforma <span style='font-style: italic;'>Android</span> (3.0 ou superior) ou computador. Seus parceiros tamb�m podem ter uma conta em <span style='font-style: italic;'>Sua Focal Point</span>. Ao aceitar outros corretores como <span style='font-style: italic;'>Parceiros</span>, eles poder�o visualizar os seus im�veis, fazer buscas e voc� tamb�m poder� fazer o mesmo. Assim, voc� n�o estar� limitado apenas aos seus im�veis.  <span style='font-style: italic;'>Sua Focal Point</span> enviar� automaticamente o im�vel cadastrado para os <span style='font-style: italic;'>Parceiros</span>, assim todos ficar�o cientes da adi��o ao seu portfolio ou ao deles. Voc� tamb�m poder� enviar por e-mail quaisquer im�veis seus ou de <span style='font-style: italic;'>Parceiros</span> para potenciais  
                            compradores ou inquilinos, mostrando todas as informa��es p�blicas inseridas no cadastro, bem como as fotos, permitindo que os clientes possam ter uma ideia dos im�veis selecionados antes de visit�-los, poupando a voc� e seu cliente, tempo e dinheiro.
                        </p>
                        <p style='margin-bottom: 40px;'>
                            <img align='right' style='margin-left: 20px;' src='http://www.suafocalpoint.com/new/static/img/img3.jpg' alt='Sua Focalpoint' />
                            <strong style='display: block; margin-bottom: 10px;'>TENHA AINDA MAIS CONTROLE SOBRE SEUS NEG�CIOS!</strong>
                            &nbsp;&nbsp;&nbsp;Voc� pode enviar por e-mail v�rios im�veis que atendam as necessidades do cliente e deixar que ele decida quais gostaria de visitar.
                            <br>A maioria dos corretores gasta muito tempo mostrando im�veis que os clientes n�o est�o interessados. <span style='font-style: italic;'>Sua Focal Point</span> elimina esse desperd�cio e chamar� ainda mais aten��o dos clientes para o seu profissionalismo.
                        </p>
                        <p style='margin-bottom: 40px;'>
                            <strong style='display: block; margin-bottom: 10px;'>COMO <span style='font-style: italic;'>SUA FOCAL POINT</span> AJUDAR� A CONSEGUIR MAIS IM�VEIS EXCLUSIVOS?</strong>
                            &nbsp;&nbsp;&nbsp;Tendo parceiros de confian�a, voc� ir� convenc�-los a utilizar <span style='font-style: italic;'>Sua Focal Point</span>. Quando um propriet�rio chamar para fazer uma avalia��o e voc� chegar ao im�vel, a primeira pergunta que deve fazer � quantos outros corretores ele pretende chamar para mostrar esse im�vel. Qualquer que seja a resposta, voc� poder� ent�o apresentar sua lista de <span style='font-style: italic;'>Parceiros</span> em seu <span style='font-style: italic;'>iPad</span>, <span style='font-style: italic;'>iPhone</span> ou <span style='font-style: italic;'>Android</span>, mostrando assim que ele n�o precisa chamar tantos e receber v�rias liga��es ao longo do dia, pois todos da sua rede receber�o um e-mail sobre o im�vel assim que terminar a avalia��o. Seus <span style='font-style: italic;'>Parceiros</span> entrar�o em contato com voc� caso queiram mostrar este im�vel e n�o diretamente com o propriet�rio, garantindo sua exclusividade.  
                        </p>
                        <p style='margin-bottom: 40px;'>
                            <strong style='display: block; margin-bottom: 10px;'><span style='font-style: italic;'>SUA FOCAL POINT</span> IR� AJUD�-LO A LEMBRAR DE IM�VEIS ALUGADOS</strong>
                            &nbsp;&nbsp;&nbsp;Para retirar um im�vel do mercado ap�s ter sido alugado, voc� precisa acess�-lo e, no campo de informa��es privadas, adicionar uma data em que gostaria de ser lembrado. O sistema remover� o im�vel da lista atual e ir� armazen�-lo at� a data informada, quando voc� receber� um e-mail lembrando de entrar em contato com o propriet�rio para checar se o im�vel vai voltar ao mercado. Se a resposta for positiva, voc� precisa somente remover a data e o im�vel voltar� ao arquivo de im�veis dispon�veis. Se n�o estiver dispon�vel, basta inserir uma nova data para ser lembrado novamente.
                        </p>
                        <p style='margin-bottom: 40px;'>
                            <strong style='display: block; margin-bottom: 10px;'>COMO <span style='font-style: italic;'>SUA FOCAL POINT</span> IR� AJUDAR A ENCONTRAR O QUE O CLIENTE EST� PROCURANDO?</strong>
                            <img style='margin-right: 20px;' align='left' src='http://www.suafocalpoint.com/new/static/img/img4.jpg' alt='Sua Focalpoint' />
                            &nbsp;&nbsp;&nbsp;Considerando que voc� tem acesso imediato a todos os im�veis (seus e de seus <span style='font-style: italic;'>Parceiros</span>), usando o recurso de busca, voc� encontrar� im�veis dentro do perfil que seu cliente procura, de maneira f�cil e r�pida. Caso nenhum atenda as necessidades de seu cliente, voc� ainda ter� os im�veis dispon�veis de seus <span style='font-style: italic;'>Parceiros</span>. Se ainda assim, voc� n�o conseguir encontrar um im�vel ideal, usando <span style='font-style: italic;'>Sua Focal Point</span>, voc� pode criar um alerta no sistema e, logo que qualquer um de sua rede cadastrar um im�vel no perfil que o cliente procura, voc� ser� avisado e poder� rapidamente enviar-lhe as informa��es deste novo im�vel.<br>
                            <img style='display: block; margin: 30px 0;' src='http://www.suafocalpoint.com/new/static/img/img5.jpg' alt='Sua Focalpoint' />
                            &nbsp;&nbsp;&nbsp;Agora que voc� conhece esta nova ferramenta e como ela pode ser �til para seus neg�cios, d� o pr�ximo passo e registre-se! Por apenas R$ 50,00 por m�s, comece a cadastrar im�veis e convide seus parceiros. Quanto maior sua rede, maior a possibilidade de fazer bons neg�cios e aumentar seus ganhos. <a style='font-weight: bold; color: #251f45; font-size: 18px; text-decoration: none; font-style: italic;' target='_BLANK' href='".URL."home/inscreva-se/dados-cadastro/".$codigo."'>Clique aqui e inscreva-se!</a>
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table width='960' style='background: url(http://www.suafocalpoint.com/new/static/img/bottom-email.jpg) repeat-x; text-align: justify; height: 105px; margin: 0 auto;' cellspacing='0' cellpadding='0' border='0'>
    <tr>
        <td>
            <p style='float: left; width: 100%; text-align: center; margin: 0;'>
                <a target='_BLANK' style='font-size: 18px; font-family: Arial; color: #251f45; text-decoration: none;' href='http://www.suafocalpoint.com'><img src='http://www.suafocalpoint.com/new/static/img/bottom-email2.jpg' alt='suafocalpoint.com' /></a>
            </p>
            <p style='float: left; width: 100%; margin: 0; text-align: center;'>
                <img src='http://www.suafocalpoint.com/new/static/img/bottom-email1.jpg' alt='RIO DE JANEIRO (21) 2429-1000 S�O PAULO (11) 3819-4366 BRAS�LIA (61) 9829-3019' />
            </p>
        </td>
    </tr>
</table>";

    $enviado = false;
    
    foreach ($_POST["email_convidar"] as $m)
        if($m != "")
            if(email($text, 'Venha Participar da '.SITE, array($m))) 
                $enviado = true;

    if($enviado)
        $msg = 'E-mail enviado com sucesso.';  
        
    include('views/amplie-sua-rede.php');  
}
else{
    include('views/convidar.php');
}