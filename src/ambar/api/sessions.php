<?php
$data = [
	'result' => -1,
	'message' => "No data"
];

if (isset($_POST['action'])) {
	try {
		require_once('../database.php');

		switch ($_POST['action']) {
			case 'remember-me':
				if (isset($_POST['token'])) {
					$data['message'] = "Pene";
				} else {
					$data['message'] = "Token missing.";
				}
				break;
			case 'end-remember-me':
				if (isset($_POST['token'])) {
					$data['message'] = "Pene";
				} else {
					$data['message'] = "Token missing.";
				}
				break;
			case 'end-session':
				if (isset($_POST['token'])) {
					$data['message'] = "Pene";
				} else {
					$data['message'] = "Token missing.";
				}
				break;
			case 'login':
				if (isset($_POST['email'], $_POST['password'])) {
					$data['message'] = "Pene";
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
