<?php 

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