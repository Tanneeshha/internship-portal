<?php
session_start();
include('dbconnect.php');

$fields=array('name','username','email','password');
$error=false; //no errors yet
foreach($fields as $fieldname)
{
  if(!isset($_POST[$fieldname]) || empty($_POST[$fieldname]))
  {
    $error=true;
  } 
}
if($error)
{
  echo "<script>alert('Field(s) empty');</script>";
    echo "<script>setTimeout(\"location.href = 'signup';\",10);</script>";
}
else
{
  //no error

   $uname = mysqli_real_escape_string($conn,$_POST['name']);
    $usname = mysqli_real_escape_string($conn,$_POST['username']);
    $uemail = mysqli_real_escape_string($conn,$_POST['email']);
    $upass = mysqli_real_escape_string($conn,md5($_POST['password']));
    $type=$_POST['type'];
    if($type=="student") $utype=0; else $utype=1;
    $query = "INSERT INTO login(name,username,email,password,type) VALUES('$uname','$usname','$uemail','$upass','$utype')";
    $result = mysqli_query($conn,$query);

    IF ($result) {
      // set session
      header('Location: login');
    }

    // Close DB connection
    mysqli_close($conn);

}
?>