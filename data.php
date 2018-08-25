<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "temp";
$con=mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
if(!$con)
{ // creation of the connection object failed
    die("connection object not created: ".mysqli_error($con));
}

if (mysqli_connect_errno())
{ // creation of the connection object has some other error
    die("Connect failed: ".mysqli_connect_errno()." : ". mysqli_connect_error());
}
if(isset($_POST['submit'])){
	//echo 'ok';
	$file=$_FILES['fileupload'];
  echo '<pre>';
	//print_r($file);
  echo '</pre>';
  for($i=0; $i<count($_FILES['fileupload']['name']); $i++):
    $file_name=$_FILES['fileupload']['name'][$i];
    $file_tmpname=$_FILES['fileupload']['tmp_name'][$i];
    $file_size=$_FILES['fileupload']['size'][$i];
    $file_error=$_FILES['fileupload']['error'][$i];
    $allowed=array('docx','pdf','txt');
    //print_r(pathinfo($file_name));
    $file_ext=pathinfo($file_name);
  	if($file_error==0){
  		if(in_array($file_ext['extension'], $allowed)){
  			if($file_size<10000000){
  				$newfilename=uniqid();
  				move_uploaded_file($file_tmpname,'upload/'.$file_name);
  				mysqli_query($con,"INSERT INTO `image`(`image`,`name`) VALUES ('".$newfilename.".".$file_ext['extension']."','".$file_ext['filename']."')");
  				echo $file_name.' has Uploaded';
  			}
  			else{
  				echo 'File Size error';
  			}
  		}
  		 else{
  		 	echo $file_name.' has file Extension error';
  		 }
  	}
  	else{
  		echo 'error';
  	}
  endfor;
 }
?>
