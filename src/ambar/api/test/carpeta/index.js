jQuery(function() {
	$.ajax('./data.json', {
		"success": (data) => {
			for (var i in data) {
				$("#productos").append(`<p>Nombre: ${data[i]['name']} | precio: $${data[i]['price']}</p>`);
			}
		},
		"processData": false
	});
});
