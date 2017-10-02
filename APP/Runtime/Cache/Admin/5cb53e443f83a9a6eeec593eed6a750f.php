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
            <th>用户名</th>
            <th>密码</th>
            <th>所拥有的角色</th>
            <th>是否启用</th>
			<th width="60">操作</th>
        </tr>
        <?php if(is_array($adminRes)): foreach($adminRes as $key=>$v): ?><tr class="tron" style="text-align:center;">
               <td><?php echo ($v["username"]); ?></td>
               <td><?php echo ($v["password"]); ?></td>
               <td><?php echo ($v["role_name"]); ?></td>
               <td class="state" id="<?php echo ($v["id"]); ?>" cur_adminid="<?php echo ($curAdminId); ?>" style="cursor:pointer;"><?php echo ($v['is_use']?'启用':'禁用'); ?></td>
               <td>
                   <a href="<?php echo U('Admin/modify',array('id'=>$v['id'],'p'=>$pageIndex));?>" class="modify" id="<?php echo ($v["id"]); ?>" cur_adminid="<?php echo ($curAdminId); ?>" style="text-decoration: none;">修改</a> <?php if($v['id'] != 1): ?>| 
                   <a href="<?php echo U('Admin/delete',array('id'=>$v['id'],'p'=>$pageIndex));?>" class="delete" id="<?php echo ($v["id"]); ?>" cur_adminid="<?php echo ($curAdminId); ?>" style="text-decoration: none;">删除</a><?php endif; ?>
               </td>
           </tr><?php endforeach; endif; ?>
        <tr>
            <td colspan="100" align="center"><?php echo ($page); ?></td>
        </tr>
	</table>
</div>
<script type="text/javascript">
   //使用ajax处理状态的切换
   $('.state').click(function(){
     var state = $(this).html();
     //当前点击记录的管理员id
     var id = $(this).attr('id');
     //当前登录的管理员id
     var curAdminId = $(this).attr('cur_adminid');
     var self = $(this);
     if(state=="启用" && id==1){
          alert('超级管理员不能被禁用！');
          return false;
     }else if(id != curAdminId && curAdminId != 1){
      //当前点击记录的管理员id与当前管理员id值不相同并且当前管理员不是超级管理员就不能切换管理员状态。
          alert('权限不足！无法修改！');
          return false;
     }else{
         var is_use = (state=="启用"?1:0);
         $.ajax({
            url:"<?php echo U('Admin/switchState','','');?>/id/"+id+"/state/"+is_use,
            type:'GET',
            data:String,
            success:function(data){
               if(data==1){
                 self.html('启用');
               }else if(data==0){
                 self.html('禁用');
               }
            }
         });
     }
   });

      $('.modify').click(function(){
          var res = confirm("你确认要修改？");
          //当前点击记录的管理员id
          var id = $(this).attr('id');
          //当前登录的管理员id
          var curAdminId = $(this).attr('cur_adminid');
          if(res==true){
            //当前点击记录的管理员id匹配当前登录的管理员id或者当前登录管理员是超级管理员。
            if(id==curAdminId||curAdminId==1)
              return true;
            else{
              alert('权限不足！无法修改！');
              return false;
            }
          }else{
              return false;
          }
      });
      $('.delete').click(function(){
          var res = confirm('你确定删除吗？');
          //当前点击记录的管理员id
          var id = $(this).attr('id');
          //当前登录的管理员id
          var curAdminId = $(this).attr('cur_adminid');
          if(res==true){
            //当前点击记录的管理员id匹配当前登录的管理员id或者当前登录管理员是超级管理员。
            if(id==curAdminId||curAdminId==1)
              return true;
            else{
              alert('权限不足！无法删除！');
              return false;
            }
          }else{
              return false;
          }
      });
</script>
<div id="footer">
&copy; 2017-2017 by yibin</div>
</body>
</html>
<script type="text/javascript" src="/shop/Public/Admin/js/tron.js"></script>