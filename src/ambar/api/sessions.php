<?php
$data = [
	'result' => -1,
	'message' => "No data"
];

if (isset($_POST['action'])) {
	try {
		require_once('../database.php');
		require_once('../oauth-lib.php');

		switch ($_POST['action']) {
			case 'remember-me':
				if (isset($_POST['token'])) {
					$token = VerifyToken($_POST['token']);
					if ($token) {
						$data['result'] = 0;
						$data['message'] = "Sesión verificada.";
					} else {
						$data['message'] = "Sesión inválida.";
					}
				} else {
					$data['message'] = "Token missing.";
				}
				break;
			case 'end-session':
				if (isset($_POST['token'])) {
					$token = VerifyToken($_POST['token']);
					if ($token) {
						$stmt = $conn->prepare('DELETE FROM tokens WHERE id = ?;');
						$stmt->bind_param('i', $token['id']);
						$stmt->execute();
						$stmt->store_result();
						if ($stmt->affected_rows > 0) {
							$data['result'] = 0;
							$data['message'] = "Se cerró la sesión.";
						}
						$stmt->close();
					}
				} else {
					$data['message'] = "Token missing.";
				}
				break;
			case 'login':
				if (isset($_POST['email'], $_POST['password'])) {
					$data['message'] = "Email y/o contraseña incorrectos.";

					$uid = 0; $hash = '';
					$stmt = $conn->prepare('SELECT id, pwrd FROM users WHERE email = lower(?) LIMIT 1;');
					$stmt->bind_param('s', $_POST['email']);
					$stmt->execute();
					$stmt->store_result();
					if ($stmt->num_rows() === 1) {
						$stmt->bind_result($uid, $hash);
						$stmt->fetch();
						
						if (password_verify($_POST['password'], $hash)) {
							$token = TokenGenerate($uid);
							list($selector, $validator) = explode('/', $token);

							$validatorHash = hash("sha3-256", $validator);
							$date = date('Y-m-d H:i:s');

							$stmt1 = $conn->prepare('INSERT INTO tokens (uuid, selector, token, created_at, last_usage) VALUES (?, ?, ?, ?, ?);');
							$stmt1->bind_param('issss', $uid, $selector, $validatorHash, $date, $date);
							$stmt1->execute();
							$stmt1->store_result();
							if ($stmt1->affected_rows > 0) {
								$data['result'] = 0;
								$data['message'] = "Inicio de sesión con éxito.";
								$data['token'] = $token;
							} else {
								$data['message'] = "Ha sucedido un error.";
							}
							$stmt1->close();
						}
					}
					$stmt->close();
				} else {
					$data['message'] = "Data missing.";
				}
				break;
			case 'signup':
				if (isset($_POST['u_name'], $_POST['u_lastname'], $_POST['email'], $_POST['pwrd'], $_POST['direction'], $_POST['cp'], $_POST['telephone'], $_POST['birthdate'])) {
					$future = strtotime('+18 years', strtotime($_POST['birthdate']));

					$dangthatsalongregex = "/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/";

					if (time() < $future) {
						$data['message'] = "No eres mayor de 18 años.";
					} if (!preg_match($dangthatsalongregex, $_POST['email'])) {
						$data['message'] = "El email es inválido.";
					} else {
						$stmt = $conn->prepare('SELECT * FROM users WHERE email = lower(?);');
						$stmt->bind_param('s', $_POST['email']);
						$stmt->execute();
						$stmt->store_result();
						if ($stmt->num_rows() === 0) {
							$pwrd = password_hash($_POST['pwrd'], PASSWORD_DEFAULT);
	
							$stmt1 = $conn->prepare('INSERT INTO users (u_name, u_lastname, email, pwrd, direction, cp, telephone, birthdate) VALUES (?, ?, lower(?), ?, ?, ?, ?, ?);');
							$stmt1->bind_param('sssssiss', $_POST['u_name'], $_POST['u_lastname'], $_POST['email'], $pwrd, $_POST['direction'], $_POST['cp'], $_POST['telephone'], $_POST['birthdate']);
							$stmt1->execute();
							$stmt1->store_result();
							if ($stmt1->affected_rows > 0) {
								$data['result'] = 0;
								$data['message'] = 'Cuenta creada con éxito.';
							} else {
								$data['message'] = 'Ha sucedido un error.';
							}
							$stmt1->close();
						} else {
							$data['message'] = 'El email ya existe.';
						}
						$stmt->close();
					}

				} else {
					$data['message'] = "Data missing.";
				}
				break;
			default:
				$data['message'] = "Invalid action.";
				break;
		}
	} catch (Throwable $err) {
		$data['message'] = "Unexpected error, code {$err->getLine()}.";
	}
}

header("Content-Type: application/json;");
echo json_encode($data, JSON_PRETTY_PRINT);
