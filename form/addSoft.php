<?php


require ('../StatusInfo.php');

session_start();
if(!isset($_SESSION["statusInfo"]))
{
echo("Invalid Access");
exit(1);
}
else
	$statusInfo = $_SESSION["statusInfo"];

if(isset($_POST['submit'])){
$name = $_POST["name"];
unset($_POST['submit']);

if($name=="")
{
	echo "<script>alert('Missing Values!')</script>";
	echo "<script>window.location.href='index.php'</script>";
}



$con = mysql_connect("127.0.0.1","root","") or die(" Mysql Connection Error");

mysql_select_db("security") or die("Invalid DB");

$query = "Insert into SoftwareList values('$name','NULL')";
//echo($query);
$res = mysql_query($query);

$query = "create table $name(user varchar(100) not null,actkey varchar(100),bios varchar(100),email varchar(100),trial int(10) not null,count varchar(11)not null,primary key(actkey,email));";
$res2 = mysql_query($query);

if(!$res && ! $res2)
{
	echo '<script>alert("Software Already Exists!")</script>';
	echo "<script>window.location.href='index.php'</script>";	
}
else{

		$query = "Select * from SoftwareList;";
		$results = mysql_query($query);
		$softwares = array();
		while($row = mysql_fetch_array($results))
			array_push($softwares, $row['sname']);
	
		//print_r($row);			
		$statusInfo->setSoftwares($softwares);
		
		mysql_close();
		
	echo '<script>alert("Software Added!")</script>';
	 echo "<script>window.location.href='index.php'</script>"; 
	
}


}
else
{
echo("Invalid Access!");
}


?>