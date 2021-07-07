<?php
	include_once('../layout-up.php');
	include_once('../utils.php');
	
	$message  = '';
	$success = isset($_GET['success']);

	if ($success) $message = '¡Cuenta creada exitosamente! Inicia sesión a continuación.';

	if (isset($_POST['email'], $_POST['pwrd'])) {
		$result = httpPost('http://localhost/Ambar/src/ambar/api/sessions.php', [
			"action" => 'login',
			"email" => $_POST['email'],
			"password" => $_POST['pwrd']
		]);

		if ($result) {
			$json = json_decode($result);

			if ($json->result == 0) {
				setcookie("obio_token", $json->token, time() + (10 * 365 * 24 * 60 * 60));
				header('Location: http://localhost/Ambar/src/obio/html/');
			} else {
				$message = $json->message;
				$success = false;
			}
		} else {
			$message = 'Algo ha salido mal...';
			$success = false;
		}
	}
?>

<!-- Section-->
<section class="py-5">
	<div class="container px-4 px-lg-5 mt-5">
		<div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
			<form method="POST">
				<center><img class="mb-4" src="./resources/imgs/obio-logo.png" width="100"/></center>
				<h1 class="h3 mb-3 fw-normal">Iniciar sesi&oacute;n</h1>
				
				<?= ($message == '' ? '' : "<p style=\"color: ". ($success ? '#43de6c' : '#f74a4a') .";\">$message</p>") ?>

				<div class="form-floating">
					<input type="email" class="form-control" id="email" name="email" placeholder="name@example.com"/>
					<label for="email">Email</label>
				</div><br/>

				<div class="form-floating">
					<input type="password" class="form-control" id="pwrd" name="pwrd" placeholder="Password"/>
					<label for="pwrd">Contraseña</label>
				</div><br/>

				<button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button><br/>
			</form>
		</div>
	</div>
</section>

<?php include_once('../layout-down.php'); ?>
