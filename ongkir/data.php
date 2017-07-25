<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script
	src="https://code.jquery.com/jquery-2.2.4.min.js"
	integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
	crossorigin="anonymous"></script>
	



	<script type="text/javascript">
		$(document).ready(function(){
			ongkir("provinsi","","","","","provinsi");

			function format(num){
				var n = num.toString(), p = n.indexOf('.');
				return n.replace(/\d(?=(?:\d{3})+(?:\.|$))/g, function($0, i){
					return p<0 || i<p ? ($0+'.') : $0;
				});
			}

			$("[name='provinsi']").change(function(){
				provinsi = $(this).val();
				ongkir("kota",provinsi,"","","","kota");
			});

			$("[name='kota']").change(function(){
				provinsi = $("[name='provinsi']").val();
				kota = $(this).val();
				ongkir("kecamatan",provinsi,kota,"","","kecamatan");
			});

			$("[name='kecamatan']").change(function(){
				provinsi = $("[name='provinsi']").val();
				kota = $("[name='kota']").val();
				kecamatan = $("[name='kecamatan']").val();
				jenis = $("[name='jenis']").val();

				ongkir("jenis",provinsi,kota,kecamatan,"","jenis");
				ongkir("ongkir",provinsi,kota,kecamatan,jenis,"ongkir");
			});

			$("[name='jenis']").change(function(){
				provinsi = $("[name='provinsi']").val();
				kota = $("[name='kota']").val();
				kecamatan = $("[name='kecamatan']").val();
				jenis = $("[name='jenis']").val();

				ongkir("ongkir",provinsi,kota,kecamatan,jenis,"ongkir");
			});


			function ongkir(bidang,provinsi,kota,kecamatan,jenis,target){
				$.ajax({
					url:"http://localhost/latihan/ongkir/base.php",
					data:{
						"bidang":bidang,
						"provinsi":provinsi,
						"kota":kota,
						"kecamatan":kecamatan,
						"jenis":jenis
					},
					type:"POST",
					success:function(hasil){
						
						if(bidang == "ongkir"){

							final = JSON.parse(hasil);


							var ongkir = final.harga;
							var belanja = $("#totalbelanja").val();

							var total = parseInt(ongkir) + parseInt(belanja);


							$("#hasil").html("Rp. " +format(final.harga));
							$("#total").html("Rp. " +format(total));
							$("[name='ongkir']").prop("value",final.id);
						}else if(bidang != "ongkir"){

							$("[name='"+target+"']").html(hasil);
						}
					}
				});
			}
		});
	</script>
</head>
<body>

	<select name="provinsi">
		<option>Pilih Provinsi</option>
	</select>
	<br>
	<br>
	<select name="kota">
		<option>Pilih kota</option>
	</select>
	<br>
	<br>
	<select name="kecamatan">
		<option>Pilih kecamatan</option>
	</select>
	<br>
	<br>
	<select name="jenis">
		<option>Pilih Jenis Ongkir</option>
	</select>
	<br>
	<br>
	<div id="hasil"></div>
	<input type="hidden" name="ongkir">

	<input type="hidden" id="totalbelanja" value="50000">

	<td><label>Total Belanja :</label> <div id="total" ></div></td>
	</html>