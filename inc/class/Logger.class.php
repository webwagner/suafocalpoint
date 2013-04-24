<?php

/**
 * class Logger
 * Gera um arquivo de erro
 * @date 08/09/2010
 */
class Logger {

    private $tipo;
    private $erro;

    public function __construct($tipo, $erro) {
        $this->setTipo($tipo);
        $this->setErro($erro);
    }

    protected function setErro($erro) {
        $this->erro = $erro;
    }

    protected function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function createLog($file) {

        $text = 'Falhou em ' . date('d/m/Y') . ' às ' . date('H:i') . ' ' . $this->tipo . "\r\n";
        $text .= 'O erro pego foi: ' . $this->erro . "\r\n\r\n";

        $file = fopen(URL_ABSOLUTE . 'logs/' . $file . '.txt', 'a');

        if (!$file)
            echo $text;
        else {
            $fp = fwrite($file, $text);
            fclose($file);
        }

        //envia o erro por email
        $mails = array("webwagner@hotmail.com");
        $subject = "Erro - Site " . SITE;
        //email($text, $subject, $mails);
    }

}