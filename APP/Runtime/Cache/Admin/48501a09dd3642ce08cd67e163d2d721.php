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


<div class="form-div">
    <form method='get'>
         <input type="hidden" name="p" value='1'><!--隐藏域为了每次搜索，从翻页的页面第一页开始搜-->
         <br/>
         <img src="/shop/Public/Admin/imgs/icon_search.gif" width="26" height="22" border="0" alt="search" />
         商品名称：<input type="text" name="goods_name" value="<?php echo I('get.goods_name'); ?>"><br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         商品价格：<input type="text" name="start_price" value="<?php echo I('get.start_price'); ?>">~
         <input type="text" name="end_price" value="<?php echo I('get.end_price'); ?>"><br/><br/>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         添加时间：<input type="text" id="start_addtime" name="start_addtime" value="<?php echo I('get.start_addtime');?>">~
         <input type="text" id="end_addtime" name="end_addtime" value="<?php echo I('get.end_addtime');?>"><br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         是否上架：
         <input type="radio" name="is_on_sale" value="-1" <?php echo I('get.is_on_sale',-1)==-1?'checked':'';?>>全部
         <input type="radio" name="is_on_sale" value="1" <?php echo I('get.is_on_sale',-1)==1?'checked':'';?>>上架
         <input type="radio" name="is_on_sale" value="0" <?php echo I('get.is_on_sale',-1)==0?'checked':'';?>>下架
         <br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         是否删除：
         <input type="radio" name="is_delete" value="-1" <?php echo I('get.is_delete',-1)==-1?'checked':'';?>>全部
         <input type="radio" name="is_delete" value="1" <?php echo I('get.is_delete',-1)==1?'checked':'';?>>已删除
         <input type="radio" name="is_delete" value="0" <?php echo I('get.is_delete',-1)==0?'checked':'';?>>未删除
         <br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         <input type="submit" value="搜索""><br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         排序方式：
         <input onclick="parentNode.submit()" type="radio" name="orderBy" value="id_asc" <?php echo I('get.orderBy','id_asc')=='id_asc'?'checked':'';?>>按添加时间升序
         <input onclick="parentNode.submit()" type="radio" name="orderBy" value="id_desc"<?php echo I('get.orderBy','id_asc')=='id_desc'?'checked':'';?>>按添加时间降序
         <input onclick="parentNode.submit()" type="radio" name="orderBy" value="price_asc" <?php echo I('get.orderBy','id_asc')=='price_asc'?'checked':'';?>>按商品价格升序
         <input onclick="parentNode.submit()" type="radio" name="orderBy" value="price_desc" <?php echo I('get.orderBy','id_asc')=='price_desc'?'checked':'';?>>按商品价格降序
    </form>
</div>

<!-- 商品列表 -->
<form method="post" action="" name="listForm" onsubmit="">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="0" border="1">
         <tr>
           <th>编号id</th>
           <th>商品名称</th>
           <th>商品价格</th>
           <th>商品描述</th>
           <th>商品logo</th>
           <th>商品logo缩略图</th>
           <th>是否上架</th>
           <th>是否删除</th>
           <th>添加时间</th>
           <th>操  作</th>
         </tr>
         <?php if(is_array($list)): foreach($list as $key=>$v): ?><tr class="tron">
             <td><?php echo ($v["id"]); ?></td>
             <td><?php echo ($v["goods_name"]); ?></td>
             <td><?php echo ($v["price"]); ?></td>
             <td><?php echo ($v["goods_desc"]); ?></td>
             <td><?php showImg($v['logo'],200,200);?></td>
             <td><?php showImg($v['sm_logo']);?></td>
             <td><?php echo ($v['is_on_sale']?'上架':'下架'); ?></td>
             <td><?php echo ($v['is_delete']?'已删除':'未删除'); ?></td>
             <td><?php echo (date('Y-m-d H:i:s',$v["addtime"])); ?></td>
             <td>
               <a href="<?php echo U('Goods/modify',array(id=>$v['id'],'p'=>I('get.p',1)));?>">修改</a>&nbsp;
               <a href="<?php echo U('Goods/delete',array('id'=>$v['id'],'p'=>I('get.p',1)));?>" onclick="return confirm('确定要删除吗？')">删除</a>
             </td>
           </tr><?php endforeach; endif; ?> 
          <tr style="text-align: center"><td colspan="10"><?php echo ($page); ?></td></tr>
        </table>
    </div>
</form>

<!---->


<script type="text/javascript">
     <!-- 引入日期中文包代码 -->
    $.datepicker.regional['zh-CN'] = {
          clearText: '清除',
          clearStatus: '清除已选日期',
          closeText: '关闭',
          closeStatus: '不改变当前选择',
          prevText: '<上月',
          prevStatus: '显示上月',
          prevBigText: '<<',
          prevBigStatus: '显示上一年',
          nextText: '下月>',
          nextStatus: '显示下月',
          nextBigText: '>>',
          nextBigStatus: '显示下一年',
          currentText: '今天',
          currentStatus: '显示本月',
          monthNames: ['一月','二月','三月','四月','五月','六月', '七月','八月','九月','十月','十一月','十二月'],
          monthNamesShort: ['一','二','三','四','五','六', '七','八','九','十','十一','十二'],
          monthStatus: '选择月份',
          yearStatus: '选择年份',
          weekHeader: '周',
          weekStatus: '年内周次',
          dayNames: ['星期日','星期一','星期二','星期三','星期四','星期五','星期六'],
          dayNamesShort: ['周日','周一','周二','周三','周四','周五','周六'],
          dayNamesMin: ['日','一','二','三','四','五','六'],
          dayStatus: '设置 DD 为一周起始',
          dateStatus: '选择 m月 d日, DD',
          dateFormat: 'yy-mm-dd',
          firstDay: 1,
          initStatus: '请选择日期',
          isRTL: false
      };
      $.datepicker.setDefaults($.datepicker.regional['zh-CN']);
      <!-- 定义日期插件元素 -->
      $("#start_addtime").datepicker({ dateFormat: "yy-mm-dd" });
      $("#end_addtime").datepicker({ dateFormat: "yy-mm-dd" });
</script>
<div id="footer">
&copy; 2017-2017 by yibin</div>
</body>
</html>
<script type="text/javascript" src="/shop/Public/Admin/js/tron.js"></script>