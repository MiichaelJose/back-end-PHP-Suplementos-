<?php

	class Administradores 
	{
		var $idAdministrador;
		var $nome;
		var $senha;
		var $email;
		var $nascimento;
		var $imagem;

		function getIdAdministrador(){
			return $this->idAdministrador;
		}
		function setIdAdministrador($idAdministrador){
			$this->idAdministrador = $idAdministrador;
		}

		function getNome(){
			return $this->nome;
		}
		function setNome($nome){
			$this->nome = $nome;
		}

		function getSenha(){
			return $this->senha;
		}
		function setSenha($senha){
			$this->senha = $senha;
		}

		function getEmail(){
			return $this->email;
		}
		function setEmail($email){
			$this->email = $email;
		}

		function getNascimento(){
			return $this->nascimento;
		}
		function setNascimento($nascimento){
			$this->nascimento = $nascimento;
		}

		function getImagem(){
			return $this->imagem;
		}
		function setImagem($imagem){
			$this->imagem = $imagem;
		}
	}

	class AdministradoresDAO 
	{
		
		function cadastroAdministrador($administrador) 
		{
			$result = array();
			
			try {
				$query = 'INSERT INTO administradores(email, senha, nome, nascimento, imagem) 
						VALUES ("'. implode( '","', $administrador ) .'")';

				$con = Connection::getInstance();

				if($con->exec($query) >= 1){
					$id = $con->lastInsertId();
					$result['id'] 	= 	$id;
				}

				$con = null;
			}catch(PDOException $e) {
				$result["err"] = $e->getMessage();
			}	

			return $result;
		}

		// LOGAR Administrador (POST)
		function logarAdministrador($administrador) 
		{
			
			$result = array();
			
			try {
				$query = "SELECT id_administrador, nome, imagem FROM administradores 
						WHERE email='".$administrador['email']."' && senha=".$administrador['senha'];

				$con = new Connection();

				$resultSet = Connection::getInstance()->query($query);
				
				while($row = $resultSet->fetchObject()){
					$result['nome'] 	= 	$row->nome;
					$result['id'] 		= 	$row->id_administrador;
					$result['imagem'] 	= 	$row->imagem;
				}

				$con = null;
				
			}catch(PDOException $e) {
				$result["err"] = $e->getMessage();
			}
			
			return $result;
			
		}

		function delete($id) 
		{
			$result = array();

			try {
				$query = "DELETE FROM administradores WHERE id_administrador=".$id;

				$con = Connection::getInstance();

				if($con->exec($query) >= 1){
					$result['sucesso'] = "alterado com sucesso";
				}else {
					$result['err'] = "erro na alteração";
				}

				$con = null;
			}catch(PDOException $e) {
				$result["err"] = $e->getMessage();
			}

			return $result;
		}
	}
