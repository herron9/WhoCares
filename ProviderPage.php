<!DOCTYPE html>
<?php
session_start();

if(!isset($_SESSION['username'])){
    $userID = $_SESSION['userid'];
    echo "<script type='text/javascript'>alert('You must login in first!')</script>";
//setcookie("user",$id, time()+3600);
echo "<script type='text/javascript'>window.location.replace('index.html');</script>";
}
?>
<HTML>
<!--==============================head=================================-->
<HEAD>
    <TITLE>My Page</TITLE>
    <link rel="stylesheet" type="text/css" href="header.css">
    <link rel="stylesheet" type="text/css" href="pvpage.css">
    <style TYPE="text/css">
        body {
            font-family:Tahoma, sans-serif;
            background-color: white;
            background-repeat: repeat;
            margin: 0 0 0 0;
            color:black;
        }
    </style>
</HEAD>
<BODY>
<div id="header" style="margin-bottom: 10px">
    <div id="headerBar">WhoCares</div>
    <!--    <div style='display: none'>-->

    <!--<!--                -->
        <div id="headerRight"> <button type="button" onclick="{location.href='logout.php'}">Log out</button> </div>

    <!--    </div>-->
</div>
<div id="content" style="float: left;">
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

        $sql1="SELECT BRANDNAME,OPENTIME,CLOSETIME,DELIVERY_DIST
               FROM G14RESTAURANT, G14BRANDNAME
               WHERE G14BRANDNAME.BRANDID=G14RESTAURANT.BRANDID AND USRID='$userID'";
        $query1 = oci_parse($connection,$sql1);
        oci_define_by_name($query1, 'BRANDNAME',$BD);
        oci_define_by_name($query1, 'OPENTIME',$OTime);
        oci_define_by_name($query1, 'CLOSETIME',$CTime);
        oci_define_by_name($query1, 'DELIVERY_DIST',$dd);
        oci_execute($query1);
        oci_fetch($query1);
        $oTime=$OTime;
        $cTime=$CTime;
        $brandName=$BD;
        $DDist=$dd;


        if(isset($_GET['Email'])){
            $oTime=$_GET['Otime'];
            $cTime=$_GET['Ctime'];
            $DDist=$_GET['DDist'];
            $email=$_GET['Email'];
            $phone=$_GET['Phone'];
            $address=$_GET['Address'];
            $city=$_GET['city'];
            $state=$_GET['State'];
            $zipCode=$_GET['Zipcode'];

            //update G14restaurant
            $sqlUpdate1="UPDATE G14RESTAURANT SET OPENTIME='$oTime',CLOSETIME='$cTime',DELIVERY_DIST='$DDist' WHERE USRID='$userID'";
            $queryU1 = oci_parse($connection,$sqlUpdate1);
            oci_execute($queryU1);

            //update G14USERINFO
            $sqlUpdate2="UPDATE G14USERINFO
                         SET EMAIL='$email',PHONENUM='$phone',ADDRESS='$address',CITY='$city',STATE='$state',ZIPCODE='$zipCode'
                         WHERE USRID='$userID'";
            $queryU2 = oci_parse($connection,$sqlUpdate2);
            oci_execute($queryU2);

            //get new email,phone address,city, state,zipcode
            $sqlN2="SELECT EMAIL,PHONENUM,ADDRESS,CITY,STATE,ZIPCODE FROM G14USERINFO WHERE USRID='$userID'";
            $queryN2 = oci_parse($connection,$sqlN2);
            oci_define_by_name($queryN2, 'EMAIL',$Email);
            oci_define_by_name($queryN2, 'PHONENUM',$Phone);
            oci_define_by_name($queryN2, 'ADDRESS',$Address);
            oci_define_by_name($queryN2, 'CITY',$City);
            oci_define_by_name($queryN2, 'STATE',$State);
            oci_define_by_name($queryN2, 'ZIPCODE',$Zipcode);
            oci_execute($queryN2);
            oci_fetch($queryN2);
            $email=$Email;
            $phone=$Phone;
            $address=$Address;
            $city=$City;
            $state=$State;
            $zipCode=$Zipcode;

            // get new opentime, closetime, DDist
            $sqlN3="SELECT OPENTIME,CLOSETIME,DELIVERY_DIST FROM G14RESTAURANT WHERE USRID='$userID'";
            $queryN3 = oci_parse($connection,$sqlN3);
            oci_define_by_name($queryN3, 'OPENTIME',$OTime);
            oci_define_by_name($queryN3, 'CLOSETIME',$CTime);
            oci_define_by_name($queryN3, 'DELIVERY_DIST',$dd);
            oci_execute($queryN3);
            oci_fetch($queryN3);
            $oTime=$OTime;
            $cTime=$CTime;
            $DDist=$dd;
        }

        echo"<div id = 'fixinfo'><span style='margin:5px' >Brandname:</span><span id='rspan'>".$brandName."</span></div>";
        echo"<div id = 'fixinfo'><span style='margin:5px' >UserID:</span><span id='rspan'>".$userID."</span></div>";
        echo"<div id = 'fixinfo' style='margin-bottom: 10px'><span style='margin:5px' >Username:</span><span id='rspan'>$userName</span></div>";
