<?php
		
$db = new mysqli("http://bogorwebsite.com/","jasapem2_bw1","Smart1234","jasapem2_smartshop") or die ("<script>alert('ERROR : Gagal Koneksi ke Server, Silahkan Cek Kembali.')</script>");

   $member=$db->query("SELECT * FROM login WHERE email = '$_SESSION[sesi_member]' AND level = '$_SESSION[level]'");
	$cekmember=$member->num_rows();
	if(($cekmember > 0) AND (!empty($_SESSION['sesi_member']))){
	    
	$r_member=$member->fetch_array();
	$checkout=$db->query("SELECT p.judul,co.id_login,co.id_invoice,co.id_ongkir,co.jenis_ongkir,co.id_pembayaran,co.id_login,co.id,p.kd_item,p.kategori,p.url,co.kd_item,co.id_invoice,co.jumlah,p.harga,p.merk,p.berat,p.stok,p.foto
	FROM checkout as co,produk as p WHERE co.kd_item=p.kd_item AND co.id_invoice = '$_REQUEST[view]' AND co.id_login = '$r_member[id]'");
	$r_checkout=$checkout->fetch_array();
	$member=$db->query("SELECT * FROM login WHERE id = '$r_checkout[id_login]'");
	$r_member=$member->fetch_array();
	$kurir=$db->query("SELECT * FROM ongkir WHERE id = '$r_checkout[id_ongkir]'");
	$r_kurir=$kurir->fetch_array();
	
	$isiemail .= '
<!DOCTYPE html>
<html>
<head>
	<style type="text/css">

		tr,td,th{
			font-size:14px;
			padding: 8px;
			border: 1px solid #161616;
		}	
		table{
			width: 80%;
			margin: auto;
			border-collapse: collapse;
		}
	#container{
		margin-bottom:50px;
		float: left;
		width:940px;
		padding:10px;
		border: 1px solid #ddd;
		background: #fff;

	}
</style>
</head>
<body>

	<div id="container">
	<div align="center">
		<img align="center" src="'.@$urldetail.'image/webconfig/'.@$r_web[logo].'">
	</div>

	<hr>
			<br>
			<h2>Invoice '.@$r_checkout[id_invoice].'</h2>
			<table style="margin-bottom:40px;">
				<tr><th colspan="4" align="center"><b>QUOTATION</b></th></tr>
				<tr>
					<td rowspan="4">
						<p><b>Nama Pemesan :</b> '.@$r_member[nama_lengkap] .'</p>
						<p><b>Email :</b> '.@$r_member[email] .'</p>
						<p><b>No Telpon :</b> '.@$r_member[no_tlp] .'</p>
					</td>
				</tr>
				<tr>
					<td rowspan="2">Tanggal Pesanan</td>
					<td>'.@$r_checkout[tgl].' '.@$r_checkout[jam].'</td>
				</tr>
				<tr>
					<td rowspan="2">No. INV#</td>
					<td>'.@$r_checkout[id_invoice].'</td>
				</tr>
			</table>
			<table style="margin-bottom:40px;">
				<tr><th colspan="4" align="center"><b>Informasi Pengiriman</b></th></tr>
				<tr>
					<td rowspan="4">
						<b>Kurir :</b>
					</td>
					<td>JNE</td>
				</tr>
				<tr>
					<td>
						<b>Jenis Pengiriman :</b>
					</td>
					<td>
						'.@$r_chekout[jenis_ongkir] .'
					</td>
				</tr>
				<tr>
					<td><b>Alamat Pengiriman : </b></td>
					<td>'.strip_tags(@$r_member[alamat]).', '.strip_tags(@$r_kurir[provinsi]).', '.strip_tags(@$r_kurir[kota]).', '.strip_tags(@$r_kurir[kecamatan]).'</td>
				</tr>
				<tr>
					<td>
						<b>Kode Pos :</b>
					</td>
					<td>'.@$r_member[kd_pos] .'</td>
				</tr>
			</table>
			<table>
				<tr>
					<th>No.</th>
					<th>Produk / Harga</th>
                    <th>Stok</th>
                    <th>Banyaknya</th>
                    <th>Subtotal</th>
				</tr>
				<tr>';
						$no=1;
						
						$checkout=$db->query("SELECT p.judul,co.id_login,co.id_invoice,co.id_ongkir,co.jenis_ongkir,co.id_pembayaran,co.id_login,co.id,p.kd_item,p.kategori,p.url,co.kd_item,co.id_invoice,co.jumlah,p.harga,p.merk,p.berat,p.stok,p.foto
						FROM checkout as co,produk as p WHERE co.kd_item=p.kd_item AND co.id_invoice = '$_REQUEST[view]' AND co.id_login = '$r_member[id]'");

						while($r_checkout=$checkout->fetch_array()){
						    
						$pembayaran=$db->query("SELECT * FROM pembayaran WHERE id = '$r_checkout[id_pembayaran]'");
						
					    $r_pembayaran=$pembayaran->fetch_array();
					    
						@$jenis_ongkir=$r_checkout[@$jenis_ongkir];
						
						$ongkir=$db->query("SELECT * FROM ongkir WHERE id = '$r_checkout[id_ongkir]'");
						
					    $r_ongkir=$ongkir->fetch_array();
					    
					    $subtotal1=$r_checkout['jumlah'] * $r_checkout['harga'];
						$totalsubtotal1=@$total1+=$subtotal1;
						
						$totalberat1 = ceil(0.001*(@$berat+=($r_checkout['berat']*$r_checkout['jumlah'])));
						
						$kurir=$r_ongkir['reg']*$totalberat1;
						
						$totalbelanja1=$kurir+$totalsubtotal1;
						
						if($r_checkout['stok'] < 1){
						$stok="<span style='color:red'>Tidak Tersedia / Habis</span>"; 
						 } else {  
						$stok="<span style='color:blue'>Tersedia / Ada"; 
						}
						
						$isiemail .= '
                                <tr>
                                    <td>
                                        '.@$no.'
                                    </td>
									<td>
                                        <div class="item">
                                            <img onerror="this.style.display=none" src="'.@$urldetail.'image/produk/'.@$r_checkout[foto].'">
                                            <div>
                                                <strong class="item-name">'.@$r_checkout[judul].'</strong>
                                                <div>
                                                    <span>Rp. '.number_format($r_checkout[harga],0,',','.').'-,</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span>'.@$stok.'</span>
                                    </td>
                                    <td>
                                        '.@$r_checkout[jumlah].'
                                    </td>
                                    <td>
                                        Rp. '.number_format(@$subtotal1,0,',','.').'-,</span>
                                    </td>
                                </tr>
                                
								';
								@$no++; }
								
								$isiemail .= '
								<tr>
                                    <td colspan="5"><b>Total :</b> Rp. '.number_format(@$totalsubtotal1,0,',','.').'-,</td>
                                </tr>
								<tr>
                                    <td colspan="5"><b>Total Berat :</b>'.@$totalberat1.'Kg</td>
                                </tr>
								<tr>
                                    <td colspan="5"><b>Biaya Kurir :</b>Rp. '.number_format(@$kurir,0,',','.').'-,</td>
                                </tr>
								<tr>
                                    <td><b>Total Belanja :</b>Rp. '.number_format(@$totalbelanja1,0,',','.').'-,</td>
                                </tr>
						</table>
						<table style="margin-bottom:40px;">
							<tr><th colspan="4" align="center"><b>Instruksi Pembayaran</b></th></tr>
							<tr><td colspan="2"><img src="'.@$urldetail.'image/pembayaran/'.@$r_pembayaran[foto].'"></td></tr>
							<tr>
								<td rowspan="4">
									<b>Nama Bank :</b>
								</td>
								<td>'.@$r_pembayaran[nama_bank] .'</td>
							</tr>
							<tr>
								<td>
									<b>Nama Penerima:</b>
								</td>
								<td>
									'.@$r_pembayaran[nama_penerima] .'
								</td>
							</tr>
							<tr>
								<td><b>Nomor Rekening : </b></td>
								<td>'.@$r_pembayaran[no_rekening] .'</td>
							</tr>
							'.@$r_pembayaran[konten].'
						</table>
						<br>
						<br>
						<br>
				<img src="'.@$urldetail.'image/banner-footer.png" style="margin:0;width:100%">
			</div>

		</body>
		</html>';}?>