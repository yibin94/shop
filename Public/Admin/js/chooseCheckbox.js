   $(function(){
        $(":checkbox").click(function(){
        //选中所有的checkbox元素并添加点击事件
            var curLevel = $(this).attr('level');
            if($(this).attr('checked')){
            //点击该checkbox后状态为选中
                //让其子元素都选中
                var next = $(this).nextAll(":checkbox");
                $(next).each(function(k,v){
                    if($(v).attr('level')>curLevel){
                        $(v).attr('checked','checked');
                    }else{
                        return false;
                    }
                });
                //让其父元素都选中
                var prev = $(this).prevAll(":checkbox");
                var tmpLevel = curLevel;
                $(prev).each(function(k,v){
                    if($(v).attr('level')<tmpLevel){
                        //找到一个就减一级
                        --tmpLevel;
                        $(v).attr('checked','checked');
                    }
                });
            }
            else{
            //点击该checkbox后状态为空（去掉勾选状态）
                //去掉子元素的勾选状态
                var next = $(this).nextAll(':checkbox');
                $(next).each(function(k,v){
                    if($(v).attr('level')>curLevel){
                        $(v).removeAttr('checked');
                    }else{
                        return false;
                    }
                })
            }
        });
   });