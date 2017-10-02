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
<!--在当前模板所在view目录开始找-->


<div class="tab-div">
    <div id="tabbar-div">
        <p>
            <span class="tab-front" id="general-tab">通用信息</span>
        </p>
    </div>
    <div id="tabbody-div">
      <form action="/shop/index.php/Admin/Goods/modify/id/32/p/1.html?p=<?php echo ($pageIndex); ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo ($goods["id"]); ?>"/>
        商品名称：<input type="text" name="goods_name" value="<?php echo ($goods["goods_name"]); ?>"/><br /><br />
        商品价格：<input type="text" name="price" value="<?php echo ($goods["price"]); ?>"/><br /><br />
        商品描述：<br /><br />
        <input type="textarea" id="goods_desc" name="goods_desc" style="width:100%;height:300px;" value='<?php echo ($goods["goods_desc"]); ?>'><br/>
        原商品logo：<br/><br/><?php showImg($goods['sm_logo']); ?><br/><br />
        新商品logo：<input type="file" name="goods_logo" /><br /><br />
        是否上架：
        <input type="radio" name="is_on_sale" value="1" <?php if($goods["is_on_sale"] == 1): ?>checked<?php endif; ?>/>上架 
        <input type="radio" name="is_on_sale" value="0" <?php if($goods["is_on_sale"] != 1): ?>checked<?php endif; ?>/>下架
        <br /><br />
        &nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="提交" />
      </form>
    </div>
</div>


<script charset="utf-8" src="/shop/Public/editor/kindeditor.js"></script>
<script charset="utf-8" src="/shop/Public/editor/lang/zh-CN.js"></script>
<script type="text/javascript">
        KindEditor.ready(function(K) {
                window.editor = K.create('#goods_desc');
        });
</script>
<div id="footer">
&copy; 2017-2017 by yibin</div>
</body>
</html>
<script type="text/javascript" src="/shop/Public/Admin/js/tron.js"></script>