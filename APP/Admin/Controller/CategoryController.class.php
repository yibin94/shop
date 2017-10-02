<?php
namespace Admin\Controller;
header('Content-Type:text/html;charset=utf8;');

class CategoryController extends ValidateController
{
    //添加分类
    public function add(){
       $cate = D('Category');
       if(IS_POST){
          if($cate->create(I('post.'),1)){//1代表增加数据的操作
             if($cate->add()){
                $this->success('添加商品分类成功！',U('Category/listCate?p='.I('get.p',1)));
                exit;//跳出最外层if,不执行以下语句.
             }
          }
          $this->error($cate->getError());
       }else{
          $cateData = $cate->select();
          unlimitedCateSingleArr($cateData,0,0,$cateRes);
          //show_bug($cateRes);die;

          $this->assign('cateRes',$cateRes);
          $this->assign('pageIndex',I('get.p',1));
          $this->setPageInfo('添加商品分类','商品分类列表',U('Category/listCate?p='.I('get.p',1)));
          $this->display(); 
       }
    }
    //修改分类记录数据
    public function modify(){
       $cate = D('Category');
       if(IS_POST){
           if($cate->create(I('post.'),2)){//2代表修改操作
               if($cate->save()!==false){ //不修改返回影响行数0所以需要特判修改失败即返回false.
                  $this->success('修改分类数据成功！',U('Category/listCate?p='.I('get.p',1)));
                  exit;
               }           
           }
           $this->error($cate->getError());
       }else{
           $id = I('get.id');
           $cateData = $cate->select();
           unlimitedCateSingleArr($cateData,0,0,$cateRes);
           $res = $cate->find($id);
           if($res['parent_id']==0)
               $par = '顶级权限';
           else//通过id字段值(prama1)查询另一字段值(prama2).
               $par = $cate->getFieldById($res['parent_id'],'cat_name');
           //show_bug($par);show_bug($res);die;
           $this->assign('parCate',$par);
           $this->assign('cate',$res);
           $this->assign('cateRes',$cateRes);
           $this->assign('pageIndex',I('get.p',1));
           $this->setPageInfo('修改商品分类','商品分类列表',U('Category/listCate?p='.I('get.p',1)));
           $this->display();
       }
    }
    //删除分类
    public function delete(){
       $id = I('get.id');
       $cate = D('Category');
       if($cate->delete($id)){
         $this->success('删除分类成功！',U('Category/listCate?p='.I('get.p',1)));
       }else{
         $this->error($cate->getError());
       }
    }
    //显示分类信息
    public function listCate(){
       $cate = M('Category');
       static $cateData = array();
       if(empty($cateData)){
          //数据分页
          $cateData = $cate->order('id')->select();
          unlimitedCateSingleArr($cateData,0,0,$cateRes);
       }
       $count = $cate->count();
       $limit = C('pageNum');//每页显示记录条数
       $page = new \Think\Page($count,$limit);
       //由于数据需要处理所以无法使用分页类的方法，于是自己封装了获取单页数据的方法。
       $cateRes = getPageInfo($cateRes,$page->firstRow,$page->listRows);
       //$cateData = $cateRes->limit($page->firstRow.','.$page->listRows)->select();
       //show_bug($cateRes);die;
       $page->setConfig('prev',"上一页");
       $page->setConfig('next',"下一页");
       //unlimitedCateSingleArr($cateData,0,0,$cateRes);
       //show_bug($cateRes);die;
       $this->assign('page',$page->show());//分页输出
       $this->assign('cates',$cateRes);
       $this->setPageInfo('商品分类列表','添加商品分类',U('Category/add?p='.I('get.p',1)));
       $this->assign('pageIndex',I('get.p',1));
       $this->display();
    }
}