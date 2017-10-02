<?php
namespace Admin\Model;
use Think\Model;
header('Content-Type:text/html;charset=utf-8');

class GoodsModel extends Model{
    // 新增数据的时候允许写入的字段
    protected $insertFields = 'goods_name,price,goods_desc,is_on_sale'; 
    // 修改数据的时候允许写入的字段(加上id才不会验证以下定义的字段规则)
    protected $updateFields = 'id,goods_name,price,goods_desc,is_on_sale';
    //定义表单验证的规则，调用控制器中的create方法时自动验证。
    protected $_validate = array(
       array('goods_name','require','商品名称不能为空！',1),
       array('goods_name','1,45','商品名称必须在1~45个字符之内！',1,'length'),
       array('goods_name','','该商品名称已存在！',1,'unique'),
       array('price','currency','价格必须是货币格式！',1),
       array('is_on_sale','0,1','是否上架只能是0,1两个值！',1,'in')
    );
    //tp在调用add()方法之前要调用的方法_before_insert(&$data,$option).
    // 插入数据前的回调方法
    //第一个参数：表单中的数据（要插入到数据库的数据），是一维数组。
    //第二个参数：额外信息：当前模型对应的实际的表名是什么。
    //说明：在这个函数中需要改变这个函数外部的数据，所以使用引用传递。
    protected function _before_insert(&$data,$option){
        //获取当前时间
        $data['addtime'] = time();
        //show_bug($_FILES);die;
        if(!$_FILES['goods_logo']['error']){//有选择图片
             //$this->upload($data,$_FILES['goods_logo']);
             $res = uploadFile($_FILES['goods_logo'],array(//假设最多上传10张缩略图
                        array(150,200),//缩略图宽高
                        array(200,250)
                     ));
             if($res['success']==1){
                 $data['logo'] = $res['images'][0];
                 if($res['images'][1]){
                    $data['sm_logo'] = $res['images'][1];
                 }
                 return true;
             }else{
                 $this->error = $res['error'];
                 return false;
             }
        }
    }
    public function upload(&$data,$file){//记得传递引用数据（才能修改源数据）
            $upload = new \Think\Upload(C('uploadConfig'));       
            $info = $upload->uploadOne($file); 
            //show_bug($info);  
            if(!$info) {// 上传错误提示错误信息 
                 //把上传失败的错误信息存到模型中
                 $this->error = $upload->getError();  
                 return FALSE; //返回控制器
            }else{// 上传成功 
                 //echo $upload->rootPath;die;
                 //$this->success('上传成功！'); 
                 $path = $info['savepath'].$info['savename'];
                 $data['logo'] = $path;//添加到收集的表单数据数组中。
                 //生成缩略图并设置路径
                 $thumbImgPath = $this->thumbImg(C('uploadConfig.rootPath'),$info['savepath'],$info['savename']);
                 //echo $thumbImgPath;
                 $data['sm_logo'] = $thumbImgPath;//存入数据库的缩略图路径
            }
    }
    public function thumbImg($rootPath,$savePath,$saveName){//产生缩略图
       $image = new \Think\Image(); 
       $srcImg = $rootPath.$savePath.$saveName;
       $thumbImgPath = $savePath.'sm_'.$saveName;
       $image->open($srcImg); 
       // 按照原图的比例生成一个最大为150*150的缩略图
       $image->thumb(150, 150)->save($rootPath.$thumbImgPath);//保存到项目中
       return $thumbImgPath;
    }
    //显示搜索后商品的操作结果
    public function getData(){
        //show_bug($_GET);
        $conditions = array();
        if($_GET){
            if($goods_name = I('get.goods_name'))
                $conditions['goods_name'] = array('like',"%$goods_name%");
            $start_price = I('get.start_price');
            $end_price = I('get.end_price');
            if($start_price&&$end_price&&$start_price<=$end_price)
                $conditions['price'] = array('between',"$start_price,$end_price");
            elseif($start_price&&!$end_price)
                $conditions['price'] = array('egt',"$start_price");
            elseif(!$start_price&&$end_price)
                $conditions['price'] = array('elt',"$end_price");
            /* 添加时间 */
            $start_addtime = I('get.start_addtime');
            $end_addtime = I('get.end_addtime');
            if($start_addtime&&$end_addtime&&$start_addtime<=$end_addtime)
                $conditions['addtime'] = array('between',array(strtotime("$start_addtime 00:00:00"),strtotime("$end_addtime 23:59:59")));
            elseif($start_addtime&&!$end_addtime)
                $conditions['addtime'] = array('egt',strtotime("$start_addtime 00:00:00"));
            elseif(!$start_addtime&&$end_price)
                $conditions['addtime'] = array('elt',strtotime("$end_addtime 23:59:59"));
            $is_on_sale = I('get.is_on_sale',-1);
            if($is_on_sale!=-1)
                $conditions['is_on_sale'] = array('eq',$is_on_sale);
            $is_delete = I('get.is_delete',-1);
            if($is_delete!=-1)
                $conditions['is_delete'] = array('eq',$is_delete);
            $order = I('get.orderBy','addtime_asc');
            $orderBy = 'id asc';//默认添加时间升序
            if($order=='id_desc')
                $orderBy = 'id desc';
            elseif($order=='price_asc')
                $orderBy = 'price asc';
            elseif($order=='price_desc')
                $orderBy = 'price desc';
            //show_bug($conditions);
        }

        $count = $this->where($conditions)->count();// 查询满足要求的总记录数 
        //echo $count;die;
        $Page = new \Think\Page($count,3);// 实例化分页类 传入总记录数和每页显示的记录数(3) 
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $show = $Page->show();// 分页显示输出 
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性 
        $list = $this->limit($Page->firstRow.','.$Page->listRows)->where($conditions)->order($orderBy)->select();  
        $data = array(
           'list' => $list,
           'page' => $show   
        );
        return $data;
    }

    // 删除数据前的回调方法
    protected function _before_delete($options) {
        //show_bug($options);die;
        $id = $options['where']['id'];
        $res = $this->field('logo,sm_logo')->find($id);
        //show_bug($res);
        //删除项目上存放的图片
        deleteImg($res['logo']);
        deleteImg($res['sm_logo']);
    }   

    //更新数据之前的回调方法
    protected function _before_update(&$data, $options){
        //show_bug($data); show_bug($options);show_bug($_FILES);
        //判断是否选择了图片上传，是的话处理图片替换（删除旧图片存储新图片）
        if(!$_FILES['goods_logo']['error']){
            $picsToDelete = $this->field('logo,sm_logo')->find($options['where']['id']);
            //删除项目中的旧图片
            deleteImg($picsToDelete['logo']);
            $path = explode('_', $picsToDelete['sm_logo']);
            for($i=1;$i<=10;$i++){//假设最多上传10张缩略图,所以删除10张.
                deleteImg($path[0].'_'.$i.'_'.$path[2]);
            }
            //增加新上传的图片到项目中再设置图片存储路径到表单数据中（数据库）
            //$this->upload($data,$_FILES['goods_logo']);
             $res = uploadFile($_FILES['goods_logo'],array(
                        array(150,200),//缩略图宽高
             ));
             if($res['success']==1){
                 $data['logo'] = $res['images'][0];
                 if($res['images'][1]){
                    $data['sm_logo'] = $res['images'][1];
                 }
                 return true;
             }else{
                 $this->error = $res['error'];
                 return false;
             }
        }
    }

 }