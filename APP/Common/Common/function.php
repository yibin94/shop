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