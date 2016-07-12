<HTML>
<HEAD>
    <TITLE>WhoCares</TITLE>
    <!-- <link rel="shortcut icon" href="favicon.ico" /> -->
    <link rel="stylesheet" type="text/css" href="index.css">
    <style TYPE="text/css">
        body {
            font-family:Arial, Helvetica, sans-serif;
            background-color: #FF9966;
            background-repeat: repeat;
            margin: 0 0 0 0;
            color:black;

        }
    </style>
</HEAD>
<?php
if (isset($_GET['userid'])){
    $userid = $_GET['userid'];
    $connection = oci_connect($username = 'my1',
        $password = 'My4114510',
        $connection_string = '//oracle.cise.ufl.edu/orcl');

    if (!$connection) {
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
//    echo $userid;

    $sql2="DELETE from G14CART WHERE CUSTID=$userid";
//    echo $sql2;
    $query2 = oci_parse($connection,$sql2);
    oci_execute($query2);
}
?>
<body>
<div id="header">
    <div id="headerBar">WhoCares</div>
    <div id="headerRight"> <button type="button" onclick="{location.href='logout.php'}">Log out</button> </div>
    <div id="headerRight"> <button type="button" onclick="{location.href='mypage.php'}">My Page</button> </div>
    <div id="headerRight"> <button type="button" onclick="{location.href='myCart.php'}">Cart</button> </div>

</div>
<div id="content" >
    <div id="searchBlock">
        <form class="form-search" name="CreateAddress"   action="homepage.php" method="get" >
            <div class="input-append">
                <table style="width:400px; border-width:1px;" >
                    <tr>
                        <td><li id="Sstates">
                            <form style="margin:0; display: inline;">
                                <select name="states" style="font-size: 20px; width:150px;height:40px">
                                    <option value="states" selected="selected" disabled="disabled">State</option>
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
                        <td><input id="Szip" name="street" type="test" placeholder="    Street"/></td>
                        <!--<td><button class="btnx">Find Food</button></td>-->
                    </tr>
                </table>
                <input  class="btnx" id="FindFood" name = "findfood" type="submit" value="Find Food"/>
            </div>
        </form>

    </div>
</div>
</div>
<?php

$connection = oci_connect($username = 'my1',
    $password = 'My4114510',
    $connection_string = '//oracle.cise.ufl.edu/orcl');

if (!$connection) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

$sql2="select C1,C2,C3,C4,C5,C6 from (select count(*) as C1 from G14order),(select count(*) as C2 from G14USERINFO)
,(select count(*) as C3 from G14RESTAURANT),(select count(*) as C4 from G14MENU),(select count(*) as C5 from G14CUSTOMER),(select count(*) as C6 from G14CART)";
$query2 = oci_parse($connection,$sql2);
oci_define_by_name($query2, 'C1',$C1);
oci_define_by_name($query2, 'C2',$C2);
oci_define_by_name($query2, 'C3',$C3);
oci_define_by_name($query2, 'C4',$C4);
oci_define_by_name($query2, 'C5',$C5);
oci_define_by_name($query2, 'C6',$C6);
oci_execute($query2);
oci_fetch($query2);

echo"<div id='footer' style='font-size: 16px;margin: 10px 0 -10px 0'>The total tuples in database are ";
echo $C1+$C2+$C3+$C4+$C5+$C6;
echo"</div>";

//select C1,C2,C3,C4,C5 from (select count(*) as C1 from G14order),(select count(*) as C2 from G14USERINFO)
//,(select count(*) as C3 from G14RESTAURANT),(select count(*) as C4 from G14MENU),(select count(*) as C5 from G14CUSTOMER)

?>


<div id="footer" class="afooter"><BR>Website Designed by <a href="mailto:herong@ufl.edu">RR</a>  All Rights Reserved</div>

<script language="javascript">
    function open_login(){
        document.getElementById('loginbg').style.display='block';
        document.getElementById('login').style.display='block';
        showloginbg();
    }
    function create(){
        document.getElementById('loginbg').style.display='block';
        document.getElementById('create').style.display='block';
        showloginbg();
    }
    function close_login(){
        document.getElementById('loginbg').style.display='none';
        document.getElementById('login').style.display='none';
    }
    function close_create(){
        document.getElementById('loginbg').style.display='none';
        document.getElementById('create').style.display='none';
    }
    function showloginbg(){
        var sWidth,sHeight;ø
        sWidth = screen.width;
        sWidth = document.body.offsetWidth;
        sHeight=document.body.offsetHeight;
        if (sHeight<screen.height){sHeight=screen.height;}
        document.getElementById("loginbg").style.width = sWidth + "px";
        document.getElementById("loginbg").style.height = sHeight + "px";
        document.getElementById("loginbg").style.display = "block";
        document.getElementById("loginbg").style.display = "block";
        document.getElementById("loginbg").style.transitionDuration="0.4s";
        document.getElementById("loginbg").style.right = document.getElementById("login").offsetLeft + "px";
    }
    //	function logo_in(){alert()
    //		close_login();
    //	};
</script>
</body>
</HTML> 