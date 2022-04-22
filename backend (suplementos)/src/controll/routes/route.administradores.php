<?php

	require("../process/process.administradores.php");

	include("configs.php");

	$ap = new AdministradoresProcess();

	switch($_SERVER['REQUEST_METHOD']) {
		case "GET":
			$ap->doGet($_GET);
			break;

		case "POST":
			$ap->doPost($_POST);
			break;

		case "PUT":
			$ap->doPut($_PUT);
			break;

		case "DELETE":
			$ap->doDelete($_DELETE);
			break;
	}