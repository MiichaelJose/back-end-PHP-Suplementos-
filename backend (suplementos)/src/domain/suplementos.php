<?php

	class Suplementos 
	{
		var $idSuplemento;
		var $idAdministrador;
		var $tipo;
		var $preco;
		var $nome;
		var $quantidade;
		var $lancamento;
		var $imagem;

		var $promocao;
		var $data;
		var $porcentagem;

		function __construct($idSuplemento, $idAdministrador, $tipo, $nome, $preco, $quantidade, $lancamento, $imagem, $promocao, $data, $porcentagem) {
			$this->idSuplemento		= $idSuplemento;
			$this->idAdministrador 	= $idAdministrador;
			$this->tipo 			= $tipo;
			$this->preco 			= $preco;
			$this->nome 			= $nome;
			$this->quantidade 		= $quantidade;
			$this->lancamento 		= $lancamento;
			$this->imagem 			= $imagem;
			$this->promocao 		= $promocao;
			$this->data 			= $data;
			$this->porcentagem 		= $porcentagem;
		}


		function getPromocao(){
			return $this->promocao;
		}
		function setPromocao($promocao){
			$this->promocao = $promocao;
		}

		function getPorcentagem(){
			return $this->porcentagem;
		}
		function setPorcentagem($porcentagem){
			$this->porcentagem = $porcentagem;
		}

		function getData(){
			return $this->data;
		}
		function setData($data){
			$this->data = $data;
		}

		function getIdSuplemento(){
			return $this->idSuplemento;
		}
		function setIdSuplemento($idSuplemento){
			$this->idSuplemento = $idSuplemento;
		}

		function getIdAdministrador(){
			return $this->idAdministrador;
		}
		function setIdAdministrador($idAdministrador){
			$this->idAdministrador = $idAdministrador;
		}

		function getTipo(){
			return $this->tipo;
		}
		function setTipo($tipo){
			$this->tipo = $tipo;
		}

		function getPreco(){
			return $this->preco;
		}
		function setPreco($preco){
			$this->preco = $preco;
		}

		function getNome(){
			return $this->nome;
		}
		function setNome($nome){
			$this->nome = $nome;
		}

		function getQuantidade(){
			return $this->quantidade;
		}
		function setQuantidade($quantidade){
			$this->quantidade = $quantidade;
		}

		function getLancamento(){
			return $this->lancamento;
		}
		function setLancamento($lancamento){
			$this->lancamento = $lancamento;
		}

		function getImagem(){
			return $this->imagem;
		}
		function setImagem($imagem){
			$this->imagem = $imagem;
		}
	}

	class SuplementosDAO 
	{
	
		function cadastrarSuplementos($suplementos) 
		{
			$result = array();

			try {

				$con = Connection::getInstance();

				foreach($suplementos as $objeto) {
					$query = "INSERT INTO suplementos(id_administrador, tipo, nome, preco, lancamento, quantidade, imagem) 
						VALUES ('". implode( "','", (array) $objeto) ."');";
				
					if($con->exec($query) >= 1) 
						$result['id']	=	intval($con->lastInsertId());
					
				}

				$con = null;
			}catch(PDOException $e) {
				$result["err"] = $e->getMessage();
			}

			return $result;
		}

		function listarAllSuplementos($tipo) 
		{
			$contador = 0;

			try {
				
				$con = new Connection();

				// limit (vai sempre começar com apenas 30 cards)
				$query = "SELECT * FROM suplementos";

				if($tipo != null) {
					if($tipo == 'true') {
						$query = "SELECT * FROM suplementos WHERE promocao = 1";
					}else {
						$query = "SELECT * FROM suplementos WHERE tipo = '$tipo'"; 
					}
				}

				$resultSet = Connection::getInstance()->query($query);

				$arr = $resultSet->fetchAll();

				$contador = count($arr);

				$con = null;
			}catch(PDOException $e) {
				$result["err"] = $e->getMessage();
			}

			return $contador;
		}

		function listarSuplementos($cont1 = 0, $tipo = null) 
		{
			$sd = new SuplementosDAO();
			$result = array();
			$cont2 = 30;
			$botao = 0;

			try {
				$con = new Connection();
				
				// limit (vai sempre começar com apenas 30 cards)
				$query = "SELECT * FROM suplementos LIMIT $cont1, $cont2";
				
				if ($tipo != null) {
					if($tipo == 'true') {
						$query = "SELECT * FROM suplementos  WHERE promocao = 1 LIMIT $cont1, $cont2";
					}else {
						$query = "SELECT * FROM suplementos  WHERE tipo = '$tipo' LIMIT $cont1, $cont2";
					}
				}
				
				$resultSet = Connection::getInstance()->query($query);

				$arr = array();

				while($row = $resultSet->fetchObject()) {

					$objeto = new Suplementos(
						$row->id_suplemento,
						$row->id_administrador,
						$row->tipo,
						$row->nome,
						$row->preco,
						$row->quantidade,
						$row->lancamento,	
						$row->imagem,
						$row->promocao,
						$row->data,
						$row->porcentagem,
					);
					
					if($row->promocao) {
						
						if(date("Y-m-d") === $row->data) {
							var_dump("entrou");
							$objeto->setData(null);
							$objeto->setPorcentagem(null);
							$sd->alterarSuplementoPromocao($objeto, $objeto->getIdSuplemento());
						}else {
							$resto = $objeto->getPreco() * ($objeto->getPorcentagem() / 100);
							$objeto->setPreco($resto + $objeto->getPreco());

							array_push($arr, $objeto); 
						}
					}else {
						array_push($arr, $objeto); 
					}
					
				}

				$botao = $sd->listarAllSuplementos($tipo);
				
				$result['numero'] = ceil($botao / 30);
				$result['arr'] = $arr;
				
				$con = null;
			}catch(PDOException $e) {
				$result["err"] = $e->getMessage();
			}

			return $result;
		}

		function alterarSuplemento($suplemento, $id) 
		{
			$result = array();

			try {
				$query = "UPDATE suplementos 
				SET tipo=:tipo, nome=:nome, preco=:preco, quantidade=:quantidade, lancamento=:lancamento, imagem=:imagem, 
				promocao=:promocao, data=:data, porcentagem=:porcentagem
				WHERE id_suplemento = $id";

				$con = new Connection();

				$status = Connection::getInstance()->prepare($query);
					
				$status->bindValue(':tipo', $suplemento->getTipo());
				$status->bindValue(':nome', $suplemento->getNome());
				$status->bindValue(':preco', $suplemento->getPreco());
				$status->bindValue(':quantidade', $suplemento->getQuantidade());
				$status->bindValue(':lancamento', $suplemento->getLancamento());
				$status->bindValue(':imagem', $suplemento->getImagem());
				$status->bindValue(':promocao', $suplemento->getPromocao());
				$status->bindValue(':data', $suplemento->getData());
				$status->bindValue(':porcentagem', $suplemento->getPorcentagem());

				if($status->execute()){
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

		function alterarSuplementoPromocao($suplemento, $id) 
		{
			$result = array();

			try {
				
				$query = "UPDATE suplementos 
				SET promocao=:promocao, data=:data, porcentagem=:porcentagem 
				WHERE id_suplemento = $id";

				$con = new Connection();

				$status = Connection::getInstance()->prepare($query);
					
				$status->bindValue(':promocao', null);
				$status->bindValue(':data', $suplemento->getData());
				$status->bindValue(':porcentagem', $suplemento->getPorcentagem());

				if($status->execute()){
					$result['sucesso'] = "alterado com sucesso";
				}else {
					$result['err'] = "erro na alteração";
				}

				$con = null;
				
			}catch(PDOException $e) {
				$result["err"] = $e->getMessage();
			}
		}

		function deletarSuplemento($id) 
		{
			$result = array();
		
			try {
				$query = "DELETE FROM suplementos WHERE id_suplemento=$id";

				$con = Connection::getInstance();

				if($con->exec($query) >= 1){
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
