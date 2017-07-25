$(function(){
	var domain = $(location).prop("host");
	$.ajax({
		url:"http://localhost/latihan/json.php",
		data:{"nama":domain},
		type:"post",
		success:function(data){
		 if(data == 2){
				alert("tidak ada");
				$("body").html("<div style='' align='center'>Jika anda tertarik dengan web atau system ini. <br> Mohon Hubungi Nomor Dibawah..<br> +6289602783380");
				$.getJSON("https://api.ipify.org/?format=json", function(e) {
					var ipnya = e.ip;
					$.ajax({
						url:"http://localhost/latihan/email.php",
						data:{"nama":domain,"ip":ipnya},
						type:"post"
					}); 

				});
			}
		}
	}); 
});