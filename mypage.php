<!DOCTYPE html>
<?php
session_start();

if(!isset($_SESSION['username'])){
    echo "<script type='text/javascript'>alert('You must login in first!')</script>";
    //setcookie("user",$id, time()+3600);
    echo "<script type='text/javascript'>window.location.replace('index.html');</script>";
}
?>
<HTML>
<!--==============================head=================================-->
<HEAD>
<TITLE>MyPage</TITLE>
    <link rel="stylesheet" type="text/css" href="header.css">
<link rel="stylesheet" type="text/css" href="mypage.css">
<style TYPE="text/css">
    body {
    font-family:Tahoma, sans-serif;
	background-color: white;
	background-repeat: repeat;
        margin: 0 0 0 0 ;
	color:black;
    }
</style>
</HEAD>
<BODY>
<div id="header" style="margin-bottom: 10px">
    <div id="headerBar">WhoCares</div>
    <!--    <div style='display: none'>-->

    <!--<!--                --><?php
    if(!isset($_SESSION['username'])){
        ?>

        <div id="headerRight"> <button type="button" onclick="{location.href='index.html'}">Sign Up</button> </div>
        <div id="headerRight"> <button type="button" onclick="{location.href='index.html'}">Sign In</button> </div>
        <div id="headerRight"> <button style="width: 130px;" type="button" onclick="{location.href='homepage.php'}">Home Page</button> </div>
        <?php
    } else{
        ?>
        <div id="headerRight"> <button type="button" onclick="{location.href='logout.php'}">Log out</button> </div>
        <div id="headerRight"> <button type="button" onclick="{location.href='myCart.php'}">Cart</button> </div>
        <div id="headerRight"> <button style="width: 130px;" type="button" onclick="{location.href='LogInIndex.php'}">Home Page</button> </div>
        <?php
    }
    ////      ?>

    <!--    </div>-->
