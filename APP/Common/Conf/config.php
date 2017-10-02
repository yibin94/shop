<?php
return array(
	//'配置项'=>'配置值'
    /* 数据库设置 */
    'DB_TYPE' => 'mysql',     // 数据库类型
    'DB_HOST' => '127.0.0.1', // 服务器地址
    'DB_NAME' => 'shop',          // 数据库名
    'DB_USER' => 'root',      // 用户名
    'DB_PWD' => '',          // 密码
    'DB_PORT' => '3306',        // 端口
    'DB_PREFIX' => 'shop_',    // 数据库表前缀
    'DB_CHARSET'=>'utf8',    //数据库字符集

    //模板路径替换
    'TMPL_PARSE_STRING' => array(
       '__HomeJs__' => __ROOT__.'/Public/Home/js',
       '__HomeCss__' => __ROOT__.'/Public/Home/css',
       '__HomeImg__' => __ROOT__.'/Public/Home/imgs',
       '__AdminJs__' => __ROOT__.'/Public/Admin/js',
       '__AdminCss__' => __ROOT__.'/Public/Admin/css',
       '__AdminImg__' => __ROOT__.'/Public/Admin/imgs'
    ),
    'SHOW_PAGE_TRACE' => 'true',
    //文件上传参数配置
    'uploadConfig' => array(
      'maxSize' => 3145728,// 设置附件上传大小 
      'exts' => array('jpg', 'gif', 'png', 'jpeg'),//设置附件上传类型  
      'rootPath' => './Uploads/',// 设置附件上传根目录 
      'savePath' => 'images/',// 设置附件上传（子）目录
    ),
    'DEFAULT_FILTER'=> 'trim,avoidXSS',//过滤 空格 和 xss 的配置项
    //超级管理员密码的md5加密前的后缀
    'pwd_suffix' => 'yibin94',
    //验证码配置参数
    'verifyConfig' => array(
      'fontSize'  =>  15,              // 验证码字体大小(px)
      'useNoise'  =>  true,            // 是否添加杂点  
      'imageH'    =>  32,               // 验证码图片高度
      'imageW'    =>  120,               // 验证码图片宽度
      'length'    =>  4,               // 验证码位数
      'fontttf'   =>  '5.ttf',              // 验证码字体，不设置随机获取
    ),
    'pageNum' => 3,
);