<?php
namespace Admin\Model;
use Think\Model;
class RoleModel extends Model 
{
	protected $insertFields = 'role_name';
	protected $updateFields = 'id,role_name';
	protected $_validate = array(
		array('role_name', 'require', '角色名称不能为空！', 1, 'regex', 3),
		array('role_name', '1,30', '角色名称的值最长不能超过 30 个字符！', 1, 'length', 3),
	);
    //插入之后
    protected function _after_insert($data,$option){
    	//show_bug($data);show_bug($option);show_bug(I('post.pri_id'));die;
        $role_id = $data['id'];
        $pri_ids = I('post.pri_id');
        foreach($pri_ids as $pri_id){
        	$sql = 'INSERT INTO '.C('DB_PREFIX').'role_privilege (`role_id`,`pri_id`) VALUES('.$role_id.','.$pri_id.')';
        	$this->execute($sql);
        }
    }
	// 修改前
	protected function _before_update($data, $option)
	{
		//show_bug(I('post.pri_id'));die;
		$pri_ids = I('post.pri_id');
		$role_id = I('post.id');
		$role_pri = M('RolePrivilege');
		//先删除原先跟此角色id关联的权限(因为一个角色对应多个权限所以只需删除角色id就可以全部删除对应的权限id)
		$role_pri->where(array('role_id'=>$role_id))->delete();
		//依次添加此角色修改后拥有的权限
		foreach ($pri_ids as $v) {
			$role_pri->add(
               array(
               	 'role_id' => $role_id,
               	 'pri_id' => $v
               	)
            );
		}
	}
	// 删除前
	protected function _before_delete($option)
	{
        $role_id = $option['where']['id'];
        //如果该角色属于管理员则不能删除(管理员角色表)
        $isManager = M('AdminRole')->where(array('role'=>$role_id))->count();
        if($isManager){
            $this->error = '此角色属于管理员的角色，无法删除！';
            return false;
        }else{
			//先删除原先跟此角色id关联的权限(因为一个角色对应多个权限所以只需删除角色id就可以全部删除对应的权限id)
			M('RolePrivilege')->where(array('role_id'=>$role_id))->delete();	
        }
	}
}