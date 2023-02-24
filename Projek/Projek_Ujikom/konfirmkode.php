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
	<title>Konfirmasi</title>
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
			<div id="effect">
				<div id="conten-form">
					<br>
					<center><img src="elektro.png" width="100px"></center>
					<br><br>
					<input type="text" name="vercode" class="adaan ussr" id="user" onchange="aas()" placeholder="Masukan kode verifikasi">
					<br><br>
					<!--<p>belum menerima kode? <button id="res" onclick="resend()" style="border: 0 none transparent; background-color : transparent;">resend</button><text id="wait"></text></p>-->
					<section>
						<center><input type="submit" value="Submit" class="btn btn-warning"style="width : 100px; border-radius : 120px;"></center>
					</section>
				</div>
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
	
	function resend(){
		$.ajax({
			type: "POST",
			dataType: "html",
			url: "pemrosesan.php",
			data: "username-daftar="+<?php echo $_SESSION['resend-code']['username'];?>
				+"&email-daftar="+<?php echo $_SESSION['resend-code']['email'];?>
				+"&password-daftar="+<?php echo $_SESSION['resend-code']['password'];?>
				+"&passwordc-daftar="+<?php echo $_SESSION['resend-code']['passwordc'];?>,
			success: function(data) {
				document.getElementById("res").disabled = true;
				inter();
			}
		});
	}
	
	function inter(){
		var intv = setInterval(function(){
			let cn = 0;
			if(cn < 30){
				cn++;
				document.getElementById("res").disabled = true;
				document.getElementById("wait").innerText = 30-cn;
			}
			else{
				clearInterval(intv);
				document.getElementById("res").disabled = false;
				cn = 0;
			}
			
		}, 1000);
	}
	</script>
</body>
</html>