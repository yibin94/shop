<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>管理中心 - 商品列表 </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/shop/Public/Admin/css/general.css" rel="stylesheet" type="text/css" />
<link href="/shop/Public/Admin/css/main.css" rel="stylesheet" type="text/css" />
<!-- 引入日期插件文件 -->
<link href="/shop/Public/datepicker/jquery-ui-1.9.2.custom.min.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" charset="utf-8" src="/shop/Public/datepicker/jquery-1.7.2.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/shop/Public/datepicker/jquery-ui-1.9.2.custom.min.js"></script>
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo ($link); ?>?p=<?php echo ($pageIndex); ?>"><?php echo ($btn); ?></a></span>
    <span class="action-span1"><a href="<?php echo U('Index/index');?>">管理中心</a>&nbsp;</span>
    <span id="search_id" class="action-span1"> - <?php echo ($title); ?> </span>
    <div style="clear:both"></div>
</h1>

<div class="main-div">
    <form name="main_form" method="POST" action="/shop/index.php/Admin/Role/add/p/1.html?p=1" >
        <table cellspacing="1" cellpadding="3" width="100%">
            <tr>
                <td class="label">角色名称：</td>
                <td>
                    <input  type="text" name="role_name" value="" />
                </td>
            </tr>
            <tr>
                <td class="label">权限列表：</td>
                <td>
                   <?php if(is_array($priRes)): foreach($priRes as $key=>$v): echo ($v["flag"]); ?><input level="<?php echo ($v["level"]); ?>" type="checkbox" name="pri_id[]" value="<?php echo ($v["id"]); ?>"/><?php echo ($v["pri_name"]); ?><br/><?php endforeach; endif; ?>                      
                </td> 
            </tr>
            <tr>
                <td colspan="99" align="center">
                    <input type="submit" class="button" value=" 确定 " style="cursor:pointer;"/>
                </td>
            </tr>
        </table>

    </form>
</div>
<!--引入选中复选框的特效 js 文件-->
<script type="text/javascript" src="/shop/Public/Admin/js/chooseCheckbox.js"></script>
<script type="text/javascript">
    $(':submit').click(function(){
        var seconds = 3;
        $(this).val(seconds+'秒后跳转...');
        $(this).attr('disabled','disabled');//禁点按钮
        var btn = $(this);
        var timer = setInterval(function(){
           if(--seconds==0){
              window.clearInterval(timer);
              $('form[name=main_form]').submit();
           }
           btn.val(seconds+'秒后跳转...');
        },1000);
    });
</script>
<div id="footer">
&copy; 2017-2017 by yibin</div>
</body>
</html>
<script type="text/javascript" src="/shop/Public/Admin/js/tron.js"></script>