<?php
namespace Admin\Model;
use Think\Model;
header("Content-Type:text/html;charset=utf8;");

class CategoryModel extends Model
{
    //定义插入的字段
    protected $insertFields = "cat_name,parent_id";
    //定义修改的字段
    protected $updateFields = "id,cat_name,parent_id";
    protected $_validate = array(
         array('cat_name','require','分类名称不能为空！',1),
         array('parent_id','require','分类的父级不能为空！',1),
         array('cat_name','1,30','分类名称必须在1~30个字符之间！',1,'length'),
         array('cat_name','','该分类名称已存在！',1,'unique'),
    );

    //向数据库删除数据前自动调用的函数
    protected function _before_delete($option)
    {
       //show_bug($option);die;
       $id = $option['where']['id'];
       $cateData = $this->select();
       getChildren($cateData,$id,$output);//获取$id所有的子节点(子孙等)
       //show_bug($output); 
       if($output){
         $res = implode(',',$output);//将数组元素组合成字符串
         $sql = 'DELETE FROM '.C('DB_PREFIX').'category WHERE id IN('.$res.')';
         if($this->execute($sql)){//$this->delete($res)调用之前会调用_before_delete()即本函数，但是经测试也可以不报错！只重复调用了一次！不过最好不用。
             return true;
         }else{
             $this->error = $this->getError();
             return false;
         }
       }
    }

}