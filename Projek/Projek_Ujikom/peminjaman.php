<?php session_start();include "koneksi.php";?>
<!DOCTYPE html>
<html>
<head>
	<title>Elektro</title>
	<link rel="stylesheet" href="bootstrap.css">
	<link rel="icon" type="image/png" href="elektro.png">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="jquery-3.5.1.min.js"></script>
	<style>
		.side{
			width : 25%;
			height : 100vh;
			background-color : #f8f8f8;
			padding : 30px;
			margin : 0;
			float : left;
			overflow : scroll;
		}
		.side-andro{
			width : 100%;
			height : 100vh;
			background-color : #f8f8f8;
			padding : 30px;
			margin : 0;
			float : left;
		}
		.acc-inf{
			display : block;
		}
		.side .acc-inf > h2{
			margin-top : 19px;
		}
		.side .acc-inf > h2, .side .acc-inf > img{
		}
		.enggang{
			margin-bottom : 5px;
			margin-top : 5px;
		}
		.output-media{
			width : 75%;
			height : 100vh;
			float : left;
			overflow : scroll;
		}
		@media only screen and (max-width : 1298px){
			.side{
				width : 30%;
			}
			.output-media{
				width : 70%;
			}
		}
		@media only screen and (max-width : 1065px){
			.side h4{
				font-size : 20px;
			}
			.side h2{
				font-size : 25px;
			}
		}
		@media only screen and (max-width : 934px){
			.side{
				width : 35%;
			}
			.output-media{
				width : 65%;
			}
		}
		.profile{
			width : 100%;
			height : 100vh;
			background-color : rgba(0,0,0,0.5);
			position : fixed;
			display : none;
			z-index : 2;
		}
		.dalam-profile{
			width : 300px;
			padding : 15px;
			border-radius : 10px;
			background-color : white;
			margin-top : 30vh;
		}
		#x{
			text-align : right;
			width : 100%;
			font-size : 20px;
			color : black;
			margin-top : -20px;
			cursor : pointer;
		}
		#y{
			text-align : right;
			width : 100%;
			font-size : 20px;
			color : black;
			margin-top : -20px;
			cursor : pointer;
		}
		#tampilan-tambah-barang{
			width : 100%;
			height : 100%;
			border : 0;
			padding : 5%;
		}
		.loading{
			width:100%;
			height : 100vh;
			background-color : rgba(0,0,0,0.5);
			color : white;
			padding-top : 30vh;
			display : none;
			position : fixed;
			
		}
		
	</style>
