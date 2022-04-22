<?php

	class Pedidos 
	{
		var $idPedido;
		var $idCliente;
		var $idSuplemento;
		var $nome;
		var $imagem;
		var $preco;
		var $quantidade;
		var $status;

		function __construct($idPedido, $idSuplemento, $idCliente, $status, $nome, $preco, $quantidade, $imagem) {
			$this->idPedido	= $idPedido;
			$this->idSuplemento	= $idSuplemento;
			$this->idCliente 	= $idCliente;
			$this->status 		= $status;
			$this->preco 		= $preco;
			$this->nome 		= $nome;
			$this->quantidade 	= $quantidade;
			$this->imagem 		= $imagem;
		}

		function getIdPedido(){
			return $this->idPedido;
		}
		function setIdPedido($idPedido){
			$this->idPedido = $idPedido;
		}

		function getIdCliente(){
			return $this->idCliente;
		}
		function setIdCliente($idCliente){
			$this->idCliente = $idCliente;
		}

		function getIdSuplemento(){
			return $this->idSuplemento;
		}
		function setIdSuplemento($idSuplemento){
			$this->idSuplemento = $idSuplemento;
		}

		function getNome(){
			return $this->nome;
		}
		function setNome($nome){
			$this->nome = $nome;
		}

		function getImagem(){
			return $this->imagem;
		}
		function setImagem($imagem){
			$this->imagem = $imagem;
		}

		function getPreco(){
			return $this->preco;
		}
		function setPreco($preco){
			$this->preco = $preco;
		}

		function getQuantidade(){
			return $this->quantidade;
		}
		function setQuantidade($quantidade){
			$this->quantidade = $quantidade;
		}

		function getStatus(){
			return $this->status;
		}
		function setStatus($status){
			$this->status = $status;
		}
	}

	class PedidosDAO 
	{
		function criarPedido($pedido) 
		{
			$result = array();

			try {
				$query = "INSERT INTO pedidos 
				VALUES (DEFAULT, $pedido->idSuplemento, $pedido->idCliente, 
						'$pedido->status', '$pedido->nome', $pedido->preco, 
						$pedido->quantidade, '$pedido->imagem');";
					
				$con = Connection::getInstance();
				
				if($con->exec($query) >= 1)
					$result['id']	=	intval($con->lastInsertId());
				
				$con = null;
			}catch(PDOException $e) {
				$result["err"] = $e->getMessage();
			}

			return $result;
		}

		function listarPedidos($status) 
		{
			$result = array();
			
			try {
				$query = "SELECT * FROM pedidos WHERE status ='$status'";

				$con = new Connection();

				$resultSet = Connection::getInstance()->query($query);
				
				while($row = $resultSet->fetchObject()) {
					
					$objeto = new Pedidos(
						$row->id_pedido,
						$row->id_suplemento,
						$row->id_cliente,
						$row->status,
						$row->nome,
						$row->preco,
						$row->quantidade,
						$row->imagem
					);
					
					array_push($result, $objeto);
				}

				$con = null;
			}catch(PDOException $e) {
				$result["err"] = $e->getMessage();
			}

			return $result;
		}

		function alterarPedido($pedido, $id) 
		{
			$result = array();

			try {
				$query = "UPDATE pedidos SET status=:status, imagem=:imagem, nome=:nome, preco=:preco, quantidade=:quantidade
				WHERE id_pedido = $id;";

				$con = new Connection();
				
				$state = Connection::getInstance()->prepare($query);
					
				$state->bindValue(':status', $pedido->getStatus());
				$state->bindValue(':imagem', $pedido->getImagem());
				$state->bindValue(':nome', $pedido->getNome());
				$state->bindValue(':preco', $pedido->getPreco());
				$state->bindValue(':quantidade', $pedido->getQuantidade());

				if($state->execute()){
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

		function delete($id) 
		{
			$result = array();

			try {
				$query = "DELETE FROM pedidos WHERE id_pedido=$id";

				$con = new Connection();

				if(Connection::getInstance()->exec($query) >= 1){
					$result['sucesso'] = "removido com sucesso";
				}else {
					$result['err'] = "erro na remoção";
				}

				$con = null;
			}catch(PDOException $e) {
				$result["err"] = $e->getMessage();
			}

			return $result;
		}
	}
