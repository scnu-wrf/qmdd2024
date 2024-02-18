
<div class="box">
    <div class="box-detail">
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
            	<table border="0" cellspacing="1" cellpadding="0" class="product_publish_content">
                    <tr>
                        <td width="15%">标题</td>
                        <td width="85%"><input class="input-text" id="intro_title" type="text" autocomplete="off"></td>
                    </tr>
                    <tr>
                        <td colspan=2>
                            <input class="input-text" id="intro_content_temp" type="hidden" autocomplete="off">
                            <script>we.editor('intro_content_temp', '<?php echo get_class($model);?>[intro_content_temp]');</script>
                            <?php echo '<script>var ue = UE.getEditor("intro_content_temp");ue.ready(function() {ue.setDisabled();});</script>'; ?>
                        </td>
                    </tr>
                </table>
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
    </div><!--box-detail end-->
</div><!--box end-->

<script>
$(function(){
    api = $.dialog.open.api;	// 			art.dialog.open扩展方法
    if (!api) return;

    // 操作对话框
    api.button(
		{
			name:'保存',
			callback:function(){
				return add_chose();
			},
			focus:true
		},
		{
			name:'取消',
			callback:function(){
				return true;
			}
		}
    );
});
function add_chose(){
	$.dialog.data('intro_title', $("#intro_title").val());
	$.dialog.data('intro_content_temp', $("#intro_content_temp").val());
	$.dialog.close();
 };
</script>
