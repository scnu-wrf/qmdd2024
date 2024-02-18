

<div class="box">
    <div class="box-content">
        <div class="material-ltNew">
            <div class="material-group">
                <a<?php if($group_id==0){?> class="current"<?php }?> href="<?php echo $this->createUrl('select/materialPicture', array('group_id'=>0,'type'=>252));?>">全部图片<span>(<?php echo $all_num;?>)</span></a>
                <a<?php if($group_id==-1){?> class="current"<?php }?> href="<?php echo $this->createUrl('select/materialPicture', array('group_id'=>-1,'type'=>252));?>">未分组<span>(<?php echo $nogroup_num;?>)</span></a>
                <?php foreach($material_group as $v){ ?>
                <a<?php if($group_id==$v->id){?> class="current"<?php }?> href="<?php echo $this->createUrl('select/materialPicture', array('group_id'=>$v->id,'type'=>252));?>"><?php echo $v->group_name;?><span>(<?php echo GfMaterial::model()->getNum($v->id,252);?>)</span></a>
                <?php } ?><P><P><P><P>
                <!-- <hr width="100%" size="1" color="#ccc" style="border:1 dashed #5151A2"> -->
                
            </div>

            </div> <!-- material-lt end -->


            <div class="material-rtNew">
<div class="material-hd c">
                <div class="material-hd-lt">

               <div class="search-radius"  style="float:left">
                    <form action="<?php echo Yii::app()->request->url;?>" method="get">
                        <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                        <input type="hidden" name="type" value="<?php echo Yii::app()->request->getParam('type');?>">

                        <label style="margin-right:10px;">
                            <input style="width:600px;" class="input-text" type="text" name="keywords" value="请输入标题关键字搜索" onfocus="if (value =='请输入标题关键字搜索'){value =''}"onblur="if (value ==''){value='请输入标题关键字搜索'}" />

                        </label>

                        <button class="btn btn-blue" type="submit">搜索</button>
                    </form>
                </div><!--box-search end-->

                </div>
                <div class="material-hd-rt">
                    <a class="btn"  style="float:left" href="<?php echo $this->createUrl('gfMaterial/picUpdate');?>">上传图片</a>
                </div>
</div><!--material-hd end-->
            
                <div class="material-pic-200 c">
                <ul id="material-main" class="c">
                    <?php foreach($arclist as $v){ ?>
                    <li>
                        <div class="pic"><a class="text" href="javascript:;" onclick="fnSelect('<?php echo $v->id;?>', '<?php echo $v->v_pic;?>','<?php echo $v->v_title;?>',this);"><img src="<?php echo $v->v_file_path;?><?php echo $v->v_pic;?>"></a></div>
                        <div class="title">
                  
                            <input type="hidden" name="g_pic" id="g_pic" value="<?php echo  $v->v_pic;?>">

                             <?php echo $v->v_title;?>

                        </div>

                    </li>
                    <?php }?>
                </ul>
                </div><!--material-pic end-->
                <div class="box-page c"><?php $this->page($pages); ?></div>
            </div><!--  material-rt end  -->

            </div><!--  material-group end -->


    </div><!--  box-content end  -->
</div><!--  box end -->


<script type="text/javascript">

var fnSelect=function(id,pic,title,op){
        $.dialog.data('material_id', id);
        $.dialog.data('app_icon', pic);
        $.dialog.data('title', title);
        $.dialog.close();
}


</script>