jQuery(function() {
	var fd = new FormData();

	$.ajax('../sessions.php', {
		"method":"POST",
		"processData":false,
		"success": (data) => {
			var p = $("#comes");
			try {
				p.append(JSON.stringify(data, null, 4));
			} catch (err) {
				p.html(`<p>Ha sucedido un error ${err}</p>`);
			}
		}
	});
});
