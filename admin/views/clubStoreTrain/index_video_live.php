<div class="box">
    <div class="box-title c">
        <h1>当前界面：首页 》直播关联 》培训直播关联</h1>
        <span style="float:right;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <?php echo show_command('添加','javascript:;','添加','onclick="fnVideoLive()"'); ?>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label>
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" id="keywords" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="">
                </label>
                <button id="submit_button" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th>序号</th>
                        <th><?php echo $model->getAttributeLabel('train_title');?></th>
                        <th>关联直播</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                <?php $basepath=BasePath::model()->getPath(118);?>
                    <?php $index = 1; foreach($arclist as $v){ ?>
                        <tr>
                            <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php echo $v->train_title; ?></td>
                            <td>
                                <?php echo $v->video_title;?>
                            </td>
                            <td>
                                <a class="btn" href="javascript:;" onclick="we.unuse2(<?php echo $v->id.','.$v->video_id;?>, relieveUrl);" title="解除">解除</a>
                            </td>
                        </tr>
                    <?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages);?></div>
    </div><!--box-content end-->
</div><!--box end-->
<?php
    $videoList=VideoLive::model()->findAll('club_id='.get_session('club_id'));
?>
<script>
var videoList=<?php echo json_encode(toArray($videoList,'id,title'));?>
</script>
<script>
    var relieveUrl = '<?php echo $this->createUrl('relieve', array('id'=>'ID','video_id'=>'VIDEID'));?>';

    we.unuse2 = function(id, video_id, url) {
        we.overlay('show');
        if (id == '' || id == undefined) {
            we.msg('error', '请选择要解除的内容', function() {
                we.loading('hide');
            });
            return false;
        }
        var fnUnuse = function() {
            url = url.replace(/ID/, id);
            url = url.replace(/VIDEID/, video_id);
            $.ajax({
                type: 'get',
                url: url,
                dataType: 'json',
                success: function(data) {
                    if (data.status == 1) {
                        we.msg('check', data.msg, function() {
                            we.loading('hide');
                            we.reload();
                        });
                    } else {
                        we.msg('error', data.msg, function() {
                            we.loading('hide');
                        });
                    }
                }
            });
        };
        $.fallr('show', {
            buttons: {
                button1: {text: '解除', danger: true, onclick: fnUnuse},
                button2: {text: '取消'}
            },
            content: '确定解除？',
            icon: 'trash',
            afterHide: function() {
                we.loading('hide');
            }
        });
    };

    // 关联直播设置
    function fnVideoLive(){
        var add_html = 
            '<div id="add_format" style="width:500px;">'+
                '<form id="add_form" name="add_form">'+
                    '<table class="list" id="table_tag" style="width:100%;border: solid 1px #d9d9d9;">'+
                        '<tr>'+
                            '<td style="width:10%;padding: 5px;">选择名称</td>'+
                            '<td style="width:40%;">'+
                                '<span id="train_box"></span>'+
                                '<input id="train_id" name="train_id" type="hidden">'+
                                '<input id="train_btn" class="btn" type="button" value="选择">'+
                            '</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td style="padding: 5px;">关联直播</td>'+
                            '<td>'+
                                '<span id="live_box"></span>'+
                                '<input id="video_live_id" name="video_live_id" type="hidden">'+
                                '<input id="live_select_btn" class="btn" type="button" value="添加">'+
                            '</td>'+
                        '</tr>'+
                    '</table>'+
                '</form>'+
            '</div>';
        if_data=0;
        $.dialog({
            id:'tianjia',
            lock:true,
            opacity:0.3,
            // height: '60%',
            // width:'80%',
            title:'弹窗',
            content:add_html,
            button:[
                {
                    name:'确定',
                    callback:function(){
                        if($("#train_id").val()==''){
                            we.msg('minus', '请选择赛事名称');
                            return false;
                        }
                        if($("#video_live_id").val()==''){
                            we.msg('minus', '请选择关联直播');
                            return false;
                        }
                        return fn_add_tr();
                    },
					
                    focus:true
                },
                {
                    name:'取消',
                    callback:function(){
                        return true;
                    }
                }
            ]
        });
        $('.aui_main').css('height','auto');
    }
    
    var club_id=<?php echo get_session('club_id'); ?>;
    $(document).on('click','#train_btn', function(){
        $.dialog.data('id', 0);
        $.dialog.open('<?php echo $this->createUrl("exchange");?>&club_id='+club_id,{
            id:'peixun',
            lock:true,
            opacity:0.3,
            title:'选择培训列表数据',
            width:'500px',
            // height:'60%',
            close: function () {
                if($.dialog.data('id')>0){
                    var data=$.parseJSON($.dialog.data('data'));
                    $("#train_id").val($.dialog.data('id'));
                    $("#train_box").html('<span class="label-box">'+data.train_title+'</span>');
                    var video_live_id=data.video_live_id;
                    $.each(videoList,function(k,info){
                        $.each(video_live_id.split(','),function(m,n){
                            if(info.id==n){
                                var s1='<span class="label-box" id="live_item_'+info.id;
                                s1=s1+'" data-id="'+info.id+'">'+info.title;
                                $("#live_box").append(s1+'<i onclick="fnDeleteLive(this);"></i></span>');
                                fnUpdateLive(); 
                            }
                        })
                    })
                }
            }
        });
    });

    $(document).on('click','#live_select_btn', function(){
        if($("#train_id").val()==''){
            we.msg('minus', '请选择培训名称');
            return false;
        }
        $.dialog.data('video_live_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/videolive_more");?>&club_id='+club_id,{
            id:'zhibo',
            lock:true,
            opacity:0.3,
            title:'选择直播',
            width:'500px',
            // height:'60%',
            close: function () {
                if($.dialog.data('video_live_id')==-1){
                    var boxnum=$.dialog.data('video_live_title');
                    for(var j=0;j<boxnum.length;j++)
                    {
                        if($('#club_item_'+boxnum[j].dataset.id).length==0){    
                            var s1='<span class="label-box" id="live_item_'+boxnum[j].dataset.id;
                            s1=s1+'" data-id="'+boxnum[j].dataset.id+'">'+boxnum[j].dataset.title;
                            $("#live_box").append(s1+'<i onclick="fnDeleteLive(this);"></i></span>');
                            fnUpdateLive(); 
                        }
                    }
                }
            }
        });
    });

    // 直播更新、删除
    var fnUpdateLive=function(){
        var arr=[];
        var id;
        $("#live_box").find('span').each(function(){
            id=$(this).attr('data-id');
            arr.push(id);
        });
        $("#video_live_id").val(we.implode(',', arr)).trigger('blur');
    };

    var fnDeleteLive=function(op){
        $(op).parent().remove();
        fnUpdateLive();
    };
    
    function fn_add_tr(){
        var form=$('#add_form').serialize();
        we.loading('show');
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('addForm',array());?>',
            data: form,
            dataType: 'json',
            success: function(data) {
                if(data.status==1){
                    we.loading('hide');
                    $.dialog.list['tianjia'].close();
                    we.success(data.msg, data.redirect);
                }else{
                    we.loading('hide');
                    we.msg('minus', data.msg);
                }
            }
        });
        return false;
    }
</script>