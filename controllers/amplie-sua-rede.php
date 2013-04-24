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
                        <img src='http://www.suafocalpoint.com/new/static/img/top-email-frase2.jpg' alt='Apresentando uma nova e poderosa ferramenta para corretores de imóveis!' />
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
                        <p style='margin: 30px 0 10px 0;'>Para ajudá-lo a</p>
                        <ul style='margin: 0 0 40px 35px; font-weight: bold; padding: 0;'>
                            <li>Encontrar o imóvel que seu cliente procura de forma fácil e rápida.</li>
                            <li>Conseguir mais imóveis exclusivos.</li>  
                            <li>Registrar e compartilhar imóveis com <span style='font-style: italic;'>Parceiros</span> de maneira rápida e eficiente, usando smartphone, tablet ou computador.</li>
                            <li>Desenvolver uma lista de <span style='font-style: italic;'>Parceiros</span> de confiança aumentando as opções dos clientes e as possibilidades de fechar um bom negócio.</li>
                            <li>Mostrar imóveis - seus e de <span style='font-style: italic;'>Parceiros</span> - a clientes, com eficiência e baixo custo.</li>
                            <li>Mostrar mais organização e profissionalismo.</li>
                            <li>Ser lembrado de quando imóveis alugados voltarão ao mercado.</li>
                            <li>Lucrar mais.</li>
                        </ul>
                        <p style='margin-bottom: 40px;'>
                            <img align='right' style='margin-left: 20px;' src='http://www.suafocalpoint.com/new/static/img/img1.jpg' alt='Sua Focalpoint' />
                            <span style='font-style: italic;'>&nbsp;&nbsp;&nbsp;Sua Focal Point</span> é uma nova e poderosa ferramenta desenvolvida especificamente para o profissional do 
                            ramo imobiliário que pode ser utilizada em conjunto com <span style='font-style: italic;'>websites</span>, propagandas, classificados e quaisquer
                            outras formas de divulgação. Utilizando <span style='font-style: italic;'>Sua Focal Point</span>, você mostrará aos clientes 
                            (compradores, vendedores, locatários ou proprietários) que dispõe de várias ferramentas, 
                            está atualizado e deseja cuidar de suas necessidades com segurança, qualidade e profissionalismo, 
                            no menor tempo possível. Você pode demonstrar isso no primeiro encontro com o cliente, 
                            apresentando-lhes o sistema de <span style='font-style: italic;'>Sua Focal Point</span>!
                        </p>
                        <p style='margin-bottom: 40px;'>
                            <img style='margin-right: 20px;' align='left' src='http://www.suafocalpoint.com/new/static/img/img2.jpg' alt='Sua Focalpoint' />
                            <strong style='display: block; margin-bottom: 10px;'>COMO <span style='font-style: italic;'>SUA FOCAL POINT</span> FUNCIONA?</strong>
                            <span style='font-style: italic;'>&nbsp;&nbsp;&nbsp;Sua Focal Point</span> é um sistema online para você arquivar infomações 
                            sobre imóveis disponíveis para venda ou aluguel. Você, usuário de <span style='font-style: italic;'>Sua Focal Point</span>, pode registrar imóveis usando <span style='font-style: italic;'>iPhone</span>, <span style='font-style: italic;'>iPad</span>, qualquer aparelho com plataforma <span style='font-style: italic;'>Android</span> (3.0 ou superior) ou computador. Seus parceiros também podem ter uma conta em <span style='font-style: italic;'>Sua Focal Point</span>. Ao aceitar outros corretores como <span style='font-style: italic;'>Parceiros</span>, eles poderão visualizar os seus imóveis, fazer buscas e você também poderá fazer o mesmo. Assim, você não estará limitado apenas aos seus imóveis.  <span style='font-style: italic;'>Sua Focal Point</span> enviará automaticamente o imóvel cadastrado para os <span style='font-style: italic;'>Parceiros</span>, assim todos ficarão cientes da adição ao seu portfolio ou ao deles. Você também poderá enviar por e-mail quaisquer imóveis seus ou de <span style='font-style: italic;'>Parceiros</span> para potenciais  
                            compradores ou inquilinos, mostrando todas as informações públicas inseridas no cadastro, bem como as fotos, permitindo que os clientes possam ter uma ideia dos imóveis selecionados antes de visitá-los, poupando a você e seu cliente, tempo e dinheiro.
                        </p>
                        <p style='margin-bottom: 40px;'>
                            <img align='right' style='margin-left: 20px;' src='http://www.suafocalpoint.com/new/static/img/img3.jpg' alt='Sua Focalpoint' />
                            <strong style='display: block; margin-bottom: 10px;'>TENHA AINDA MAIS CONTROLE SOBRE SEUS NEGÓCIOS!</strong>
                            &nbsp;&nbsp;&nbsp;Você pode enviar por e-mail vários imóveis que atendam as necessidades do cliente e deixar que ele decida quais gostaria de visitar.
                            <br>A maioria dos corretores gasta muito tempo mostrando imóveis que os clientes não estão interessados. <span style='font-style: italic;'>Sua Focal Point</span> elimina esse desperdício e chamará ainda mais atenção dos clientes para o seu profissionalismo.
                        </p>
                        <p style='margin-bottom: 40px;'>
                            <strong style='display: block; margin-bottom: 10px;'>COMO <span style='font-style: italic;'>SUA FOCAL POINT</span> AJUDARÁ A CONSEGUIR MAIS IMÓVEIS EXCLUSIVOS?</strong>
                            &nbsp;&nbsp;&nbsp;Tendo parceiros de confiança, você irá convencê-los a utilizar <span style='font-style: italic;'>Sua Focal Point</span>. Quando um proprietário chamar para fazer uma avaliação e você chegar ao imóvel, a primeira pergunta que deve fazer é quantos outros corretores ele pretende chamar para mostrar esse imóvel. Qualquer que seja a resposta, você poderá então apresentar sua lista de <span style='font-style: italic;'>Parceiros</span> em seu <span style='font-style: italic;'>iPad</span>, <span style='font-style: italic;'>iPhone</span> ou <span style='font-style: italic;'>Android</span>, mostrando assim que ele não precisa chamar tantos e receber várias ligações ao longo do dia, pois todos da sua rede receberão um e-mail sobre o imóvel assim que terminar a avaliação. Seus <span style='font-style: italic;'>Parceiros</span> entrarão em contato com você caso queiram mostrar este imóvel e não diretamente com o proprietário, garantindo sua exclusividade.  
                        </p>
                        <p style='margin-bottom: 40px;'>
                            <strong style='display: block; margin-bottom: 10px;'><span style='font-style: italic;'>SUA FOCAL POINT</span> IRÁ AJUDÁ-LO A LEMBRAR DE IMÓVEIS ALUGADOS</strong>
                            &nbsp;&nbsp;&nbsp;Para retirar um imóvel do mercado após ter sido alugado, você precisa acessá-lo e, no campo de informações privadas, adicionar uma data em que gostaria de ser lembrado. O sistema removerá o imóvel da lista atual e irá armazená-lo até a data informada, quando você receberá um e-mail lembrando de entrar em contato com o proprietário para checar se o imóvel vai voltar ao mercado. Se a resposta for positiva, você precisa somente remover a data e o imóvel voltará ao arquivo de imóveis disponíveis. Se não estiver disponível, basta inserir uma nova data para ser lembrado novamente.
                        </p>
                        <p style='margin-bottom: 40px;'>
                            <strong style='display: block; margin-bottom: 10px;'>COMO <span style='font-style: italic;'>SUA FOCAL POINT</span> IRÁ AJUDAR A ENCONTRAR O QUE O CLIENTE ESTÁ PROCURANDO?</strong>
                            <img style='margin-right: 20px;' align='left' src='http://www.suafocalpoint.com/new/static/img/img4.jpg' alt='Sua Focalpoint' />
                            &nbsp;&nbsp;&nbsp;Considerando que você tem acesso imediato a todos os imóveis (seus e de seus <span style='font-style: italic;'>Parceiros</span>), usando o recurso de busca, você encontrará imóveis dentro do perfil que seu cliente procura, de maneira fácil e rápida. Caso nenhum atenda as necessidades de seu cliente, você ainda terá os imóveis disponíveis de seus <span style='font-style: italic;'>Parceiros</span>. Se ainda assim, você não conseguir encontrar um imóvel ideal, usando <span style='font-style: italic;'>Sua Focal Point</span>, você pode criar um alerta no sistema e, logo que qualquer um de sua rede cadastrar um imóvel no perfil que o cliente procura, você será avisado e poderá rapidamente enviar-lhe as informações deste novo imóvel.<br>
                            <img style='display: block; margin: 30px 0;' src='http://www.suafocalpoint.com/new/static/img/img5.jpg' alt='Sua Focalpoint' />
                            &nbsp;&nbsp;&nbsp;Agora que você conhece esta nova ferramenta e como ela pode ser útil para seus negócios, dê o próximo passo e registre-se! Por apenas R$ 50,00 por mês, comece a cadastrar imóveis e convide seus parceiros. Quanto maior sua rede, maior a possibilidade de fazer bons negócios e aumentar seus ganhos. <a style='font-weight: bold; color: #251f45; font-size: 18px; text-decoration: none; font-style: italic;' target='_BLANK' href='".URL."home/inscreva-se/dados-cadastro/".$codigo."'>Clique aqui e inscreva-se!</a>
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
                <img src='http://www.suafocalpoint.com/new/static/img/bottom-email1.jpg' alt='RIO DE JANEIRO (21) 2429-1000 SÃO PAULO (11) 3819-4366 BRASÍLIA (61) 9829-3019' />
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