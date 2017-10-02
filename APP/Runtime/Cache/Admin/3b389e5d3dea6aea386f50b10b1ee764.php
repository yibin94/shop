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
    <form name="main_form" method="POST" action="/shop/index.php/Admin/Admin/modify/id/6/p/1.html">
        <input type="hidden" name="id" value="<?php echo ($adminRes["id"]); ?>"/>
        <table cellspacing="1" cellpadding="3" width="100%">
            <tr>
              <td class="label">用户名</td>
              <td><input type="text" name="username" value="<?php echo ($adminRes["username"]); ?>"/></td>
            </tr>
            <tr>
                <td class="label">密  码</td>
                <td><input type="text" name="password" value="" />&nbsp;<b>留空则默认不修改密码</b></td>
            </tr>
            <tr>
                <td class="label">所拥有的权限</td>
                <td>
                  <?php if(is_array($roles)): foreach($roles as $key=>$r): ?><input type="checkbox" name="role_name[]" value="<?php echo ($r["id"]); ?>" 
                     <?php if(strpos(','.$adminRes['role_name'].',',','.$r['role_name'].',')!==false): ?>checked<?php endif; ?>
                     /><?php echo ($r["role_name"]); ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php endforeach; endif; ?>   
                </td>
            </tr>
            <?php if($adminRes['id'] != 1): ?><tr>
                  <td class="label">是否启用</td>
                  <td>
                     是：<input type="radio" name="is_use" value="1" <?php echo ($adminRes['is_use']?'checked':''); ?>/>
                     否：<input type="radio" name="is_use" value="0" <?php echo ($adminRes['is_use']?'':'checked'); ?>/>
                  </td>
              </tr><?php endif; ?>
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