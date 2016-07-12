<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
session_start();

echo"<head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";


if(!isset($_SESSION['username'])){
    echo "<script type='text/javascript'>alert('You must login in first!')</script>";
//setcookie("user",$id, time()+3600);
    echo "<script type='text/javascript'>window.location.replace('homepage.php');</script>";
}


$usrID = $_GET['usrID'];
$brandID = $_GET['BRANDID'];
$brandName =$_GET['BRANDNAME'];
$bussID =$_GET['BUSSID'];
$DELIVERY_DIST =$_GET['DELIVERY_DIST'];
$openTime =$_GET['openTime'];
echo"
    <title>".$brandName."</title>
    <link rel='stylesheet' type='text/css' href='header.css'>
    <link rel='stylesheet' type='text/css' href='restaurant.css'>
    <style TYPE='text/css'>
body {
	/*font-family:sans-serif;*/
	font-family: Tahoma, sans-serif;
	background-repeat: repeat;
	margin: 0 0 0 0;
	color:black;

}
</style>

</head>

<body>";?>
<div id="header">
    <div id="headerBar">WhoCares</div>
    <!--    <div style='display: none'>-->

    <!--<!--                --><?php
    if(!isset($_SESSION['username'])){
        ?>

        <div id="headerRight"> <button type="button" onclick="{location.href='mypage.php'}">Sign Up</button> </div>
        <div id="headerRight"> <button type="button" onclick="{location.href='cart.php'}">Sign In</button> </div>
        <div id="headerRight"> <button style="width: 130px;" type="button" onclick="{location.href='homepage.php'}">Home Page</button> </div>
        <?php
    } else{
        ?>
        <div id="headerRight"> <button type="button" onclick="{location.href='logout.php'}">Log out</button> </div>
        <div id="headerRight"> <button type="button" onclick="{location.href='mypage.php'}">My Page</button> </div>
        <div id="headerRight"> <button type="button" onclick="{location.href='myCart.php'}">Cart</button> </div>
        <div id="headerRight"> <button style="width: 130px;" type="button" onclick="{location.href='homepage.php'}">Home Page</button> </div>
        <?php
    }
    ////      ?>

    <!--    </div>-->
</div>
<!--<div>-->
<?php

echo"
<div>
    <div style='width:auto; height: 100%; margin-right: 10px''>";


$connection = oci_connect($username = 'my1',
    $password = 'My4114510',
    $connection_string = '//oracle.cise.ufl.edu/orcl');



    $sql1 = "SELECT ITEMPRICE,ITEMSIZE,ITEMNAME,ITEMID FROM G14MENU WHERE BRANDID='$brandID' AND ITEMID IN

    (select DISHID FROM (select dishid, sum (DISHQUANTITY)as total from g14order where BUSSID='$bussID' group by dishid order by total desc)
    WHERE ROWNUM <=3)";

    $query1 = oci_parse($connection,$sql1);
    oci_execute($query1);
    $nrows1 = oci_fetch_all($query1, $res1);


    //$sql = "select ITEMCATG,itemname,itemsize,itemprice from g14menu where brandid ='$brandID' group by ITEMCATG,itemname,itemsize,itemprice ";
    $sql = "select ITEMCATG from g14menu where brandid ='$brandID' group by ITEMCATG order by ITEMCATG asc";

    $query = oci_parse($connection,$sql);
    oci_execute($query);
    $nrows = oci_fetch_all($query, $res);
    echo "<div id='intro'>
            <table>
                <tr><td id='name'>".$brandName;
    echo"</td><td><table id='opendist'>
                        <tr><td>Opening Time:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $openTime A.M</td></tr>
                        <tr><td>Delivery distance: $DELIVERY_DIST Miles</td></tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>";
    echo"<div id='BS'>Best Seller</div>";
    echo"<div id='menulist'>
            <dl id='dlstyle'>";
    echo"<form method='get' action='myCart.php'>";

//print top3
$array3 = array();
    for($i1=0; $i1 <= $nrows1-1; $i1++) {
        $itemname = $res1['ITEMNAME'][$i1];
        $ITEMSIZE = $res1['ITEMSIZE'][$i1];
        $ITEMPRICE = $res1['ITEMPRICE'][$i1];
        $itemid = $res1['ITEMID'][$i1];
        $array3[]=$itemid;


        echo"<dt><a><label id ='labelx'><input name='color[]' type='checkbox' value=".$itemid."><span>".$itemname."</span>";
        echo"<span id=i2>".$ITEMSIZE."</span>";
        echo"<span id=i3>$&nbsp;".$ITEMPRICE."</span></label>\n";
        echo"<span id=i4>QTY:&nbsp;<select name='qua[]'>
            <option></option>
            <option value='1'>1</option>
            <option value='2'>2</option>
            <option value='3'>3</option>
            <option value='4'>4</option>
            <option value='5'>5</option>
            <option value='6'>6</option>
            <option value='7'>7</option>
            <option value='8'>8</option>
            <option value='9'>9</option>

            </select></span>\n";
    }
    if($nrows1=0)
    {
        $array3[]=-1;
        $array3[]=-1;
        $array3[]=-1;
    }
