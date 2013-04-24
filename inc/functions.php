<?php
/**
 * Verfica o se existe valor 
 * @param string $campo
 * @return string
 */
function getGet( $campo ){
    return isset($_GET[$campo]) ? filter( $_GET[$campo] ) : '';
}

/**
 * Verfica o se existe valor 
 * @param string $campo
 * @return string
 */
function getPost( $campo ){
    return isset($_POST[$campo]) ? filter( $_POST[$campo] ) : '';
}

/**
 * Evita SQL Injection
 * @param string $var
 * @return $str string
 */
function filter( $var ){
    if( !get_magic_quotes_gpc() )
        $str = addslashes( $var );
    else
        $str = $var;
    $str = str_replace( '#', '\#', $str );
    return $str;
}

/**
 * Gera Senha Aleatória
 * @param int $n
 * @return $str string
 */
function gerarsenha($n){
    $str = "ABCDEFGHIJLMNOPQRSTUVXZYWKabcdefghijlmnopqrstuvxzywk0123456789";
    $cod = "";
    for($a = 0;$a < $n;$a++){
        $rand = rand(0,63);
        $cod .= substr($str,$rand,1);
    }
    return $cod;
}

/**
 * Faz o upload da imagem
 * @param string $campo|$destino
 * @return string $nome
 */
function upload($campo,$destino,$redimensionar = false,$largura = ""){
    $arquivo = $_FILES[$campo];
    $nome_arquivo = $arquivo['name'];
    $tmpname_arquivo = $arquivo['tmp_name'];

    //renomear a imagem
    $ext = strtolower(substr($nome_arquivo, -4));

    if($ext == 'jpeg')
        $ext = '.jpg';

    $sort = rand(00,99999999);
    $nome = $sort.$ext;
    
    $caminho = $destino . $nome;
    
    if($redimensionar){

        $isTrueColor = false;
        
        if ($ext == ".jpg")
            $img = imagecreatefromjpeg($tmpname_arquivo);
        elseif ($ext == ".gif")
            $img = imagecreatefromgif($tmpname_arquivo);
        elseif ($ext == ".png"){
            $img = imagecreatefrompng($tmpname_arquivo);
            $isTrueColor = imageistruecolor($img);
        }

        $x = imagesx($img);
        $y = imagesy($img);
        $altura = ($largura * $y)/$x;

        $nova = imagecreatetruecolor($largura, $altura);
        
         if(isset($isTrueColor)){
             imagealphablending($nova, false);
             imagesavealpha($nova  , true );
         }
        
        imagecopyresampled($nova, $img, 0, 0, 0, 0, $largura, $altura, $x, $y); 
        
        if ($ext == ".jpg")
            imagejpeg($nova, $caminho);
        elseif ($ext == ".gif")
            imagegif($nova, $caminho);
        elseif ($ext == ".png")
            imagepng($nova, $caminho);

        imagedestroy($img);
        imagedestroy($nova);	
        
        return $nome;
    }
    else{
        if(move_uploaded_file($tmpname_arquivo, $caminho)){
            @rename($tmpname_arquivo,$nome);
            return $nome;
        }
        else{
            $log = new Logger( 'Upload de Imagem', 'Erro ao fazer o upload da imagem '.$nome );
            $log->createLog('log');
        }
    }
    
}

/**
 * Marca um campo radio com checked
 * @param string $var|$var2
 * @return string $ret
 */
function checked( $var, $var2 ){
    if($var2 == "")
        $var2 = 'SIM';
    if($var2 == $var)
        $ret = "checked = checked";
    else
        $ret = "";
    return $ret;
}

/**
 * Retira os espaços e acentos 
 * @param string $str
 * @return string $ret
 */
