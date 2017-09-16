<?php
namespace Admin\Controller;
use Think\Controller;
header('Content-Type:text/html;charset=utf-8');

class GoodsController extends Controller{
    //添加商品操作
    public function add(){
        if(IS_POST){
            //D和M的区别：D生成我们自己创建的模型对象，M生成TP自带的模型对象
            //a.接收表单中所有的数据并存到模型中 b.使用I函数过滤数据 c.根据模型中定义的规则验证表单
            $goods = D('Goods');
            //<=>$goods = new \Admin\Model\GoodsModel();
            if($goods->create(I('post.'),1)){//收集表单数据并自动验证(I('post.'):create方法要接收的数据过滤之后的$_POST;1指定当前是添加的表单.)
                if($goods->add()){
                    $this->success('添加成功！',U('listGoods'),true);
                }else{
                    $this->error('添加失败！',U('add'),true);
                }
            }else{
                 $this->error($goods->getError(),U('add'),true);
            }
        }
        else{
            $this->display();            
        }
    }
    //修改商品操作
    public function modify(){
        $goods = D('Goods');
        if(IS_POST){
            if($goods->create(I('post.'),2)){//收集表单数据并自动验证(I('post.'):create方法要接收的数据过滤之后的$_POST;2指定当前是修改的表单.)
            //save()返回受影响的行数，没修改就返回0，为false才是修改失败，受所以要特判！
                if($goods->save()!==false){
                    $this->success('修改记录成功！',U('listGoods?p='.I('get.p')));
                }else{
                    $this->error('修改记录失败！',U('modify?id='.I('post.id')));
                }
            }else{
                $this->error($goods->getError(),U('modify?id='.I('post.id')));
            }
        }
        else{
            $res = $goods->find(I('get.id'));
            $this->assign('pageIndex',I('get.p'));
            $this->assign('goods',$res);
            $this->assign('rootpath',__ROOT__.ltrim(C('uploadConfig.rootPath'),'.'));
            $this->display();            
        }
    }
    //删除商品操作
    public function delete(){
        $goods = D('Goods');
        if($goods->delete(I('get.id'))){
            $this->success('删除记录成功!',U('Admin/Goods/listGoods/p/'.I('get.p')));
        }else{
            $this->error('删除记录失败！');
        }
    }
    //显示商品操作
    public function listGoods(){
        $goods = D('Goods');//实例化自定义的模型
        $data = $goods->getData();//show_bug($data);
        $this->assign('list',$data['list']);
        $this->assign('page',$data['page']);
        //echo __ROOT__.ltrim(C('uploadConfig.rootPath'),'.');die;
        $this->assign('rootpath',__ROOT__.ltrim(C('uploadConfig.rootPath'),'.'));
        $this->display();
    }
}