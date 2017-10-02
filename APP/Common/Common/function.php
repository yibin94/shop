<?php

  function show_bug($msg){
    echo dump($msg,1,'<pre>',0);//<pre>格式化输出信息
  }

  function avoidXSS($content){
     //实现了一个单例模式，这个函数调用多次时只有第一次调用时生成了一个对象，
     //之后再调用时使用的是第一次生成的对象（只生成一个对象），使性能更好！
     static $obj = null;
     if($obj === null){
        require('./HTMLPurifier/HTMLPurifier.includes.php');
        $config = HTMLPurifier_Config::createDefault();
        //保留a标签上的target属性
        $config->set('HTML.TargetBlank',TRUE);
        $obj = new HTMLPurifier($config);
     }
     return $obj->purify($content);
  }
  //上传文件代码封装
  function uploadFile($srcLogo,$thumb=array()){
        $rootPath = C('uploadConfig.rootPath');
        $upload = new \Think\Upload(C('uploadConfig'));     
        $info = $upload->uploadOne($srcLogo);
        if(!$info) {// 上传错误提示错误信息 
             //把上传失败的错误信息存到模型中
             $res['success'] = 0;
             $res['error'] = $upload->getError();
             return FALSE; 
        }else{// 上传成功 
             $savepath = $info['savepath'];
             $savename = $info['savename'];
             $res['success'] = 1;
             $res['images'][0] = $savepath.$savename;//原图在数据库的存放路径
             if($thumb){
                foreach($thumb as $k=>$v){//遍历缩略图数组
                   $thumbImgPath = $savepath.'sm_'.($k+1).'_'.$savename;//缩略图在数据库的存放路径
                   $image = new \Think\Image();
                   $image->open($rootPath.$res['images'][0]);//打开项目中的原图
                   $image->thumb($v[0], $v[1])->save($rootPath.$thumbImgPath);//保存缩略图到项目上
                   $res['images'][$k+1] = $thumbImgPath;
                }
             }
             return $res;
        }
  }

  //显示图片
  function showImg($url,$width='',$height=''){
    $url = __ROOT__.ltrim(C('uploadConfig.rootPath'),'.').$url;//根路径
    if($width)
      $width = "width='$width'";
    if($height)
      $height = "height='$height'";
    echo "<img src='$url' $width $height/>";
  }
  //删除图片
  function deleteImg($img){
    $rootPath = C('uploadConfig.rootPath');//根路径
    @unlink($rootPath.$img);
  }

      /**
     * [unlimitedCate 以树状形式(父子关系清晰)形式]
     * @param  array  $arr    [分类数据的数组]
     * @param  [type] $par_id [父级分类的id]
     * @param  [type] $num    [标识孩子层级关系的标志数目]
     * @return [type]         [按父子关系显示的结果数组]
     */
    function unlimitedCate($arr=array(),$par_id=0,$num=0)
    {
       if(!$arr) return;
       $output = array();
       foreach($arr as $v){
          if($v['parent_id']==$par_id){
             $v['flag']=str_repeat('+++',$num);
             $v['children'] = unlimitedCate($arr,$v['id'],$num+1);
             $output[] = $v;
          }
       }  
       return $output;
    }
    //
    /**
     * [unlimitedCateSingleArr 一维数组形式显示分类数据（便于遍历）]
     * @param  array   $arr    [分类数据的数组]
     * @param  integer $par_id [父级分类的id]
     * @param  integer $num    [标识孩子层级关系的标志数目]
     * @param  [type]  $output [一维形式的结果数组]
     */
    function unlimitedCateSingleArr($arr=array(),$par_id=0,$num=0,&$output)//一维数组形式显示(便于遍历)
    {
       if(!$arr) return;
       foreach($arr as $v){
          if($v['parent_id']==$par_id){
             $v['flag'] = str_repeat('+++',$num);
             $v['level'] = $num; 
             $output[] = $v;
             unlimitedCateSingleArr($arr,$v['id'],$num+1,$output);
          }
       }
    }

    /**
     * [getChildren 根据id获取其下的所有子辈（孩子和孙子等）]
     * @param  array   $srcArr    [分类数据的数组]
     * @param  integer $id [要查找子分类的id]
     * @param  [type]  $output [一维形式的结果数组]
     */
    function getChildren($srcArr=array(),$id=0,&$output)
    {
       if(!$srcArr) return;
       foreach($srcArr as $v){
          if($v['parent_id']==$id){
            $output[] = $v['id'];
            getChildren($srcArr,$v['id'],$output);
          }
       }
    }
    /**
     * [getPageInfo 返回指定的分页数据数组]
     * @param  array   $arr    [源数据数组]
     * @param  integer $startRow [开始的记录行号]
     * @param  [type]  $num [要取的记录数]
     */
    function getPageInfo($arr,$startRow,$num){
       $res = array();
       $count = count($arr);
       for($i=$startRow;$i<$startRow+$num&&$i<$count;++$i){
          $res[] = $arr[$i];
       }
       return $res;
    }