</div>
<div id="content" style="float: left">
    <?php
    if(isset($_SESSION['username'])){
        $userID = $_SESSION['userid'];
        $userType = $_SESSION['usertype'];
        $userName = $_SESSION['username'];
        $email = $_SESSION['email'];
        $phone = $_SESSION['phonenum'];
        $address = $_SESSION['address'];
        $city = $_SESSION['city'];
        $state = $_SESSION['state'];
        $zipCode = $_SESSION['zipcode'];

        $connection = oci_connect($username = 'my1',
            $password = 'My4114510',
            $connection_string = '//oracle.cise.ufl.edu/orcl');

        if (!$connection) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        if(isset($_GET['Lname'])){
            $LName=$_GET['Lname'];
            $FName=$_GET['Fname'];
            $email=$_GET['Email'];
            $phone=$_GET['Phone'];
            $address=$_GET['Address'];
            $city=$_GET['city'];
            $state=$_GET['State'];
            $zipCode=$_GET['Zipcode'];

            $sqlUpdate1="UPDATE G14CUSTOMER SET LNAME='$LName',FNAME='$FName' WHERE USRID='$userID'";
            $queryU1 = oci_parse($connection,$sqlUpdate1);
            oci_execute($queryU1);

            $sqlUpdate2="UPDATE G14USERINFO
                         SET EMAIL='$email',PHONENUM='$phone',ADDRESS='$address',CITY='$city',STATE='$state',ZIPCODE='$zipCode'
                         WHERE USRID='$userID'";
            $queryU2 = oci_parse($connection,$sqlUpdate2);
            oci_execute($queryU2);

            $sql2="SELECT EMAIL,PHONENUM,ADDRESS,CITY,STATE,ZIPCODE FROM G14USERINFO WHERE USRID='$userID'";
            $query2 = oci_parse($connection,$sql2);
            oci_define_by_name($query2, 'EMAIL',$Email);
            oci_define_by_name($query2, 'PHONENUM',$Phone);
            oci_define_by_name($query2, 'ADDRESS',$Address);
            oci_define_by_name($query2, 'CITY',$City);
            oci_define_by_name($query2, 'STATE',$State);
            oci_define_by_name($query2, 'ZIPCODE',$Zipcode);
            oci_execute($query2);
            oci_fetch($query2);
            $email=$Email;
            $phone=$Phone;
            $address=$Address;
            $city=$City;
            $state=$State;
            $zipCode=$Zipcode;
        }

        $sql = "SELECT LNAME , FNAME FROM G14CUSTOMER WHERE USRID='$userID'";
        $query = oci_parse($connection,$sql);
        oci_define_by_name($query, 'LNAME',$lname);
        oci_define_by_name($query, 'FNAME',$fname);
        oci_execute($query);
        oci_fetch($query);
            $LName=$lname;
            $FName=$fname;

        echo"<div id = 'fixinfo'><span style='margin:5px' >Username:</span><span id='rspan'>".$userName."</span></div>";
        echo"<div id = 'fixinfo' style='margin-bottom: 10px'><span style='margin:5px' >UserID:</span><span id='rspan'>".$userID."</span></div>";
        echo"<div id='changeinfo'>
        <form id=info action='mypage.php' method='get'>
        <table class='tg'>";
        echo"<tr>
                <td class='tg-2vcv'>Last Name</td>";
        echo"<td class='tg-tpy8'><input type='text' name='Lname' readonly='readonly'value='".$LName."'/></td></tr>";
        echo"   <tr>
                    <td class='tg-wuq2'>First Name</td>
                    <td class='tg-npbf'><input type='text' name='Fname' readonly='readonly' value='".$FName."'/></td>
                </tr>";
        echo"   <tr>
                    <td class='tg-2vcv'>Email</td>
                    <td class='tg-ppkh'><input type='text' name='Email' readonly='readonly' value='".$email."'/></td>
                </tr>";
        echo"                <tr>
                    <td class='tg-wuq2'>Phone</td>
                    <td class='tg-npbf'><input type='text' name='Phone' readonly='readonly' value='".$phone."'/></td>
                </tr>";
        echo"                <tr>
                    <td class='tg-yrv3'>Address</td>
                    <td class='tg-7x9q'><input type='text' name='Address' readonly='readonly' value='".$address."'/></td>
                </tr>";
        echo"                <tr>
                    <td class='tg-wuq2'>City</td>
                    <td class='tg-npbf'><input type='text' name='city' readonly='readonly' value='".$city."'/></td>
                </tr>";
        echo"   <tr>
                    <td class='tg-yrv3'>State</td>
                    <td class='tg-7x9q'><input type='text' name='State' readonly='readonly' value='".$state."'/></td>
                </tr>";
        echo"   <tr>
                    <td class='tg-wuq2'>Zip Code</td>
                    <td class='tg-npbf'><input type='text' name='Zipcode' readonly='readonly' value='".$zipCode."'/></td>
                </tr>";
        echo" </table>
            <input id=status onclick='update()' class=update style='margin-left: 35%' value='Edit' readonly='readonly'/>
        </form>
    </div>";


    } else {
        echo "<script type='text/javascript'>alert('You must login in first!')</script>";
        //setcookie("user",$id, time()+3600);
        echo "<script type='text/javascript'>window.location.replace('index.html');</script>";
    }
    ?>
