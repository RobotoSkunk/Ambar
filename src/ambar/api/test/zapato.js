jQuery(function() {
	var fd = new FormData();
	fd.append('action', 'end-session');
	fd.append('token', 'end-session');

	$.ajax('../sessions.php', {
		"data": fd,
		"method":"POST",
		"processData":false,
		"contentType": false,
		"success": (data) => {
			var p = $("#comes");
			try {
				p.append(JSON.stringify(data, null, 4));
			} catch (err) {
				p.html(`<p>Ha sucedido un error ${err}</p>`);
			}
		},
		"error": (data) => {
			$("#comes").html(`<p>Ha sucedido un error ${err}</p>`);
		}
	});
});
