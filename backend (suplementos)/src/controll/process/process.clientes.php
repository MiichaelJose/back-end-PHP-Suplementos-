<?php

	require("../../domain/connection.php");
	require("../../domain/clientes.php");

	class ClientesProcess 
	{
		var $cd;

		function doGet($arr)
		{
			$cd = new ClientesDAO();
			$result = $cd->listarCliente($arr['id']);
			http_response_code(200);
			echo json_encode($result);
		}

		function doPost($arr)
		{
			$cliente = new Clientes();
			$cd = new ClientesDAO();
			$result = "";
			
			$cliente->setSenha($arr->senha);
			$cliente->setEmail($arr->email);

			if(isset($arr->nome)) {	
				$cliente->setNome($arr->nome);
				$result = $cd->cadastroCliente($cliente);
				http_response_code(201);
			}else {
				$result = $cd->logarCliente($cliente);
				http_response_code(200);
			}
		
				//tratamento de erro//
			//login 
			if(isset($result['status'])) http_response_code(401);

			//cadastro
			if(isset($result['err']) && str_contains($result['err'], "Duplicate")) {
				$result['err'] = "email já cadastrado"; 
				http_response_code(400);
			}

			echo json_encode($result);
		}

		function doPut($arr)
		{
			$cliente = new Clientes();
			$cd = new ClientesDAO();
			$result = "";

			if(property_exists($arr, 'imagem') || property_exists($arr, 'nascimento')) {
				// alterar imagem ou (endereco e nascimento) 2 cadastro;
				if(property_exists($arr, 'imagem')) {
					$cliente->setImagem($arr->imagem);
				}else {
					$cliente->setEndereco($arr->endereco);
					$cliente->setNascimento($arr->nascimento);
				}
				$result = $cd->alterarCadastro($cliente, $_GET['id']);
			}else {
				// alterar senha
				$cliente->setSenha($arr->senhaNova. "," .$arr->senhaAntiga);
				$result = $cd->alterarSenha($cliente, $_GET['id']);
			}
			http_response_code(200);
			echo json_encode($result);
		}
	}