<?php
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

