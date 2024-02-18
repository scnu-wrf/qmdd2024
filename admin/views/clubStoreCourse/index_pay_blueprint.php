<div class="box">
    <div class="box-title c">
        <h1>当前界面：培训/活动》课程收费方案》课程收费方案</h1>
        <span style="float:right;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>&nbsp;
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>日期：</span>
                    <input style="width:80px;" class="input-text" type="text" id="start" name="start" value="<?php echo $start;?>">
                    <span>-</span>
                    <input style="width:80px;" class="input-text" type="text" id="end" name="end" value="<?php echo $end;?>">
                </label>
                <label>
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" id="keywords" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="方案编号、方案标题、使用方案单位">
                </label>
                <button id="submit_button" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th>序号</th>
                        <th>收费方案编号</th>
                        <th>收费课程标题</th>
                        <th><?php echo $model->getAttributeLabel('star_time1');?></th>
                        <th><?php echo $model->getAttributeLabel('end_time1');?></th>
                        <th><?php echo $model->getAttributeLabel('supplier_name1');?></th>
                        <th><?php echo $model->getAttributeLabel('product_code');?></th>
                        <th><?php echo $model->getAttributeLabel('product_name');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 1; $fee = ClubMembershipFee::model()->find('code="TS53"'); foreach($arclist as $v){ ?>
                        <tr>
                            <td><span class="num num-1"><?php echo $index; ?></span></td>
                            <td><?php echo $v->event_code; ?></td>
                            <td><?php echo $v->event_title; ?></td>
                            <td><?php echo $v->star_time; ?></td>
                            <td><?php echo $v->end_time; ?></td>
                            <td><?php echo $v->supplier_name; ?></td>
                            <td><?php if(!empty($fee)){ echo $fee->product_code; }?></td>
                            <td><?php if(!empty($fee)){ echo $fee->product_name; }?></td>
                            <td>
                                <?php echo show_command('详情',$this->createUrl('pay_blueprint_details',array('id'=>$v->id)),'查看'); ?>
                                <a href="javascript:;" class="btn" onclick="clickRefresh(<?php echo $v->id; ?>);">刷新</a>
                            </td>
                        </tr>
                    <?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages);?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var $start_time=$('#start');
    var $end_time=$('#end');
    $start_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    $end_time.on('click', function(){
         WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });

    function clickRefresh(id){
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('gameList/refresh'); ?>&id='+id,
            dataType: 'json',
            success: function(data){
                if(data.status==1){
                    we.success(data.msg, data.redirect);
                }
                else{
                    we.msg('minus',data.msg);
                }
            },
            errer: function(request){
                console.log(request);
            }
        });
    }
</script>