</head>
<body>
	<div class="side">
		<div class="acc-inf">
		<p></p>
			<center>
			<img src="elektro.png" width="120px" style="-webkit-filter : brightness(1);"><br><br>
			<h2><?php if(isset($_SESSION['user'])){
					echo "Inventaris barang Elektronika";
				}
				else{
					echo "<script>window.location.replace('login.php');</script>";
				}?></h2></center>
		</div>
		<br><br>
		<div class="kelompok-tomb" method="post">
			<form id="selektor">
				<input type="text" id="search" name="search" placeholder="search" class="form-control">
				<br>
				<h4> Tampilkan berdasarkan :</h4>
				<label for="kategori" class="enggang">Kategori :</label>
				<select id="kategori" class="form-control" name="kategori">
					<option value="">Semua</option>
					<?php
					$hals = mysqli_query($koneksi, "select * from kategori");
					while($d = mysqli_fetch_array($hals)){
						echo "<option value='".$d['kode_kategori']."'>".$d['jenis_kategori']."</option>";
					}
					?>
				</select>
				<br>
			<h4> Urutkan berdasarkan :</h4>
				<label for="abjad" class="enggang">Barang :</label>
				<select id="abjad" class="form-control" name="short">
					<option value="">None</option>
					<option value=" order by nama_barang">A-Z</option>
					<option value=" order by nama_barang desc">Z-A</option>
				</select>		
				<label for="id-bar" class="enggang">Kode barang :</label>
				<select id="id-bar" class="form-control" name="short2">
					<option value="">None</option>
					<option value=" order by kode_barang">Ascend</option>
					<option value=" order by kode_barang desc">Descend</option>
				</select>
				<br>
			</form> 
			
			<?php 
			if($_SESSION['role'] == "admin"){
				echo "<button style=\"margin-top : 5px;\" class=\"btn btn-warning\" id=\"munculkan-profile\"><h6 style=\"padding :0; margin : 0;\">Profil</h6></button>
				<button style=\"margin-top : 5px;\" class=\"btn btn-primary\" id=\"penambahan-data\"><h6 style=\"padding :0; margin : 0;\">Tambah data</h6></button>
				<button style=\"margin-top : 5px;\" class=\"btn btn-success\" id=\"histori\" onclick=\"histori()\"><h6 style=\"padding :0; margin : 0;\">Histori</h6></button>
				<button style=\"margin-top : 5px;\" class=\"btn btn-secondary\" onclick=\"tblw()\"><h6 style=\"padding :0; margin : 0;\">Tabel data</h6></button>
				<button style=\"margin-top : 5px;\" class=\"btn btn-info\" onclick=\"tampilpermintaan()\"><h6 style=\"padding :0; margin : 0;\">Permintaan</h6></button>";
			}
			else if($_SESSION['role'] == "user"){
				echo "<button style=\"margin-top : 5px;\" class=\"btn btn-warning\" id=\"munculkan-profile\"><h6 style=\"padding :0; margin : 0;\">Profil</h6></button>
				<button style=\"margin-top : 5px;\" class=\"btn btn-secondary\" onclick=\"tblw()\"><h6 style=\"padding :0; margin : 0;\">Tabel data</h6></button>
				<button style=\"margin-top : 5px;\" class=\"btn btn-info\" onclick=\"tampilstatus()\"><h6 style=\"padding :0; margin : 0;\">Status</h6></button>";
			}
				
				
				?>
			<br><br><br>
		</div>
	</div>	
		
	<!--untuk android-->	
	
	<!--Untuk menampilkan data yang diminta user-->
	
	<div class="output-media">
		<br><br>
		<center><h2 id="judul-media"></h2></center>
		<br><br><center>
		<div id="media" style="width:95%;">
		<center>
		<br>
		<br>
		<img src="elektro.png" width="200px" style="-webkit-filter : brightness(1);"><br><br><br><br>
		<h1>Selamat datang di web <br> inventaris barang elektronika</h1>
		</center>
		</div></center>
	</div>
	
	<!--tampilan profil-->
	
	<div class="profile" id="profile">
		<center><div class="dalam-profile">
			<div class="x" id="x">x</div>
			<br>
			<?php
			$que = "select pp from user where username='".$_SESSION['user']."'";
			$has = mysqli_query($koneksi, $que);
			while($dam = mysqli_fetch_array($has)){
			?>
			<center><div style="border-radius : 100%; overflow : hidden; width : 130px; height : 130px; cursor : pointer;" onclick="gantipp()"><img src="<?php echo $dam['pp'];}?>" width="260px"><div></center>
			<br>
			<h3><?php echo $_SESSION['user']?></h3>
			<br>
			<button id="logout" class="btn btn-danger" style="width : 90%">Logout</button>
		</div></center>
	</div>
	
	<!--untuk ganti pp-->
	
	<div class="profile" id="gantipp" style="display : none;">
	<form action="pemrosesan.php" method="post" enctype="multipart/form-data">
		<center><div class="dalam-profile">
			<div id="y">x</div>
			<br>
			<h3>Ganti foto profil</h3>
			<br>
			<input type="file" name="gantipp" class="form-control" id="upgambar">
			<br>
			<input type="submit" value="set" class="btn btn-secondary" style="width : 100%;">
			<br>
		</center>
		</form>
	</div>
	<div id="mediaver"></div>
	
	<script>
	//Perilaku button atau objek lain
	
	$("#x").click(function(){
		document.getElementById("profile").style.display = "none";
	});
	$("#y").click(function(){
		document.getElementById("gantipp").style.display = "none";
	});
	$("#munculkan-profile").click(function(){
		document.getElementById("profile").style.display = "block";
	});
	function gantipp(){
		document.getElementById("gantipp").style.display = "block";
	}
	
	//menampilkan barang kategori
	$("#kategori").change(function(){
		document.getElementById("search").value = "";
		var valkategori = $("#kategori").val();
		var valabjad = $("#abjad").val();
		$.ajax({
			type: "POST",
			dataType: "html",
			url: "pemrosesan.php",
			data: "kategori="+valkategori+"&short="+valabjad,
			success: function(data) {
			$("#media").html(data);
			}
		});
		document.getElementById("abjad").value = "";
		document.getElementById("id-bar").value = "";
		document.getElementById("judul-media").innerText = "List Barang";
	});
	
	//Urutkan barang sesuai abjad
	$("#abjad").change(function(){
		document.getElementById("search").value = "";
		var valkategori = $("#kategori").val();
		var valabjad = $("#abjad").val();
		$.ajax({
			type: "POST",
			dataType: "html",
			url: "pemrosesan.php",
			data: "kategori="+valkategori+"&short="+valabjad,
			success: function(data) {
			$("#media").html(data);
			}
		});
		document.getElementById("id-bar").value = "";
		document.getElementById("judul-media").innerText = "List Barang";
	});
	
	//urutkan barang sesuai id
	$("#id-bar").change(function(){
		document.getElementById("search").value = "";
		var valkategori = $("#kategori").val();
		var valid = $("#id-bar").val();
		$.ajax({
			type: "POST",
			dataType: "html",
			url: "pemrosesan.php",
			data: "kategori="+valkategori+"&short2="+valid,
			success: function(data) {
			$("#media").html(data);
			}
		});
		document.getElementById("abjad").value = "";
		document.getElementById("judul-media").innerText = "List Barang";
	});
	
	//Search
	$("#search").on("input", function(){
		var valsrc = $("#search").val();
		$.ajax({
			type: "POST",
			dataType: "html",
			url: "pemrosesan.php",
			data: "search="+valsrc,
			success: function(data) {
			$("#media").html(data);
			}
		});
		document.getElementById("abjad").value = "";
		document.getElementById("id-bar").value = "";
		document.getElementById("kategori").value = "";
		if(valsrc != ""){
			document.getElementById("judul-media").innerText = "Hasil pencarian dari \""+valsrc+"\"";
		}
		else{
			document.getElementById("judul-media").innerText = "List Barang";
		}
	});
	
	//Logout
	$("#logout").click(function(){
		$.ajax({
			type: "POST",
			dataType: "html",
			url: "pemrosesan.php",
			data: "logout=true",
			success: function(data) {
			$("#media").html(data);
			}
		});
	});
	
	//Dalam pengembangan
	$("#kirim-gambar").click(function(){
		var upg = $("#upgambar").val();
		$.ajax({
			type: "POST",
			dataType: "html",
			url: "pemrosesan.php",
			data: "gantipp="+upg,
			success: function(data) {
			$("#media").html(data);
			}
		});
	});
	
	//Menampilkan menu penambahan data
	$("#penambahan-data").click(function(){
		$.ajax({
			type: "POST",
			dataType: "html",
			url: "form-tambahdata.php",
			success: function(data) {
			$("#media").html(data);
			}
		});
		document.getElementById("judul-media").innerText = "Tambah barang";
		document.getElementById("abjad").value = "";
		document.getElementById("id-bar").value = "";
		document.getElementById("kategori").value = "";

	});
	
	//Tombol tampilkan tabel
	
	function tblw(){
		$.ajax({
			type: "POST",
			dataType: "html",
			url: "pemrosesan.php",
			data: "tabelawal=true",
			success: function(data) {
			$("#media").html(data);
			}
		});
		document.getElementById("judul-media").innerText = "List Barang";
		document.getElementById("abjad").value = "";
		document.getElementById("id-bar").value = "";
		document.getElementById("kategori").value = "";
	}
	
	//Untuk mengirimkan data dari penambahan barang
	
	function clickirim(){
		var namb = $("#tambah-namabarang").val();
		var stob = $("#tambah-stok").val();
		var katb = $("#tambah-kategori").val();
		var merb = $("#tambah-merk").val();
		var sub = $("#tambah-sumber").val();
		$.ajax({
			type: "POST",
			dataType: "html",
			url: "pemrosesan.php",
			data :"tambahnama="+namb+"&tambahstok="+stob+"&tambahkategori="+katb+"&tambahmerk="+merb+"&tambahsumber="+sub,
			success: function(data){
			$("#mediaver").html(data);
			}
		});
	}
	
	function ketikaduplikat(){
		var verkebdatain = confirm('Barang sudah ada di dalam sistem, apakah anda ingin menambah stok saja?');
		if(verkebdatain == true){
			var namin = $("#tambah-namabarang").val();
			var stoin = $("#tambah-stok").val();
			$.ajax({
				type: "POST",
				dataType: "html",
				url: "pemrosesan.php",
				data :"verkebdatain=true&tambahnama2="+namin+"&tambahstok="+stoin,
				success: function(data){
					$("#mediaver").html(data);
				}
			});
		}
		else{
			
		}
	}
	
	function ketikatidakduplikat(){
		alert('Penambahan data berhasil');
		document.getElementById("tambah-namabarang").value = "";
		document.getElementById("tambah-stok").value = "";
		document.getElementById("tambah-merk").value = "";
		document.getElementById("tambah-sumber").value = "";
	}
	
	//Untuk menghapus data
	
	function hapusdata(kodebrg,refreshtbl){
		var hapver = confirm("Apakah anda yakin untuk menghapus data ini?");
		if(hapver == true){
			$.ajax({
				type: "POST",
				dataType: "html",
				url: "pemrosesan.php",
				data :"hapusbrg="+kodebrg+"&refreshtbl="+refreshtbl,
				success: function(data){
					$("#media").html(data);
				}
			});
		}
		else{
		}
	}
	
	//edit data
	
	function editdata(edkodebrg,ednamabrg,edkatbrg,edstok,edmerk,edsumber){
		$.ajax({
			type: "POST",
			dataType: "html",
			url: "form-editdata.php",
			success: function(data) {
			$("#media").html(data);
			}
		});
		document.getElementById("judul-media").innerText = "Edit data barang";
		document.getElementById("abjad").value = "";
		document.getElementById("id-bar").value = "";
		document.getElementById("kategori").value = "";
		document.getElementById("loading").style.display= "block";
		
		setTimeout(function(){
		document.getElementById("edkodebar").value = edkodebrg;
		document.getElementById("ednamabar").value = ednamabrg;
		document.getElementById("edstokbar").value = parseInt(edstok);
		document.getElementById("edkatbar").value = edkatbrg;
		document.getElementById("edmerk").value = edmerk;
		document.getElementById("edsumber").value = edsumber;
		document.getElementById("loading").style.display= "none";
		},1000);
	}
	
	function edclickirim(){
		var edbrgkir = $("#ednamabar").val();
		var edstokir = $("#edstokbar").val();
		var edkatir = $("#edkatbar").val();
		var edkodkir = $("#edkodebar").val();
		var edmerkkir = $("#edmerk").val();
		var edsumkir = $("#edsumber").val();
		$.ajax({
			type: "POST",
			dataType: "html",
			url: "pemrosesan.php",
			data :"editbrg="+edbrgkir+"&editstok="+edstokir+"&editkat="+edkatir+"&editkod="+edkodkir+"&editmerk="+edmerkkir+"&editsum="+edsumkir,
			success: function(data){
			$("#mediaver").html(data);
			}
		});
			
	}
	
	//Untuk memunculkan tampilan histori
	
	function histori(){
		$.ajax({
			type: "POST",
			dataType: "html",
			url: "pemrosesan.php",
			data: "histori=true",
			success: function(data) {
			$("#media").html(data);
			}
		});
		document.getElementById("judul-media").innerText = "Histori anda";
		
	}
	
	//Ketika user tekan tombol pinjam
	
	function pinjam(pinkod){
		var pinconf = confirm("Apa anda ingin meminjam benda ini?");
		if(pinconf == true){
			var pinprompt = prompt("Masukan jumlah yang ingin anda pinjam");
			if((pinprompt == null || pinprompt == "") || pinprompt.match(/[a-z]/)){
				alert("mohon masukan nilai yang valid!!");
			}
			else{
				$.ajax({
					type: "POST",
					dataType: "html",
					url: "pemrosesan.php",
					data: "pinkod="+pinkod+"&pinquant="+pinprompt,
					success: function(data) {
					$("#mediaver").html(data);
					}
				});
			}
		}
	}
	
	//Ketika user tekan tombol status
	
	function tampilstatus(){
		$.ajax({
			type: "POST",
			dataType: "html",
			url: "pemrosesan.php",
			data: "tampilstatus=true",
			success: function(data){
				$("#media").html(data);
			}
		});
		document.getElementById("judul-media").innerText = "Status peminjaman";
	}
	
	//Untuk menampilkan menu permintaan
	
	function tampilpermintaan(){
		$.ajax({
			type: "POST",
			dataType: "html",
			url: "pemrosesan.php",
			data: "tampilpermintaan=true",
			success: function(data){
				$("#media").html(data);
			}
		});
		document.getElementById("judul-media").innerText = "Konfirmasi permintaan pinjam";
	}
	
	//Konfirmasi peminjaman barang
	
	function konfirm(noaksi, tindakan, kdbrangg){
		$.ajax({
			type: "POST",
			dataType: "html",
			url: "pemrosesan.php",
			data: "konpinoak="+noaksi+"&konpitindakan="+tindakan+"&konpikdbar="+kdbrangg,
			success: function(data){
				$("#media").html(data);
			}
		});
	}
	
	//Konfirmasi pengembalian barang
	
	function konfirmkem(konkemnoak, konkemkdbr){
		$.ajax({
			type: "POST",
			dataType: "html",
			url: "pemrosesan.php",
			data: "konkemnoak="+konkemnoak+"&konkemkdbr="+konkemkdbr,
			success: function(data){
				$("#media").html(data);
			}
		});
	}
	
	//Kembalikan barang
	
	function kembalikan(kemnoak, kemkdbr){
		$.ajax({
			type: "POST",
			dataType: "html",
			url: "pemrosesan.php",
			data: "kemnoak="+kemnoak+"&kemkdbr="+kemkdbr,
			success: function(data){
				$("#media").html(data);
			}
		});
	}
	
	//Hapus histori
	
	function hapushistori(){
		var pinconf = confirm("Anda Yakin menghapus histori? tindakan akan menghapus semua histori anda");
		if(pinconf == true){
			$.ajax({
				type: "POST",
				dataType: "html",
				url: "pemrosesan.php",
				data: "hapushistori=true",
				success: function(data) {
				$("#media").html(data);
				}
			});
		}
		else{
		}
		
	}
	

	
	//untuk notif error upload file
	
	<?php
	if(isset($_GET['upfile'])){
		unset($_GET['upfile1']);
		echo "alert('Masukan file dulu!!');
		window.location.replace('peminjaman.php');";
	}
	if(isset($_GET['upfile2'])){
		unset($_GET['upfile2']);
		echo "alert('Web tidak support ektensi file!!');
		window.location.replace('peminjaman.php');";
	}
	if(isset($_GET['upfile3'])){
		unset($_GET['upfile3']);
		echo "alert('Ukuran file tidak boleh lebih dari 2Mb!!');
		window.location.replace('peminjaman.php');";
	}
	if(isset($_GET['upfile4'])){
		unset($_GET['upfile4']);
		echo "alert('Berhasil ganti pp');
		window.location.replace('peminjaman.php');";
	}
	?>
	</script>
	<div class="loading" id="loading">
		<center><h1>Loading</h1></center>
	</div>
</body>
</html>
