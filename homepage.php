<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<?php
//ini_set('session.save_path',getcwd(). '/');
session_start();

if (isset($_GET['street'])){
    $street = $_GET['street'];
    $city = $_GET['city'];
    $state = $_GET['states'];
    setcookie("mystreet","$street");
    setcookie("mycity","$city");
    setcookie("mystate","$state");
} else{
    $street = $_COOKIE["mystreet"];
    $city = $_COOKIE["mycity"];
    $state = $_COOKIE["mystate"];
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HomePage</title>
    <link rel="stylesheet" type="text/css" href="header.css">
    <link rel="stylesheet" type="text/css" href="homepage.css">
    <link rel="stylesheet" type="text/css" href="layout.css">
    <link rel="stylesheet" type="text/css" href="sort.css">
    <script type="text/javascript" src="open.js"></script>
    <style TYPE="text/css">
        body {
            font-family:Tahoma, sans-serif;
            background-color: #FF9966;
            background-repeat: repeat;
            margin: 0 0 0 0;}
    </style>
</head>
<body>
<div id="header">
    <div id="headerBar">WhoCares</div>
<!--    <div style='display: none'>-->

        <!--<!--                --><?php
    if(!isset($_SESSION['username'])){
        ?>

        <div id="headerRight"> <button type="button" onclick="{location.href='index.html'}">Sign Up</button> </div>
        <div id="headerRight"> <button type="button" onclick="{location.href='index.html'}">Sign In</button> </div>
        <?php
    } else{
        ?>
        <div id="headerRight"> <button type="button" onclick="{location.href='logout.php'}">Log out</button> </div>
        <div id="headerRight"> <button type="button" onclick="{location.href='mypage.php'}">My Page</button> </div>
        <div id="headerRight"> <button type="button" onclick="{location.href='myCart.php'}">Cart</button> </div>
        <?php
    }
    ////      ?>

<!--    </div>-->
</div>
<div>
    <div id="right">
        <div  style="margin:0 0 0 200px; background-color: white">
            <div id="searchbar">
        <form class="form-search" name="CreateAddress"   action="homepage.php" method="get"  >
            <div class="input-append">
              <table >
                <tr>
                    <td><li id="Sstates">
                        <form style="margin:0; display: inline;">
                            <select name="states" style="font-size: 20px; width:150px;height:30px">
                                <option value="states" selected="selected" disabled="disabled">States</option>
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
                        </form>
                        </li>
                    </td>
                    <td><input id="Scity" name="city" type="test" placeholder="    City"/></td>
                    <td><input id="Saddr" name="street" type="test" placeholder="    Address"/></td>
                    <td><button class="btnx" type="submit" style="margin-left: 40px">Find Food</button></td>
                </tr>
              </table>
            </div>
        </form>
            </div>

            <div id="restlist" style="background-color:white; width:100%;height:auto">
                <?php
//                $street = $_GET['street'];
//                $city = $_GET['city'];
//                $state = $_GET['states'];

                if (isset($_GET['mc'])) {

                    $mc=$_GET['mc'];
                } else $mc=0;

                if (isset($_GET['bk']))
                {
                    $bk=$_GET['bk'];
                } else $bk=0;

                if (isset($_GET['ph']))
                {
                    $ph=$_GET['ph'];
                } else $ph=0;

                if (isset($_GET['tb']))
                {
                    $tb=$_GET['tb'];
                } else $tb=0;

                if (isset($_GET['we']))
                {
                    $we=$_GET['we'];
                } else $we=0;

                if (isset($_GET['kf']))
                {
                    $kf=$_GET['kf'];
                } else $kf=0;

                if (isset($_GET['ji']))
                {
                    $ji=$_GET['ji'];
                } else $ji=0;

                if (isset($_GET['ha']))
                {
                    $ha=$_GET['ha'];
                } else $ha=0;

                if (isset($_GET['cf']))
                {
                    $cf=$_GET['cf'];
                } else $cf=0;

                if (isset($_GET['in']))
                {
                    $in=$_GET['in'];
                } else $in=0;

                if($mc==0&&$bk==0&&$ph==0&&$tb==0&&$we==0&&$kf==0&&$ji==0&&$ha==0&&$cf==0&&$in==0)
                {
                    $mc=1;
                    $bk=2;
                    $ph=3;
                    $tb=4;
                    $we=5;
                    $kf=6;
                    $ji=7;
                    $ha=8;
                    $cf=9;
                    $in=10;
                }

                if(isset($_GET['RATE'])){
                    $rateValue=$_GET['RATE'];
                } else $rateValue=0;

                if(isset($_GET['DISTANCE'])){
                    $distanceValue=$_GET['DISTANCE'];
                } else $distanceValue=0;

                if(isset($_GET['SALE'])){
                    $saleValue=$_GET['SALE'];
                } else $saleValue=0;

                if(isset($_GET['NAME'])){
                    $nameValue=$_GET['NAME'];
                } else $nameValue=0;



                $url_prefix = "https://maps.googleapis.com/maps/api/geocode/xml?address=";
                $address =urlencode ( str_replace(' ','+',$street).'+,'.str_replace(' ','+',$city).'+,'.$state);
                $api_key = "&key=AIzaSyCu4osXRbVK0yOZDZzLGab5RT4Li4JK3Wo";
                $google_api_url = $url_prefix.$address.$api_key;
                $str = file_get_contents($google_api_url);
                #echo $str;
                $xml = simplexml_load_string($str);

                $lat = floatval ($xml->result->geometry->location->lat);
                $lon = floatval ($xml->result->geometry->location->lng);

                $connection = oci_connect($username = 'my1',
                                          $password = 'My4114510',
                                          $connection_string = '//oracle.cise.ufl.edu/orcl');

                $sql = "select BUSSID, DELIVERY_DIST,ANNOUNCEMENT,BRANDID,USRID,BRANDNAME, OPENTIME, CLOSETIME, ADDRESS, CITY, STATE, ZIPCODE, RATE,LAT,LON,SALE
                        from g14brandname natural join G14RESTAURANT natural join g14userinfo, (select bussid,avg(rating)as RATE, count(DISTINCT ORDERID) AS SALE from g14order GROUP BY bussid)
                        WHERE (brandid='$mc'or brandid='$bk'or brandid='$ph'or brandid='$tb'or brandid='$we'or brandid='$kf'or brandid='$ji'or brandid='$ha'or brandid='$cf'or brandid='$in')
                         and USRID = BUSSID AND  USRTYPE='b' AND LAT > '$lat'-0.1 AND LAT < '$lat'+0.1 AND LON> '$lon'-0.1 AND LON< '$lon'+0.1";

                //sort by rate
                if($rateValue==1){
                    $sql = "select BUSSID, DELIVERY_DIST, ANNOUNCEMENT,BRANDID,USRID,BRANDNAME, OPENTIME, CLOSETIME, ADDRESS, CITY, STATE, ZIPCODE,RATE,LAT,LON,SALE
                            from g14brandname natural join G14RESTAURANT natural join g14userinfo, (select bussid,avg(rating)as RATE , count(DISTINCT ORDERID) AS SALE from g14order GROUP BY bussid)
                            WHERE (brandid='$mc'or brandid='$bk'or brandid='$ph'or brandid='$tb'or brandid='$we'or brandid='$kf'or brandid='$ji'or brandid='$ha'or brandid='$cf'or brandid='$in')
                            and USRID = BUSSID AND  USRTYPE='b' AND LAT > '$lat'-0.1 AND LAT < '$lat'+0.1 AND LON> '$lon'-0.1 AND LON< '$lon'+0.1
                            order by RATE DESC";
                }

                //sort by distance
                if($distanceValue==1){
                    $sql = "select BUSSID, DELIVERY_DIST,ANNOUNCEMENT,BRANDID,USRID,BRANDNAME, OPENTIME, CLOSETIME, ADDRESS, CITY, STATE, ZIPCODE,RATE,LAT,LON,SALE
                            from g14brandname natural join G14RESTAURANT natural join g14userinfo, (select bussid,avg(rating)as RATE, count(DISTINCT ORDERID) AS SALE from g14order GROUP BY bussid)
                            WHERE (brandid='$mc'or brandid='$bk'or brandid='$ph'or brandid='$tb'or brandid='$we'or brandid='$kf'or brandid='$ji'or brandid='$ha'or brandid='$cf'or brandid='$in')
                            and USRID = BUSSID AND  USRTYPE='b' AND LAT > '$lat'-0.1 AND LAT < '$lat'+0.1 AND LON> '$lon'-0.1 AND LON< '$lon'+0.1
                            order by ((LAT-'$lat')*(LAT-'$lat')+(LON-'$lon')*(LON-'$lon')) ASC";

                }

                //sort by sale
                if($saleValue==1){
                    $sql = "select BUSSID,DELIVERY_DIST,ANNOUNCEMENT,BRANDID,USRID,BRANDNAME, OPENTIME, CLOSETIME, ADDRESS, CITY, STATE, ZIPCODE,RATE,LAT,LON, SALE
                        from g14brandname natural join G14RESTAURANT natural join g14userinfo, (select bussid,avg(rating)as RATE, count(DISTINCT ORDERID) AS SALE from g14order GROUP BY bussid)
                        WHERE (brandid='$mc'or brandid='$bk'or brandid='$ph'or brandid='$tb'or brandid='$we'or brandid='$kf'or brandid='$ji'or brandid='$ha'or brandid='$cf'or brandid='$in')
                         and USRID = BUSSID AND  USRTYPE='b' AND LAT > '$lat'-0.1 AND LAT < '$lat'+0.1 AND LON> '$lon'-0.1 AND LON< '$lon'+0.1
                         ORDER BY SALE DESC";
                }

                //sort by name
                if($nameValue==1){
                    $sql = "select BUSSID,DELIVERY_DIST,ANNOUNCEMENT,BRANDID,USRID,BRANDNAME, OPENTIME, CLOSETIME, ADDRESS, CITY, STATE, ZIPCODE,RATE,LAT,LON,SALE
                            from g14brandname natural join G14RESTAURANT natural join g14userinfo, (select bussid,avg(rating)as RATE, count(DISTINCT ORDERID) AS SALE from g14order GROUP BY bussid)
                            WHERE (brandid='$mc'or brandid='$bk'or brandid='$ph'or brandid='$tb'or brandid='$we'or brandid='$kf'or brandid='$ji'or brandid='$ha'or brandid='$cf'or brandid='$in')
                            and USRID = BUSSID AND  USRTYPE='b' AND LAT > '$lat'-0.1 AND LAT < '$lat'+0.1 AND LON> '$lon'-0.1 AND LON< '$lon'+0.1
                            order by BRANDNAME ASC ";
                }


                $query = oci_parse($connection,$sql);
                oci_execute($query);

                $nrows = oci_fetch_all($query, $res);

                /*
                  show pages: first page, previous page, next page,last page
                  */
                // numbers of pages
                $pages = intval($nrows/10);
                if($nrows % 10){
                    $pages++;
                }
                // pageNumber
                if(isset($_GET['PAGENUM'])){
                    $pagenum = $_GET['PAGENUM'];
                }
                else{
                    $pagenum = 1;
                }

                // choose how to sort the results
                echo"<div id='sort' style='display: block; margin-right: 10px'><section id='sortby'>Sort By</section>";
                echo"<section class='ff-container'>

                    <input id='select-type-all' name='radio-set-1' type='radio' class='ff-selector-type-all' checked='checked' />
                    <label for='select-type-0' class='ff-label-type-0'>
                     <a href='homepage.php?street=$street & city=$city & states=$state & mc=$mc&bk=$bk&ph=$ph&tb=$tb&we=$we&kf=$kf&ji=$ji&ha=$ha&cf=$cf&in=$in
                        &RATE=1'>Rate</a></label>

                    <input id='select-type-1' name='radio-set-1' type='radio' class='ff-selector-type-1' />
                    <label for='select-type-1' class='ff-label-type-1'>
                     <a href='homepage.php?street=$street & city=$city & states=$state & mc=$mc&bk=$bk&ph=$ph&tb=$tb&we=$we&kf=$kf&ji=$ji&ha=$ha&cf=$cf&in=$in
                        &DISTANCE=1'>Distance</a></label>

                    <input id='select-type-2' name='radio-set-1' type='radio' class='ff-selector-type-2' />
                    <label for='select-type-2' class='ff-label-type-2'>
                      <a href='homepage.php?street=$street & city=$city & states=$state & mc=$mc&bk=$bk&ph=$ph&tb=$tb&we=$we&kf=$kf&ji=$ji&ha=$ha&cf=$cf&in=$in
                         &SALE=1'>Sale</a></label>

                    <input id='select-type-3' name='radio-set-1' type='radio' class='ff-selector-type-3' />
                    <label for='select-type-3' class='ff-label-type-3'>
                     <a href='homepage.php?street=$street & city=$city & states=$state & mc=$mc&bk=$bk&ph=$ph&tb=$tb&we=$we&kf=$kf&ji=$ji&ha=$ha&cf=$cf&in=$in
                         &NAME=1'>Name</a></label>
                </section>

</div>";
                echo "<div  id='total'> ";
                echo $nrows." Restaurants In Total.";

                echo "<span style='float:right;'>Total $pages Pages</span>";
                echo "<span style='float:right;padding:2px;'> | </span>";
                // last page
                echo "<span style='float:right;'>
                       <a href='homepage.php?street=$street & city=$city & states=$state & PAGENUM=$pages & mc=$mc & bk=$bk & ph=$ph & tb=$tb & we=$we & kf=$kf & ji=$ji & ha=$ha & cf=$cf & in=$in
                       &RATE=$rateValue & DISTANCE=$distanceValue & SALE=$saleValue & NAME=$nameValue'>
                       Last Page</a></span>";

                //next page
                if($pagenum != $pages){
                    echo "<span style='float:right;padding:2px;'> | </span>";
                    $nextpage = $pagenum+1;
                    echo "<span style='float:right;'>
                           <a href='homepage.php?street=$street & city=$city & states=$state & PAGENUM=$nextpage & mc=$mc & bk=$bk & ph=$ph & tb=$tb & we=$we & kf=$kf & ji=$ji & ha=$ha & cf=$cf & in=$in
                           &RATE=$rateValue & DISTANCE=$distanceValue & SALE=$saleValue & NAME=$nameValue'>
                            Next Page</a></span>";
                }

                //Previous page
                if($pagenum != 1){
                    echo "<span style='float:right;padding:2px;'> | </span>";
                    $prepage = $pagenum-1;
                    echo "<span style='float:right;'>
                            <a href='homepage.php?street=$street & city=$city & states=$state & PAGENUM=$prepage & mc=$mc & bk=$bk & ph=$ph & tb=$tb & we=$we & kf=$kf & ji=$ji & ha=$ha & cf=$cf & in=$in
                            &RATE=$rateValue & DISTANCE=$distanceValue & SALE=$saleValue & NAME=$nameValue'>
                              Previous Page</a></span>";
                }
                echo "<span style='float:right;padding:2px;'> | </span>";

                // First page
                echo "<span style='float:right;'>
                           <a href='homepage.php?street=$street & city=$city & states=$state & PAGENUM=1 & mc=$mc & bk=$bk & ph=$ph & tb=$tb & we=$we & kf=$kf & ji=$ji & ha=$ha & cf=$cf & in=$in
                           &RATE=$rateValue & DISTANCE=$distanceValue & SALE=$saleValue & NAME=$nameValue'>
                              First Page</a></span>";
                echo "</div>";

                /*
                 * display every page's content
                 */
                echo "<hr>";
                // start number of tuples in a pagenum
                $offset = ($pagenum-1)*10;
                $maxcount = min(10, $nrows - $offset);   //number of tuples in a page
                for($i=$offset; $i < $offset + $maxcount; $i++){
                    $usrID=$res['USRID'][$i];
                    $brandName =$res['BRANDNAME'][$i];
                    $openTime = $res['OPENTIME'][$i];
                    $closeTime= $res['CLOSETIME'][$i];
                    $Street= $res['ADDRESS'][$i];
                    $City= $res['CITY'][$i];
                    $State= $res['STATE'][$i];
                    $zipCode= $res['ZIPCODE'][$i];
                    $Rate = number_format($res['RATE'][$i],2);
                    $brandID=$res['BRANDID'][$i];
                    $bussID=$res['BUSSID'][$i];
                    $DELIVERY_DIST=$res['DELIVERY_DIST'][$i];
                    $ANNOUNCEMENT=$res['ANNOUNCEMENT'][$i];
                    $Sale=$res['SALE'][$i];

                   // if(isset($_GET['DISTANCE'])){
                        $Blat=$res['LAT'][$i];
                        $Blon=$res['LON'][$i];
                        $dlat = floatval($Blat - $lat) * 3.14 / 180.;
                        $dlon = floatval($Blon - $lon) * 3.14 / 180.; //units: rad
                        $a = (sin($dlat/2.)**2 + cos($lat * 3.14/180.) * cos($Blat * 3.14/180.) * sin($dlon/2.)**2);
                        $c = 2. * atan2(sqrt($a), sqrt(1-$a));
                        $R =3961; //R:radius of the Earth 3961 miles
                        $Distance = number_format(floatval($R * $c ),2); // units: miles
                    //}


                    echo "<table id=cover>";
                    echo "<tr>";
                    echo "<td style='width: 210px;'>";
                    //display pic
                    echo "<div >
							<img class='summary-pic' src='brand_logo/$brandID.png' alt=''>
					      </div>";
                    echo"</td>";
                    echo"<td>";

                    //display restaurant name
                    echo "<div id=detail>

                            <span><a href='restaurant.php?usrID=$usrID  & BRANDID=$brandID & openTime=$openTime & DELIVERY_DIST=$DELIVERY_DIST& BUSSID=$bussID& BRANDNAME=$brandName'> $brandName</a></span>
                            <span>OpenTime: $openTime, CloseTime: $closeTime </span>							";
                    //display rating
                    $intRate = round($Rate);
                    echo "<p><span ><img src='$intRate.png' alt=''  align='top'/></span><span id=rate>Rate:".$Rate ."<span id=rate>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total Orders:".$Sale ;
                    echo"</span></p>";
                    //display address
                    echo"<div id=addr>";
                    echo "<h4>Address: </h4>";
                    echo "<span>$Street, $City, $State, $zipCode</span><br>";
                    echo "<h4>Distance:</h4>";
                    echo "<span>$Distance miles</span>";
                    echo"</div>";
                    echo "</div>";
//                    echo "</li>";
                    echo"</td>";
                    echo"</tr>";
                    echo "</table>";
                }

                ?>


            </div>
        </div>
    </div>

    <div id="left">

        <form class="form-search" name="CreateAddress"  method="get"  action="homepage.php"  >

            <div id="filter">
                <h1>Brand</h1>
                <div class="items">
                    <input id="mc" name="mc" type="checkbox" value="1">
                    <label for="mc">McDonalid's</label>

                    <input id="bk" name="bk" type="checkbox" value="2">
                    <label for="bk">Burger King</label>

                    <input id="ph" name="ph" type="checkbox" value="3">
                    <label for="ph">Pizza Hut</label>

                    <input id="tb" name="tb" type="checkbox" value="4">
                    <label for="tb">Taco Bell</label>

                    <input id="we" name="we" type="checkbox" value="5">
                    <label for="we">Wendy's</label>

                    <input id="kf" name="kf" type="checkbox" value="6">
                    <label for="kf">KFC</label>

                    <input id="ji" name="ji" type="checkbox" value="7">
                    <label for="ji">Jack in the Box</label>

                    <input id="ha" name="ha" type="checkbox" value="8">
                    <label for="ha">Hardee's</label>

                    <input id="cf" name="cf" type="checkbox" value="9">
                    <label for="cf">Chick-fil-A</label>

                    <input id="in" name="in" type="checkbox" value="10">
                    <label for="in">in-N-Out</label>

                    <input id="states" name="states" type="hidden" value="<?php echo $state?>" >
                    <input id="city" name="city" type="hidden" value="<?php echo $city?>" >
                    <input id="street" name="street" type="hidden" value="<?php echo $street?>" >

                    <h2 class="selected" aria-hidden="true">Selected</h2>
                    <h2 class="unselected" aria-hidden="true">Unselected</h2>
                </div>
            </div>
            <button class="btnx" type="submit" style="margin:10px auto auto 40px; ">Filter</button>
        </form>
    </div><!--end of left-->
</div>

<div id="restTable">
    <table>
        <tr>
            <td></td>
        </tr>
        </tr>
    </table>
</div>
</body>
</html>