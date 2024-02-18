<!doctype html>
<html lang="zh">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="<?php echo Yii::app()->request->baseUrl.'/static/admin/switch/docs/js/jquery.min.js';?>"></script>
        <script> 
            function test(msgx){
                art.dialog({
                    width: '40em',
                    height: 55,
                    content: msgx
                });
            } 
        </script>
    </head>
    <body>
        <div class="box">
            <div class="box-title c"><h1><i class="fa fa-table"></i>导入学生Excel表格</h1></div><!--box-title end-->
            <div class="box-content">
                <form action="<?php echo Yii::app()->request->url;?>" method="post" enctype="multipart/form-data">
                <div class="box-table">
                    <table class="list" >
                        <tr>
                            <td colspan="2"><label style="margin-right:20px;">请选择要导入的Excel文档：</label></td>
                        </tr>
                        <tr>
                            <td colspan="2" width="30%"> <label style="margin-right:20px;"><input type="file" name="excel_file" id="excel_file" /> </label>
                            <input type="submit" name="submit" value="上传" class="btn btn-blue" /></td>
                        </tr>
                        <tr>
                            <td>
                                <div>
                                    导入规则：<br>
                                    1.文件大小不超过2M。<br>
                                    2.一次导入学生数据最多为1000条。<br>
                                    3.详细信息请下载模板查看。<br>
                                </div>
                            </td>
                            <td>
                                <a  class="btn" href="<?php echo Yii::app()->request->baseUrl.'/admin/views/studentInfo/模板.xlsx';?>">下载信息模板</a>
                            </td>
                        </tr>
                    </table>
                </div> <!-- box-table -->
                </form>
                <?php                   
                    if (!$info==''){
                        echo "<script type='text/javascript'>test('$info');</script>";
                    }
                ?>
            </div><!--box-content end-->
        </div><!--box end-->
    </body>
</html>