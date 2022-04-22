<?php

	require("../../domain/connection.php");
	require("../../domain/pedidos.php");

	class PedidosProcess 
	{
		var $pd;

		function doGet($arr)
		{
			$pd = new PedidosDAO();
			$result = $pd->listarPedidos($arr["status"]);
			http_response_code(200);
			echo json_encode($result);
		}

		function doPost($arr)
		{
			$pd = new PedidosDAO();
			
			$pedido = new Pedidos(
				isset($arr->idPedido),
				$arr->idSuplemento,
				$arr->idCliente,
				$arr->status,
				$arr->nome,
				$arr->preco,
				$arr->quantidade,
				$arr->imagem
			);

			$result = $pd->criarPedido($pedido);
			http_response_code(200);
			echo json_encode($result);
		}

		function doPut($arr)
		{
			$pd = new PedidosDAO();

			$pedido = new Pedidos(
				isset($arr->idPedido),
				$arr->idSuplemento,
				$arr->idCliente,
				$arr->status,
				$arr->nome,
				$arr->preco,
				$arr->quantidade,
				$arr->imagem
			);

			$result = $pd->alterarPedido($pedido, $_GET["idPedido"]);
			var_dump($_GET["idPedido"]);
			http_response_code(200);
			echo json_encode($result);
		}

		function doDelete($arr)
		{
			$pd = new PedidosDAO();
			$result = $pd->delete($arr);
			http_response_code(200);
			echo json_encode($result);
		}
	}