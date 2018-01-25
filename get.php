
<!DOCTYPE HTML>
<!--     各位大哥大姐，别研究本站代码啦，没什么好看的......     -->
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>免费上网账号</title>
    <style type="text/css">
        body {font-size:0.9rem;}
        div.container {margin:0 auto;min-width:760px;max-width:900px;text-align:center;}
        div.banner {text-align:center;}
        div.affdiv {height: 40px;}
        ul {list-style-type:none;padding-left:0;}
        li.aff {float:left;margin-left:6px;margin-right:6px;}
        li.q {font-weight:bold;}
        li.red {color:red;}
        td {text-align:left;}
        div.footer {text-align:left;}
    </style>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.16/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.16/css/dataTables.foundation.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.16/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.16/js/dataTables.foundation.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Base64/1.0.1/base64.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/layer/2.3/layer.js"></script>
    <script type="text/javascript">
$(document).ready(function() {
  var table = $('#ss').DataTable( {
    "ajax": "ss.json",
    "dom": "t",
    "paging": false,
    "order": [[0, "desc"]],
    "columnDefs": [ {
       "targets": -1,
       "data": null,
       "defaultContent": '<i class="fa fa-qrcode" aria-hidden="true" style="cursor:pointer"></i>',
    } ],
  } );
  $('#ss_wrapper').append(table).append('<div style="display:none" id="qrcode"></div>');
  $('#ss tbody').on('click', 'i', function () {
    var data = table.row( $(this).closest('tr') ).data();
    var str = 'ss://'+btoa(data[4]+':'+data[3]+'@'+data[1]+':'+data[2]);
    var qrcode = $('#qrcode');
    qrcode.children('canvas').remove();
    qrcode.children('br').remove();
    qrcode.children('a').remove();
    qrcode.qrcode({background:'#FFFFFF',ecLevel:'M',text:str});
    qrcode.append('<br /><a href="'+str+'">URI</a>');
    layer.open( {
      type: 1,
      title: data[1]+' ('+data[6]+')',
      closeBtn: 0,
      shade: 0.1,
      area: '24em',
      shadeClose: true,
      content: qrcode,
    } );
  } );
} );
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?257efbccce3ea2eebc5a5f6c94376665";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
    </script>
</head>
<body>
<div class="container">
<div class="banner">
<!-- Begin BidVertiser code -->
<script data-cfasync="false" SRC="//bdv.bidvertiser.com/BidVertiser.dbm?pid=794115&bid=1920828" TYPE="text/javascript"></script>
<!-- End BidVertiser code -->
</div>
<div class="main">
<table id="ss" class="compact stripe hover nowrap">
<thead>
<tr>
  <th><i class="fa fa-heart" aria-hidden="true"></i></th>
  <th>IP</th>
  <th>Port</th>
  <th>Password</th>
  <th>Method</th>
  <th><i class="fa fa-clock-o" aria-hidden="true"></i></th>
  <th><i class="fa fa-globe" aria-hidden="true"></i></th>
  <th><i class="fa fa-qrcode" aria-hidden="true"></i></th></tr>
</thead>
</table>
</div>
<div class="affdiv">
<ul>
<li class="aff"><a href="aff/bwh.html"><img src="aff/bwh.png" title="VPS 推荐 - 搬瓦工" /></a></li>
<li class="aff"><a href="aff/vultr.html"><img src="aff/vultr.png" title="VPS 推荐 - Vultr" /></a></li>
<li class="aff"><a href="aff/virmach.html"><img src="aff/virmach.png" title="VPS 推荐 - Virmach" /></a></li>
<li class="aff"><a href="aff/hostdare.html"><img src="aff/hostdare.png" title="VPS 推荐 - HostDare" /></a></li>
</ul>
</div>
<div class="footer">
<ul>
<li class="q"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> 注意事项</li>
<li class="a red"><i class="fa fa-info-circle" aria-hidden="true"></i> 禁止使用免费账号进行黑客攻击，BT下载，滥发垃圾邮件。这些账号来之不易，请珍惜使用。</li>
<li class="q"><i class="fa fa-question-circle" aria-hidden="true"></i> 如何使用免费账号？</li>
<li class="a"><i class="fa fa-info-circle" aria-hidden="true"></i> 下载并安装相应的客户端，然后添加账号即可使用。</li>
<li class="q"><i class="fa fa-question-circle" aria-hidden="true"></i> 为什么突然就用不了呢？</li>
<li class="a"><i class="fa fa-info-circle" aria-hidden="true"></i> 部分账号大概每隔6小时变1次，重新输入最新的账号即可。另外部分账号的IP已经被墙，发现不能使用请换其他账号。</li>
<li class="q"><i class="fa fa-question-circle" aria-hidden="true"></i> <i class="fa fa-heart" aria-hidden="true"></i>和<i class="fa fa-clock-o" aria-hidden="true"></i>这两列是什么意思？</li>
<li class="a"><i class="fa fa-info-circle" aria-hidden="true"></i> 本站每隔5分钟检测各个账号的可用性。<i class="fa fa-heart" aria-hidden="true"></i>表示账号在最近2小时内可用性的打分值（越大越好）。<i class="fa fa-clock-o" aria-hidden="true"></i>表示最近一次验证可用的时间（越接近当前时间越好）。</li>
<li class="q"><i class="fa fa-question-circle" aria-hidden="true"></i> 按照你说的，我已经选了最好的账号了，怎么速度还这么慢？</li>
<li class="a"><i class="fa fa-info-circle" aria-hidden="true"></i> 原因可能是该账号使用者比较多，或使用了部分限速的账号。可以尝试换另一个账号。</li>
<li class="q"><i class="fa fa-question-circle" aria-hidden="true"></i> 联系方式？</li>
<li class="a"><i class="fa fa-info-circle" aria-hidden="true"></i> 本站没有任何官方群。如有疑问，发送邮件到客服邮箱 ss at rohankdd dot com 。如发现主站不能访问，也可发邮件询问最新镜像站地址。</li>
</ul>
</div>
</div>
</body>
</html>
