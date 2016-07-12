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
    <?php
    // define variables and set to empty values
    $state_post ="All";
    $top_number_post = "5";
    $brandname_post = "All";
    $pastmonth_post = "0";
    $value = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : null;
    if ($value == "POST") {
        $state_post = $_POST["state"];
        $top_number_post = $_POST["top"];
        $brandname_post = $_POST["brand"];
        $pastmonth_post = $_POST["past_months"];
        //$brandname_post = strtolower($brandname_post[0]);
    }
    $php_str = "?top=" . $top_number_post . "&brandname=" . $brandname_post
        . "&state=" . $state_post . "&pastmonth=" . $pastmonth_post;
    if($state_post != "All"){
        $url_prefix = "https://maps.googleapis.com/maps/api/geocode/xml?address=";
        $address =urlencode ($state_post);
        $api_key = "&key=AIzaSyCu4osXRbVK0yOZDZzLGab5RT4Li4JK3Wo";
        $google_api_url = $url_prefix.$address.$api_key;
        $str = file_get_contents($google_api_url);
        $xml = simplexml_load_string($str);

        $lat = floatval ($xml->result->geometry->location->lat);
        $lon = floatval ($xml->result->geometry->location->lng);
        echo "<script> var center = {lat: $lat, lng:$lon}; </script>\n";
        echo "<script> var zoomlevel = 7; </script>\n";

    }
    else{
        echo "<script> var center = {lat: 41.30, lng: -103.43}; </script>\n";
        echo "<script> var zoomlevel = 4; </script>\n";
    }
    echo "<script> var send_str = \"$php_str\"; </script>\n";
    ?>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <link rel="stylesheet" type="text/css" href="header.css">
    <link rel="stylesheet" type="text/css" href="manager.css">
    <title>Manager Page</title>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCu4osXRbVK0yOZDZzLGab5RT4Li4JK3Wo"></script>
    <script>
        //<![CDATA[
        //var labelIndex = 1;
        //var center = {lat: 41.30, lng: -103.43 }; //default center for us
        var customIcons = {
            restaurant: {
                icon: 'http://labs.google.com/ridefinder/images/mm_20_blue.png',
                shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
            },
            bar: {
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
            i: {icon: './brand_icon/10.png'}
        };
        function load() {
            var map = new google.maps.Map(document.getElementById("map"), {
                center: center,
                zoom: zoomlevel,
                mapTypeId: 'roadmap'
            });
            var infoWindow = new google.maps.InfoWindow;
            // Change this depending on the name of your PHP file
            downloadUrl("xml_helper1.php", function(data) {
                var xml = data.responseXML;
                var markers = xml.documentElement.getElementsByTagName("marker");
                for (var i = 0; i < markers.length; i++) {
                    var rank = markers[i].getAttribute("rank");
                    var id = markers[i].getAttribute("id")
                    var name = markers[i].getAttribute("name");
                    var ordernum = markers[i].getAttribute("ordernum");
                    var revenue = markers[i].getAttribute("revenue");
                    var address = markers[i].getAttribute("address");
                    var type = name.charAt(0).toLocaleLowerCase();
                    var point = new google.maps.LatLng(
                        parseFloat(markers[i].getAttribute("lat")),
                        parseFloat(markers[i].getAttribute("lng")));
                    var opentime = markers[i].getAttribute("opentime");
                    var closetime = markers[i].getAttribute("closetime");
                    var phone_number = markers[i].getAttribute("phone_number");
                    var html = '<div id="content">' +
                            '<b>Rank: ' + rank + '</b>'
                            + '<br/>brand:' + name
                            + '<br/>Order Number: ' + ordernum
                            + '<br/>Revenue: $' + revenue
                            + '<br/>Address: ' + address
                            + '<br/>Time: ' + opentime + '-' + closetime
                            + '<br/><a href="restaurant_order.php?id=' + id +'">Order History</a></div>';
                    var icon = customIcons[type] || {};
                    var marker = new google.maps.Marker({
                        map: map,
                        position: point,
                        icon: icon.icon
                    });
                    bindInfoWindow(marker, map, infoWindow, html);
                }
            });
        }
        function bindInfoWindow(marker, map, infoWindow, html) {
            google.maps.event.addListener(marker, 'click', function() {
                infoWindow.setContent(html);
                infoWindow.open(map, marker);
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
        //]]>
    </script>
</head>
<body onload="load()">

<?php
   // echo $GLOBALS['php_str'];
?>
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
<!--        <div id="headerRight"> <button type="button" onclick="{location.href='myCart.php'}">Cart</button> </div>-->
        <?php
    }
    ////      ?>

    <!--    </div>-->
</div>
<!--<div id ="header">-->
<!--    <h1>Geo-data analysis </h1>-->
<!--</div>-->
<div id = 'fixinfo' style=""><span >Geo-data analysis</span></div>
<div id ="nav">
    <form style="margin:0; display: inline;" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <select name="state" id="state">
            <option value="All" selected="selected">All States</option>
            <option value="AK">AK</option>
            <option value="AL">AL</option>
            <option value="AZ">AZ</option>
            <option value="AR">AR</option>
            <option value="CA">CA</option>
            <option value="CO">CO</option>
            <option value="CT">CT</option>
            <option value="DE">DE</option>
            <option value="DC">DC</option>
            <option value="FL">FL</option>
            <option value="GA">GA</option>
            <option value="HI">HI</option>
            <option value="ID">ID</option>
            <option value="IL">IL</option>
            <option value="IN">IN</option>
            <option value="IA">IA</option>
            <option value="KS">KS</option>
            <option value="KY">KY</option>
            <option value="LA">LA</option>
            <option value="ME">ME</option>
            <option value="MD">MD</option>
            <option value="MA">MA</option>
            <option value="MI">MI</option>
            <option value="MN">MN</option>
            <option value="MS">MS</option>
            <option value="MO">MO</option>
            <option value="MT">MT</option>
            <option value="NB">NB</option>
            <option value="NV">NV</option>
            <option value="NH">NH</option>
            <option value="NJ">NJ</option>
            <option value="NM">NM</option>
            <option value="NY">NY</option>
            <option value="NC">NC</option>
            <option value="ND">ND</option>
            <option value="OH">OH</option>
            <option value="OK">OK</option>
            <option value="OR">OR</option>
            <option value="PA">PA</option>
            <option value="PR">PR</option>
            <option value="RI">RI</option>
            <option value="SC">SC</option>
            <option value="SD">SD</option>
            <option value="TN">TN</option>
            <option value="TX">TX</option>
            <option value="UT">UT</option>
            <option value="VT">VT</option>
            <option value="VA">VA</option>
            <option value="VI">VI</option>
            <option value="WA">WA</option>
            <option value="WV">WV</option>
            <option value="WI">WI</option>
            <option value="WY">WY</option>
        </select>
        <script type="text/javascript">
            document.getElementById('state').value = "<?php echo $_POST['state'];?>";
        </script>
        <select name="top" id="top">
            <option value = "5" selected="selected">Top 5</option>
            <option value = "10">Top 10</option>
            <option value = "50">Top 50</option>
            <option value = "100">Top 100</option>
        </select>
        <script type="text/javascript">
            document.getElementById('top').value = "<?php echo $_POST['top'];?>";
        </script>
        <select name="brand" id="brand">
            <option value = "All" selected="selected">All Brands</option>
            <option value = "m">McDonald's</option>
            <option value = "b">Burger King</option>
            <option value = "p">Pizza Hut</option>
            <option value = "t">Taco Bell</option>
            <option value = "w">Wendy's</option>
            <option value = "k">KFC</option>
            <option value = "j">Jack in the Box</option>
            <option value = "h">Hadree's</option>
            <option value = "c">Chick-fil-A</option>
            <option value = "i">In-N-Out</option>
        </select>
        <script type="text/javascript">
            document.getElementById('brand').value = "<?php echo $_POST['brand'];?>";
        </script>
        <select name="past_months" id="past_months">
            <option value = "0" selected="selected">no time limit</option>
            <option value = "0.03333">past 1 day</option>
            <option value = "0.2333">past 1 week</option>
            <option value = "1">past 1 month</option>
            <option value = "3">past 3 months</option>
            <option value = "6">past 6 months</option>
            <option value = "12">past 1 year</option>
            <option value = "24">past 2 years</option>
            <option value = "60">past 5 years</option>
        </select>
        <script type="text/javascript">
            document.getElementById('past_months').value = "<?php echo $_POST['past_months'];?>";
        </script>
        <input type="submit" value="Update Search">
    </form>


    <?php
    /*echo "<br>";
    echo "state: $state <br>";
    echo "top: $top_number <br>";
    echo "brandid: $brandid <br>"; */
    ?>
</div>
<div id="map"></div>
<div id="footer">Copy Right @G14-COP5725 </div>
</body>
</html>