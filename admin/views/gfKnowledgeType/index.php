<style>
.zc-kb-tree-box .func-bar {
    width: calc(100% - 20px);
    height: 25px;
    padding-top: 12px;
    padding-left: 20px;
    border-bottom: 1px solid #E1E7F4;
}
.zc-kb-tree-box .func-bar .add-icon, .zc-kb-tree-box .func-bar .delete-icon, .zc-kb-tree-box .func-bar .down-icon, .zc-kb-tree-box .func-bar .edit-icon, .zc-kb-tree-box .func-bar .up-icon {
    width: 12px;
    height: 12px;
    background-image: url(../images/jui.png);
    display: inline-block;
}
.zc-kb-tree-box .func-bar .add-icon {
    background-position: -140px -220px;
    margin-right: 20px;
}
.zc-kb-tree-box .func-bar .edit-icon {
    background-position: 0 0;
    margin-right: 20px;
}
.zc-kb-tree-box .func-bar .edit-icon.disable {
    background-position: -40px 0;
}
.zc-kb-tree-box .func-bar .delete-icon {
    background-position: 0 -60px;
    margin-right: 20px;
}
.zc-kb-tree-box .func-bar .delete-icon.disable {
    background-position: -40px -60px;
}
.zc-kb-tree-box .func-bar .up-icon {
    background-position: 0 -20px;
    margin-right: 20px;
}
.zc-kb-tree-box .func-bar .up-icon.disable {
    background-position: -40px -20px;
}
.zc-kb-tree-box .func-bar .down-icon {
    background-position: 0 -40px;
}
.zc-kb-tree-box .func-bar .down-icon.disable {
    background-position: -40px -40px;
}
.zc-kb-tree-box .func-bar::after {
    content: '';
    height: 0;
    visibility: hidden;
    clear: both;
    display: block;
}
.zc-kb-tree-box .zc-kb-tree li {
    position: relative;
}
.zc-kb-tree-box .zc-kb-tree .directiveDropdownTree-list-li .js-item-box {
    position: relative;
    width: 100%;
    display: inline-block;
}
.zc-kb-tree-box .zc-kb-tree .directiveDropdownTree-list-li .js-item-box .js-item-arrow {
    position: absolute;
    top: 8px;
    left: 10px;
    width: 11px;
    height: 11px;
    display: inline-block;
    background-image: url(../images/jui.png);
    background-position: -80px -200px;
    cursor: pointer;
    background-color: #FAFCFD;
    z-index: 1;
}
.zc-kb-tree-box .zc-kb-tree .directiveDropdownTree-list-li .js-item-box .js-item-arrow.active {
    background-position: -120px -200px;
}
.zc-kb-tree-box .zc-kb-tree .directiveDropdownTree-list-li .js-item-box .js-item-arrow:hover {
    background-position: -100px -200px;
}
.zc-kb-tree-box .zc-kb-tree .directiveDropdownTree-list-li .js-item-box .js-item-arrow.active:hover {
    background-position: -140px -200px;
}
.zc-kb-tree-box .zc-kb-tree .directiveDropdownTree-list-li .js-item-box .js-item-name {
    margin-left: 26px;
    display: inline-block;
    line-height: 30px;
	height: 30px;
    cursor: pointer;
    white-space: nowrap;
    text-overflow: ellipsis;
    max-width: 145px;
    overflow: hidden;
    width: 145px;
    padding-left: 5px;
}
.zc-kb-tree-box .zc-kb-tree .directiveDropdownTree-list-li .js-item-box .js-item-name.active {
    background-color: #f0f3fb;
}
.zc-kb-tree-box .zc-kb-tree .directiveDropdownTree-list-li .js-child-list {
    padding: 0;
    margin-left: 20px;
}
.zc-kb-tree-box .zc-kb-tree .directiveDropdownTree-list-li .js-item-box::before {
    content: '';
    display: block;
    position: absolute;
    width: 15px;
    height: 1px;
    background-color: #E4E7ED;
    top: 13px;
    left: -5px;
}
.zc-kb-tree-box .zc-kb-tree li::after {
    content: '';
    display: block;
    position: absolute;
    width: 1px;
    height: 100%;
    background-color: #E4E7ED;
    top: -20px;
    left: -5px;
}
.zc-kb-tree-box .zc-kb-tree .directiveDropdownTree-list-li .js-child-list>li:last-of-type::after {
    content:'';display:none!important;
}
.zc-kb-tree-box .zc-kb-tree .directiveDropdownTree-list-li .js-item-box:last-of-type::after {
    content: '';
    display: block;
    position: absolute;
    width: 1px;
    height: 100%;
    background-color: #E4E7ED;
    top: -21px;
    left: -5px;
}
.zc-kb-tree-box .zc-kb-tree .directiveDropdownTree-list-li .first-item-box::before{
	content:'';display:none!important;
}
.zc-kb-tree-box .zc-kb-tree .directiveDropdownTree-list-li .first-item-box::after{
	content:'';display:none!important;
}
.zc-kb-tree-box .zc-kb-tree .directiveDropdownTree-list-li::after{
	content:'';display:none!important;
}
.zc-kb-tree-box .zc-kb-tree .directiveDropdownTree-list-li .js-item-box .js-item-arrow.disappear, .zc-kb-tree-box .zc-kb-tree .directiveDropdownTree-list-li .js-item-box .js-item-arrow.disappear:hover {
    background-position: -157px -197px;
}
</style>
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>知识类管理</h1></div><!--box-title end-->
    <div class="box-content">
        <div class="box-table zc-kb-tree-box">
			<div class="func-bar ng-scope" ng-if="editMode &amp;&amp; !suspend"><a class="add-icon" ng-class="{'disable': classifyId == ''}" href="javascript:;" ng-click="addFlag()"></a> <a class="edit-icon disable" ng-class="{'disable': classifyId == -1 || classifyId == ''}" href="javascript:;" ng-click="editFlag()"></a> <a class="delete-icon disable" ng-class="{'disable': classifyId == -1 || classifyId == ''}" href="javascript:;" ng-click="deleteFlag()"></a> <!--<a class="up-icon disable" ng-class="{'disable': classifyId == -1 || classifyId == '' || !beforeNode}" href="javascript:;" ng-click="transferFlag('up')"></a> <a class="down-icon disable" ng-class="{'disable': classifyId == -1 || classifyId == '' || !afterNode}" href="javascript:;" ng-click="transferFlag('down')"></a>--></div>
			<ul class="zc-kb-tree zc-j-scrollbar">
				<li class="directiveDropdownTree-list-li"><span class="js-item-box first-item-box"><span class="js-item-arrow active" questiontypeid="-1"></span>  <span class="js-item-name root active" title="全部分类" questiontypename="全部分类" questiontypeid="-1">全部分类</span></span>
					<ul class="js-child-list">
					<?php 
						function child_list($a){
							foreach($a as $m=>$n){
								$gf_knowledge_type=GfKnowledgeType::model()->findAll("fater_id=".$n->id);
								echo '<li><span class="js-item-box"><span class="js-item-arrow'.(count($gf_knowledge_type)>0?"":" disappear").'" questiontypeid="'.$n->id.'"></span><span class="js-item-name" title="'.$n->title.'" questiontypename="'.$n->title.'" questiontypeid="'.$n->id.'">'.$n->title.'</span></span><ul class="js-child-list" style="display:none;">';
								child_list($gf_knowledge_type);
								echo '</ul></li>';
							}
						}
						foreach($arclist as $k=>$v){?>
					<?php $gf_knowledge_type=GfKnowledgeType::model()->findAll("fater_id=".$v->id);?>
						<li>
							<span class="js-item-box"><span class="js-item-arrow<?php echo count($gf_knowledge_type)>0?"":" disappear";?>" questiontypeid="<?php echo $v->id;?>"></span><span class="js-item-name" title="<?php echo $v->title;?>" questiontypename="<?php echo $v->title;?>" questiontypeid="<?php echo $v->id;?>"><?php echo $v->title;?></span></span>
							<ul class="js-child-list" style="display:none;">
							<?php 
							child_list($gf_knowledge_type);?>
							</ul>
						</li>
					<?php }?>
					</ul>
				</li>
			</ul>
        </div><!--box-table end-->
    </div><!--box-content end-->
