<html>  

<head>  
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
<script src="http://libs.baidu.com/jquery/2.0.0/jquery.js"></script>
<script type="text/javascript" src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script> 
<script>
$(document).ready(function(){
  // 对浏览器的UserAgent进行正则匹配，不含有微信独有标识的则为其他浏览器
  var useragent = navigator.userAgent;
  if (useragent.match(/MicroMessenger/i) != 'MicroMessenger') {
  // 这里警告框会阻塞当前页面继续加载
  alert('已禁止本次访问：您必须使用微信内置浏览器访问本页面！');
  // 以下代码是用javascript强行关闭当前页面
  var opened = window.open('about:blank', '_self');
  opened.opener = null;
  opened.close();
  }else{
  }
  
  function onBridgeReady() {
WeixinJSBridge.call('hideOptionMenu');
}


if (typeof WeixinJSBridge == "undefined") {
if (document.addEventListener) {
document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
} else if (document.attachEvent) {
document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
}
} else {
onBridgeReady();
}

});
</script>

<title>免费ss账号</title>  
<meta http-equiv="refresh" content="0.1;url=http://www.free-ss.site">

</body>  
</html>
