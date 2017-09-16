<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>管理中心 - 编辑商品 </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/shop/Public/Admin/css/general.css" rel="stylesheet" type="text/css" />
<link href="/shop/Public/Admin/css/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo U('Goods/listGoods');?>">商品列表</a>
    </span>
    <span class="action-span1"><a href="<?php echo U('Index/index');?>">管理中心</a></span>
    <span id="search_id" class="action-span1"> - 编辑商品 </span>
    <div style="clear:both"></div>
</h1>

<div class="tab-div">
    <div id="tabbar-div">
        <p>
            <span class="tab-front" id="general-tab">通用信息</span>
        </p>
    </div>
    <div id="tabbody-div">
      <form action="/shop/index.php/Admin/Goods/modify/id/40/p/6.html?p=<?php echo ($pageIndex); ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo ($goods["id"]); ?>"/>
        商品名称：<input type="text" name="goods_name" value="<?php echo ($goods["goods_name"]); ?>"/><br /><br />
        商品价格：<input type="text" name="price" value="<?php echo ($goods["price"]); ?>"/><br /><br />
        商品描述：<br /><br />
        <input type="textarea" id="goods_desc" name="goods_desc" style="width:100%;height:300px;" value='<?php echo ($goods["goods_desc"]); ?>'><br/>
        原商品logo：<br/><br/><img src="<?php echo ($rootpath); echo ($goods["sm_logo"]); ?>"/><br/><br />
        新商品logo：<input type="file" name="goods_logo" /><br /><br />
        是否上架：
        <input type="radio" name="is_on_sale" value="1" <?php if($goods["is_on_sale"] == 1): ?>checked<?php endif; ?>/>上架 
        <input type="radio" name="is_on_sale" value="0" <?php if($goods["is_on_sale"] != 1): ?>checked<?php endif; ?>/>下架
        <br /><br />
        &nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="提交" />
      </form>
    </div>
</div>

<div id="footer">
共执行 9 个查询，用时 0.025161 秒，Gzip 已禁用，内存占用 3.258 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>
<script charset="utf-8" src="/shop/Public/editor/kindeditor.js"></script>
<script charset="utf-8" src="/shop/Public/editor/lang/zh-CN.js"></script>
<script type="text/javascript">
        KindEditor.ready(function(K) {
                window.editor = K.create('#goods_desc');
        });
</script>