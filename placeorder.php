<?php
/**
 * Created by PhpStorm.
 * User: qw
 * Date: 4/15/2016
 * Time: 7:37 PM
 */

//$orderid= $_GET['orderid'];
$userid= $_GET['userid'];
$nitem= $_GET['nitem'];




$connection = oci_connect($username = 'my1',
    $password = 'My4114510',
    $connection_string = '//oracle.cise.ufl.edu/orcl');

if (!$connection) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

//    $sql5="select MAX(ORDERID) AS CARTORDERID5 from G14ORDER";
//    $query5 = oci_parse($connection,$sql5);
//    oci_define_by_name($query5, 'CARTORDERID5',$maxorder);
//
//    oci_execute($query5);
//    oci_fetch($query5);
//$maxinsert=0;
//$maxinsert=$maxorder+1;
//
//$sql4="update (SELECT * FROM G14CART WHERE CUSTID='$userid') set orderid='$maxinsert'";
//$query4 = oci_parse($connection,$sql4);
//oci_execute($query4);

date_default_timezone_set('america/new_york');
$ordertime= date('d/m/Y H:i:s');


$sql3="update (SELECT * FROM G14CART WHERE CUSTID='$userid') set ordertime=to_date('$ordertime','DD/MM/YYYY HH24:MI:SS')";
$query3 = oci_parse($connection,$sql3);
oci_execute($query3);


$sql="INSERT INTO G14ORDER SELECT * FROM G14CART WHERE CUSTID=$userid";
$query = oci_parse($connection,$sql);
oci_execute($query);


$sql2="DELETE from G14CART WHERE CUSTID=$userid";
$query2 = oci_parse($connection,$sql2);
oci_execute($query2);

if($nitem==0)
{
    echo "<script type='text/javascript'>alert('your cart is empty go to homepage now ')</script>";

    echo "<script type='text/javascript'>window.location.replace('LogInIndex.php');</script>";
}
else
{
    echo "<script type='text/javascript'>alert('you success place order! going to mypage now')</script>";

    echo "<script type='text/javascript'>window.location.replace('mypage.php');</script>";
}

?>