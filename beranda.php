<?php
session_start()
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>halaman beranda</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div>
		<header>
			<p>Halaman utama</p>
		</header>
		<nav>
			<table border="10px">
				<tr style="text-decoration: none;text-underline-position: none;">
					<th><a href="login.php">logout</a></th>
					<th></th>
				</tr>
			</table>
		</nav>

		<div style="display: flex;">
			<main style="width: 50%;color: white;" >
				<th>
					<td>
							<table >
									<h3>daftar produk</h3>
										<table border='1' style="font-size: 15px;">

											<tr>
												<th>no</th>
												<th>kode produk</th>
												<th>nama produk</th>
												<th>merk</th>
												<th>harga satuan pdk</th>
												<th>qty</th>
											</tr>
										
											<?php
											include "connection.php";
											$no=1;
											$produk = mysqli_query($connect,"SELECT*FROM produk");
											while ($data = mysqli_fetch_array($produk)) {
												echo "
												<tr>
													<td>$no</td>
										            <td>".$data['kodepdk']."</td>
										            <td>".$data['namapdk']."</td>
										            <td>".$data['merk']."</td>
										            <td>".$data['harga_satuan']."</td>
										            <td>".$data['qty']."</td>
										        </tr>";

										        $no++;
											}
											?>
										</table>
										</table>
									</td>
								</th>
			</main>
			<aside>
				<div class="menu" style="justify-content: center;">
					<?php
					//halaman pengguna/pembeli
					$level = $_SESSION['level'] == "pengguna";
					if($level){
					?>
					<table>
						<tr>
							<th>
								<table border="1px">
								<h3>membeli</h3>
									<form action="" method="post">
										<tr>
											<td>kode produk </td>
											<td><input type="text" name="kodepdk"></td>
										</tr>
										<tr>
											<td>tanggal beli </td>
											<td><input type="date" name="tanggal_terjual"></td>
										</tr>
										<tr>
											<td>jumlah / qty </td>
											<td><input type="number" name="qty"></td>
										</tr>
										<tr>
											<td>harga barang satuan</td>
											<td><input type="text" name="harga_satuan"></td>
										</tr>
										<tr>
											<td></td>
											<td><input type="submit" value="beli" name="membeli"></td>
										</tr>
									<?php
									include"connection.php";
									if (isset($_POST['membeli'])) { mysqli_query($connect,"INSERT INTO produkjual SET 
										kodepdk = '$_POST[kodepdk]',
										tanggal_terjual = '$_POST[tanggal_terjual]',
										qty = '$_POST[qty]',
										harga_satuan = '$_POST[harga_satuan]'");
											echo "produk berhasil terbeli";
										
										}
									?>
									</form>

								</table>
								
							</th>
						</tr>
					</table>
					<?php }else { ?>
						<table>
							<tr>
								<th>
									<td>
										<h3>update produk </h3>
										<table >
										<form action="" method="post">
											<tr>
												<td>kode produk </td>
												<td><input type="text" name="kodepdk"></td>
											</tr>
											<tr>
												<td>tanggal masuk </td>
												<td><input type="date" name="tanggal_masuk"></td>
											</tr>
											<tr>
												<td>jumlah / qty </td>
												<td><input type="text" name="qty"></td>
											</tr>
											<tr>
												<td>harga barang satuan</td>
												<td><input type="text" name="harga_satuan"></td>
											</tr>
											<tr>
												<td></td>
												<td><input type="submit" value="masukkan" name="restok"></td>
											</tr>
										<?php
										include "connection.php";
										if (isset($_POST['restok'])) { mysqli_query($connect,"INSERT INTO pdkmasuk SET 
										kodepdk = '$_POST[kodepdk]',
										tanggal_masuk = '$_POST[tanggal_masuk]',
										qty = '$_POST[qty]',
										harga_satuan = '$_POST[harga_satuan]'");
											echo "produk berhasil diperbarui/restok";
										}
										?>
										</form>
										</table>
									</td>
								</th>
								<th>
									<td>
										<table>
											<h4>laporan menampilkan rekap pemasukkan produk</h4>
											<table border="14px">
												<tr>
													<th><a href="pengeluaran.php">pengeluaran</a></th>
												</tr>
											</table>
										
										<form method="post">
											<table>
												<tr>
													<td>dari tanggal </td>
													<td><input type="date" name="dari_tanggal" required="required"></td>
													<td> sampai tanggal </td>
													<td><input type="date" name="sampai_tanggal" required="required"></td>
													<td><input type="submit" value ="filter" name="filter"></td>
												</tr>
											</table>
										</form>
										<table border='1' style="font-size: 15px;">
											<tr>
												<th>no</th>
												<th>kode produk</th>
												<th>tanggal masuk</th>
												<th>qty</th>
												<th>harga satuan pdk</th>
											</tr>
									
										<?php
										include "connection.php";
										$no=1;
										$produk_msk = mysqli_query($connect,"SELECT*FROM pdkmasuk");
										if (isset($_POST['filter'])) {
											$dari_tgl = mysqli_real_escape_string($connect,$_POST['dari_tanggal']);
											$sampai_tgl = mysqli_real_escape_string($connect,$_POST['sampai_tanggal']);
											$produk_msk = mysqli_query($connect,"SELECT*FROM pdkmasuk WHERE tanggal_masuk BETWEEN'$dari_tgl' AND'$sampai_tgl'");
											}else{
												$produk_msk = mysqli_query($connect,"SELECT*FROM pdkmasuk");
											}
											while ($in = mysqli_fetch_array($produk_msk)) {
												echo "
												<tr>
													<td>$no</td>
										            <td>".$in['kodepdk']."</td>
										            <td>".$in['tanggal_masuk']."</td>
										            <td>".$in['qty']."</td>
										            <td>".$in['harga_satuan']."</td>
										        </tr>";

											$no++;
											}
											?>

										</table>
										</table>
									</td>
								</th>
							</tr>
						</table>
					<?php } ?>
				</div>
			</aside>
	</div>
</div>
</body>
</html>