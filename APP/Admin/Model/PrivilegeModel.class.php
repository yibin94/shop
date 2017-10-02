<?php
namespace Admin\Model;
use Think\Model;
class PrivilegeModel extends Model 
{
	protected $insertFields = array('pri_name','module_name','controller_name','action_name','parent_id');
	protected $updateFields = array('id','pri_name','module_name','controller_name','action_name','parent_id');
	protected $_validate = array(
		array('pri_name', 'require', '权限名称不能为空！', 1, 'regex', 3),
		array('pri_name', '1,30', '权限名称的值最长不能超过 30 个字符！', 1, 'length', 3),
		array('module_name', 'require', '模块名称不能为空！', 1, 'regex', 3),
		array('module_name', '1,10', '模块名称的值最长不能超过 10 个字符！', 1, 'length', 3),
		array('controller_name', 'require', '控制器名称不能为空！', 1, 'regex', 3),
		array('controller_name', '1,10', '控制器名称的值最长不能超过 10 个字符！', 1, 'length', 3),
		array('action_name', 'require', '方法名称不能为空！', 1, 'regex', 3),
		array('action_name', '1,12', '方法名称的值最长不能超过 10 个字符！', 1, 'length', 3),
		array('parent_id', 'number', '上级权限的id，0代表顶级权限必须是一个整数！', 2, 'regex', 3),
	);
	
	// 修改前
	protected function _before_update($data, $option)
	{
        //执行修改save()之前判断其填写的父级权限id有没有在范围内部
        $priData = $this->select();
        unlimitedCateSingleArr($priData,0,0,$priRes);//show_bug($priRes);
        $ids = array(0);
        $id = $option['where']['id'];
        foreach ($priRes as $v) {
            if($v['id']==$id) continue;
            $ids[] = $v['id'];
        }
        if(!in_array(I('post.parent_id'),$ids)){//填写的父级权限不符合要求则返回错误。
           $this->error = "你填写的父级权限 id 值不存在！请根据下表选择填写。";
            return false;//记得写此句（不然还是可以通过判断。。）
        }else{
            return true;
        }
	} 
    //向数据库删除数据前自动调用的函数
    protected function _before_delete($option)
    {
       //show_bug($option);die;
       $id = $option['where']['id'];
       $priData = $this->select();
       getChildren($priData,$id,$output);//获取$id所有的子节点(子孙等)
       if($output){
         $res = implode(',',$output);//将数组元素组合成字符串
         $sql = 'DELETE FROM '.C('DB_PREFIX').'privilege WHERE id IN('.$res.')';
         if($this->execute($sql)){//$this->delete($res)调用之前会调用_before_delete()即本函数，但是经测试也可以不报错！只重复调用了一次！不过最好不用。
             return true;
         }else{
             $this->error = $this->getError();
             return false;
         }
       }
    }
}