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
    <form name="main_form" method="POST" action="/shop/index.php/Admin/Admin/add/p/1.html?p=1">
        <table cellspacing="1" cellpadding="3" width="100%">
			<tr>
				<td class="label">用户名</td>
                <td><input type="text" name="username" value=""/></td>
			</tr>
            <tr>
                <td class="label">密  码</td>
                <td><input type="password" name="password" value="" /></td>
            </tr>
            <tr>
                <td class="label">确认密码</td>
                <td><input type="password" name="repassword" value="" /></td>
            </tr>
            <tr>
                <td class="label">是否启用</td>
                <td>
                   <input type="radio" name="is_use" value="1" checked/>是
                   <input type="radio" name="is_use" value="0" />否
                </td>
            </tr>
            <tr>
                <td class="label">所在的角色</td>
                <td>
                    <?php if(is_array($roles)): foreach($roles as $key=>$v): ?><input type="checkbox" name="roles[]" value="<?php echo ($v["id"]); ?>"/><?php echo ($v["role_name"]); ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php endforeach; endif; ?>
                </td>
            </tr>
            <tr>
                <td colspan="100" align="center">
                    <input type="submit" class="button" value=" 确定 " style="cursor:pointer;"/>
                </td>
            </tr>
        </table>
    </form>
</div>
<div id="footer">
&copy; 2017-2017 by yibin</div>
</body>
</html>
<script type="text/javascript" src="/shop/Public/Admin/js/tron.js"></script>