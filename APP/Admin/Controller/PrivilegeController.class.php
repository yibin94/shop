<?php
namespace Admin\Controller;
header('Content-Type:text/html;charset=utf8;');

class PrivilegeController extends ValidateController
{
    //添加分类
    public function add(){
       $pri = D('Privilege');
       if(IS_POST){
          if($pri->create(I('post.'),1)){//1代表增加数据的操作
             if($pri->add()){
                $this->success('添加管理权限成功！',U('Privilege/listPri?p='.I('get.p',1)));
                exit;//跳出最外层if,不执行以下语句.
             }
          }
          $this->error($pri->getError());
       }else{
          $priData = $pri->select();
          unlimitedCateSingleArr($priData,0,0,$priRes);
          //show_bug($priRes);die; 
          $this->assign('priRes',$priRes);
          $this->assign('pageIndex',I('get.p',1));
          $this->setPageInfo('添加管理权限','管理权限列表',U('Privilege/listPri?p='.I('get.p',1)));
          $this->display(); 
       }
    }
    //修改分类记录数据
    public function modify(){
       $pri = D('Privilege');
       if(IS_POST){
           if($pri->create(I('post.'),2)){//2代表修改操作
               if($pri->save()!==false){ //不修改返回影响行数0所以需要特判修改失败即返回false.
                  $this->success('修改管理权限成功！',U('Privilege/listPri?p='.I('get.p',1)));
                  exit;
               }           
           }
           $this->error($pri->getError());
       }else{
           $id = I('get.id');
           $priData = $pri->select();
           unlimitedCateSingleArr($priData,0,0,$priRes);//show_bug($priRes);die;
           $res = $pri->find($id);
           //show_bug($par);show_bug($res);die;
           $this->assign('pri',$res);//当前要修改的记录
           $this->assign('priRes',$priRes);//全部记录
           $this->assign('pageIndex',I('get.p',1));
           $this->setPageInfo('修改管理权限','管理权限列表',U('Privilege/listPri?p='.I('get.p',1)));
           $this->display();
       }
    }
    //删除分类
    public function delete(){
       $id = I('get.id');
       $pri = D('Privilege');
       if($pri->delete($id)){
         $this->success('删除管理权限成功！',U('Privilege/listPri?p='.I('get.p',1)));
       }else{
         $this->error($pri->getError());
       }
    }
    //显示分类信息
    public function listPri(){
       $pri = M('Privilege');
       static $priData = array();
       if(empty($priData)){
          //数据分页
          $priData = $pri->order('id')->select();   
          unlimitedCateSingleArr($priData,0,0,$priRes); 
       }
       $count = $pri->count();
       $limit = C('pageNum');//每页显示记录条数
       $page = new \Think\Page($count,$limit);
       //由于数据需要处理所以无法使用分页类的方法，于是自己封装了获取单页数据的方法。
       $priRes = getPageInfo($priRes,$page->firstRow,$page->listRows);
       //$cateData = $cateRes->limit($page->firstRow.','.$page->listRows)->select();
       //show_bug($cateRes);die;
       $page->setConfig('prev',"上一页");
       $page->setConfig('next',"下一页");
       //unlimitedCateSingleArr($cateData,0,0,$cateRes);
       //show_bug($cateRes);die;
       $this->assign('page',$page->show());//分页输出
       $this->assign('priRes',$priRes);
       $this->setPageInfo('管理权限列表','添加管理权限',U('Privilege/add?p='.I('get.p',1)));
       $this->assign('pageIndex',I('get.p',1));
       $this->display();
    }
}