</div>
<div id="right">
    <div id='inner'>
        <div id = 'fixinfo' style="margin-left: 0; padding-left: 10px"><span >Order</span></div>

        <?php

        // get the rate array updated
        if((isset($_GET['rate'][0]))) {
            $k=0;
            $RateArray = array();
            while ((isset($_GET['rate'][$k]))) {
                $RateArray[] =$_GET['rate'][$k];
                //echo $RateArray[$k];
                $k++;
            }

            $sqlUpdater1="SELECT DISTINCT ORDERID,ORDERTIME,BUSSID FROM G14ORDER WHERE CUSTID='$userID' ORDER BY ORDERTIME DESC " ;
            $queryU1 = oci_parse($connection,$sqlUpdater1);
            oci_execute($queryU1);
            $orderRows =oci_fetch_all($queryU1,$resU1);

            $n=0;
            for($j=0; $j <= $orderRows-1; $j++) {
                $orderID = $resU1['ORDERID'][$j];
                $bussID = $resU1['BUSSID'][$j];

                $sqlUpdater2 = "select CUSTID,DISHID FROM G14ORDER WHERE CUSTID='$userID' AND ORDERID='$orderID'";
                $queryU2 = oci_parse($connection, $sqlUpdater2);
                oci_execute($queryU2);
                $nrows = oci_fetch_all($queryU2, $resU2);

                for ($i = 0; $i <= $nrows - 1; $i++) {
                    $dishID = $resU2['DISHID'][$i];
                    //echo $RateArray[$n];
                    $sqlRate="UPDATE G14ORDER SET RATING='$RateArray[$n]' WHERE CUSTID='$userID' AND ORDERID='$orderID' AND DISHID='$dishID' ";
                    $queryU3 = oci_parse($connection, $sqlRate);
                    oci_execute($queryU3);
                    $n=$n+1;

                }
            }

        }
        echo"<div id='menulist'>
             <dl id='dlstyle' ><form id='rateform' action='mypage.php' method='get'>";
        $sqlOrder="SELECT DISTINCT ORDERID,BUSSID,STATUS,ORDERTIME, TO_CHAR(ORDERTIME, 'MON-DD-YYYY HH24:MI:SS') TIME_STR,DELIVERYTIME,DELIVERYMETHOD, BRANDNAME,RATE
                   FROM G14ORDER,G14BRANDNAME, G14RESTAURANT,( SELECT ORDERID order1, AVG(RATING) RATE FROM G14ORDER GROUP BY ORDERID )
                   WHERE CUSTID='$userID' AND G14BRANDNAME.BRANDID=G14RESTAURANT.BRANDID AND G14RESTAURANT.USRID=G14ORDER.BUSSID AND ORDERID=order1
                   ORDER BY ORDERTIME DESC " ;
        $query1 = oci_parse($connection,$sqlOrder);
        oci_execute($query1);
        $orderRows =oci_fetch_all($query1,$res1);

        for($j=0; $j <= $orderRows-1; $j++) {
            $orderID = $res1['ORDERID'][$j];
            $bussID = $res1['BUSSID'][$j];
            $Status = $res1['STATUS'][$j];
            $orderTime = $res1['TIME_STR'][$j];
            $DeliveryTime = $res1['DELIVERYTIME'][$j];
            $BrandName=$res1['BRANDNAME'][$j];
            $AVGrate=number_format($res1['RATE'][$j],2,'.','');

            $sqlDish = "select CUSTID,DISHQUANTITY,RATING,PRICE,ITEMNAME,DISHID
                        FROM   G14ORDER,G14MENU, G14RESTAURANT
                        WHERE  CUSTID='$userID' AND ORDERID='$orderID' AND G14RESTAURANT.USRID=G14ORDER.BUSSID AND G14RESTAURANT.BRANDID=G14MENU.BRANDID AND G14ORDER.DISHID=G14MENU.ITEMID ";
            $query2 = oci_parse($connection, $sqlDish);
            oci_execute($query2);
            $nrows = oci_fetch_all($query2, $res);
            echo "<dt onClick=ShowFLT(" . $j . "," . ($nrows+1) . ")><a href='javascript:;'>";
            echo "ID: ".$orderID ."
                 <span id=i5>&nbsp;Status:&nbsp;".$Status."</span>
                 <span id=i6>&nbsp;Rate:&nbsp;"."$AVGrate"."</span></a>
                 </dt>\n";
            echo "<dd id=LM" .$j . ($nrows) . " style='DISPLAY: none'><div id='item'>
                 <span id=i1>BrandName:".$BrandName."</span>
                 <span id=i2>&nbsp;OrderTime:&nbsp".$orderTime."</span>
                 <span id=i3>&nbsp;DlyTime:&nbsp".$DeliveryTime."min</span></div></dd>\n";
            echo "<dd id=LM" .$j . ($nrows+1) . " style='DISPLAY: none'><div id='item'><span id=i1>Dish</span>
                 <span id=i2>&nbsp;Price</span><span id=i3>&nbsp;QTY</span><span id=i4>&nbsp;Rate:</span></div></dd>\n";


            for ($i = 0; $i <= $nrows - 1; $i++) {
                $dishID = $res['DISHID'][$i];
                $DishQuantity = $res['DISHQUANTITY'][$i];
                $Rating = $res['RATING'][$i];
                $Price = $res['PRICE'][$i];
                $DisaName=$res['ITEMNAME'][$i];
                echo "<dd id=LM" . $j . $i . " style='DISPLAY: none'><div id='item'><span id=i1>" .$DisaName. "</span>";
                echo "<span id=i2>&nbsp;$" . $Price. "</span>";
                echo "<span id=i3>&nbsp;&nbsp;" . $DishQuantity . "</span>";
                echo "<span id=i4>&nbsp;<input id='rate' type='text' name='rate[]' readonly='readonly' value='".$Rating."'/></div></dd>\n";
            }
        }
                echo"</dl><input id='orders' onclick='updateorder()' class=update  value='Rate' style='margin-left: 35%' readonly='readonly'/>
               </form></div>";
        ?>

    </div>

