<?php
namespace Admin\Controller;
header('Content-Type:text/html;charset=utf-8;');
class IndexController extends ValidateController {
    public function index(){
       $this->display();  
    }

    public function main(){
       $this->display();  
    }

    public function menu(){
       //取出当前管理员的权限
       $adminId = session('id');
       //echo $adminId;die;
       //$sql = 'select a.username,d.* from shop_admin a left join shop_admin_role b on a.id=b.admin_id left join shop_role_privilege c on b.role_id=c.role_id left join shop_privilege d on c.pri_id=d.id where a.id='.$adminId.' order by d.id';
       //$res = M('Admin')->alias('a')->query($sql);
       $sql = 'select c.* from shop_admin_role a LEFT JOIN shop_role_privilege b on a.role_id=b.role_id LEFT JOIN shop_privilege c on b.pri_id=c.id where a.admin_id='.$adminId.' order by c.id';
       $res = M()->query($sql);//show_bug($res);die;
       $privileges = array();
       foreach($res as $v){
         if($v['parent_id']==0){
            foreach ($res as $c) {
                if($c['parent_id']==$v['id'])
                    $v['children'][] = $c;
            }
            $privileges[] = $v;
         }
       }
       //show_bug($privileges);die;
       $this->assign('privileges',$privileges);
       $this->display();  
    }

    public function top(){
       $this->display();  
    }
}