<div class="box" div style="font-size: 9px">
    <div class="box-content">
     <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
   
        <div class="box-header">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <button  class="btn btn-blue" type="submit">保存</button>
        </div><!--box-header end-->
    <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th><?php echo $model->getAttributeLabel('f_club_item_type_name');?></th>
                        <th><?php echo $model->getAttributeLabel('f_club_type_name');?></th>
                        <th><?php echo $model->getAttributeLabel('f_rname');?></th>
                    </tr>
                </thead>
                <tbody>
                
<?php 
 $s1="substr(f_rcode,3,1)<>' ' and substr(f_rcode,4,1)=' ' and f_tcode<>'T' ";
 $cc=array('order'=>'f_rcode','condition'=>$s1,);$ri=0;
 $checks=Chtml::listData(Role::model()->findAll($cc), 'f_id', 'f_rname');
 $club_type=ClubType::model()->findAll("f_level=2 and member_attribute like '%404%' order by f_ctcode ");

foreach($club_type as $v){ ?>
    <tr>
        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
    
        <td><?php echo $v->f_ctcode; ?></td>
        <td><?php echo $v->f_ctname; ?></td>
        <td><?php 
            $model->tmp[$ri][0]=$v->id;
            $model->tmp[$ri][1]=0;
            $model->tmp[$ri][2]=0;
            $model->tmp[$ri][3]=$v->f_ctcode;
            $model->tmp[$ri][4]=$v->f_ctname;
            foreach($arclist as $v1){
                if($v->id==$v1->f_club_type){
                    $model->tmp[$ri][1]=$v1->f_roleid;
                    $model->tmp[$ri][2]=$v1->f_roleid;
                }
            }
            echo $form->hiddenField($model,'tmp['.$ri.'][0]',array('class' =>'input-text'));
            echo $form->hiddenField($model,'tmp['.$ri.'][1]',array('class' =>'input-text'));
            echo $form->hiddenField($model,'tmp['.$ri.'][3]',array('class' =>'input-text'));
            echo $form->hiddenField($model,'tmp['.$ri.'][4]',array('class' =>'input-text'));
            echo  $form->radioButtonList($model, 'tmp['.$ri.'][2]',$checks, $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>'));
            $ri=$ri+1;
         ?></td>
    </tr>
   <?php } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
       
        <div class="box-page c"><?php $this->page($pages); ?></div>
           <?php $this->endWidget(); ?>
    </div><!--box-content end-->
</div><!--box end-->
