<div id="tampilan-tambah-barang">
	<center>
		<form>
			<table width="440px">
				<tr>
					<th>Nama barang</th>
					<th> : </th>
					<td><input type="text" id="ednamabar" class="form-control"></td>
					<input type="hidden" id="edkodebar">
				</tr>
				<tr>
					<th>Stok</th>
					<th> : </th>
					<td>
						<input type="number" id="edstokbar" class="form-control">
					</td>
				</tr>
				<tr>
					<th>Merk</th>
					<th> : </th>
					<td>
						<input type="text" id="edmerk" class="form-control">
					</td>
				</tr>
				<tr>
					<th>Sumber</th>
					<th> : </th>
					<td>
						<input type="text" id="edsumber" class="form-control">
					</td>
				</tr>
				<tr>
					<th>Kategori</th>
					<th> : </th>
					<td>
						<select id="edkatbar" class="form-control">
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
		<button onclick="edclickirim()" class="btn btn-secondary" style="width : 39.5%;">Ok</button>
	</center>	
</div>
