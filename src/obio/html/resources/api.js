jQuery(function() {
	function Signup(name, lastname, email, password, direction, cp, telephone, birthdate) {
		var fd = new FormData();
		fd.append('action', 'signup');
		fd.append('u_name', name);
		fd.append('u_lastname', lastname);
		fd.append('email', email);
		fd.append('pwrd', password);
		fd.append('direction', direction);
		fd.append('cp', cp);
		fd.append('telephone', telephone);
		fd.append('birthdate', birthdate);
		
		$.ajax('../sessions.php', {
			"data": fd,
			"method":"POST",
			"processData":false,
			"contentType": false,
			"success": (data) => {
				var p = $("#comes");
				try {
					p.append(`<div>
							<p>${data.result}</p>
							<p>${data.message}</p>
						</div><br/>`);
				} catch (err) {
					p.html(`<p>Ha sucedido un error ${err}</p>`);
				}
			},
			"error": (data) => {
				$("#comes").html(`<p>Ha sucedido un error ${err}</p>`);
			}
		});
	}

	function Login(email, password){
		var fd = new FormData();
		fd.append('action', 'login');
		fd.append('email', email);
		fd.append('password', password);
		
		
		$.ajax('../sessions.php', {
			"data": fd,
			"method":"POST",
			"processData":false,
			"contentType": false,
			"success": (data) => {
				var p = $("#comes");
				try {
					p.append(`<div>
							<p>${data.result}</p>
							<p>${data.message}</p>
							<p>${data.token}</p>
						</div><br/>`);
				} catch (err) {
					p.html(`<p>Ha sucedido un error ${err}</p>`);
				}
			},
			"error": (data) => {
				$("#comes").html(`<p>Ha sucedido un error ${err}</p>`);
			}
		});
	}

	function End_Session(token){
		var fd = new FormData();
		fd.append('action', 'login');
		fd.append('token', token);
		
		
		$.ajax('../sessions.php', {
			"data": fd,
			"method":"POST",
			"processData":false,
			"contentType": false,
			"success": (data) => {
				var p = $("#comes");
				try {
					p.append(`<div>
							<p>${data.result}</p>
							<p>${data.message}</p>
						</div><br/>`);
				} catch (err) {
					p.html(`<p>Ha sucedido un error ${err}</p>`);
				}
			},
			"error": (data) => {
				$("#comes").html(`<p>Ha sucedido un error ${err}</p>`);
			}
		});
	}

	function Remember_Me(token){
		var fd = new FormData();
		fd.append('action', 'login');
		fd.append('token', token);
		
		
		$.ajax('../sessions.php', {
			"data": fd,
			"method":"POST",
			"processData":false,
			"contentType": false,
			"success": (data) => {
				var p = $("#comes");
				try {
					p.append(`<div>
							<p>${data.result}</p>
							<p>${data.message}</p>
						</div><br/>`);
				} catch (err) {
					p.html(`<p>Ha sucedido un error ${err}</p>`);
				}
			},
			"error": (data) => {
				$("#comes").html(`<p>Ha sucedido un error ${err}</p>`);
			}
		});
	}
	

	function Load_Categories(){
		var fd = new FormData();
		fd.append('action', 'load-categories');

		$.ajax('../shop.php', {
			"data": fd,
			"method":"POST",
			"processData":false,
			"contentType": false,
			"success": (data) => {
				var toAppend = '';
				
				for (var i in data['categories']) {
					toAppend += `<div><h2>${data['categories'][i]['name']}</h2>`;
					

					for (var a in data['categories'][i]['childs']) {
						toAppend += `<p>${data['categories'][i]['childs'][a]['name']}</p>`;
					}
					
					toAppend += '</div><br/>';
				}

				$("#productos").html(toAppend);
			}
		})
	}

	Load_Categories();
});
