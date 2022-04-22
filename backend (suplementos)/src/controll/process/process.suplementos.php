<?php

	require("../../domain/connection.php");
	require("../../domain/suplementos.php");

	class SuplementosProcess 
	{
		var $sd;

		function doGet($arr)
		{
			$sd = new SuplementosDAO();
			$result;

			if (isset($arr['cont1']) && isset($arr['tipo'])) {
				$result = $sd->listarSuplementos($arr['cont1'], $arr['tipo']);

			}elseif(isset($arr['cont1'])) {
				$result = $sd->listarSuplementos($arr['cont1']);

			} else {
				$result = $sd->listarSuplementos();
				
			}

			//$agora = date("Y-m-d");
			//var_dump($agora);
			http_response_code(200);
			echo json_encode($result);
		}

		function doPost($arr)
		{
			$arrObj = array();
			$sd = new SuplementosDAO();
			$result = $sd->cadastrarSuplementos($arr);
			http_response_code(200);
			echo json_encode($result);
		}

		function doPut($arr)
		{
			$suplemento = new Suplementos(
				isset($arr->idSuplemento),
				isset($arr->idAdministrador),
				$arr->tipo, 
				$arr->nome,
				$arr->preco, 
				$arr->quantidade, 
				$arr->lancamento, 
				$arr->imagem,
				$arr->promocao,
				$arr->data,
				$arr->porcentagem
			);

			$sd = new SuplementosDAO();
			$result = $sd->alterarSuplemento($suplemento, $_GET['id']);
			http_response_code(200);
			echo json_encode($result);
		}

		function doDelete($arr)
		{
			$sd = new SuplementosDAO();
			$result = $sd->deletarSuplemento($arr);
			http_response_code(200);
			echo json_encode($result);
		}
	}