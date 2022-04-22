<?php

	require("../../domain/connection.php");
	require("../../domain/administradores.php");

	class AdministradoresProcess 
	{
		var $ad;

		/*
		function doGet($arr)
		{
			$ad = new AdministradoresDAO();
			$result = "use to result to DAO";
			http_response_code(200);
			echo json_encode($result);
		}
		*/

		function doPost($arr)
		{	
			$arrObject = array();
			$administrador = new Administradores();
			$ad = new AdministradoresDAO();
			$result = "";

			$administrador->setEmail($arr->email);
			$administrador->setSenha($arr->senha);
			$arrObject['email'] = $arr->email;
			$arrObject['senha'] = $arr->senha;

			if(isset($arr->nome)) {	
				$administrador->setNome($arr->nome);
				$administrador->setNascimento($arr->nascimento);
				$administrador->setImagem($arr->imagem);

				$arrObject['nome'] 			= $arr->nome;
				$arrObject['nascimento'] 	= $arr->nascimento;
				$arrObject['imagem'] 		= $arr->imagem;
				
				$result = $ad->cadastroAdministrador($arrObject);
				http_response_code(201);
			}else {
				$result = $ad->logarAdministrador($arrObject);
				http_response_code(200);
			}

			//cadatro
			if(isset($result['err']) && str_contains($result['err'], "Duplicate")) {
				$result['err'] = "email já cadastrado"; 
				http_response_code(400);
			}

			echo json_encode($result);
		}

		function doDelete($arr)
		{
			$ad = new AdministradoresDAO();
			$result = $ad->delete($_GET['id']);
			http_response_code(200);
			echo json_encode($result);
		}
	}