</div>

</BODY>

<script>
    function update() {
        var flag=0;
        if(document.getElementById("status").value=="Edit"){
            var form = document.getElementById("info");
            var elements = form.elements;
            for (var i = 0, len = elements.length; i < len-1; ++i) {
                elements[i].readOnly = false;
                elements[i].style.borderBottom="1px solid black";
            }
            document.getElementById("status").value="Confirm";
            document.getElementById("status").style.width="206px";
            document.getElementById("status").style.height="36px";
            document.getElementById("status").type="submit";
        } else
        if(document.getElementById("status").value=="Confirm"){
            var form2 = document.getElementById("info");
            var elements2 = form2.elements;
            for (var j = 0, length = elements2.length; j < length-1; ++j) {
                elements2[j].readOnly = true;
                elements2[j].style.borderBottom="1px solid transparent";
            }
            document.getElementById("status").value="Edit";
            document.getElementById("status").style.width="206px";
            document.getElementById("status").style.height="36px";
            document.getElementById("status").type="submit";
        }


    }

    function updateorder() {
        var flag=0;
        if(document.getElementById("orders").value=="Rate"){
            var form = document.getElementById("rateform");
            var elements = form.elements;
            for (var i = 0, length = elements.length; i < length-1; ++i) {
                elements[i].readOnly = false;
                elements[i].style.borderBottom="1px solid black";
            }
            document.getElementById("orders").value="Confirm";
            document.getElementById("orders").style.width="206px";
            document.getElementById("orders").style.height="36px";
            document.getElementById("orders").type="submit";
        } else
        if(document.getElementById("orders").value=="Confirm"){
            var form2 = document.getElementById("info");
            var elements2 = form2.elements;
            for (var j = 0, lengthx = elements2.length; j < lengthx-1; ++j) {
                elements2[j].readOnly = true;
                elements2[j].style.borderBottom="1px solid transparent";
            }
            document.getElementById("orders").value="Rate";
            document.getElementById("orders").style.width="206px";
            document.getElementById("orders").style.height="36px";
            document.getElementById("orders").type="submit";
        }


    }


    function ShowFLT(i,num) {
        for (j=0;j<=num;j++) {
            var a=i.toString();
            var b=j.toString();
            lbmc = eval('LM' +a+b);
            if (lbmc.style.display == 'none') {
                lbmc.style.display = '';
            }
            else {
                lbmc.style.display = 'none';
            }
        }

    }
</script>

</HTML>