<?php 
session_start();
if(isset($_SESSION['user'])){
	header("location:peminjaman.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="style-login.css">
	<link rel="stylesheet" href="bootstrap.css">
	<link rel="icon" type="image/png" href="elektro.png">
	<title>Login</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="jquery-3.5.1.min.js"></script>
	<script>
		function hapus(){
			document.getElementById("errno").innerHTML = "";
		}
	</script>
	<style id="metas"></style>
	<style id="metasta"></style>
</head>
<body>
	<form method="post" id="login" name="forlog" action="pemrosesan.php">
		<div class="wadah-form">
			<div id="conten-form">
				<br>
				<center><img src="elektro.png" width="100px"></center>
				<br>
				<input type="text" name="username-login" class="adaan ussr" id="user" onchange="aas()" placeholder="Username">
				<br>
				<input type="password" name="password-login" class="adaan pssr" id="pass" onchange="uus()" placeholder="Password">
				<br>
				<p style="color : red;" id="errno"><?php if(isset($_GET['ver'])){echo "*Username atau password salah!! ";}?></p>
				<p>Belum punya akun? <a href="daftar.php">Daftar</a></p>
				<section>
					<center><input type="submit" value="Login" class="btn btn-warning"style="width : 100px; border-radius : 120px;"></center>
				</section>
			</div>
		</div>
	</form>
	<script>
	function aas(){
	var isi = document.getElementById("user").value;
	if(isi != ""){
		$("#metas").html(".adaan.ussr~#labela{margin-top: -16px;font-size: 12px;color: black;transition: 0.3s;}");
	}
	else{
		$("#metas").html("");
	}
	}
	
	function uus(){
	var usi = document.getElementById("pass").value;
	if(usi != ""){
		$("#metasta").html(".adaan.pssr~#labeli{margin-top: -6px;font-size: 12px;color: black;transition: 0.3s;}");
	}
	else{
		$("#metasta").html("");
	}
	}

	</script>
</body>
</html>