echo"<div id='changeinfo'>
    <form id=info action='ProviderPage.php' method='get'>
        <table class='tg'>";
            echo"<tr>
                <td class='tg-2vcv'>Open Time</td>";
                echo"<td class='tg-tpy8'><input type='text' name='Otime' readonly='readonly'value='".$oTime."'/></td></tr>";
            echo"   <tr>
                <td class='tg-wuq2'>Close Time</td>
                <td class='tg-npbf'><input type='text' name='Ctime' readonly='readonly' value='".$cTime."'/></td>
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
            echo"   <tr>
                <td class='tg-yrv3'>Delivery Dist</td>
                <td class='tg-7x9q'><input type='text' name='DDist' readonly='readonly' value='".$DDist."'/></td>
            </tr>";
            echo" </table>
        <input id=status onclick='updateedit()'  class=update value='Edit' readonly='readonly'/>
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
        <div id = 'fixinfox' style="margin:0 0 10px 0;width: auto; padding-left: 10px;" onclick="{location.href='restaurant_order.php?id=<?php echo$userID ?>'}"><span >Analysis</span></div>
        <div id = 'fixinfo' style="margin:0 0 0 0;width: auto; padding-left: 10px"><span >Order</span></div>

        <?php

        //get the status and dly
        if((isset($_GET['status']))){
            $Status =$_GET['status'];
            $Dly =$_GET['dly'];
            $orderid=$_GET['orderID'];
            $sqlUpdater2 = "UPDATE G14ORDER SET STATUS='$Status', DELIVERYTIME='$Dly'
                                WHERE BUSSID='$userID' AND ORDERID='$orderid' ";
               $queryU2 = oci_parse($connection, $sqlUpdater2);
               oci_execute($queryU2);
        }


            // get the status and dly array updated
