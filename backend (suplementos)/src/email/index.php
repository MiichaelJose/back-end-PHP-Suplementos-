<?php
/*
$para = "michaeljosecraft@hotmail.com";

$assunto = 'Praticando SendEmail';

$mensagem = '
<html>
<head>
  <title>Enviando Email</title>
</head>
<body>
  
    <p>oi</p>
  
</body>
</html>
';

$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: text/html; charset=UTF-8';

mail($para, $assunto, $mensagem, implode("\r\n", $headers));
*/

	class Email
    {
        var $para;
        var $assunto;
        var $mensagem;
        var $headers;

        function getPara(){
			return $this->nome;
		}
		function setPara($para){
			$this->para = $para;
		}

        function getAssunto(){
			return $this->assunto;
		}
		function setAssunto($assunto){
			$this->assunto = $assunto;
		}

        function getMensagem(){
			return $this->mensagem;
		}
		function setMensagem($mensagem){
			$this->mensagem = $mensagem;
		}
    }