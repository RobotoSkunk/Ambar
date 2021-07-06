<?php
	require('./src/ambar/oauth-lib.php');

	$rnd = random_bytes(16);
	$b64 = str_replace(["+", "/", "=="], "", base64_encode($rnd));

	$rnd1 = "37". random_bytes(8);
	$selector = ShuffleTxt($rnd1);
?>
<html>
	<body style="text-align: center;">
		<p><?=$rnd?></p>
		<p><?=$rnd1?></p>
		<p><?="$selector/$b64"?></p>
		<p><?=hash("sha3-256", $b64)?></p>
		<p><?=bin2hex(random_bytes(16))?></p>
	</body>
</html>
