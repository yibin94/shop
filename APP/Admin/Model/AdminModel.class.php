<?php
namespace Admin\Model;
use Think\Model;
header('Content-Type:text/html;charset=utf-8;');

class AdminModel extends Model
{
    protected $insertFields = 'username,password,repassword,is_use';//允许插入的字段
    protected $updateFields = 'id,username,password,repassword,is_use';//允许修改的字段

    //登录的验证
    public $_loginValidate = array(
       array('username','require','用户名不能为空！',1),
       array('password','require','密码不能为空！',1),
       array('verifyCode','require','验证码不能为空！',1),
       array('verifyCode','verifyCheck','验证码错误！',1,'callback'),
    );
    //添加管理员的验证
    //第六个参数（1新增数据时候验证,2编辑数据时候验证,3全部情况验证）
    protected $_validate = array(
         array('username','require','管理员名称不能为空！',1,'',3),
         array('password','require','密码不能为空！',1,'',1),
         array('repassword','password','确认密码不正确！',1,'confirm',1),
         array('username','1,30','管理员名称必须在1~30个字符之间！',1,'length'),
         array('username','','该管理员已存在！',1,'unique',3),
    );
    //处理登录操作
    public function login(){
        //show_bug($_POST); die;
        //获取表单中的用户名和密码
        $username = $this->username;
        $password = $this->password;
        $user = $this->where(array('username'=>$username))->find();
        //show_bug($user);
        if($user){
            if($user['id']==1 || $user['is_use']==1){//超级管理员id=1不被禁用。
                if($user['password']==md5($password.C('pwd_suffix'))){
                    //登录成功将信息存入session.
                    session('id',$user['id']);
                    session('username',$user['username']);
                    return true;
                }else{
                    $this->error = "用户名或密码错误！";
                    return false;
                }
            }else{
                $this->error = "此用户被禁用！";
                return false;
            }
        }else{
            $this->error = "用户名或密码错误！";
            return false;
        }
    }
    //检测验证码        
    public function verifyCheck($code){
        $verify = new \Think\Verify();
        return $verify->check($code);
    }

    //插入前
    protected function _before_insert(&$data,$option){
       $data['password'] = md5($data['password'].C('pwd_suffix'));
    }
    //插入后
    protected function _after_insert($data,$option)
    {
        //show_bug($data);show_bug($option);show_bug(I('post.'));die;
        $adminId = $data['id'];
        $roles = I('post.')['roles'];
        //将数据插入管理员角色表
        $admin_role = M('AdminRole');
        foreach($roles as $v){
           $admin_role->add(
              array(
                  'role_id' => $v,
                  'admin_id' => $adminId
              )
           );
        }
    }
    //修改前
    protected function _before_update(&$data,$option){
        //show_bug($data);show_bug($option);
        $adminId = $option['where']['id'];

        //判断如果密码留空则删除表单提交过来的password字段，因为不用更新。
        if($data['password']=='')
            unset($data['password']);
        else
            $data['password'] = md5($data['password'].C('pwd_suffix'));//md5加密
        //更新管理员角色表(先删后增)
        $adminRole = M('AdminRole');
        $adminRole->where(array('admin_id'=>$adminId))->delete();
        $roleIds = $_POST['role_name'];
        foreach($roleIds as $rd){
           $adminRole->add(array(
               'admin_id'=>$adminId,
               'role_id'=>$rd
            ));
        }
    }
    //删除前
    protected function _before_delete($option){
        $adminId = $option['where']['id'];
        //如果是超级管理员（id=1）则不允许删除
        if($adminId==1){
            $this->error = '超级管理员不能被删除！';
            return false;
        }
        //删除管理员进角色表中此管理员的相关记录
        M('AdminRole')->where(array('admin_id'=>$adminId))->delete();
    }
}