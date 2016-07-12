<?php
//session start in case of login
session_start();
$valid=false;
$connection = oci_connect($username = 'my1',
                          $password = 'My4114510',
                          $connection_string = '//oracle.cise.ufl.edu/orcl');

if (!$connection) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}


$valid =true;
//email phone number is optional
if (isset($_POST['email'])  &&  $_POST['phnum']  )
{
	$email = $_POST['email'];
	$phnum = $_POST['phnum'];
}



//Signup required username, Password, First Name, Last Name, Street, City, State, and zip code
if (isset($_POST['username'])  &&  $_POST['pwd']   && $_POST['pwd2']
 && $_POST['addr']
 && $_POST['states']
 && $_POST['city']
 && $_POST['zip']
 && $_POST['fname']
 && $_POST['lname']     )
{
	$user = $_POST['username'];
	$pass = $_POST['pwd'];
	$pass1 = $_POST['pwd2'];
//	$email = $_POST['email'];
//	$phnum = $_POST['phnum'];
	$street = $_POST['addr'];
	$state = $_POST['states'];
	$city = $_POST['city'];


	$zip = $_POST['zip'];

	$fname = $_POST['fname'];
	$lname = $_POST['lname'];

	//use address to obtain lan lon
	$url_prefix = "https://maps.googleapis.com/maps/api/geocode/xml?address=";
	$address =urlencode ( str_replace(' ','+',$street).'+,'.str_replace(' ','+',$city).'+,'.$state);
	$api_key = "&key=AIzaSyCu4osXRbVK0yOZDZzLGab5RT4Li4JK3Wo";
	$google_api_url = $url_prefix.$address.$api_key;
	$str = file_get_contents($google_api_url);
#echo $str;
	$xml = simplexml_load_string($str);

#print_r($xml);
	$lat = floatval ($xml->result->geometry->location->lat);
	$long = floatval ($xml->result->geometry->location->lng);

	//password do not match, cannot sign up
	if($pass != $pass1) {echo "<script type='text/javascript'>alert('Both password do not match')</script>"; $valid=false;}

}
else

{ echo "<script type='text/javascript'>alert('Signup required username, Password, First Name, Last Name, Street, City, State, and zip code. please sign up again')</script>";; $valid = false;}
//some filed is emty cannot log in





if($valid == true)
{
	//sql to check if usrname is already exist in database or not, return the how many of this username is already exist in databse
	$sql1 = "SELECT USRNAME, COUNT(*) AS CNT FROM G14USERINFO where USRNAME = '$user' Group By USRNAME";
	$query1 = oci_parse($connection,$sql1);
	oci_define_by_name($query1, 'CNT',$cnt);
	oci_execute($query1);
	// must use this to execute and fetch variable, variable should be capital
	while ($row=oci_fetch_assoc($query1)) {
	}
	
	if(oci_num_rows($query1) > 0)
	{
		echo "<script type='text/javascript'>alert('username is already exist, please choose another username and sign up agian')</script>";
	}
	else
	{
		//assign
		$sql="select MAX(USRID) AS useridm from G14USERINFO";
		$query = oci_parse($connection,$sql);
		oci_define_by_name($query, 'USERIDM',$cnt);
		
		oci_execute($query);
		while ($row=oci_fetch_assoc($query)) {
		    $useridm=$row['USERIDM'];
		}
		$useridm=$useridm+1;
//		$sql="Insert into G14USERINFO values('$useridm','$pass','$fname','$lname','$iurl','$street','$zip','$user','$gen','$date','$level','$usersince','$city','$state')";
		$sql="Insert into G14USERINFO values('$useridm','c','$user','$pass','$email','$phnum','$street','$city','$state','$zip','$lat','$long')";
		$query = oci_parse($connection,$sql);
		oci_execute($query);

		$sql2="Insert into G14CUSTOMER values('$useridm','$lname','$fname')";
		$query2 = oci_parse($connection,$sql2);
		oci_execute($query2);
					
		if(!$query)
		{
		  echo "Failed ".oci_error();
		}
		else
		{
		  //echo "Successful";
	  	  //set cookie with userid, userid is unique
		  //Done, commenting it out for time being
		  //setcookie("user",$useridm, time()+3600);
		  echo "<script type='text/javascript'>alert('You have successfully signed up.')</script>";


			$sql1 = "SELECT * FROM G14USERINFO WHERE USRNAME = '$user'";
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



			echo "<script type='text/javascript'>window.location.replace('LogInIndex.php');</script>";

//			echo"<form id=info action='signin.php'  method='post'>";
//			echo"<input id='username' name='username' type='hidden' value=' $user' >";
//			echo"<input id='pwd' name='pwd' type='hidden' value=' $pass' >";
//
// echo"</form>";



		  
		}
		oci_free_statement($query);
	}
	oci_free_statement($query1);
}
echo "<script type='text/javascript'>window.location.replace('index.html');</script>";
oci_close($connection);
?>