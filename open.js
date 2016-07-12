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
    //sHeight=document.body.scrollHeight;
    if (sHeight<screen.height){sHeight=screen.height;}
    document.getElementById("loginbg").style.width = sWidth + "px";
    document.getElementById("loginbg").style.height = sHeight + "px";
    document.getElementById("loginbg").style.display = "block";
    document.getElementById("loginbg").style.display = "block";
    document.getElementById("loginbg").style.transitionDuration="0.4s";
    document.getElementById("loginbg").style.right = document.getElementById("login").offsetLeft + "px";
}/**
 * Created by herron on 4/18/16.
 */
