<!DOCTYPE html>
<?php
session_start();

if(!isset($_SESSION['username'])){
    echo "<script type='text/javascript'>alert('You must login in first!')</script>";
//setcookie("user",$id, time()+3600);
    echo "<script type='text/javascript'>window.location.replace('index.html');</script>";
}
?>
<html>
<head>
    <title>Analysis</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="header.css">
    <link rel="stylesheet" type="text/css" href="restA.css">
    <?php
    require_once('./libchart/libchart/classes/libchart.php');
    $conn = oci_connect("my1","My4114510" , "//oracle.cise.ufl.edu/orcl");
    if (!$conn){
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    $bussid = isset($_GET['id']) ? $_GET['id']:13696;
    $topnum = isset($_POST['top']) ? $_POST['top']: 10;

    $order_mon_chart = new VerticalBarChart(600, 300); // class from libchart
    $order_mon_dataSet = new XYDataSet();
    $order_hr_chart = new VerticalBarChart(600, 300); // class from libchart
    $order_hr_dataSet = new XYDataSet();
    /*$hour_array = array("00:00-01:00", "01:00-02:00",
        "02:00-03:00","03:00-04:00","04:00-05:00",
        "05:00-06:00","06:00-07:00","07:00-08:00",
        "08:00-09:00","09:00-10:00","10:00-11:00",
        "11:00-12:00","12:00-13:00","13:00-14:00",
        "14:00-15:00","15:00-16:00","16:00-17:00",
        "17:00-18:00","18:00-19:00","19:00-20:00",
        "20:00-21:00","21:00-22:00","22:00-23:00"); */

    $hour_array = array("00:00-01:00", "",
        "","03:00-04:00","",
        "","06:00-07:00","",
        "","09:00-10:00","",
        "","12:00-13:00","",
        "","15:00-16:00","",
        "","18:00-19:00","",
        "","21:00-22:00","", "");

    // retrieve the lat/lon info from db
    $stid = oci_parse($conn,
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
    oci_free_statement($stid);
// set the map center for the google map
    echo "<script> var center = {lat: $buss_lat, lng: $buss_lon}; </script>\n";
// set the _get link for xml_helper2.php
    $str = "?id=" . $bussid;
    echo "<script> var send_str = \"$str\"; </script>\n";
    ?>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCu4osXRbVK0yOZDZzLGab5RT4Li4JK3Wo"></script>
    <script>
        var type_ary = ['o','m','b','p','t','w','k','j','h','c','i','cus']
        var customIcons = {
            o: {
                icon: 'http://labs.google.com/ridefinder/images/mm_20_red.png',
                shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
            },
            m: {icon: './brand_icon/1.png'},
            b: {icon: './brand_icon/2.png'},
            p: {icon: './brand_icon/3.png'},
            t: {icon: './brand_icon/4.png'},
            w: {icon: './brand_icon/5.png'},
            k: {icon: './brand_icon/6.png'},
            j: {icon: './brand_icon/7.png'},
            h: {icon: './brand_icon/8.png'},
            c: {icon: './brand_icon/9.png'},
            i: {icon: './brand_icon/10.png'},
            cus:{icon: './brand_icon/11.png'}
        };

        var map;
        function load() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: center,
                zoom: 12
            });
            downloadUrl("xml_helper2.php", function(data) {
                var xml = data.responseXML;
                var markers = xml.documentElement.getElementsByTagName("marker");
                for (var i = 0; i < markers.length; i++) {
                    var id = markers[i].getAttribute("usrid");
                    var type = markers[i].getAttribute("type");
                    var point = new google.maps.LatLng(
                        parseFloat(markers[i].getAttribute("lat")),
                        parseFloat(markers[i].getAttribute("lng")));
                    var icon = customIcons[type_ary[type]] || {};
                    var marker = new google.maps.Marker({
                        map: map,
                        position: point,
                        icon: icon.icon
                    });
                }
            });
        }
        function downloadUrl(url, callback) {
            var request = window.ActiveXObject ?
                new ActiveXObject('Microsoft.XMLHTTP') :
                new XMLHttpRequest;
            request.onreadystatechange = function() {
                if (request.readyState == 4) {
                    request.onreadystatechange = doNothing;
                    callback(request, request.status);
                }
            };
            request.open('GET', url + send_str, true);
            request.send(null);
        }
        function doNothing() {}
    </script>
</head>


