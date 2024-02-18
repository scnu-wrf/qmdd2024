<?php 
// if (!isset($_REQUEST['club_news_id'])) {$_REQUEST['club_news_id']=0;}
$f_types=BaseCode::model()->getCode(1018);  
 
?>
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>敏感词库</h1></div><!--box-title end-->
    <div class="box-content">
    	<div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('create');?>"><i class="fa fa-plus"></i>添加</a>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>解禁</a>
        </div><!--box-header end-->

        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">



               <label style="margin-right:20px;">
                    <span>类型：</span>
                    <select id="type_name" name="type_name">
                        <option value="">请选择</option>
                        <option value="所有类型">所有类型</option>
                        <?php foreach ($f_types as $v) {?>
                            <option value="<?php echo $v->F_NAME;?>"<?php if(Yii::app()->request->getParam('type_name')!==null && Yii::app()->request->getParam('type_name')!==''  && Yii::app()->request->getParam('type_name')==$v->F_NAME){?> selected<?php }?>><?php echo $v->F_NAME;?></option>
                        <?php } ?>
                    </select>
                </label>

                <label style="margin-right:10px;">
                    <span>敏感词内容：</span>
                        <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" onfocus="if (value =='请输入关键字'){value =''}"onblur="if (value ==''){value='请输入关键字'}" />

                </label>

                <button  id="submit_button" class="btn btn-blue" type="submit">查询</button>&nbsp;&nbsp;&nbsp;&nbsp;

                <button class="btn btn-blue" type="button" onclick="javascript:importfile()" >导入</button>
               <input id="is_excel" type="hidden" name="is_excel" value="0">
                <button class="btn btn-blue" type="button" onclick="javascript:excel();" >导出</button>
            </form>
        </div><!--box-search end-->

        <div class="box-table">
            <table class="list">
                <thead>
                    <tr align="center">
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th>序号</th>
                        <th><?php echo $model->getAttributeLabel('sensitive_type_name');?></th>
                        <th><?php echo $model->getAttributeLabel('sensitive_content');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>


                    <?php 
                    $i=1; 
                    $index = 1;
                    foreach($arclist as $v){ ?>
                    <tr align="center">
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->sensitive_type_name; ?></td>
                        <td><?php echo $v->sensitive_content; ?></td>
                        <td>
    
                            <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i></a>
                            <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="解禁"><i class="fa fa-trash-o"></i></a>

                        </td>
                    </tr>




                    <?php $i++; $index++;} ?>
                </tbody>
            </table>
        </div><!--box-table end-->                






        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';

    function excel(){
        $("#is_excel").val(1);
        $("#submit_button").click();
    }

    function importfile(){
        // $.dialog.data('f_id', 0);
        $.dialog.open('<?php echo $this->createUrl("upExcel");?>',{
            id:'sensitive',
            lock:true,
            opacity:0.3,
            title:'导入敏感词',
            width:'60%',
            height:'50%',
            close: function () {
                 
                // if($.dialog.data('f_id')>0){

                //     $("<option value='"+$.dialog.data('f_id')+"'>"+$.dialog.data('F_NAME')+"</option>").appendTo("#SensitiveWords_sensitive_type");

                //     $("#SensitiveWords_sensitive_type").find("option[value = '"+$.dialog.data('f_id')+"']").attr("selected",true).trigger('blur');   
                            
                // }
                window.location.reload(true);
            }
        });
    }
</script>