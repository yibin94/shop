<?php
namespace Admin\Controller;
use Think\Controller;
header('Content-Type:text/html;charset=utf-8;');
class ValidateController extends Controller
{
    public function __Construct(){
        parent::__Construct();//调用父类的构造函数.
        if(empty(session('id'))){//判断是否有登录信息决定其是否能访问
           redirect(U('Login/login'));
        }
        //echo $url = MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME;
        //开发后台首页
        if(CONTROLLER_NAME=='Index') 
            return true;
        $adminId = session('id');
        $condition = ' `module_name`="'.MODULE_NAME.'" AND `controller_name`="'.CONTROLLER_NAME.'" AND `action_name`="'.ACTION_NAME.'"';
        //超级管理员将拥有权限表的所有权限
        if($adminId==1){
           $sql = 'select * from shop_privilege where '.$condition;
        }else{
            //查询指定管理员拥有的权限
            $sql = 'select c.* from shop_admin_role a LEFT JOIN shop_role_privilege b on a.role_id=b.role_id LEFT JOIN shop_privilege c on b.pri_id=c.id where a.admin_id='.$adminId.' AND '.$condition;
        }
        //echo $sql;
        $model = M();
        $res = $model->query($sql);
        if(empty($res)){
           $this->error('权限不足！无法访问！');
           return false;
        }
        
        //show_bug($res);die;
    }
    //设置公共页眉的内容
    public function setPageInfo($title,$btn,$link){
        $this->assign('title',$title);
        $this->assign('btn',$btn);
        $this->assign('link',$link);
    }
}