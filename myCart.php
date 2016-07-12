<!DOCTYPE html>
<?php
session_start();

//?>
<HTML>
<!--==============================head=================================-->
<HEAD>
    <TITLE>MyPage</TITLE>
    <link rel="stylesheet" type="text/css" href="header.css">
    <link rel="stylesheet" type="text/css" href="mycart.css">
    <style TYPE="text/css">
        body {
            font-family:Tahoma, sans-serif;
            background-color: white;
            background-repeat: repeat;
            margin:  0 0 0 0;
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

        <div id="headerRight"> <button type="button" onclick="{location.href='index.php'}">Sign Up</button> </div>
        <div id="headerRight"> <button type="button" onclick="{location.href='index.php'}">Sign In</button> </div>
        <div id="headerRight"> <button style="width: 130px;" type="button" onclick="{location.href='LogInIndex.php'}">Home Page</button> </div>
        <?php
    } else{
        ?>
        <div id="headerRight"> <button type="button" onclick="{location.href='logout.php'}">Log out</button> </div>
        <div id="headerRight"> <button type="button" onclick="{location.href='mypage.php'}">My Page</button> </div>
        <div id="headerRight"> <button style="width: 130px;" type="button" onclick="{location.href='LogInIndex.php'}">Home Page</button> </div>
        <?php
    }
    ////      ?>

    <!--    </div>-->
