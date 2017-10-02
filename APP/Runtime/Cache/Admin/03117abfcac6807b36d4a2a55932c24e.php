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
    <form name="main_form" method="POST" action="/shop/index.php/Admin/Privilege/modify/id/1/p/1.html?p=<?php echo ($pageIndex); ?>">
    	<input type="hidden" name="id" value="<?php echo ($pri["id"]); ?>" />
        <table cellspacing="1" cellpadding="3" width="100%">
            <tr>
                <td class="label">权限名称：</td>
                <td>
                    <input  type="text" name="pri_name" value="<?php echo ($pri["pri_name"]); ?>" />
                </td>
            </tr>
            <tr>
                <td class="label">模块名称：</td>
                <td>
                    <input  type="text" name="module_name" value="<?php echo ($pri["module_name"]); ?>" />
                </td>
            </tr>
            <tr>
                <td class="label">控制器名称：</td>
                <td>
                    <input  type="text" name="controller_name" value="<?php echo ($pri["controller_name"]); ?>" />
                </td>
            </tr>
            <tr>
                <td class="label">方法名称：</td>
                <td>
                    <input  type="text" name="action_name" value="<?php echo ($pri["action_name"]); ?>" />
                </td>
            </tr>
            <tr>
                <td class="label">上级权限的 id，0 代表顶级权限：</td>
                <td>
                    <input  type="text" name="parent_id" value="<?php echo ($pri["parent_id"]); ?>" />
                </td>
            </tr>
            <tr>
                <td colspan="99" align="center">
                    <input type="submit" class="button" value=" 确定 " style="cursor:pointer;"/>
                </td>
            </tr>
        </table>
        <!--罗列有的权限及id值（不包括当前权限，避免自己选自己当父级权限）-->
        <table cellpadding="3" cellspacing="0" border="1px" style="background:#BBDDE5;text-align:center;width:80%;margin:auto;">
           <tr>
               <th style="font-weight:bold;font-size:15px;">当前所有的权限</th>
               <th style="font-weight:bold;font-size:15px;">权限的 id</th>
           </tr>
           <tr>
               <td>顶级权限</td>
               <td>0</td>
           </tr>
           <?php if(is_array($priRes)): foreach($priRes as $key=>$p): if($p['id'] != $pri['id']): ?><tr>
                      <td><?php echo ($p['pri_name']); ?></td>
                      <td><?php echo ($p['id']); ?></td>
                  </tr><?php endif; endforeach; endif; ?>
        </table>
    </form>
</div>

<div id="footer">
&copy; 2017-2017 by yibin</div>
</body>
</html>
<script type="text/javascript" src="/shop/Public/Admin/js/tron.js"></script>