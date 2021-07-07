<?php
	include_once('../layout-up.php');
	include_once('../utils.php');
	
	$message  = '';

	
	// case 'signup':
	// 	if (isset($_POST['u_name'], $_POST['u_lastname'], $_POST['email'], $_POST['pwrd'], $_POST['direction'], $_POST['cp'], $_POST['telephone'], $_POST['birthdate'])) {

	if (isset($_POST['u_name'], $_POST['u_lastname'], $_POST['email'], $_POST['pwrd'], $_POST['direction'], $_POST['cp'], $_POST['telephone'], $_POST['birthdate'])) {
		$result = httpPost('http://localhost/Ambar/src/ambar/api/sessions.php', [
			"action" => 'signup',
			"u_name" => $_POST['u_name'],
			"u_lastname" => $_POST['u_lastname'],
			"email" => $_POST['email'],
			"pwrd" => $_POST['pwrd'],
			"direction" => $_POST['direction'],
			"cp" => $_POST['cp'],
			"telephone" => $_POST['telephone'],
			"birthdate" => $_POST['birthdate']
		]);

		if ($result) {
			$json = json_decode($result);

			if ($json->result == 0) {
				header('Location: http://localhost/Ambar/src/obio/html/login.php?success=true');
			} else {
				$message = $json->message;
			}
		} else {
			$message = 'Algo ha salido mal...';
		}
	}
?>

<!-- Section-->
<section class="py-5">
	<div class="container px-4 px-lg-5 mt-5">
		<div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
			<form method="POST">
				<center><img class="mb-4" src="./resources/imgs/obio-logo.png" width="100"/></center>
				<h1 class="h3 mb-3 fw-normal">Registrarse</h1>

				<?= ($message == '' ? '' : "<p style=\"color: #f74a4a;\">$message</p>") ?>

				<div class="form-floating">
					<input type="text" class="form-control" id="u_name" name="u_name" placeholder="Luis Gustavo"/>
					<label for="u_name">Nombre de usuario</label>
				</div><br/>

				<div class="form-floating">
					<input type="text" class="form-control" id="u_lastname" name="u_lastname" placeholder="López Hernández"/>
					<label for="u_lastname">Apellidos</label>
				</div><br/>

				<div class="form-floating">
					<input type="email" class="form-control" id="email" name="email" placeholder="name@example.com"/>
					<label for="email">Email</label>
				</div><br/>

				<div class="form-floating">
					<input type="password" class="form-control" id="pwrd" name="pwrd" placeholder="MySecurePassword"/>
					<label for="pwrd">Contraseña</label>
				</div><br/>

				<div class="form-floating">
					<input type="text" class="form-control" id="direction" name="direction" placeholder="Calle Cobos Rodriguez #123"/>
					<label for="direction">Dirección</label>
				</div><br/>

				<div class="form-floating">
					<input type="text" class="form-control" id="cp" name="cp" placeholder="123456"/>
					<label for="cp">Código postal</label>
				</div><br/>

				<div class="form-floating">
					<input type="text" class="form-control" id="telephone" name="telephone" placeholder="782 001 0101"/>
					<label for="telephone">Teléfono</label>
				</div><br/>

				<div class="form-floating">
					<input type="date" class="form-control" id="birthdate" name="birthdate" placeholder="2021-10-3"/>
					<label for="birthdate">Fecha de nacimiento</label>
				</div><br/>

				<button class="w-100 btn btn-lg btn-primary" type="submit">Registrarse</button><br/>
			</form>
		</div>
	</div>
</section>

<?php include_once('../layout-down.php'); ?>