</div><!--box end-->
<script>
$(document).on("click",".js-item-arrow",function(){
	if($(this).is(".active")){
		$(this).removeClass("active");
		$(this).parent().next().hide();
	}else if($(this).not(".disappear")){
		$(this).addClass("active");
		$(this).parent().next().show();
	}
})
$(document).on("click",".js-item-name",function(){
	if(!$(this).is(".active")){
		$(".js-item-name").removeClass("active");
		$(this).addClass("active");
		if($(this).attr("questiontypeid")<0){
			$(".edit-icon").addClass("disable");
			$(".delete-icon").addClass("disable");
			$(".up-icon").addClass("disable");
			$(".down-icon").addClass("disable");
		}else{
			$(".edit-icon").removeClass("disable");
			$(".delete-icon").removeClass("disable");
			if($(this).parent().parent().prev("li").length>0){
				$(".up-icon").removeClass("disable");
			}else{
				$(".up-icon").addClass("disable");
			}
			if($(this).parent().parent().next("li").length>0){
				$(".down-icon").removeClass("disable");
			}else{
				$(".down-icon").addClass("disable");
			}
		}
	}
})
//<input type="text" class="js-new-input zc-j-input" placeholder="请回车提交">
$(document).on("click",function(){
	if(!$(event.target).isChildAndSelfOf(".edit-icon")&&!$(event.target).isChildAndSelfOf(".add-icon")&&!$(event.target).isChildAndSelfOf(".js-item-name[contenteditable='true']")){
		$(".js-item-name").attr("contenteditable",false);
		if($.trim($(".js-item-name[questiontypeid='0']").html())==""){
			$(".js-item-name[questiontypeid='0']").parent().parent().remove();
		}else{
			var fater_id=$(".js-item-name[questiontypeid='0']").parents(".js-child-list").prev().children(".js-item-name").attr("questiontypeid");
			savequestiontype(fater_id);
		}
		$(".js-child-list").each(function(k){
			if($.trim($(this).html())==""){
				$($(this).prev().children(".js-item-arrow").addClass("disappear").removeClass("active"));
			}
		})
	}
})
function savequestiontype(fater_id){
	var url="<?php echo $this->createUrl('saveData');?>";
	var title=$(".js-item-name[questiontypeid='0']").html();
	var club_id='<?php echo get_session("club_id");?>';
	console.log(fater_id)
	$.ajax({
		url: url,
		type: 'post',
		data: {title:title,club_id:club_id,fater_id:fater_id},
		dataType: 'json',
		beforeSend:function(){
			we.overlay("show");
		},
		success: function (d) {
			console.log(d)
			if(d.status==1){
				we.success(d.msg, d.redirect);
			}else{
				we.error(d.msg, d.redirect);
				return false;
			}
		}
	})
}
$(".edit-icon").on("click",function(){
	if(!$(this).is(".disable")){
		$(".js-item-name.active").attr("contenteditable",true);
		keepLastIndex($(".js-item-name.active").get(0));
	}
})
$(".delete-icon").on("click",function(){
	if(!$(this).is(".disable")){
		we.dele($(".js-item-name.active").attr("questiontypeid"), deleteUrl);
	}
})
$(".add-icon").on("click",function(){
	$(".js-item-name[questiontypeid='0']").parent().parent().remove();
	$(".js-item-name").attr("contenteditable",false);
	if($.trim($(".js-item-name.active").parent().parent().children("ul").html())==""){
		$(".js-item-name.active").prev().removeClass("disappear");
	}
	$(".js-item-name.active").parent().parent().children("ul").append('<li><span class="js-item-box"><span class="js-item-arrow disappear" questiontypeid="0"></span><span class="js-item-name" title="" questiontypename="" questiontypeid="0" contenteditable="false"></span></span><ul class="js-child-list" style="display:none;"></ul></li>').show();
	$(".js-item-name.active").prev().addClass("active");
	$(".js-item-name[questiontypeid='0']").attr("contenteditable",true);
	keepLastIndex($(".js-item-name[questiontypeid='0']").get(0));
})
function keepLastIndex(obj) {
    if (window.getSelection) {//ie11 10 9 ff safari
        obj.focus(); //解决ff不获取焦点无法定位问题
        var range = window.getSelection();//创建range
        range.selectAllChildren(obj);//range 选择obj下所有子内容
        range.collapseToEnd();//光标移至最后
    }
    else if (document.selection) {//ie10 9 8 7 6 5
        var range = document.selection.createRange();//创建选择对象
        //var range = document.body.createTextRange();
        range.moveToElementText(obj);//range定位到obj
        range.collapse(false);//光标移至最后
        range.select();
    }
}
jQuery.fn.isChildAndSelfOf = function(b){ 
	return (this.closest(b).length > 0); 
};
var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
</script>