function getUrl($str){
    $val = strtolower(str_replace(" ", "-", $str));
    $array1 = array("á", "à", "â", "ã", "ä", "ã", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç", "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç", "?", "/", "%", "'" );	
    $array2 = array("a", "a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c", "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C", "-", "-", "-", "" );
    return str_replace($array1, $array2, $val); 
}

/**
 * Cria diretorio
 * @param string $dir
 * @return bool
 */
function cria_dir($dir){
    
    if (mkdir($dir)){
        return true;
    }
    else{
        $log = new Logger( 'DIRETORIO', 'Não criou o diretorio '.$dir );
        $log->createLog('log');
        return false;
    }

}

/**
 * Pega a url
 * @param int $num
 * @return int
 */
function url( $num = 1 ){  
    $uri = $_SERVER['REQUEST_URI'];
    $url = explode("/", $uri);
    unset($url[0]);
    if($_SERVER['SERVER_NAME'] == 'localhost' || $url[1] == 'new')
        $num = $num + 1;
    if($num > count($url))
        $num = count($url);
    return $url[$num];

}

/**
 * Envia email
 * @param string $body|$subject|$mails|$redirect
 * @return string
 */
function email($body, $subject, $mails, $redirect = "", $bcc = ""){
    
    if (!class_exists("PHPMailer"))
        include(URL_ABSOLUTE.'library/phpmailer/class.phpmailer.php');
    
    $mail = new PHPMailer(true);  
    
    try{
        $mail->IsSMTP(); // Define que a mensagem será SMTP
        $mail->Host = HOST; // Endereço do servidor SMTP
        $mail->From = EMAIL; // Seu e-mail
        $mail->FromName = SITE;
        $mail->Sender = EMAIL; // Seu e-mail
        
        foreach($mails as $email){
            if($bcc != "")
                $mail->AddBCC($email);
            else
                $mail->AddAddress($email);
        }
        
        $assinatura = "<br>Sua Focal Point: Rede de Ferramentas para Corretores - <a href='http://www.suafocalpoint.com/new'>http://www.suafocalpoint.com</a>";
       
        $body = $body.$assinatura;
        
        $mail->IsHTML(true);
        $mail->Subject  = $subject;
        $mail->Body = $body;
        $enviado = $mail->Send();
        $mail->ClearAllRecipients();
        $mail->ClearAttachments();
        
        if($redirect != "")
            echo "<script>window.location.href = '".URL.$redirect."';</script>";  
        
        return true;
    }
    catch (phpmailerException $e) {
        $log = new Logger( 'E-MAIL', 'Erro ao enviar email: '.$e->errorMessage() );
        $log->createLog('log'); 
        echo "<font color='red'>Ocorreu um erro ao enviar email. Entre em contato com o administrador.</font><br />";
        return false;
    }
}

/**
 * Retorna a imagem renderizada
 * @param string|int|int|string|string|string $img|$w|$h|$alt|$marcadagua|$pos_marcadagua   
 * @return string
 */
function ImgRender( $img, $w, $h, $alt = ''){

     if(is_file($img))
        $tam_img = getimagesize($img);
     else
         return false;
     
     if($tam_img[1] > $tam_img[0])
        return '<div class="box-img-phpthumb" style="overflow:hidden; width:'.$w.'px; height:'.$h.'px;"><img src="'.URL.'library/phpthumb/phpThumb.php?src='.$img.'&w='.$w.'" alt="'.$alt.'" /></div>';
     else
        return '<div class="box-img-phpthumb" style="overflow:hidden; width:'.$w.'px; height:'.$h.'px;"><img src="'.URL.'library/phpthumb/phpThumb.php?src='.$img.'&h='.$h.'" alt="'.$alt.'" /></div>';  
}

/**
 * Retorna um texto abreviado caso for maior que $tam
 * @param string|int $txt|$tam
 * @return string $txt
 */
function txtReduce($txt , $tam){
    if(strlen($txt) > $tam)
        return substr($txt, 0, $tam).'...';
    else
        return $txt;
}

/**
 * Retorna a data formatada
 * @param string $data
 * @return string $txt
 */
function converteData($data){
    $dt = explode(' ',$data);
    $data = $dt[0];
    $d = explode ("-", $data);
    $rstData = $d[2]."/".$d[1]."/".$d[0];
    return $rstData;
}

/**
 * Retorna o valor formatado para o mysql
 * @param string $valor
 * @return string $ret
 */
function convertPreco($valor){
    $valor = str_replace('.', '', $valor);
    $ret = str_replace(',', '.', $valor);
    return $ret;
}

function Redimensionar($imagem, $largura, $pasta){
		
    $name = md5(uniqid(rand(),true));

    if ($imagem['type']=="image/jpeg"){
            $img = imagecreatefromjpeg($imagem['tmp_name']);
    }
    else if ($imagem['type']=="image/gif"){
            $img = imagecreatefromgif($imagem['tmp_name']);
    }
    else if ($imagem['type']=="image/png"){
            $img = imagecreatefrompng($imagem['tmp_name']);
    }
    
    $x   = imagesx($img);
    $y   = imagesy($img);
    $autura = ($largura * $y)/$x;

    $nova = imagecreatetruecolor($largura, $autura);
    imagecopyresampled($nova, $img, 0, 0, 0, 0, $largura, $autura, $x, $y);

    if ($imagem['type']=="image/jpeg"){
            $local="$pasta/$name".".jpg";
            imagejpeg($nova, $local);
    }else if ($imagem['type']=="image/gif"){
            $local="$pasta/$name".".gif";
            imagejpeg($nova, $local);
    }else if ($imagem['type']=="image/png"){
            $local="$pasta/$name".".png";
            imagejpeg($nova, $local);
    }		

    imagedestroy($img);
    imagedestroy($nova);	

    return $local;
}
