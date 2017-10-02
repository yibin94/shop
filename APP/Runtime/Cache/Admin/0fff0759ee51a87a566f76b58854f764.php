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
<!--以当前模板所在目录View开始找-->
<!-- 列表 -->
<div class="list-div" id="listDiv">
	<table cellpadding="3" cellspacing="1">
    	<tr>
            <th >分类名称</th>
            <th >上级分类的 id, 0 代表顶级分类</th>
			<th width="60">操作</th>
        </tr>
        <?php if(is_array($cates)): foreach($cates as $key=>$v): ?><tr class="tron">
               <td><?php echo ($v["cat_name"]); ?></td>
               <td><?php echo ($v["parent_id"]); ?></td>
               <td>
                   <a href="<?php echo U('Category/modify',array('id'=>$v['id'],'p'=>$pageIndex));?>" style="text-decoration: none;">修改</a>&nbsp;
                   <a href="<?php echo U('Category/delete',array('id'=>$v['id'],'p'=>$pageIndex));?>" style="text-decoration: none;" onclick="return confirm('你确定删除吗？');">删除</a>
               </td>
           </tr><?php endforeach; endif; ?>
        <tr>
            <td colspan="3" align="center"><?php echo ($page); ?></td>
        </tr>
	</table>
</div>
<script>
</script>
<div id="footer">
&copy; 2017-2017 by yibin</div>
</body>
</html>
<script type="text/javascript" src="/shop/Public/Admin/js/tron.js"></script>