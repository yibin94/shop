<?php
namespace Admin\Controller;
header('Content-Type:text/html;charset=utf-8;');
class AdminController extends ValidateController
{
    //添加管理员信息
    public function add(){
       $admin = D('Admin');
       if(IS_POST){
          if($admin->create(I('post.'),1)){//1代表增加数据的操作
             if($admin->add()){
                $this->success('添加管理员信息成功！',U('Admin/listAdmin?p='.I('get.p',1)));
                exit;//跳出最外层if,不执行以下语句.
             }
          }
          $this->error($admin->getError());
       }else{
          //取出所有角色并分配到模板
          $roles = M('Role')->select();
          //show_bug($roles);die;
          $this->assign('roles',$roles);
          $this->assign('pageIndex',I('get.p',1));
          $this->setPageInfo('添加管理员信息','管理员信息列表',U('Admin/listAdmin?p='.I('get.p',1)));
          $this->display(); 
       }
    }
    //修改管理员信息
    public function modify(){
       $admin = D('Admin');
       if(IS_POST){
           if($admin->create(I('post.'),2)){//2代表修改操作
               if($admin->save()!==false){ //不修改返回影响行数0所以需要特判修改失败即返回false.
                  $this->success('修改管理员信息成功！',U('Admin/listAdmin?p='.I('get.p',1)));
                  exit;
               }           
           }
           $this->error($admin->getError());
       }else{
            $id = I('get.id');

            //判断如果是超级管理员(id=1)则允许修改任何其它管理员的信息，否则只能修改自己的信息。
            if($id != session('id') && session('id') != 1){
               $this->error('权限不足！无法修改！');
               return false;
            }

           $admin = D('Admin');
           //查询该管理员拥有的角色信息
           //select a.*,GROUP_CONCAT(c.role_name) role_name from shop_admin a left join shop_admin_role b on a.id=b.admin_id left join shop_role c on b.role_id=c.id where a.id=$id;
           $adminRes = $admin->alias('a')->where(array('a.id'=>$id))->group('a.id')->field('a.*,GROUP_CONCAT(c.role_name) role_name')->join('left join shop_admin_role b on a.id=b.admin_id left join shop_role c on b.role_id=c.id')->find();
           //echo $admin->getLastSql();//查看执行的sql语句
           //show_bug($adminRes);die;
           //取出所有角色并分配到模板
           $roles = M('Role')->select();
           $this->assign('roles',$roles);
           $this->assign('adminRes',$adminRes);
           $this->assign('pageIndex',I('get.p',1));
           $this->setPageInfo('修改管理员信息','管理员信息列表',U('Admin/listAdmin?p='.I('get.p',1)));
           $this->display();
       }
    }
    //删除管理员信息
    public function delete(){
       $id = I('get.id');

        //判断如果是超级管理员(id=1)则允许修改任何其它管理员的信息，否则只能修改自己的信息。
        if($id != session('id') && session('id') != 1){
           $this->error('权限不足！无法删除！');
           return false;
        }

       $admin = D('Admin');
       if($admin->delete($id)){
         $this->success('删除管理员信息成功！',U('Admin/listAdmin?p='.I('get.p',1)));
       }else{
         $this->error($admin->getError());
       }
    }
    //显示管理员信息列表
    public function listAdmin(){
       $admin = M('Admin');
       $count = $admin->count();
       $limit = C('pageNum');//每页显示记录条数
       $page = new \Think\Page($count,$limit);

       //查询管理员拥有的所有角色名称
       //select a.*,GROUP_CONCAT(c.role_name) role_name from shop_admin a left join shop_admin_role b on a.id=b.admin_id left join shop_role c on b.role_id=c.id group by a.id;
       $adminRes = $admin->alias('a')->field('a.*,GROUP_CONCAT(c.role_name) role_name')->group('a.id')->join('left join shop_admin_role b on a.id=b.admin_id left join shop_role c on b.role_id=c.id')->limit($page->firstRow.','.$page->listRows)->select();
       //echo $admin->getLastSql();
       //show_bug($adminRes);die;
       $page->setConfig('prev',"上一页");
       $page->setConfig('next',"下一页");
       $this->assign('page',$page->show());//分页输出
       $this->assign('adminRes',$adminRes);//管理员信息

       $this->assign('curAdminId',session('id'));//传递当前登录的管理员id值

       $this->setPageInfo('管理员信息列表','添加管理员信息',U('Admin/add?p='.I('get.p',1)));
       $this->assign('pageIndex',I('get.p',1));
       $this->display();
    }

    //使用ajax处理启用与否的状态切换
    public function switchState(){
       //show_bug($_GET);
       //echo I('get.id');
       $state = I('get.state');
       $is_use = $state==1?0:1;
       //更新数据库指定记录的状态
       M('Admin')->where(array('id'=>I('get.id')))->setField('is_use',$is_use);
       //返回状态标志（1-启用，0-禁用）
       echo $is_use;
    } 
}
