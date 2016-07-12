<?php
session_start();
$valid=true;
$c=0;
$connection = oci_connect($username = 'my1',
                          $password = 'My4114510',
                          $connection_string = '//oracle.cise.ufl.edu/orcl');

if (!$connection) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

$name = $_POST['username'];
$password = $_POST['pwd'];


if(empty($name) || empty($password)){ $valid = false; }

if($valid == true)
{	
	$sql = "select USRNAME from G14USERINFO where USRNAME = '$name' AND PASSWORD = '$password' ";
	$query = oci_parse($connection,$sql);
	oci_execute($query);

	if(oci_fetch($query) == true)
	{
	//get userid and first name from database and set them to session
		$sql1 = "SELECT * FROM G14USERINFO WHERE USRNAME = '$name'";
		$query1 = oci_parse($connection,$sql1);
		oci_define_by_name($query1, 'USRID',$userid);
		oci_define_by_name($query1, 'USRTYPE',$usertype);
		oci_define_by_name($query1, 'USRNAME',$username);
		oci_define_by_name($query1, 'EMAIL',$email);
		oci_define_by_name($query1, 'PHONENUM',$phonenum);
		oci_define_by_name($query1, 'ADDRESS',$address);
		oci_define_by_name($query1, 'CITY',$city);
		oci_define_by_name($query1, 'STATE',$state);
		oci_define_by_name($query1, 'ZIPCODE',$zipcode);
		oci_define_by_name($query1, 'LAT',$lat);
		oci_define_by_name($query1, 'LON',$lon);
		oci_execute($query1);
		while(oci_fetch($query1)){
			$_SESSION['userid']=$userid;
			$_SESSION['usertype']=$usertype;
			$_SESSION['username']=$username;
			$_SESSION['email']=$email;
			$_SESSION['phonenum']=$phonenum;
			$_SESSION['address']=$address;
			$_SESSION['city']=$city;
			$_SESSION['state']=$state;
			$_SESSION['zipcode']=$zipcode;
			$_SESSION['lat']=$lat;
			$_SESSION['lon']=$lon;
		}
	//end of session part
		$login="Welcome, $username";
	}	
	else
	{
		$login= 'Wrong login or password'; $c=1;
	}

	if(!$query)
	{
		//echo "test_query1";
		echo "<script type='text/javascript'>alert('$login')</script>";
		//setcookie("user",$id, time()+3600);
		echo "<script type='text/javascript'>window.location.replace('index.html');</script>";
	}
	else
	{
		//setcookie("user",$id, time()+3600);
		echo "<script type='text/javascript'>alert('$login')</script>";

		//After signin user sees new index.html page as he is logged in, so sees logout and Logged In: UserName
		if($c==1){
                // wrong login or password
				echo "<script type='text/javascript'>window.location.replace('index.html');</script>";
		}
		else{
		        if($usertype=="m"){
					// go to manager page
					echo "<script type='text/javascript'>window.location.replace('manager_main.php');</script>";
				} else if ($usertype=="b"){
					// go to providerpage
					echo "<script type='text/javascript'>window.location.replace('ProviderPage.php');</script>";
				} else
		        // go to LogInIndex
			    echo "<script type='text/javascript'>window.location.replace('LogInIndex.php');</script>";   //test for my page
				//echo "<script type='text/javascript'>window.location.replace('index.html');</script>";
			    echo "sign in success!!!";
		}
	}
	oci_free_statement($query1);
	oci_free_statement($query);
}
else
{   // empty username or empty password
	echo "<script type='text/javascript'>window.location.replace('index.html');</script>";
}
oci_close($connection);
?>