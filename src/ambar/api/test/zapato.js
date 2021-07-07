jQuery(function() {
	var fd = new FormData();
	fd.append('action', 'signup');
	fd.append('u_name', 'end-session');
	fd.append('u_lastname', 'end-session');
	fd.append('email', 'end-session');
	fd.append('pwrd', 'end-session');
	fd.append('direction', 'end-session');
	fd.append('cp', 'end-session');
	fd.append('telephone', 'end-session');
	fd.append('birthdate', '2001-10-03');

	// $_POST['u_name'], $_POST['u_lastname'], $_POST['email'], $_POST['pwrd'], $_POST['direction'], $_POST['cp'], $_POST['telephone'], $_POST['birthdate']

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
