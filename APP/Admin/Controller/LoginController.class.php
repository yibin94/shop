<?php
namespace Admin\Controller;
use Think\Controller;
header('Content-Type:text/html;charset=utf-8;');
class LoginController extends Controller
{
    //登录
    public function login(){
        if(IS_POST){
            //show_bug($_POST);
            $model = D('Admin');
            //指定登录的验证字段(因为默认当做添加的操作所以过滤了验证码导致登录验证码为空从而登录失败，因此可以在model里$insertFields中添加验证码字段或者通过create(param1,param2))中的param2来指定(1添加,2修改,所以自定义数字做登录操作标识符比如下面的9)
            if($model->validate($model->_loginValidate)->create(I('post.'),9)){
               if($model->login()){
                  redirect(U('Index/index'));
                  exit;
               }
            }
            $this->error($model->getError(),U('Login/login'));
        }else{
            $this->display();
        }  
    }
    //生成验证码
    public function verify(){
        $verify = new \Think\Verify(C('verifyConfig'));
        $verifyCode = $verify->entry();
    }
    //退出登录
    public function logout(){
        //清除session里面的用户名和id。
        session('id',null);
        session('username',null);
        redirect(U('Login/login'));
    }
}