//        if((isset($_GET['status'][0]))) {
//            $k=0;
//            $StatusArray = array();
//            while ((isset($_GET['status'][$k]))) {
//                $StatusArray[] =$_GET['status'][$k];
//                //echo $StatusArray[$k];
//                $k++;
//            }
//
//            $l=0;
//            $DlyArray = array();
//            while ((isset($_GET['dly'][$l]))) {
//                $DlyArray[] =$_GET['dly'][$l];
//                //echo $DlyArray[$l];
//                $l++;
//            }
//
//
//            $sqlUpdater1="SELECT DISTINCT ORDERID,ORDERTIME FROM G14ORDER WHERE BUSSID='$userID' ORDER BY ORDERTIME DESC " ;
//            $queryU1 = oci_parse($connection,$sqlUpdater1);
//            oci_execute($queryU1);
//            $orderRows =oci_fetch_all($queryU1,$resU1);
//
//            $n=0;
//            for($j=0; $j <= $orderRows-1; $j++) {
//                $orderID = $resU1['ORDERID'][$j];
//                //$bussID = $resU1['BUSSID'][$j];
////                echo "1";
//                $sqlUpdater2 = "UPDATE G14ORDER SET STATUS='$StatusArray[$n]',DELIVERYTIME='$DlyArray[$n]'
//                                WHERE BUSSID='$userID' AND ORDERID='$orderID' ";
//                $queryU2 = oci_parse($connection, $sqlUpdater2);
//                oci_execute($queryU2);
////                echo "2";
//            }
//        }

        echo"<div id='menulist'>
            <dl id='dlstyle'>";
        $sqlOrder="SELECT DISTINCT ORDERID,CUSTID,STATUS,ORDERTIME,DELIVERYTIME,DELIVERYMETHOD,TO_CHAR(ORDERTIME, 'MON-DD-YYYY HH24:MI:SS') TIME_STR, RATE
                   FROM G14ORDER, ( SELECT ORDERID order1, AVG(RATING) rate FROM G14ORDER GROUP BY ORDERID )
                   WHERE BUSSID='$userID' AND ORDERID= order1
                   ORDER BY ORDERTIME DESC " ;
        $query1 = oci_parse($connection,$sqlOrder);
        oci_execute($query1);
        $orderRows =oci_fetch_all($query1,$res1);
        for($j=0; $j <= $orderRows-1; $j++) {
            $orderID = $res1['ORDERID'][$j];
            $custID = $res1['CUSTID'][$j];
            $Status = $res1['STATUS'][$j];
            $orderTime = $res1['TIME_STR'][$j];
            $DliveryTime = $res1['DELIVERYTIME'][$j];
            $DeliveryMethod = $res1['DELIVERYMETHOD'][$j];
            $AVGrate=number_format($res1['RATE'][$j],2);
           // $Rating = $res1['RATING'][$j];

            $sqlDish = "select DISHID,DISHQUANTITY,RATING,PRICE
                    FROM   G14ORDER
                    WHERE  BUSSID='$userID' AND ORDERID='$orderID' ";
            $query2 = oci_parse($connection, $sqlDish);
            oci_execute($query2);

            $nrows = oci_fetch_all($query2, $res);
        echo"<form id='pform".$j."' action='ProviderPage.php' method='get'>";
        echo "<dt onClick=ShowFLT(" . $j . "," . ($nrows+1) . ")><a href='javascript:;'>";
        echo "ID: ".$orderID ."
                 <span id=i5>Status:&nbsp;<input id='status' type='text' name='status' readonly='readonly' value='".$Status."'/></span>
                 <span><input id='porder".$j."' onclick='pupdate(".$j.")' class='po' value='Update' readonly='readonly'/>
                       <input id='orderID' type='hidden' name='orderID' value='".$orderID."' readonly='readonly'/>
                 </span>
                 <span id=i6>&nbsp;Rate:&nbsp;".$AVGrate."</span></a>
                 </dt>\n";
        echo "<dd id=LM" .$j . ($nrows) . " style='DISPLAY: none'><div id='item'>
                 <span id=i1>CustomerID:&nbsp".$custID."</span>
                 <span id=i2>OrderTime:".$orderTime."</span>
                 <span id=i3>&nbsp;Dly.Time:&nbsp<input id='dly' type='text' name='dly' readonly='readonly' value='".$DliveryTime."'/>min</span></div></dd></form>\n";

        echo "<dd id=LM" .$j . ($nrows+1) . " style='DISPLAY: none'><div id='item'><span id=i1>Dish</span>
                 <span id=i2>Price</span><span id=i3>&nbsp;QTY</span><span id=i4>&nbsp;Rate:</span></div></dd>\n";





            for ($i = 0; $i <= $nrows - 1; $i++) {
                $dishID = $res['DISHID'][$i];
                $DishQuantity = $res['DISHQUANTITY'][$i];
                $Rating = $res['RATING'][$i];
                $Price = $res['PRICE'][$i];
                echo "<dd id=LM" . $j . $i . " style='DISPLAY: none'><div id='item'><span id=i1>" . $dishID . "</span>";
                echo "<span id=i2>$" . $Price. "</span>";
                echo "<span id=i3>&nbsp;&nbsp;" . $DishQuantity . "</span>";
                echo "<span id=i4>&nbsp;".$Rating."</span></div></dd>\n";
            }
        }
        echo"</dl></div>";
        ?>

    </div>

</div>


</BODY>

<script>
    function updateedit() {
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
    function update() {
        var flag=0;
        if(document.getElementById("status").value=="Edit"){
            var a= j.toString();
            var form = document.getElementById('pform'+a);
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
            for (var i = 0, length = elements2.length; i < length-1; ++j) {
                elements2[i].readOnly = true;
                elements2[i].style.borderBottom="1px solid transparent";
            }
            document.getElementById("status").value="Edit";
            document.getElementById("status").style.width="206px";
            document.getElementById("status").style.height="36px";
            document.getElementById("status").type="submit";
        }
    }

    function pupdate(j) {
        var a= j.toString();
        if(document.getElementById("porder"+a).value=="Update"){
            var a= j.toString();
            var form = document.getElementById('pform'+a);
//            var form = document.getElementById("pform");
            var elements = form.elements;
            for (var x = 0, length = elements.length; x < length; x=x+3) {
                elements[x].readOnly = false;
                elements[x].style.borderBottom="1px solid black";
            }
            document.getElementById("porder"+a).value="Confirm";
//            document.getElementById("porder"+a).style.lineHeight="20px";
            document.getElementById("porder"+a).style.width="66px";
            document.getElementById("porder"+a).style.height="21px";
            document.getElementById("porder"+a).type="submit";
        } else
        if(document.getElementById("porder"+a).value=="Confirm"){
            var b= j.toString();
            var form2 = document.getElementById('pform'+b);
            var elements2 = form2.elements;
            for (var y = 0, lengthx = elements2.length; y < length; y=y+3) {
                elements2[y].readOnly = true;
                elements2[y].style.borderBottom="1px solid transparent";
            }
            document.getElementById("porder"+a).value="Update";
            document.getElementById("porder"+a).style.width="66px";
            document.getElementById("porder"+a).style.height="21px";
            document.getElementById("porder"+a).type="submit";
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