<?php
namespace Admin\Controller;
header('Content-Type:text/html;charset=utf8;');

class RoleController extends ValidateController
{
    //添加角色
    public function add(){
       $role = D('Role');
       if(IS_POST){
         // show_bug($_POST);show_bug(I('post.pri_id'));die;
          if($role->create(I('post.'),1)){//1代表增加数据的操作
             if($role->add()){
                $this->success('添加角色成功！',U('Role/listRole?p='.I('get.p',1)));
                exit;//跳出最外层if,不执行以下语句.
             }
          }
          $this->error($role->getError());
       }else{
          $priData = D('Privilege')->select();
          unlimitedCateSingleArr($priData,0,0,$priRes);
          //show_bug($priRes);die;
          $this->assign('priRes',$priRes);
          $this->assign('pageIndex',I('get.p',1));
          $this->setPageInfo('添加角色信息','角色列表',U('Role/listRole?p='.I('get.p',1)));
          $this->display(); 
       }
    }
    //修改分类记录数据
    public function modify(){
       $role = D('Role');
       if(IS_POST){
        //show_bug($_POST);die;
           if($role->create(I('post.'),2)){//2代表修改操作
               if($role->save()!==false){ //不修改返回影响行数0所以需要特判修改失败即返回false.
                  $this->success('修改分类数据成功！',U('Role/listRole?p='.I('get.p',1)));
                  exit;
               }           
           }
           $this->error($role->getError());
       }else{
           $id = I('get.id');
           $priData = D('Privilege')->select();
           unlimitedCateSingleArr($priData,0,0,$priRes);
           //show_bug($priRes);die;
           $this->assign('priRes',$priRes);//权限信息
           $res = $role->find($id);
           //根据角色id选出其拥有的所有权限id。
           $pids = M('RolePrivilege')->where(array('role_id'=>$id))->select();
           $this->assign('pri_ids',array_column($pids,'pri_id'));//只取'pri_id'列。
           //$pids = M('RolePrivilege')->field('GROUP_CONCAT(pri_id) pri_id')->where(array('role_id'=>$id))->find();
           $this->assign('role',$res);//当前修改的角色信息
           $this->assign('pageIndex',I('get.p',1));
           $this->setPageInfo('修改角色信息','角色列表',U('Role/listRole?p='.I('get.p',1)));
           $this->display();
       }
    }
    //删除分类
    public function delete(){
       $id = I('get.id');
       $role = D('Role');
       if($role->delete($id)){
         $this->success('删除角色信息成功！',U('Role/listRole?p='.I('get.p',1)));
       }else{
         $this->error($role->getError());
       }
    }
    //显示分类信息
    public function listRole(){
        $role = M('Role');
        $count = $role->count();
        $limit = C('pageNum');//每页显示记录条数
        $page = new \Think\Page($count,$limit);
        //取出角色所拥有的所有权限
       //select a.*,GROUP_CONCAT(c.pri_name) pri_name from shop_role a left join shop_role_privilege b on a.id=b.role_id left join shop_privilege c on b.pri_id=c.id GROUP BY a.id; alias(别名)
       $roleRes = $role->alias('a')->field('a.*,GROUP_CONCAT(c.pri_name) pri_name')->join('left join shop_role_privilege b on a.id=b.role_id left join shop_privilege c on b.pri_id=c.id')->group('a.id')->limit($page->firstRow.','.$page->listRows)->select();
       //show_bug($roleRes);die;
       $page->setConfig('prev',"上一页");
       $page->setConfig('next',"下一页");
       $this->assign('page',$page->show());//分页输出
       $this->assign('roleRes',$roleRes);
       $this->assign('pageIndex',I('get.p',1));
       $this->setPageInfo('角色列表','添加角色信息',U('Role/add?p='.I('get.p',1)));
       $this->display();
    }
}