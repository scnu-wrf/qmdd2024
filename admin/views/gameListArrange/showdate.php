<?php
    check_request('game_id',0);
    check_request('data_id',0);
    check_request('check_team',0);
    // $_REQUEST['check_team']=1;
    if(!isset($_REQUEST['type'])){
        $_REQUEST['type'] = '';
    }
    $url = 'javascript:;';
    if($_REQUEST['type']=='arrange_list'){
        $url = $this->createUrl('gameListArrange/list',array('game_id'=>$_REQUEST['game_id'],'data_id'=>$_REQUEST['data_id']));
    }
?>
<style>
    .switch{
        width:50px;
    }
    .btn_fath{
        position:relative;
        border-radius:20px;
    }
    .btn1{
        float:left;
    }
    .btn2{
        float:right;
    }
    .btnSwitch{
        height:25px;
        width:25px;
        border:none;
        color:#fff;
        line-height:22px;
        font-size:14px;
        text-align:center;
        z-index:1;
    }
    .move{
        width:20px;
        height:20px;
        z-index:100;
        border-radius:20px;
        cursor:pointer;
        position:absolute;
        border:1px solid #828282;
        background-color:#f1eff0;
        /* box-shadow:1px 2px 2px 1px #fff inset,0 0 5px 1px #999; */
    }
    .on .move{
        left:29px;
    }
    .on.btn_fath{
        background-color:#44b549;
        height:22px
    }
    .off.btn_fath{
        background-color:#828282;
        height:22px
    }
</style>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：赛事/活动/培训 》赛事管理 》赛程发布展示时间</h1>
        <span style="float:right;">
            <a class="btn" href="<?php echo $url; ?>"><i class="fa fa-reply"></i>返回</a>&nbsp;
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>&nbsp;
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="submitType" id="submitType" value="">
                <label style="margin-right:10px;">
                    <span>赛事：</span>
                    <?php echo downList($game_id,'id','game_title','game_id','id="game_id" onchange="changeGameid(this);"'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>项目：</span>
                    <select name="data_id" id="data_id">
                        <option value="">请选择</option>
                    </select>
                </label>
                <button onclick="submitType='find'" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <form id="save_time" name="save_time">
            <div class="box-table">
                <table class="list">
                    <thead>
                        <tr>
                            <th class="list-id">序号</th>
                            <th><?php echo $model->getAttributeLabel('arrange_tcode');?></th>
                            <th><?php echo $model->getAttributeLabel('arrange_tname');?></th>
                            <th><?php echo $model->getAttributeLabel('if_rele');?></th>
                            <th><?php echo $model->getAttributeLabel('rele_date_start');?></th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $index = 1; foreach($arclist as $v){ ?>
                        <tr>
                            <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php echo $v->arrange_tcode; ?></td>
                            <td><?php echo $v->arrange_tname; ?></td>
                            <td>
                                <div class="switch">
                                    <div class="btn_fath clearfix <?php echo ($v->if_rele==649) ? 'on' : 'off'; ?>" onclick="toogle(this,<?php echo $v->id; ?>)">
                                        <div class="move" data-state="<?php echo ($v->if_rele==649) ? 'on' : 'off'; ?>"></div>
                                        <div class="btnSwitch btn1">是</div>
                                        <div class="btnSwitch btn2 ">否</div>
                                    </div>
                                </div>
                            </td>
                            <td style="width: 250px;">
                                <input type="hidden" name="arr_id_<?php echo $index; ?>" value="<?php echo $v->id; ?>">
                                <?php echo '<input type="datetime-local" class="input-text" name="rele_date_start_'.$index.'" value="'.substr($v->rele_date_start,0,10).'T'.substr($v->rele_date_start,-8,-3).'">'; ?>
                            </td>
                            <td>
                                <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id,'game_id'=>$v->game_list->id,'data_id'=>$v->game_list_data->id));?>" title="赛程编辑"><i class="fa fa-edit"></i></a>
                            </td>
                        </tr>
                    <?php $index++; } ?>
                    </tbody>
                </table>
            </div><!--box-table end-->
        </form>
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content || gamesign-lt end-->
</div><!--box end-->
<script>
    changeGameid($('#game_id'));
    function changeGameid(obj){
        var obj = $(obj).val();
        if(obj > 0){
            var pr = '<?php echo $_REQUEST['data_id']; ?>';
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('data_id'); ?>&game_id='+obj,
                dataType: 'json',
                success: function(data) {
                    var s_html = '<option value>请选择</option>';
                    for(var i=0;i<data.length;i++){
                        s_html += '<option value="'+data[i]['id']+'" '+((data[i]['id']==pr) ? 'selected>' : '>')+data[i]['game_data_name']+'</option>';
                    }
                    $('#data_id').html(s_html);
                }
            });
        }
    }

    function toogle(th,id) {
        var ele = $(th).children(".move");
        var re = '';
        if (ele.attr("data-state") == "on") {
            ele.animate({
                left: "0"
            }, 300, function() {
                ele.attr("data-state", "off");
            });
            $(th).removeClass("on").addClass("off");
            re = '0';
        }
        else if (ele.attr("data-state") == "off") {
            ele.animate({
                left: '29px'
            }, 300, function() {
                $(this).attr("data-state", "on");
            });
            $(th).removeClass("off").addClass("on");
            re = '1';
        }
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('rele'); ?>&id='+id+'&if_rele='+re,
            dataType: 'json',
            success: function(data){
                console.log('成功');
            }
        })
    }

    $('.input-text').blur(function(){
        if(this.value=='' || this.value==undefined){
            console.log('为空');
            return false;
        }
        var form=$('#save_time').serialize();
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('saveReleTime',array('index'=>$index)); ?>',
            data: form,
            dataType: 'json',
            success: function(data){
                if(data==1){
                    console.log('成功');
                }
            }
        });
    });
</script>