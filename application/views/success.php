
<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>支付成功</title>
<style type="text/css">
  body{
    color: #fff;
    text-align: center;
    text-shadow: 0 1px 3px rgba(0,0,0,.5);
    height: 100%;
    background-color: #333;
  }
  .container{
    padding-right: 15px;
    padding-left: 15px;
    margin-right: auto;
    margin-left: auto;
  }
  .panel{
    padding: 50px 15px;
    text-align: center;
    font-family: 'Microsoft Yahei' inherit;
  }
  h1{
      display: block;
      -webkit-margin-before: 0.67em;
      -webkit-margin-after: 0.67em;
      -webkit-margin-start: 0px;
      -webkit-margin-end: 0px;
       font-size: 2.2em;
  }
  a{
    color: #fff;
    text-decoration: none;
  }
  .lead{
      display: block;
      -webkit-margin-before: 1em;
      -webkit-margin-after: 1em;
      -webkit-margin-start: 0px;
      -webkit-margin-end: 0px;
      font-size: 1.2em;
  }
  .btn{
      padding: 10px 20px;
      font-weight: bold;
      color: #333;
      text-shadow: none;
      background-color: #fff;
      border: 1px solid #fff;
      font-size: 18px;
      line-height: 1.3333333;
      border-radius: 6px;
      border-color: #ccc;
      display: inline-block;
      margin-bottom: 0;
      text-align: center; 
      white-space: nowrap;
      vertical-align: middle;
      touch-action: manipulation;
      cursor: pointer;
      -webkit-user-select: none;
      text-decoration: none;
      margin-top: 15px;
  }
.foot{
  color: rgba(255,255,255,.5);
  margin-top: 30px;
}
.warning{
  font-size: 30px;
  font-weight: bold;
  color:rgb(64, 205, 231);
}

</style>
  </head>

  <body>

    <div class="container">

      <div class="panel">
        <h1>支付成功</h1>
        <p class="lead">您的订单已支付成功！<br>
        <p class="warning">入场前请携带有效身份证件对号入座</p>
        <p class="lead">可在首页查询您的购票信息</p>
        <p><a class="btn" style="color:#333" href="http://shiyida.net:8080/ticket/"> 点击返回首页 </a></p>

        <p class="lead"><time></time>秒后自动跳转首页</p>
      </div>
    </div>
    <div class="foot">
      <p>Copyright © 2015 by <a  href="http://shiyida.net">shiyida</a>.</p>
    </div>  
  </body>
  <script type="text/javascript">
    var count = 10;
    var t;
    window.onload = timedCount();
    function timedCount(){
      document.getElementsByTagName('time')[0].innerHTML = count;
      if(count == 0){
       window.location.href = 'http://shiyida.net:8080/ticket/';
        // clearTimeout(t);
        return;
      }
      count--;
      t = setTimeout("timedCount()",1000);
    }
  </script>
</html>