else if ($nrows1=1){


        $array3[]=-1;
        $array3[]=-1;

}
else if ($nrows1=2){
    $array3[]=-1;

}

    echo"</dl></div>";
    ?>


          <div id='menu'>Menu</div>
        <div id='menulist'>
            <dl id='dlstyle'>

    <?php
    for($i=0; $i <= $nrows-1; $i++) {
        $ITEMCATG = $res['ITEMCATG'][$i];
//        echo '<br/>';
//        echo '<br/>';
//        echo $ITEMCATG;
//        echo '<br/>';
//        echo '<br/>';
        $sql1 = "select itemid,itemname,itemsize,itemprice from g14menu  where itemid not in ($array3[0],$array3[1],$array3[2]) and brandid ='$brandID'and ITEMCATG=q'$$ITEMCATG$' group by itemname,itemsize,itemprice,itemid order by itemname asc,itemsize desc,itemprice asc";
//        $sql1 = "select itemid,itemname,itemsize,itemprice from g14menu where itemid not in(SELECT ITEMID FROM G14MENU WHERE BRANDID='$brandID' AND ITEMID IN(select DISHID FROM (select dishid, sum (DISHQUANTITY)as total from g14order where BUSSID='$bussID' group by dishid order by total desc)
//    WHERE ROWNUM <=3))
// and brandid ='$brandID'and ITEMCATG=q'$$ITEMCATG$' group by itemname,itemsize,itemprice,itemid order by itemname asc,itemsize desc,itemprice asc";




        $query1 = oci_parse($connection,$sql1);
        oci_execute($query1);
        $nrows1 = oci_fetch_all($query1, $res1);
        echo"<dt onClick=ShowFLT(".$i.",".$nrows1.")><a href='javascript:;'>";
        echo $ITEMCATG."</a></dt>\n";
        for($i1=0; $i1 <= $nrows1-1; $i1++) {
            $itemname = $res1['ITEMNAME'][$i1];
            $itemsize = $res1['ITEMSIZE'][$i1];
            $itemprice = $res1['ITEMPRICE'][$i1];
            $itemid = $res1['ITEMID'][$i1];

//    if($itemid==$array3[0] ||$itemid==$array3[1]||$itemid==$array3[2])
//    {
//
//    }



            echo"<dd id=LM".$i.$i1." style='DISPLAY: none'><div id ='item'>

                 <label id =labelx><input name='color[]' type='checkbox' value=".$itemid."><span id=i1>".$itemname."</span>";
            echo"<span id=i2>".$itemsize."</span>";
            echo"<span id=i3>$&nbsp;".$itemprice."</span></label>";
            echo"<span id=i4>QTY:&nbsp;<select name='qua[]'>
 <option></option>
            <option value='1'>1</option>
            <option value='2'>2</option>
            <option value='3'>3</option>
            <option value='4'>4</option>
            <option value='5'>5</option>
                        <option value='6'>6</option>
            <option value='7'>7</option>
            <option value='8'>8</option>
            <option value='9'>9</option>
            </select></span></div></dd>\n";
        }

    }
//    <option value='QTY' selected='selected' disabled='disabled'></option>

    $sql3="select MAX(ORDERID) AS useridm from G14ORDER";
    $query3 = oci_parse($connection,$sql3);
    oci_define_by_name($query3, 'USERIDM',$cnt);

    oci_execute($query3);
    while ($row=oci_fetch_assoc($query3)) {
        $useridm=$row['USERIDM'];
    }
    $useridm=$useridm+1;

?>


    <input id="brandID" name="brandID" type="hidden" value="<?php echo $brandID?>" >
    <input id="bussID" name="bussID" type="hidden" value="<?php echo $bussID?>" >
    <input id="orderid" name="orderid" type="hidden" value="<?php echo $useridm?>" >
        <div id ='atc'><button type='submit'>Add to Cart</button></div>
        </dl></div>
        </form>





        </div>
<!--    </div>-->

    </div>
<script>
    var number=5;

    function LMYC() {
        var lbmc;
        for (i=1;i<=number;i++) {
            lbmc = eval('LM' + i);
            lbmc.style.display = 'none';
        }
    }

    function ShowFLT(i,num) {
        for (j=0;j<num;j++) {
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

</body>
</html>
