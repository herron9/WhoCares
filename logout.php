<?php
/**
 * Created by PhpStorm.
 * User: Universe_Lu
 * Date: 4/4/16
 * Time: 18:07
 */
	session_start();
	unset($_SESSION['username']);

unset($_SESSION['userid']);
unset($_SESSION['usertype']);
unset($_SESSION['email']);
unset($_SESSION['phonenum']);
unset($_SESSION['address']);
unset($_SESSION['city']);
unset($_SESSION['state']);
unset($_SESSION['zipcode']);
unset($_SESSION['lat']);
unset($_SESSION['lon']);


	header("Location:index.html");
