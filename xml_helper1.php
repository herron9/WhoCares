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
$value = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : null;
if ($value == "GET") {
    $top_val = $_GET["top"];
    $brand_abbre = $_GET["brandname"];
    $state_abbre = $_GET["state"];
    $past_month = $_GET["pastmonth"];
}
else{
    $top_val = "10";
    $brand_abbre = 'All';
    $state_abbre = 'All';
    $past_month = "0";
}

$brandid_array = array();
$brandname_array = array(); //key(brandid) -> value(brandfullname)
$sql_str = "SELECT * FROM G14BRANDNAME";
$stid = oci_parse($connection, $sql_str);
$r = oci_execute($stid);
if(!$r){
    $e = oci_error($stid);
    trigger_error(htmlentities($e['message'], ENT_QUOTES),E_USER_ERROR);
}
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
    $brd_fullname = $row['BRANDNAME'];
    $brd_id  = $row['BRANDID'];
    $brd_abbre = strtolower($brd_fullname[0]);
    $brandname_array[$brd_id] = $brd_fullname;
    $brandid_array[$brd_abbre] = $brd_id;
}
oci_free_statement($stid);

// prepare the statement
$nest1_sql_str = "SELECT ROWNUM RANKINFO, TOP_RESULTS.BUSSID, ORDERNUM, REVENUE, G14_R1.BRANDID, G14_R1.OPENTIME, G14_R1.CLOSETIME,
                    G14_U1.ADDRESS, G14_U1.PHONENUM, G14_U1.LAT, G14_U1.LON
                    FROM G14RESTAURANT G14_R1, G14USERINFO G14_U1, (";
$nest2_sql_str = "       SELECT * FROM (";
$nest3_sql_str = "       SELECT G14_O3.BUSSID, COUNT(DISTINCT  ORDERID) ORDERNUM, SUM(G14_O3.PRICE) REVENUE
                         FROM G14ORDER G14_O3, G14USERINFO G14_U3, G14RESTAURANT G14_R3";
$nest3_where_filter = "  WHERE G14_O3.BUSSID = G14_U3.USRID AND G14_U3.USRID = G14_R3.USRID";
if($state_abbre != 'All'){
    $nest3_where_filter .= " AND UPPER(G14_U3.STATE) = '" . $state_abbre ."'";
}
if($brand_abbre != "All"){
    $nest3_where_filter .= " AND G14_R3.BRANDID =" . $brandid_array[$brand_abbre];
}
if($past_month != "0") { // time limit is checked
    $start_time = date("d/m/Y H:i:s", time() - (30 * 24 * 60 * 60) * floatval($past_month));
    //echo "$start_time\n";
    // to_date function in oracle 
    $time_query_limit = " AND ORDERTIME >= to_date('" . $start_time . "', 'DD/MM/YYYY HH24:MI:SS')";
    $nest3_where_filter .= $time_query_limit;
   // echo "$time_query_limit\n";
}

$nest3_group_st = " GROUP BY G14_O3.BUSSID";
$nest3_order_st = " ORDER BY ORDERNUM DESC)";
$nest2_where_filter = " WHERE ROWNUM <=" . $top_val.") TOP_RESULTS";
$nest1_where_filter = " WHERE G14_R1.USRID = TOP_RESULTS.BUSSID AND TOP_RESULTS.BUSSID = G14_U1.USRID";


$sql_str = $nest1_sql_str . $nest2_sql_str. $nest3_sql_str. $nest3_where_filter . $nest3_group_st . $nest3_order_st . $nest2_where_filter . $nest1_where_filter;
// echo "$sql_str\n";
$stid = oci_parse($connection, $sql_str);
//perform the logic of the query
$r = oci_execute($stid);
if(!$r){
    $e = oci_error($stid);
    trigger_error(htmlentities($e['message'], ENT_QUOTES),E_USER_ERROR);
}
//fetch the results of the query
header("Content-type: text/xml");
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
    //print_r ($row);
    $node = $dom->createElement("marker");
    $newnode = $parnode->appendChild($node);
    $newnode->setAttribute("rank", $row['RANKINFO']);
    $newnode->setAttribute("id", $row['BUSSID']);
    $newnode->setAttribute("name", $brandname_array[$row['BRANDID']]);
    $newnode->setAttribute("ordernum", $row['ORDERNUM']);
    $newnode->setAttribute("revenue", $row['REVENUE']);
    $newnode->setAttribute("opentime", $row['OPENTIME']);
    $newnode->setAttribute("closetime", $row['CLOSETIME']);
    //$newnode->setAttribute("delivery_distance", $row['DELIVERY_DIST']);
    $newnode->setAttribute("phone_number", $row['PHONENUM']);
    $newnode->setAttribute("address", $row['ADDRESS']);
    $newnode->setAttribute("lat", $row['LAT']);
    $newnode->setAttribute("lng", $row['LON']);
    //$newnode->setAttribute("type", "bar");
    //$newnode->setAttribute("brand", $brandname_array[$row['BRANDID']]);
}
oci_free_statement($stid);
oci_close($connection);
echo $dom->saveXML();
?>