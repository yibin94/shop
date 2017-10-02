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
      <form id="addForm" name = "addForm" action="/shop/index.php/Admin/Goods/add.html?p=" method="post" enctype="multipart/form-data">
        商品名称：<input type="text" name="goods_name" /><br /><br />
        商品价格：<input type="text" name="price" /><br /><br />
        商品描述：<br /><br />
        <textarea id="goods_desc" name="goods_desc" style="width:100%;height:300px;"></textarea><br/>
        商品logo：<input type="file" name="goods_logo" /><br /><br />
        是否上架：
        <input type="radio" name="is_on_sale" value="1" checked="checked" />上架
        <input type="radio" name="is_on_sale" value="0" />下架
        <br /><br />
        &nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="提交"/>
      </form>
    </div>
</div>

<script type="text/javascript" charset="utf-8" src="/shop/Public/datepicker/jquery-1.7.2.min.js"></script>
<script charset="utf-8" src="/shop/Public/editor/kindeditor.js"></script>
<script charset="utf-8" src="/shop/Public/editor/lang/zh-CN.js"></script>
<script type="text/javascript">
        KindEditor.ready(function(K) {
                //window.editor = K.create('#goods_desc');
           window.editor = K.create('#goods_desc',{  
              afterBlur:function(){  
                 this.sync();  //this.sync()将编辑器的内容设置到原来的textarea控件里。不然值获取不到，后台拿不到数据。
              }  
           });  
        });

        $("form[name=addForm]").submit(function(){
            var formData = new FormData(document.getElementById("addForm"));
            $.ajax({
                url:"/shop/index.php/Admin/Goods/add.html?p=",
                type:"post",
                data:formData,
                dataType: 'json', //返回的数据类型
                processData:false,// 告诉jQuery不要去处理发送的数据
                contentType:false,// 告诉jQuery不要去设置Content-Type请求头
                success:function(data)//ajax执行后的回调函数
                {
                    //判断是否添加成功
                    if(data.status == 1){
                        alert(data.info);
                        location.href = data.url;//跳转
                    }
                    else{
                        alert(data.info);
                    }
                }
            });
            return false;//阻止表单提交
        });
</script>
<div id="footer">
&copy; 2017-2017 by yibin</div>
</body>
</html>
<script type="text/javascript" src="/shop/Public/Admin/js/tron.js"></script>