</div>
<div id="content">
    <?php
    $connection = oci_connect($username = 'my1',
        $password = 'My4114510',
        $connection_string = '//oracle.cise.ufl.edu/orcl');



    if (!$connection) {
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    $userid=$_SESSION['userid'];

    if (isset($_GET['brandID']) &&isset($_GET['bussID']) &&isset($_GET['orderid']) ){
        $brandID= $_GET['brandID'];
        $bussID= $_GET['bussID'];
        $orderid= $_GET['orderid'];



//    date_default_timezone_set('america/new_york');
//    $addcarttime= date('d/m/Y H:i:s');



        $quai=0;
        $quan=0;
        $array = array();
        while((isset($_GET['qua'][$quai]))){

            if ($_GET['qua'][$quai]!=null)
            {
                $qua=$_GET['qua'][$quai];
                $array[]=$qua;
                $quan++;
            }
            $quai++;
        }

        $i=0;
        $tprice=0;



//    $sql4="select count(*) as CARTORDERID2 from G14cart";
//    $query4 = oci_parse($connection,$sql4);
//    oci_define_by_name($query4, 'CARTORDERID2',$numberofcart);
//
//    oci_execute($query4);
//    oci_fetch($query4);
//
//
//
//    if($numberofcart>0)
//    {
//        $sql3="select MAX(ORDERID) AS CARTORDERID from G14cart";
//        $query3 = oci_parse($connection,$sql3);
//        oci_define_by_name($query3, 'CARTORDERID',$cnt2);
//
//        oci_execute($query3);
//        oci_fetch($query3);
//        $cnt2=$cnt2+1;
//    }
//    else
//    {
//        $sql3="select MAX(ORDERID) AS CARTORDERID from G14ORDER";
//        $query3 = oci_parse($connection,$sql3);
//        oci_define_by_name($query3, 'CARTORDERID',$cnt2);
//
//        oci_execute($query3);
//        oci_fetch($query3);
//        $cnt2=$cnt2+1;
//    }

        $sql3="select MAX(ORDERID) AS CARTORDERID from G14CART";
        $query3 = oci_parse($connection,$sql3);
        oci_define_by_name($query3, 'CARTORDERID',$maxcart);

        oci_execute($query3);
        oci_fetch($query3);


        $sql5="select MAX(ORDERID) AS CARTORDERID5 from G14ORDER";
        $query5 = oci_parse($connection,$sql5);
        oci_define_by_name($query5, 'CARTORDERID5',$maxorder);

        oci_execute($query5);
        oci_fetch($query5);

        $maxinsert=0;


        if($maxcart==null or $maxcart<$maxorder)
        {
            $maxinsert=$maxorder+1;
        }
        else
        {
            $maxinsert=$maxcart+1;
        }


//    echo"<div id = 'fixinfo' style='margin-top: 10px;margin-bottom: 10px'><span style='margin:5px;' >My Cart</span></div>";
//
//    echo"<div id='orderdetail'>
//        <form id=info action='placeorder.php'  method='get'>
//            <table class='tg'>";
//    echo"  <tr>
//                    <td class='tg-mme0'>No.</td>
//                    <td class='tg-mme0'>DISH</td>
//                    <td class='tg-mme0'>PRICE</td>
//                    <td class='tg-mme0'>QTY</td>
//                </tr>";
        $itemi=0;

    while((isset($_GET['color'][$itemi]))) {
        $itemi++;

    }
//        echo $itemi;
//        echo "aaaaaa";
//        echo $quan;
        if($itemi==$quan){





        while((isset($_GET['color'][$i]))){

            $itemid=$_GET['color'][$i];

            $sql2="select ITEMPRICE,ITEMNAME from g14menu where brandid=$brandID and itemid=$itemid";
            $query2 = oci_parse($connection,$sql2);
            oci_define_by_name($query2, 'ITEMPRICE',$ITEMPRICE);
            oci_define_by_name($query2, 'ITEMNAME',$ITEMNAME);
            oci_execute($query2);
            $row=oci_fetch_assoc($query2);

//    $tprice=$tprice+$array[$i]*$ITEMPRICE;
//        echo"<tr> <td class='tg-175l'>".($i+1)."</td>";
//        echo"<td class='tg-175l'>".$ITEMNAME."</td>";
//        echo"<td class='tg-175l'>$".$ITEMPRICE."</td>";
//        echo"<td class='tg-175l' style='padding-left: 15px'>".$array[$i]."</td></tr>";

            $sql="INSERT INTO G14CART VALUES( '$maxinsert', $userid, $bussID, '$itemid', $array[$i], 'p',null, null, 'd',null,$array[$i]*$ITEMPRICE)";
//        $sql="INSERT INTO G14CART VALUES( null, $userid, $bussID, '$itemid', $array[$i], 'p',null, null, 'd',null,$array[$i]*$ITEMPRICE)";
//        echo  $sql;
            $query = oci_parse($connection,$sql);
            oci_execute($query);
            $i++;
        }
        }
        else
        {
            echo "<script type='text/javascript'>alert('the quantity you choose not match the number of item you place, return to homepage now')</script>";
            echo "<script type='text/javascript'>window.location.replace('LogInIndex.php');</script>";
            return;
        }

    }



    //print cart item

    $sqlOrder = "SELECT * FROM G14CART WHERE CUSTID='$userid' ";
    $query6 = oci_parse($connection,$sqlOrder);
    oci_execute($query6);

    $nrows=oci_fetch_all($query6,$res);

    echo"<div id = 'fixinfo' style='margin-top: 10px;margin-bottom: 10px'><span style='margin:5px 5px 5px 10px;' >My Cart</span></div>";

    echo"<div id='orderdetail'>
        <form id=info action='placeorder.php'  method='get'>
            <table class='tg'>";
    echo"  <tr>
                    <td class='tg-mme0'>No.</td>
                    <td class='tg-mme0'>DISH</td>
                    <td class='tg-mme0'>PRICE</td>
                    <td class='tg-mme0'>QTY</td>
                </tr>";
    $tprice=0;

    for($i=0; $i <= $nrows-1; $i++) {
        $userID = $res['CUSTID'][$i];
        $orderID = $res['ORDERID'][$i];
        $bussID = $res['BUSSID'][$i];
        $dishID = $res['DISHID'][$i];
        $DishQuantity = $res['DISHQUANTITY'][$i];
        $Status = $res['STATUS'][$i];
        $orderTime = $res['ORDERTIME'][$i];
        $DliveryTime = $res['DELIVERYTIME'][$i];
        $DeliveryMethod = $res['DELIVERYMETHOD'][$i];
        $Rating = $res['RATING'][$i];
//    $Price = $res['PRICE'][$i];

        //$tITEMPRICE indatabase is itemprice*quantity
        $tITEMPRICE = $res['PRICE'][$i];

        $ITEMPRICE=$tITEMPRICE/$DishQuantity;

        $sqlOrder = "SELECT ITEMNAME FROM G14CART c,G14RESTAURANT r,G14MENU m WHERE c.bussid='$bussID' and c.dishid='$dishID'  and r.USRID=c.bussid and  r.brandid=m.brandid and m.itemid=c.dishid";
//echo $sqlOrder;
        $query = oci_parse($connection,$sqlOrder);

        oci_define_by_name($query, 'ITEMNAME',$ITEMNAME);
        oci_execute($query);
        oci_fetch($query);
//    echo  $ITEMNAME;


        $tprice=$tprice+$DishQuantity*$ITEMPRICE;
        echo"<tr> <td style='margin-left: 10px' class='tg-175l'>".($i+1)."</td>";
        echo"<td class='tg-175l'>".$ITEMNAME."</td>";
        echo"<td class='tg-175l'>$".$ITEMPRICE."</td>";
        echo"<td class='tg-175l' style='padding-left: 15px'>".$DishQuantity."</td></tr>";



//    echo"  itemname: ".$ITEMNAME;
//    echo"  quantity: ".$DishQuantity;
//    echo"  price: ".$Price;
    }






    echo"  <tr>
                  <td class='tg-71kt' ></td>
                  <td class='tg-71kt' style='text-align: right'>TOTAL:</td>
                  <td class='tg-71kt' >$".$tprice."</td>
                  <td class='tg-rb70' ></td></tr></table>";
//    echo"<input id='orderid' name='orderid' type='hidden' value=' $orderid' >";
    echo"<input id='userid' name='userid' type='hidden' value=' $userid' >";
    echo"<input id='nitem' name='nitem' type='hidden' value=' $nrows' >";
    echo"
        <input class=update type='submit' style='margin-left: 62%' value='Place Order' />";
    echo"<a href='LogInIndex.php?userid=$userid'><span id='ep'>Empty cart</span></a>";
//    echo"<input onclick='{location.href='LogInIndex.php?userid=$userid'}' class=update style='margin-left: 5%' value='Empty cart' />";



?>
<!--    <input onclick="{location.href='LogInIndex.php?userid=$userid'}" class=update style='margin-left: 5%' value='Empty cart' />-->

    <?php
    echo"
    </form>
</div>";

    ?>
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
            var elements2 = form.elements;
            for (var j = 0, length = elements.length; i < length-1; ++j) {
                elements2[i].readOnly = true;
                elements2[i].style.borderBottom="1px solid transparent";
            }
            document.getElementById("status").value="Edit";
            document.getElementById("status").style.width="200px";
            document.getElementById("status").style.height="30px";
            document.getElementById("status").type="text";
        }


    }

</script>

</HTML>