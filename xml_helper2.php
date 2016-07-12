<?php
$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

$connection = oci_connect("my1","My4114510" , "//oracle.cise.ufl.edu/orcl");
if (!$connection){
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}
// store the brandid's name
//$state_request = $_REQUEST['state'];
//$top_request = $_REQUEST['top'];
//$brandname = $_REQUEST['brandname'];
$bussid = isset($_GET['id'])?$_GET['id']:13696;
$stid = oci_parse($connection,
                    'SELECT LAT, LON
                     FROM G14USERINFO
                     WHERE USRID = :target_id');
oci_bind_by_name($stid, ':target_id', $bussid);
$r = oci_execute($stid);
if(!$r){
    $e = oci_error($stid);
    trigger_error(htmlentities($e['message'], ENT_QUOTES),E_USER_ERROR);
}
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
    $buss_lat = $row['LAT'];
    $buss_lon  = $row['LON'];
}
//var_dump($buss_lat);
//var_dump($buss_lon);
oci_free_statement($stid);

// prepare the statement

// echo "$sql_str\n";
header("Content-type: text/xml");

// query center
$node = $dom->createElement("marker");
$newnode = $parnode->appendChild($node);
$newnode->setAttribute("usrid", $bussid);
$newnode->setAttribute("type", '0');
$newnode->setAttribute("lat", $buss_lat);
$newnode->setAttribute("lng", $buss_lon);

// query fast food provider
$stid = oci_parse($connection,
           "SELECT U.USRID, BRANDID, LAT, LON
            FROM G14USERINFO U, G14RESTAURANT R
            WHERE (LAT > :target_lat - 0.3 AND LAT < :target_lat + 0.3)
            and (LON > :target_lon - 0.3 and LON < :target_lon + 0.3)
            and (LON != :target_lon and LAT != :target_lat)
            and USRTYPE = 'b'
            and U.USRID = R.USRID");
oci_bind_by_name($stid, ':target_lat', $buss_lat);
oci_bind_by_name($stid, ':target_lon', $buss_lon);
$r = oci_execute($stid);
if(!$r){
    $e = oci_error($stid);
    trigger_error(htmlentities($e['message'], ENT_QUOTES),E_USER_ERROR);
}
//fetch the results of the query
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
    //print_r ($row);
    $node = $dom->createElement("marker");
    $newnode = $parnode->appendChild($node);
    $newnode->setAttribute("usrid", $row['USRID']);
    $newnode->setAttribute("type", $row['BRANDID']);
    $newnode->setAttribute("lat", $row['LAT']);
    $newnode->setAttribute("lng", $row['LON']);
}
oci_free_statement($stid);

// query customer
$stid = oci_parse($connection,
    "SELECT U.USRID, LAT, LON
            FROM G14USERINFO U
            WHERE (LAT > :target_lat - 0.3 AND LAT < :target_lat + 0.3)
            and (LON > :target_lon - 0.3 AND LON < :target_lon + 0.3)
            and USRTYPE = 'c'");
oci_bind_by_name($stid, ':target_lat', $buss_lat);
oci_bind_by_name($stid, ':target_lon', $buss_lon);
$r = oci_execute($stid);
if(!$r){
    $e = oci_error($stid);
    trigger_error(htmlentities($e['message'], ENT_QUOTES),E_USER_ERROR);
}
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
    //print_r ($row);
    $node = $dom->createElement("marker");
    $newnode = $parnode->appendChild($node);
    $newnode->setAttribute("usrid", $row['USRID']);
    $newnode->setAttribute("type", '11');
    $newnode->setAttribute("lat", $row['LAT']);
    $newnode->setAttribute("lng", $row['LON']);
}
oci_close($connection);
oci_free_statement($stid);
echo $dom->saveXML();
?>