<body onload="load()">
<div id="header" style="margin-bottom: 10px">
    <div id="headerBar">WhoCares</div>
    <!--    <div style='display: none'>-->

    <!--<!--                --><?php
    if(!isset($_SESSION['username'])){
        ?>

        <div id="headerRight"> <button type="button" onclick="{location.href='index.php'}">Sign Up</button> </div>
        <div id="headerRight"> <button type="button" onclick="{location.href='index.php'}">Sign In</button> </div>
        <?php
    } else{
        ?>
        <div id="headerRight"> <button type="button" onclick="{location.href='logout.php'}">Log out</button> </div>
<!--        <div id="headerRight"> <button type="button" onclick="{location.href='mypage.php'}">My Page</button> </div>-->
        <?php
    }
    ////      ?>

    <!--    </div>-->
</div>
<div>
    <div id = 'fixinfo' style=""><span >Top 10 Dishes</span></div>
<!--    <h1>Top 10 Dishes</h1>-->
<table class='tg' style="width:50%">
    <tr>
        <th class='tg-mme0'>Dish Name</th>
        <th class='tg-mme0'>Dish Id</th>
        <th class='tg-mme0'>Sales</th>
    </tr>

    <?php

    // top dish info for table
        $stid = oci_parse($conn,
            'SELECT ITEMNAME, DISHID, DISHNUM
             FROM (SELECT *
                   FROM (SELECT DISHID, SUM(DISHQUANTITY) DISHNUM
                         FROM G14ORDER
                         WHERE BUSSID=:target_id
                         GROUP BY DISHID
                        ORDER BY SUM(DISHQUANTITY) DESC)
                         WHERE ROWNUM <= :top_num) DISHINFO, G14MENU
             WHERE DISHID = ITEMID AND
                   BRANDID = (SELECT BRANDID
                              FROM G14RESTAURANT
                              WHERE USRID = :target_id)
             Order by DISHNUM DESC');
            oci_bind_by_name($stid, ':target_id', $bussid);
            oci_bind_by_name($stid, ':top_num', $topnum);
            $r = oci_execute($stid);  // executes and commits

    if(!$r){
        $e = oci_error($stid);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    while($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){
        print "<tr>\n";
        foreach ($row as $item) {
            print "    <td class='tg-175l'>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
        }
        print "</tr>\n";
    }
    oci_free_statement($stid);

    // monthly order
    $stid = oci_parse($conn,
        'SELECT  extract(month from ORDERTIME) "Month",
             COUNT(DISTINCT ORDERID) ORDERNUM
     FROM    G14ORDER
     WHERE BUSSID=:target_id
     GROUP BY extract(month from ORDERTIME)');
    oci_bind_by_name($stid, ':target_id', $bussid);
    $r = oci_execute($stid);  // executes and commits
    if(!$r){
        $e = oci_error($stid);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    while($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
        $order_mon_dataSet->addPoint(new Point($row["Month"], $row["ORDERNUM"]));
    }
    $order_mon_chart->setDataSet($order_mon_dataSet);
    $order_mon_chart->setTitle("Monthly Sale Info");
    $order_mon_chart->render("order_monthlysale.png");
    oci_free_statement($stid);

    // hourly order info
    $stid = oci_parse($conn,
        'Select EXTRACT (HOUR FROM CAST(ORDERTIME AS TIMESTAMP)) "Hour", COUNT(DISTINCT ORDERID) ORDERNUM
     FROM G14ORDER
     WHERE BUSSID = :target_id
     GROUP BY EXTRACT (HOUR FROM CAST(ORDERTIME AS TIMESTAMP))');
    oci_bind_by_name($stid, ':target_id', $bussid);
    $r = oci_execute($stid);  // executes and commits
    if(!$r){
        $e = oci_error($stid);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    while($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
        $order_hr_dataSet->addPoint(new Point($hour_array[$row["Hour"]], $row["ORDERNUM"]));
    }
    $order_hr_chart->setDataSet($order_hr_dataSet);
    $order_hr_chart->setTitle("Hourly Sale Info");
    $order_hr_chart->render("order_hourlysale.png");
    oci_free_statement($stid);
    ?>

</table>
</div>
<div  id="pic" style="float: right">
<img src="order_monthlysale.png" alt="order month sale" height=300 width=600>
<img src="order_hourlysale.png" alt="order hourly sale" height=300 width=600>
</div>
    <div id="map"></div>
</body>
</html>

