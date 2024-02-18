<style>.box-table .list tr th,.box-table .list tr td{ text-align: center; }</style>
<div class="box">
    <div class="box-title c">
      <h1><i class="fa fa-table"></i>学生列表</h1></div><!--box-title end-->
    <div class="box-content">
    	<div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('create');?>"><i class="fa fa-plus"></i>添加</a>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
            <span style="float:right">
                <button class="btn btn-blue" type="button" onclick="javascript:importfile()" >导入</button>
                <!-- <button class="btn btn-blue" type="button" onclick="javascript:excel();" >导出</button> -->
                <a class="btn" href="javascript:;" type="button" onclick="javascript:excel();"><i class="fa fa-file-excel-o"></i>导出</a>
            </span>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button id="submit_button" class="btn btn-blue" type="submit">查询</button>
                <input id="is_excel" type="hidden" name="is_excel" value="0">
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th width="5%">序号</th>
                        <th><?php echo $model->getAttributeLabel('club_id');?></th>
                        <th><?php echo $model->getAttributeLabel('gf_user_id');?></th>
                        <th><?php echo $model->getAttributeLabel('name');?></th>
                        <th><?php echo $model->getAttributeLabel('sc_facult');?></th>
                        <th><?php echo $model->getAttributeLabel('sc_yeal');?></th>
                        <th><?php echo $model->getAttributeLabel('sc_code');?></th>
                        <th><?php echo $model->getAttributeLabel('sc_grade');?></th>
                        <th><?php echo $model->getAttributeLabel('sc_class');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
					<?php $index=1; foreach($arclist as $v){ ?>
                    <tr> 	
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>    
                        <td><span class="num num-1"><?php echo $index; ?></td>
                        <td><?php if(!empty($v->club_id))echo $v->club_name->club_name;?></td>
                        <td><?php if(!empty($v->gf_user_id))echo $v->gf_user->GF_ACCOUNT;?></td>
                        <td><?php if(!empty($v->gf_user_id))echo $v->gf_user->ZSXM;?></td>
                        <td><?php echo $v->sc_facult; ?></td>
                        <td><?php echo $v->sc_yeal; ?></td>
                        <td><?php echo $v->sc_code; ?></td>
                        <td><?php echo $v->sc_grade; ?></td>
                        <td><?php echo $v->sc_class; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i></a>
                            <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>
                        </td>
                    </tr>
					<?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID')); ?>';

    function excel(){
        $("#is_excel").val(1);
        $("#submit_button").click();
    }

    function importfile(){
        $.dialog.open('<?php echo $this->createUrl("upExcel");?>',{
            id:'sensitive',
            lock:true,
            opacity:0.3,
            title:'导入学生信息',
            width:'60%',
            height:'50%',
            close: function () {
                window.location.reload(true);
            }
        });
    }
</script>