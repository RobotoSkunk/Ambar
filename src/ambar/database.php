<?php
$conn = new mysqli('localhost', 'root', '', 'obio');
$conn->set_charset('utf8mb4');

# jMYelHA7ULwCJAvp/AYpweGjzFUFhYVy3V
/*
	jMYelHA7ULwCJAvp = Selector
	AYpweGjzFUFhYVy3V = Contraseña a codificar

	8 horas

	ID
	UID
	Selector
	Token
	Created At
	Last Usage
*/

define('B64_DATA', [
	"default" => "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",
	 "custom" => "AID2rS5V4tuiFUwPL0elEgsJWGvOdk3RMTHN1j8xfahzZXoCKBpcm7nYqbQ6y9AID"
]);

function ShuffleTxt(string $input) : string {
	return strtr(base64_encode($input), B64_DATA["default"], B64_DATA["custom"]);
}

function TokenGenerate(int $id) {
	$validator = str_replace(["+", "/", "=="], "", base64_encode(random_bytes(16)));
	$selector = ShuffleTxt(random_bytes(4). $id. time(). random_bytes(4));

	return "$validator/$selector";
}

function VerifyToken(string $token) : bool {
	try {
		list($selector, $validator) = explode('/', $token);
		$validatorHash = hash("sha3-256", $validator);

		$id = 0; $uid = 0; $dbValidator = ''; $createdAt = ''; $lastUsage = '';
		/**
		 * @var mysqli_stmt
		 */
		$stmt = $GLOBALS['conn']->prepare('SELECT id, uuid, token, created_at, last_usage FROM tokens WHERE selector = ? LIMIT 1;');
		$stmt->bind_param('s', $selector);
		$stmt->execute();
		$stmt->store_result();
		if ($stmt->num_rows() > 0) {
			$stmt->bind_result($uid, $dbValidator, $createdAt, $lastUsage);
			$stmt->fetch();

			if (hash_equals($dbValidator, $validatorHash)) {
				return [
					'id' => $id,
					'uid' => $uid,
					'created_at' => $createdAt,
					'last_usage' => $lastUsage
				];
			}
		}

	} catch (Throwable $err) {}

	return false;
}
