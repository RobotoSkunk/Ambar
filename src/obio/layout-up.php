<?php
	include_once(__DIR__. '/utils.php');

	$session_active = false;

	if (isset($_COOKIE['obio_token'])) {
		$result = httpPost('http://localhost/Ambar/src/ambar/api/sessions.php', [
			"action" => 'remember-me',
			"token" => $_COOKIE['obio_token']
		]);

		if ($result && $result !== NULL) {
			$json = json_decode($result);

			if ($json->result == 0) {
				$session_active = true;
			}
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<meta name="description" content="" />
		<meta name="author" content="" />
		<title>Obio</title>
		<!-- Favicon-->
		<link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
		<!-- Bootstrap icons-->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" type="text/css" href="./resources/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="./resources/bootstrap/css/obio.css">
		<link rel="stylesheet" type="text/css" href="./resources/bootstrap/css/sidebar.css">
	</head>
	<body>
		<!-- Header-->
		<header class="py-5" style = "background-color: #fcaf1a;">
			<div class="container px-4 px-lg-5 my-5">
				<div class="text-center">
					<img src="./resources/imgs/obio-logo.png" class="rounded" alt="...">
				</div>
			</div>
		</header>
		<!-- Navigation-->
		<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
			<div class="container px-4 px-lg-5">
				<a class="navbar-brand" href="#!">Obio</a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
						<li class="nav-item"><a class="nav-link active" aria-current="page" href="#!">Compras</a></li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Mi perfil</a>
							<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
								<li><a class="dropdown-item" href="#!">Direccion</a></li>
								<li><hr class="dropdown-divider" /></li>
								<li><a class="dropdown-item" href="#!">Tarjetas</a></li>
								<li><a class="dropdown-item" href="#!">Correo</a></li>
							</ul>
						</li>
						<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
						<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
					</ul>
					<form class="d-flex">
						<button class="btn btn-outline-dark" type="submit">
							<i class="bi-cart-fill me-1"></i>
							Cart
							<span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
						</button>
					</form>
				</div>
			</div>
		</nav>
