<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">

  <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl.'/static/admin/crop/css/font-awesome.min.css'; ?>">
  <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl.'/static/admin/crop/css/bootstrap.min.css'; ?>">
  <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl.'/static/admin/crop/css/cropper.css'; ?>">
  <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl.'/static/admin/crop/css/main.css'; ?>">

</head>
<body>

<?php

  $size=BasePath::model()->find('f_id=' . Yii::app()->request->getParam('fd'));
  $basepath=BasePath::model()->getPath(185);$picprefix='';

?>
<div class="box">
    <div class="box-title c">
      <h1><i class="fa fa-table"></i>图片裁切</h1>
       <a class="btn" href="<?php echo $this->createUrl('gfMaterial/materialPictureAll', array('type'=>252));?>" ><i class="fa fa-reply"></i>返回</a></a></span>
    </div><!--box-title end-->

  <div class="container">
    <div class="row">
      <div class="col-md-9">
        <!-- <h3>Demo:</h3> -->
        <div class="img-container">
           <img id="image" src="<?php echo $basepath->F_WWWPATH.$model->v_pic; ?>" alt="Picture"> 

            <?php
                $url=$model->v_file_path.$model->v_pic;
                getImage($url,dirname($basepath->F_WWWPATH),$model->v_name);
            ?>
        </div>
      </div> <!-- col-md-9 end  -->

       <div class="col-md-3">
        <!-- <h3>Preview:</h3> -->
        <div class="docs-preview clearfix">
       
          <div class="img-preview preview-lg"></div>
<!--           <div class="img-preview preview-md"></div>
          <div class="img-preview preview-sm"></div>
          <div class="img-preview preview-xs"></div> -->
        </div>
       <input type="text" name="dataX" id="dataX"  readonly="readonly" />&nbsp;&nbsp;
       <input type="text" name="dataY" id="dataY"  readonly="readonly" />&nbsp;&nbsp;
       <input type="text" name="dataWidth" id="dataWidth"  readonly="readonly" />&nbsp;&nbsp;
       <input type="text" name="dataHeight" id="dataHeight"  readonly="readonly" />
        <p><p>
        <input style="margin-left:5px;" id="picture_select_btn" class="btn" type="button" value="提交图片" >

     


    </div> <!-- row end -->
  </div> <!-- container end  -->
</div><!--  box end -->



      <!-- Scripts -->

    <script src="<?php echo Yii::app()->request->baseUrl.'/static/admin/crop/js/bootstrap.bundle.min.js'; ?>"></script>
    <script src="<?php echo Yii::app()->request->baseUrl.'/static/admin/crop/js/common.js'; ?>"></script>

    <script src="<?php echo Yii::app()->request->baseUrl.'/static/admin/crop/js/cropper.js'; ?>"></script>
    <script src="<?php echo Yii::app()->request->baseUrl.'/static/admin/crop/js/main.js'; ?>"></script>

<script type="text/javascript">

  $('#image').cropper({
        aspectRatio: <?php echo $size->F_PX_WIDE.'/'.$size->F_PX_HIGH;?>,
        width:<?php echo $size->F_PX_WIDE;?>,
        height:<?php echo $size->F_PX_HIGH;?>,
        viewMode:1,
        autoCropArea:1,
        preview:".img-preview",
        crop: function (e) {
            console.log(e);

            $("#dataX").val(Math.round(e.x)).trigger('blur');
            $("#dataY").val(Math.round(e.y));
            $("#dataWidth").val(Math.round(e.width));
            $("#dataHeight").val(Math.round(e.height));

        }
    });

  $('#picture_select_btn').on('click', function(){
    var id=<?php echo $model->id;?>;
    var pic='<?php echo $model->v_pic;?>';
    var dataX=$("#dataX").val();
    var dataY=$("#dataY").val();
    var dataWidth=$("#dataWidth").val();
    var dataHeight=$("#dataHeight").val();

    $.dialog.data('material_id', id);
    $.dialog.data('app_icon', pic);
    $.dialog.data('dataX',dataX);
    $.dialog.data('dataY',dataY);
    $.dialog.data('dataWidth',dataWidth);
    $.dialog.data('dataHeight',dataHeight);

    $.dialog.close();

      });
 
</script>


<?php

/**
*功能：php完美实现下载远程图片保存到本地
*参数：文件url,保存文件目录,保存文件名称，使用的下载方式
*当保存文件名称为空时则使用远程文件原来的名称
*/
function getImage($url,$save_dir='',$filename='',$type=0){


    if(trim($url)==''){
        return array('file_name'=>'','save_path'=>'','error'=>1);
    }
    if(trim($save_dir)==''){
        $save_dir='./';
    }
    if(trim($filename)==''){//保存文件名
        $ext=strrchr($url,'.');
        if($ext!='.gif'&&$ext!='.jpg'){
            return array('file_name'=>'','save_path'=>'','error'=>3);
        }
        $filename=time().$ext;
    }
    if(0!==strrpos($save_dir,'/')){
        $save_dir.='/';
    }
    //创建保存目录
    if(!file_exists($save_dir)){  // &&!mkdir($save_dir,0777,true)
        return array('file_name'=>'','save_path'=>'','error'=>5);
    }
    //获取远程文件所采用的方法
    if($type){
        $ch=curl_init();
        $timeout=5;
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
        $img=curl_exec($ch);
        curl_close($ch);
    }else{
        ob_start();
        readfile($url);
        $img=ob_get_contents();
        ob_end_clean();
    }
    //$size=strlen($img);
    //文件大小
    $fp2=@fopen($save_dir.$filename,'w');
    fwrite($fp2,$img);
    fclose($fp2);
    unset($img,$url);


    return array('file_name'=>$filename,'save_path'=>$save_dir.$filename,'error'=>0);

}

?>

</body>
</html>