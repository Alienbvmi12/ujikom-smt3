<div id="tampilan-tambah-barang">
	<center>
		<form id="penambahan" name="penambahan" method="post">
			<table width="440px">
				<tr>
					<th>Nama barang</th>
					<th> : </th>
					<td><input type="text" id="tambah-namabarang" class="form-control" name="tambahnama"></td>
				</tr>
				<tr>
					<th>Kuantitas</th>
					<th> : </th>
					<td>
						<input type="number" id="tambah-stok" class="form-control" name="tambahstok" min="1">
					</td>
				</tr>
				<tr>
					<th>Merk</th>
					<th> : </th>
					<td>
						<input type="text" id="tambah-merk" class="form-control" name="tambahmerk">
					</td>
				</tr>
				<tr>
					<th>Sumber</th>
					<th> : </th>
					<td>
						<input type="text" id="tambah-sumber" class="form-control" name="tambahsumber">
					</td>
				</tr>
				<tr>
					<th>Kategori</th>
					<th> : </th>
					<td>
						<select id="tambah-kategori" class="form-control" name="tambahkategori">
							<?php
							include "koneksi.php";
					$hals = mysqli_query($koneksi, "select * from kategori");
					while($d = mysqli_fetch_array($hals)){
						echo "<option value='".$d['kode_kategori']."'>".$d['jenis_kategori']."</option>";
					}
					?>
						</select>
					</td>
				</tr>
			</table>
			<br>
		</form>
		<br>
		<button onclick="clickirim()" class="btn btn-secondary" style="width : 39.5%;">Ok</button>
	</center>	
</div>
