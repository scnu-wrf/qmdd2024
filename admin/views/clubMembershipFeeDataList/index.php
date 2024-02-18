<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>应收会员列表</h1></div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <!-- <a class="btn" href="<?php //echo $this->createUrl('create');?>"><i class="fa fa-plus"></i>添加</a> -->
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url; ?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r'); ?>">
                <label style="margin-right:20px;">
                    <span>单位：</span>
                    <select name="club_id">
                        <option value="">请选择</option>
                        <?php foreach($club_id as $v){?>
                            <option value="<?php echo $v->id;?>"<?php if(Yii::app()->request->getParam('club_id')!==null && Yii::app()->request->getParam('club_id')!=='' && Yii::app()->request->getParam('club_id')==$v->id){?> selected<?php }?>><?php echo $v->club_name;?></option>
                        <?php }?>
                    </select>
                </label>
                <label style="margin-right:10px;">
                    <span>缴费日期：</span>
                    <input type="text" style="width:130px;" id="start_date" class="input-text" name="start_date" value="<?php echo Yii::app()->request->getParam('start_date'); ?>" placeholder="开始日期">
                    <span>-</span>
                    <input type="text" style="width:130px;" id="end_date" class="input-text" name="end_date" value="<?php echo Yii::app()->request->getParam('end_date'); ?>" placeholder="结束日期">
                </label>
                <label style="margin-right:20px;">
                    <span>关键字：</span>
                    <input type="text" style="width:200px" class="input-text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords'); ?>" placeholder="请输入收费编码或收费方案名称">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div>
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input type="checkbox" id="j-checkall" class="input-check"></th>
                        <th style="text-align:center;">序号</th>
                        <!-- <th style="text-align:center;"><?php //echo $model->getAttributeLabel('scale_no') ?></th> -->
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('gf_id') ?></th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('gf_name') ?></th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('name') ?></th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('levetypeid') ?></th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('scale_amount') ?></th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('f_userdate') ?></th>
                        <th style="text-align:center;">缴费状态</th>
                        <th style="text-align:center;width:15%">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 1; foreach($arclist as $v) {?>
                        <tr>
                            <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                            <td style="text-align:center;"><span class="num num-1"><?php echo $index; ?></span></td>
                            <!-- <td style="text-align:center"><?php //echo $v->scale_no; ?></td> -->
                            <td style="text-align:center"><?php echo $v->gf_id; ?></td>
                            <td style="text-align:center"><?php echo $v->gf_name; ?></td>
                            <td style="text-align:center"><?php echo $v->name; ?></td>
                            <td style="text-align:center"><?php if(!empty($v->levetypeid))echo $v->base_levetypeid->F_NAME; ?></td>
                            <td style="text-align:center"><?php echo $v->scale_amount; ?></td>
                            <td style="text-align:center"><?php echo $v->f_userdate; ?></td>
                            <td style="text-align:center"><?php if($v->scale_no<1){ echo '待缴费'; } ?></td>
                            <td style="text-align:center">
                                <a class="btn" href="<?php echo $this->createUrl('update',array('id'=>$v->id)); ?>" title="编辑"><i class="fa fa-edit"></i></a>
                                <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id; ?>',deleteUrl)" title="删除"><i class="fa fa-trash-o"></i></a>
                                <a href="javascript:;" class="btn" onclick="onFreemark(<?php echo $v->id; ?>);">免费入驻</a>
                            </td>
                        </tr>
                    <?php $index++; }?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div>
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete',array('id'=>'ID')); ?>';
    $('#start_date').on('click',function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd H:m:s'});
    })
    $('#end_date').on('click',function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd H:m:s',minDate:'#F{$dp.$D(\'start_date\')}'});
    })

    var mark_html = 
        '<div>'+
            '<table>'+
                '<tr>'+
                    '<td>免费原因：</td>'+
                    '<td><textarea id="f_freememo" style="width:290px; height:80px;" maxlength="60"></textarea></td>'+
                '</tr>'+
            '</table>'+
        '</div>';

    function onFreemark(id){
        $.dialog({
            id:'mianfei',
            lock:true,
            opacity:0.3,
            height:'25%',
            width:'30%',
            title:'免费入驻',
            content:mark_html,
            button:[
                {
                    name:'确认',
                    callback:function(){
                        we.loading('show');
                        $.ajax({
                            type: 'post',
                            url: '<?php echo $this->createUrl('freemark');?>&id='+id,
                            data: {f_freememo:$('#f_freememo').val()},
                            dataType: 'json',
                            success: function(data) {
                                if(data.status==1){
                                    we.loading('hide');
                                    $.dialog.list['mianfei'].close();
                                    we.success(data.msg, data.redirect);
                                }else{
                                    we.loading('hide');
                                    we.msg('minus', data.msg);
                                }
                            }
                        });
                        return false;
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
    };
</script>