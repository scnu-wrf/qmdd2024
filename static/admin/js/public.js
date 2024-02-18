window.onerror=function(){return true;}

$(function() {
    $('.input-text').attr('autocomplete','off');
    //$("html").niceScroll({zindex: '1000'});

    var $jDelete = $('#j-delete');
    if ($jDelete.length > 0) {
        var $this, $temp1 = $('.check-item .input-check'), $temp2 = $('.box-table .list tbody tr');

        $('#j-checkall').on('click', function() {
            $this = $(this);
            if ($this.is(':checked')) {
                $temp1.each(function() {
                    if(this.disabled!=true){
                        this.checked = true;
                    }
                });
                $temp2.addClass('selected');
            } else {
                $temp1.each(function() {
                    this.checked = false;
                });
                $temp2.removeClass('selected');
            }
            we.hasDelete('.check-item .input-check:checked', '#j-delete');
        });

        $temp1.each(function() {
            $this = $(this);
            if ($this.is(':checked')) {
                $this.parent().parent().addClass('selected');
            } else {
                $this.parent().parent().removeClass('selected');
            }
        });

        $temp1.on('click', function() {
            $this = $(this);
            if ($this.is(':checked')) {
                $this.parent().parent().addClass('selected');
            } else {
                $this.parent().parent().removeClass('selected');
            }
            we.hasDelete('.check-item .input-check:checked', '#j-delete');
        });
    }

    // 火狐浏览器不加高度显示会不完整，所以加大下拉框的高度
    if(navigator.userAgent.indexOf('Firefox') >= 0){
        $('select').css('height','33px');
    }
});

var we = window.we || {};
we.tab=function(tabli,tabitem,fnback){
    var $tabli=$(tabli);
    var $tabitem=$(tabitem);
    var $this;
    var index;
    var istab=false;
    $tabli.on('click', function(){
        $this=$(this);
        index=$this.index();
        if(fnback==undefined || fnback==''){
            $tabli.removeClass('current');
            $this.addClass('current');
            $tabitem.hide();
            $tabitem.eq(index).show();
        }else{
            fnback.call(this,index);
            if(fnback(index)){
                $tabli.removeClass('current');
                $this.addClass('current');
                $tabitem.hide();
                $tabitem.eq(index).show();
            }
            return false;
        }
    });
};
we.success = function(msg, redirect) {
    we.msg('check', msg, function() {
        we.loading("hide");
        if (redirect != undefined && redirect != '') {
            window.location.href = redirect;
        }
    });
};
we.error = function(msg, redirect) {
    we.msg('error', msg, function() {
        we.loading("hide");
        if (redirect != '') {
            window.location.href = redirect;
        }
    });
};

we.status = function(op, url) {
    we.overlay('show');
    var $this = $(op);
    var status = $this.attr('data-status');
    var $yes = $this.attr('data-yes');
    var $no = $this.attr('data-no');
    status = status == 1 ? 0 : 1;
    $.ajax({
        type: 'get',
        url: url,
        data: {status: status},
        dataType: 'json',
        success: function(data) {
            if (data.status == 1) {
                if (status == 1) {
                    $this.attr('data-status', 1);
                    $this.attr('src', $yes);
                } else {
                    $this.attr('data-status', 0);
                    $this.attr('src', $no);
                }
                we.msg('check', data.msg, function() {
                    we.loading('hide');
                });
            } else {
                we.msg('error', data.msg, function() {
                    we.loading('hide');
                });
            }
        }
    });
};

we.sortid = function(op, url) {
    we.overlay('show');
    var $this = $(op);
    var sortid = parseInt($this.val());
    $.ajax({
        type: 'get',
        url: url,
        data: {sortid: sortid},
        dataType: 'json',
        success: function(data) {
            if (data.status == 1) {
                we.msg('check', data.msg, function() {
                    we.loading('hide');
                });
            } else {
                we.msg('error', data.msg, function() {
                    we.loading('hide');
                });
            }
        }
    });
};

we.dele = function(id, url) {
    we.overlay('show');
    var url1 = url.replace(/ID/, id);
    if (id == '' || id == undefined) {
        we.msg('error', '请选择要删除的内容', function() {
            we.loading('hide');
        });
        return false;
    }
    var fnDelete = function() {
        url = url.replace(/ID/, id);
        $.ajax({
            type: 'get',
            url: url,
            dataType: 'json',
            success: function(data) {
                if (data.status == 1) {
                    we.msg('check', data.msg, function() {
                        we.loading('hide');
                        we.reload();
                    });
                } else {
                    we.msg('error', data.msg, function() {
                        we.loading('hide');
                    });
                }
            }
        });
    };
    $.fallr('show', {
        buttons: {
            button1: {text: '删除', danger: true, onclick: fnDelete},
            button2: {text: '取消'}
        },
        content: '确定删除？',
        icon: 'trash',
        afterHide: function() {
            we.loading('hide');
        }
    });
};
we.down = function(id, url) {
    we.overlay('show');
    var url1 = url.replace(/ID/, id);
    if (id == '' || id == undefined) {
        we.msg('error', '请选择要下线的内容', function() {
            we.loading('hide');
        });
        return false;
    }
    var fnDown = function() {
        url = url.replace(/ID/, id);
        $.ajax({
            type: 'get',
            url: url,
            dataType: 'json',
            success: function(data) {
                if (data.status == 1) {
                    we.msg('check', data.msg, function() {
                        we.loading('hide');
                        we.reload();
                    });
                } else {
                    we.msg('error', data.msg, function() {
                        we.loading('hide');
                    });
                }
            }
        });
    };
    $.fallr('show', {
        buttons: {
            button1: {text: '确定', danger: true, onclick: fnDown},
            button2: {text: '取消'}
        },
        content: '确定下线吗？',
        //icon: 'trash',
        afterHide: function() {
            we.loading('hide');
        }
    });
};
we.online = function(id, url) {
    we.overlay('show');
    var url1 = url.replace(/ID/, id);
    if (id == '' || id == undefined) {
        we.msg('error', '请选择要上线的内容', function() {
            we.loading('hide');
        });
        return false;
    }
    var fnOnline = function() {
        url = url.replace(/ID/, id);
        $.ajax({
            type: 'get',
            url: url,
            dataType: 'json',
            success: function(data) {
                if (data.status == 1) {
                    we.msg('check', data.msg, function() {
                        we.loading('hide');
                        we.reload();
                    });
                } else {
                    we.msg('error', data.msg, function() {
                        we.loading('hide');
                    });
                }
            }
        });
    };
    $.fallr('show', {
        buttons: {
            button1: {text: '确定', danger: true, onclick: fnOnline},
            button2: {text: '取消'}
        },
        content: '确定上线吗？',
        //icon: 'trash',
        afterHide: function() {
            we.loading('hide');
        }
    });
};
we.operate = function(id, url ,show) {
    we.overlay('show');
    var url1 = url.replace(/ID/, id);
    if (id == '' || id == undefined) {
        we.msg('error', '请选择要操作的内容', function() {
            we.loading('hide');
        });
        return false;
    }
    var fn = function() {
        url = url.replace(/ID/, id);
        $.ajax({
            type: 'get',
            url: url,
            dataType: 'json',
            success: function(data) {
                if (data.status == 1) {
                    we.msg('check', data.msg, function() {
                        we.loading('hide');
                        we.reload();
                    });
                } else {
                    we.msg('error', data.msg, function() {
                        we.loading('hide');
                    });
                }
            }
        });
    };
    $.fallr('show', {
        buttons: {
            button1: {text: '确定', danger: true, onclick: fn},
            button2: {text: '取消'}
        },
        content: show,
        //icon: 'trash',
        afterHide: function() {
            we.loading('hide');
        }
    });
};

we.end = function(id, url) {
    we.overlay('show');
    var url1 = url.replace(/ID/, id);
    if (id == '' || id == undefined) {
        we.msg('error', '请选择要结束的内容', function() {
            we.loading('hide');
        });
        return false;
    }
    var fnEnd = function() {
        url = url.replace(/ID/, id);
        $.ajax({
            type: 'get',
            url: url,
            dataType: 'json',
            success: function(data) {
                if (data.status == 1) {
                    we.msg('check', data.msg, function() {
                        we.loading('hide');
                        we.reload();
                    });
                } else {
                    we.msg('error', data.msg, function() {
                        we.loading('hide');
                    });
                }
            }
        });
    };
    $.fallr('show', {
        buttons: {
            button1: {text: '确定', danger: true, onclick: fnEnd},
            button2: {text: '取消'}
        },
        content: '确定结束吗？',
        //icon: 'trash',
        afterHide: function() {
            we.loading('hide');
        }
    });
};

we.istop = function(id, url) {
    we.overlay('show');
    var url1 = url.replace(/ID/, id);
    if (id == '' || id == undefined) {
        we.msg('error', '请选择要置顶的内容', function() {
            we.loading('hide');
        });
        return false;
    }
    var fnIstop = function() {
        url = url.replace(/ID/, id);
        $.ajax({
            type: 'get',
            url: url,
            dataType: 'json',
            success: function(data) {
                if (data.status == 1) {
                    we.msg('check', data.msg, function() {
                        we.loading('hide');
                        we.reload();
                    });
                } else {
                    we.msg('error', data.msg, function() {
                        we.loading('hide');
                    });
                }
            }
        });
    };
    $.fallr('show', {
        buttons: {
            button1: {text: '确定', danger: true, onclick: fnIstop},
            button2: {text: '取消'}
        },
        content: '确定置顶吗？',
        //icon: 'trash',
        afterHide: function() {
            we.loading('hide');
        }
    });
};
we.notop = function(id, url) {
    we.overlay('show');
    var url1 = url.replace(/ID/, id);
    if (id == '' || id == undefined) {
        we.msg('error', '请选择要取消置顶的内容', function() {
            we.loading('hide');
        });
        return false;
    }
    var fnNotop = function() {
        url = url.replace(/ID/, id);
        $.ajax({
            type: 'get',
            url: url,
            dataType: 'json',
            success: function(data) {
                if (data.status == 1) {
                    we.msg('check', data.msg, function() {
                        we.loading('hide');
                        we.reload();
                    });
                } else {
                    we.msg('error', data.msg, function() {
                        we.loading('hide');
                    });
                }
            }
        });
    };
    $.fallr('show', {
        buttons: {
            button1: {text: '确定', danger: true, onclick: fnNotop},
            button2: {text: '取消'}
        },
        content: '确定取消置顶吗？',
        //icon: 'trash',
        afterHide: function() {
            we.loading('hide');
        }
    });
};

we.first = function(id, url) {
    we.overlay('show');
    var url1 = url.replace(/ID/, id);
    if (id == '' || id == undefined) {
        we.msg('error', '请选择要置顶的内容', function() {
            we.loading('hide');
        });
        return false;
    }
    var fnFirst = function() {
        url = url.replace(/ID/, id);
        $.ajax({
            type: 'get',
            url: url,
            dataType: 'json',
            success: function(data) {
                if (data.status == 1) {
                    we.msg('check', data.msg, function() {
                        we.loading('hide');
                        we.reload();
                    });
                } else {
                    we.msg('error', data.msg, function() {
                        we.loading('hide');
                    });
                }
            }
        });
    };
    $.fallr('show', {
        buttons: {
            button1: {text: '确定', danger: true, onclick: fnFirst},
            button2: {text: '取消'}
        },
        content: '确定置顶吗？',
        //icon: 'trash',
        afterHide: function() {
            we.loading('hide');
        }
    });
};
we.cancel = function(id, url) {
    we.overlay('show');
    if (id == '' || id == undefined) {
        we.msg('error', '请选择要撤销的内容', function() {
            we.loading('hide');
        });
        return false;
    }
    var fnCancel = function() {
        url = url.replace(/ID/, id);
        $.ajax({
            type: 'get',
            url: url,
            dataType: 'json',
            success: function(data) {
                if (data.status == 1) {
                    we.msg('check', data.msg, function() {
                        we.loading('hide');
                        we.reload();
                    });
                } else {
                    we.msg('error', data.msg, function() {
                        we.loading('hide');
                    });
                }
            }
        });
    };
    $.fallr('show', {
        buttons: {
            button1: {text: '撤销', danger: true, onclick: fnCancel},
            button2: {text: '取消'}
        },
        content: '确定撤销？',
        icon: 'trash',
        afterHide: function() {
            we.loading('hide');
        }
    });
};

we.cancelsvi = function(id, url) {
    we.overlay('show');
    if (id == '' || id == undefined) {
        we.msg('error', '请选择要取消的服务', function() {
            we.loading('hide');
        });
        return false;
    }
    var fnCancelsvi = function() {
        url = url.replace(/ID/, id);
        $.ajax({
            type: 'get',
            url: url,
            dataType: 'json',
            success: function(data) {
                if (data.status == 1) {
                    we.msg('check', data.msg, function() {
                        we.loading('hide');
                        we.reload();
                    });
                } else {
                    we.msg('error', data.msg, function() {
                        we.loading('hide');
                    });
                }
            }
        });
    };
    $.fallr('show', {
        buttons: {
            button1: {text: '确定', danger: true, onclick: fnCancelsvi},
            button2: {text: '取消'}
        },
        content: '取消服务将会影响订单交易，是否继续操作？',
        icon: 'trash',
        afterHide: function() {
            we.loading('hide');
        }
    });
};

we.through = function(id, url) {
    we.overlay('show');
    if (id == '' || id == undefined) {
        we.msg('error', '请选择要审核的内容', function() {
            we.loading('hide');
        });
        return false;
    }
    var fnThrough = function() {
        url = url.replace(/ID/, id);
        $.ajax({
            type: 'get',
            url: url,
            dataType: 'json',
            success: function(data) {
                if (data.status == 1) {
                    we.msg('check', data.msg, function() {
                        we.loading('hide');
                        we.reload();
                    });
                } else {
                    we.msg('error', data.msg, function() {
                        we.loading('hide');
                    });
                }
            }
        });
    };
    $.fallr('show', {
        buttons: {
            button1: {text: '审核', danger: true, onclick: fnThrough},
            button2: {text: '取消'}
        },
        content: '确定审核？',
        icon: 'trash',
        afterHide: function() {
            we.loading('hide');
        }
    });
};
we.unuse = function(id, url) {
    we.overlay('show');
    if (id == '' || id == undefined) {
        we.msg('error', '请选择要解除的内容', function() {
            we.loading('hide');
        });
        return false;
    }
    var fnUnuse = function() {
        url = url.replace(/ID/, id);
        $.ajax({
            type: 'get',
            url: url,
            dataType: 'json',
            success: function(data) {
                if (data.status == 1) {
                    we.msg('check', data.msg, function() {
                        we.loading('hide');
                        we.reload();
                    });
                } else {
                    we.msg('error', data.msg, function() {
                        we.loading('hide');
                    });
                }
            }
        });
    };
    $.fallr('show', {
        buttons: {
            button1: {text: '解除', danger: true, onclick: fnUnuse},
            button2: {text: '取消'}
        },
        content: '确定解除？',
        icon: 'trash',
        afterHide: function() {
            we.loading('hide');
        }
    });
};

we.update = function(id, url) {
    we.overlay('show');
    var url1 = url.replace(/ID/, id);
    if (id == '' || id == undefined) {
        return false;
    }
        url = url.replace(/ID/, id);
        $.ajax({
            type: 'get',
            url: url,
            dataType: 'json',
            success: function(data) {
                     we.reload();
            }
        });

};

we.hasDelete = function(op, btn) {
    if ($(op).length > 0) {
        $(btn).show();
    } else {
        $(btn).hide();
    }
};

we.overlay = function(op) {
    op = op || 'show';
    if (op == 'show') {
        $('#fallr-overlay').show();
        we.loading('show');
    } else {
        $('#fallr-overlay').hide();
        we.loading('hide');
    }
};

we.loading = function(op) {
    op = op || 'show';
    var $loading;
    if ($('#loading').length == 0) {
        $('body').append('<div id="loading"></div>');
    }
    $loading = $('#loading');
    if (op == 'show') {
        $loading.show();
    } else {
        $loading.hide();
    }
};

we.msg = function(css, msg, fn, time=1000) {
    var time = time;
    if (css != 'check') {
        time = time;
    } else{
        time = 2000;
    }
    $.fallr('show', {
        buttons: {},
        icon: css,
        autoclose: time,
        content: msg,
        afterHide: function() {
            if (fn != undefined) {
                (fn)();
            }
        }
    });
};

we.checkval = function(op) {
    var str = '';
    $(op).each(function() {
        str += $(this).val() + ',';
    });
    if (str.length > 0) {
        str = str.substring(0, str.length - 1);
    }
    return str;
};

we.editor = function(op, textarea, iHeight,iWidth='100%') {
    if(iHeight==undefined){iHeight=500;}
    document.write('<script id="editor_'+op+'" type="text\/plain" style="height:'+iHeight+'px;"><\/script>');
    if(textarea!=undefined){
        var editor = UE.getEditor('editor_'+op,{'textarea':textarea,initialFrameWidth : iWidth});
    }else{
        var editor = UE.getEditor('editor_'+op,{initialFrameWidth : iWidth});
    }
    var $text = $('#' + op);
    editor.addListener('ready', function() {
        if($text.val()==undefined || $text.val()==''){
            editor.setContent('');
        }else{
            editor.setContent($text.val());
        }
    });
     editor.addListener('contentChange', function() {
     //      editor.render(editor.getContent());
     //      $text.trigger('blur');
     $text.val(editor.getContent()).trigger('blur');
      //        setTimeout(function(){
      //            $text.val(editor.getContent()).trigger('blur');
      //        },100);
    });
 };

// 表单某个字段为图片时使用
we.uploadpic = function(op,file_prefix,file_savepath,file_sitepath,fnback,limit,buttonText='上传') {
    if(file_prefix==undefined){ file_prefix=''; }
    if(file_savepath==undefined){ file_savepath=''; }
    if(file_sitepath==undefined){ file_sitepath=''; }
    var multi=true;
    var delete_btn='<i onclick="$(this).parent().remove();fnUpdateServicePic();return false;"></i>';
    if(limit==undefined || limit==''){ limit=0; multi=false; delete_btn='';}
    // if(buttonText)
    var html='<div id="upload_box_'+op+'" class="upload fl"><input id="upload_'+op+'" type="file" name="uploadify"></div>'+
        '<br class="cb">';
    if($('#upload_pic_'+op).length==0){
        html='<div class="upload_img fl" id="upload_pic_'+op+'"></div>'+html;
    }
    if($('#box_'+op).length>0){
        $('#box_'+op).html(html);
    }else{
        document.write(html);
    }
    $('#upload_'+op).uploadifive({
        //'debug': true,
        'formData': {},
        'multi': multi,
        'uploadLimit':limit,
        'uploadScript': uppicUrl+'&savepath='+file_savepath+'&sitepath='+file_sitepath+'&prefix='+file_prefix,
        'width': 61,
        'height': 24,
        'buttonText': buttonText,
        //'overrideEvents': ['onUploadError'],
        //'onUploadError': onUploadError,
        'onUploadComplete': function(file, data) {
            var data = $.parseJSON(data);
            if (data.status==1) {
                if(fnback==undefined || fnback==''){
                    $('#'+op).val(data.savename).trigger('blur');
                    $('#upload_pic_'+op).html('<a href="'+data.allpath+'" target="_blank"><img src="'+data.allpath+'" width="100">'+delete_btn+'</a>');
                }else{
                    fnback.call(this,data);
                    $('#'+op).trigger('blur');
                }
            } else {
                we.msg('error', data.msg);
            }
            //alert(typeof(datas));
        }
    });
};
// 表单某个字段为图片时使用。 替换原图片。
we.uploadpicx = function(mo,op,file_prefix,file_savepath,file_sitepath,fnback,limit) {

    if(file_prefix==undefined){ file_prefix=''; }
    if(file_savepath==undefined){ file_savepath=''; }
    if(file_sitepath==undefined){ file_sitepath=''; }
    var multi=true;
    var delete_btn='<i onclick="$(this).parent().remove();fnUpdateServicePic();return false;"></i>';
    if(limit==undefined || limit==''){ limit=0; multi=false; delete_btn='';}
    var html='<div id="upload_box_'+op+'" class="upload fl"><input id="upload_'+op+'" type="file" name="uploadify"></div>'+
        '<br class="cb">';
    if($('#upload_pic_'+op).length==0){
        html='<div class="upload_img fl" id="upload_pic_'+op+'"></div>'+html;
    }
    if($('#box_'+op).length>0){
        $('#box_'+op).html(html);
    }else{
        document.write(html);
    }
    $('#upload_'+op).uploadifive({
        //'debug': true,
        'formData': {},
        'multi': multi,
        'uploadLimit':limit,
        'uploadScript': uppicUrl+'&savepath='+file_savepath+'&sitepath='+file_sitepath+'&prefix='+file_prefix,
        'width': 61,
        'height': 24,
        'buttonText': '上传',
        //'overrideEvents': ['onUploadError'],
        //'onUploadError': onUploadError,
        'onUploadComplete': function(file, data) {
            var data = $.parseJSON(data);
            if (data.status==1) {
                if(fnback==undefined || fnback==''){
                    $('#'+mo+'_'+op).val(data.savename).trigger('blur');
                    $('#upload_pic_'+op).html('<a href="'+data.allpath+'" target="_blank"><img src="'+data.allpath+'" width="100">'+delete_btn+'</a>');
                }else{
                    fnback.call(this,data);
                    $('#'+mo+'_'+op).trigger('blur');
                }
            } else {
                we.msg('error', data.msg);
            }
            //alert(typeof(datas));
        }
    });
};

// 图片素材上传
we.materialPic = function(fnback) {
    var op='up'+new Date().getTime()+parseInt(Math.random()*100000);
    var html='<input id="upload_'+op+'" type="file" name="uploadify">';
    document.write(html);
    $('#upload_'+op).uploadifive({
        //'debug': true,
        'formData': {},
        'multi': true,
        'uploadLimit':0,
        'uploadScript': materialPicUrl,
        'width': 89,
        'height': 29,
        'buttonText': '本地上传',
        //'overrideEvents': ['onUploadError'],
        //'onUploadError': onUploadError,
        'onUploadComplete': function(file, data) {
            var data = $.parseJSON(data);
            if (data.status==1) {
                if(fnback==undefined || fnback==''){
                    $('#material-main').prepend('<li>'+
                        '<div class="pic"><a href="'+data.allpath+'" target="_blank"><img src="'+data.allpath+'"></a></div>'+
                        '<div class="title">'+
                            '<input class="input-check check-item" type="checkbox" value="'+data.id+'">'+
                            '<input id="title-'+data.id+'" class="input-text" type="text" value="'+data.title+'" readonly>'+
                        '</div>'+
                        '<div class="bar">'+
                            '<a class="fa fa-pencil" href="javascript:;" onclick="fnChangeTitle(\''+data.id+'\', this);"></a>'+
                            '<a class="fa fa-exchange" href="javascript:;" onclick="fnChangeGroupShow(\''+data.id+'\', this);"></a>'+
                            '<a class="fa fa-trash-o" href="javascript:;" onclick="we.dele(\''+data.id+'\', deleteUrl);"></a>'+
                        '</div>'+
                    '</li>');
                }else{
                    fnback.call(this,data);
                }
            } else {
                we.msg('error', data.msg);
            }
            //alert(typeof(datas));
        }
    });
};

we.uploadfont = function(op,file_prefix,file_savepath,file_sitepath,fnback,limit) {
    if(file_prefix==undefined){ file_prefix=''; }
    if(file_savepath==undefined){ file_savepath=''; }
    if(file_sitepath==undefined){ file_sitepath=''; }
    var multi=true;
    var delete_btn='<i onclick="$(this).parent().remove();fnUpdateServicePic();return false;"></i>';
    if(limit==undefined || limit==''){ limit=0; multi=false; delete_btn='';}
    var html='<div id="upload_box_'+op+'" class="upload fl"><input id="upload_'+op+'" type="file" name="uploadify"></div>'+
        '<br class="cb">';
    if($('#upload_file_'+op).length==0){
        html='<div id="upload_file_'+op+'"></div>'+html;
    }
    if($('#box_'+op).length>0){
        $('#box_'+op).html(html);
    }else{
        document.write(html);
    }
    $('#upload_'+op).uploadifive({
        //'debug': true,
        'formData': {},
        'multi': multi,
        'uploadLimit':limit,
        'uploadScript': uppicUrl+'&savepath='+file_savepath+'&sitepath='+file_sitepath+'&prefix='+file_prefix,
        'width': 61,
        'height': 24,
        'buttonText': '上传',
        'onUploadComplete': function(file, data) {
            var data = $.parseJSON(data);
            if (data.status==1) {
                if(fnback==undefined || fnback==''){
                    $('#'+op).val(data.savename).trigger('blur');
                    $('#upload_file_'+op).html('<a href="'+data.allpath+'" target="_blank">'+data.savename+delete_btn+'</a>');
                    //$('#set_file'+itemId).html('<span>'+data.savename+'</span>');
                }else{
                    fnback.call(this,data);
                    $('#'+op).trigger('blur');
                }
            } else {
                we.msg('error', data.msg);
            }
        }
    });
};

// 视频素材上传
we.materialVideo = function(fnback, buttonText, url) {
    if(buttonText==undefined){buttonText='本地上传';}
    var op='up'+new Date().getTime()+parseInt(Math.random()*100000);
    var html='<div id="uploadifive-upload_'+op+'" class="uploadifive-button" style="height: 24px; line-height: 24px; overflow: hidden; position: relative; text-align: center; width: 61px;">'+buttonText+'<input id="upload_'+op+'" type="file" accept="video/mp4" style="font-size: 24px; opacity: 0; position: absolute; right: -3px; top: -3px; z-index: 999;"></div><div id="uploadifive-upload_'+op+'-queue" class="uploadifive-queue"></div>';
    document.write(html);
	var fileForm = document.getElementById('upload_'+op);
	var upload = new Upload();
	fileForm.onchange = function(){
        upload.addFileAndSend(this);
    }
	function Upload(){
        var xhr = new XMLHttpRequest();
        var form_data = new FormData();
        const LENGTH = 1024 * 1024 * 5;
        var start = 0;
        var end = start + LENGTH;
        var blob_num = 1;
        var is_stop = 0;
        var running=false;
		var filename='';
		var filetitle='';
		var res_json;
        //对外方法，传入文件对象
        this.addFileAndSend = function(that){
			$('#upload_'+op).parents('.up_btn').find(".up_progress").show();
			$('#upload_'+op).parents('.up_btn').find(".up_finish").html('0%');

			var file = that.files[0];
            var filename = file.name;
            var index = filename.lastIndexOf(".");
    		var suffix = filename.substr(index+1);
        	if(suffix=='mp4'||suffix=='mp3'){
	            //获取音频、视频时长
		        var url = URL.createObjectURL(file);
		        var audioElement = new Audio(url);
		    	var duration;
		        audioElement.addEventListener("loadedmetadata", function (_event) {
		            duration = Math.ceil(audioElement.duration);
		            doFileToMd5(file,duration);
		        });
        	}else{
	            doFileToMd5(file,0);
        	}
        }
        //停止文件上传
        this.stop = function(){
            xhr.abort();
            is_stop = 1;
        }

		//获取文件Md5
        function doFileToMd5(file,duration) {
            if (running) {
                return;
            }
            if (file.size==0) {
                return;
            }
            var blobSlice = File.prototype.slice || File.prototype.mozSlice || File.prototype.webkitSlice,
                chunkSize = 1024 * 1024 * 5,                           // read in chunks of 2MB
                chunks = Math.ceil(file.size / chunkSize),
                currentChunk = 0,
                spark = new SparkMD5.ArrayBuffer(),
                time,
                fileReader = new FileReader(),md5_str='';
            fileReader.onload = function (e) {
                spark.append(e.target.result);                 // append array buffer
                currentChunk += 1;
                if (currentChunk < chunks) {
                    loadNext();
                } else {
                    running = false;
                    md5_str=spark.end();
                    askSendFile(file,md5_str,duration);
                }
            };
            fileReader.onerror = function () {
                running = false;
            };
            function loadNext() {
                var start = currentChunk * chunkSize,
                    end = start + chunkSize >= file.size ? file.size : start + chunkSize;
                fileReader.readAsArrayBuffer(blobSlice.call(file, start, end));
            }
            running = true;
            time = new Date().getTime();
            loadNext();
        }

        //切割文件
        function cutFile(file){
            var file_blob = file.slice(start,end);
            start = end;
            end = start + LENGTH;
            return file_blob;
        };
        //请求发送文件
        function askSendFile(file,md5_str,duration){
			filetitle=file.name;
			$.ajax({
				url: "/gw/chunk_upload.php",
				type: 'post',
				data: {action:'upload_ask',slen:file.size,segs:Math.ceil(file.size / LENGTH),file_md5:md5_str,fileName:file.name,duration:Math.ceil(duration),fileCode:fileCode.value},
				dataType: 'json',
				success: function (json) {
					res_json=json;
					var filename_arr=json.filename.split('/');
					filename=filename_arr[filename_arr.length-1]
                    if(json.code==0){
                        sendFile(cutFile(file),file,json.fileId);
                    }else if(json.error>0){
						askSendFile(file,md5_str,duration);
					}else{
						askSendFile(file,md5_str,duration);
					}
				}
			});
        }
        //发送文件
        function sendFile(blob,file,fileId){
			var total_blob_num = Math.ceil(file.size / LENGTH);
            form_data = new FormData();
            form_data.append('action','chunk_upload_file');
            form_data.append('file',blob);
            form_data.append('fileId',fileId);
            form_data.append('segno',blob_num);
            form_data.append('start',start-LENGTH);
			$.ajax({
				url: "/gw/chunk_upload.php",
				type: 'post',
				data: form_data,
				processData: false,
				contentType: false,
				dataType: 'json',
				success: function (json) {
					if(json.code==0){
                    	var progress;
		                var progressObj = $('#upload_'+op).parents('.up_btn').find(".up_finish").get(0);
		                if(total_blob_num == 1){
		                    progress = 100;
		                }else{
		                    progress = Math.min(100,(blob_num/total_blob_num)* 100 );
		                }
		                progressObj.style.width = progress+'%';
						$('#upload_'+op).parents('.up_btn').find(".up_finish").html(parseInt(progress));
		                var t = setTimeout(function(){
		                    if(start < file.size && is_stop === 0){
		                        sendFile(cutFile(file),file,fileId);
		                    }else{
		                        setTimeout(t);
		                    }
		                },500);
						if(progress == 100){
							var index = filetitle.lastIndexOf(".");
							var suffix = filetitle.substr(index+1);
							var v_type=253;
							if(suffix=="mp3"){
								v_type=254;
							}else if(suffix=="mp4"){
								v_type=253;
							}
							$.ajax({
								url: url,
								type: 'post',
								data: {v_title:filetitle,v_type:v_type,v_name:res_json.filename,v_file_path:res_json.fileUrl,v_file_insert_size:sec_format(res_json.playtime_seconds)},
								dataType: 'json',
								success: function (data) {
									var $_this=$('#upload_'+op);
									$_this.parents('.up_btn').find(".up_progress").hide();
									$_this.parents('.up_btn').find(".video_box").html('<span class="label-box" style="max-width: 120px;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;word-break: keep-all;"><a href="../qmdd2018/index.php?r=gfMaterial/video_player&id='+data.id+'" target="_blank" title="'+filetitle+'">'+filetitle+'</a></span>');
									fnback.call(this,data);
								}
							});
						}
                    }else if(json.error>0){
						sendFile(blob,file,fileId);
					}else{
		                sendFile(blob,file,fileId);
                    }
                    blob_num  += 1;
				}
			});
        }
    }
};

we.materialVideoNew = function(url) {
    var op='up'+new Date().getTime()+parseInt(Math.random()*100000);
    var html='<div id="uploadifive-upload_'+op+'" class="uploadifive-button" style="height: 24px; line-height: 24px; overflow: hidden; position: relative; text-align: center; width: 61px;">上传视频<input id="upload_'+op+'" type="file" accept="video/mp4,audio/mp3" style="font-size: 24px; opacity: 0; position: absolute; right: -3px; top: -3px; z-index: 999;"></div><div id="uploadifive-upload_'+op+'-queue" class="uploadifive-queue"></div>';
    document.write(html);
	var fileForm = document.getElementById('upload_'+op);
	var upload = new Upload();
	fileForm.onchange = function(){
        upload.addFileAndSend(this);
    }
	function Upload(){
        var xhr = new XMLHttpRequest();
        var form_data = new FormData();
        const LENGTH = 1024 * 1024 * 5;
        var start = 0;
        var end = start + LENGTH;
        var blob_num = 1;
        var is_stop = 0;
        var running=false;
		var filename='';
		var filetitle='';
		var res_json;
        //对外方法，传入文件对象
        this.addFileAndSend = function(that){
			$('#upload_'+op).parents('.up_btn').find(".up_progress").show();
			$('#upload_'+op).parents('.up_btn').find(".up_finish").html('0%');

			var file = that.files[0];
            var filename = file.name;
            var index = filename.lastIndexOf(".");
    		var suffix = filename.substr(index+1);
        	if(suffix=='mp4'||suffix=='mp3'){
	            //获取音频、视频时长
		        var url = URL.createObjectURL(file);
		        var audioElement = new Audio(url);
		    	var duration;
		        audioElement.addEventListener("loadedmetadata", function (_event) {
		            duration = Math.ceil(audioElement.duration);
		            doFileToMd5(file,duration);
		        });
        	}else{
	            doFileToMd5(file,0);
        	}
        }
        //停止文件上传
        this.stop = function(){
            xhr.abort();
            is_stop = 1;
        }

		//获取文件Md5
        function doFileToMd5(file,duration) {
            if (running) {
                return;
            }
            if (file.size==0) {
                return;
            }
            var blobSlice = File.prototype.slice || File.prototype.mozSlice || File.prototype.webkitSlice,
                chunkSize = 1024 * 1024 * 5,                           // read in chunks of 2MB
                chunks = Math.ceil(file.size / chunkSize),
                currentChunk = 0,
                spark = new SparkMD5.ArrayBuffer(),
                time,
                fileReader = new FileReader(),md5_str='';
            fileReader.onload = function (e) {
                spark.append(e.target.result);                 // append array buffer
                currentChunk += 1;
                if (currentChunk < chunks) {
                    loadNext();
                } else {
                    running = false;
                    md5_str=spark.end();
                    askSendFile(file,md5_str,duration);
                }
            };
            fileReader.onerror = function () {
                running = false;
            };
            function loadNext() {
                var start = currentChunk * chunkSize,
                    end = start + chunkSize >= file.size ? file.size : start + chunkSize;
                fileReader.readAsArrayBuffer(blobSlice.call(file, start, end));
            }
            running = true;
            time = new Date().getTime();
            loadNext();
        }

        //切割文件
        function cutFile(file){
            var file_blob = file.slice(start,end);
            start = end;
            end = start + LENGTH;
            return file_blob;
        };
		//请求发送文件
        function askSendFile(file,md5_str,duration){
			filetitle=file.name;
			$.ajax({
				url: "/gw/chunk_upload.php",
				type: 'post',
				data: {action:'upload_ask',slen:file.size,segs:Math.ceil(file.size / LENGTH),file_md5:md5_str,fileName:file.name,duration:Math.ceil(duration),fileCode:fileCode.value},
				dataType: 'json',
				success: function (json) {
					res_json=json;
					var filename_arr=json.filename.split('/');
					filename=filename_arr[filename_arr.length-1]
                    if(json.code==0){
                        sendFile(cutFile(file),file,json.fileId);
                    }else if(json.error>0){
						askSendFile(file,md5_str,duration);
					}else{
						askSendFile(file,md5_str,duration);
					}
				}
			});
        }
        //发送文件
        function sendFile(blob,file,fileId){
			var total_blob_num = Math.ceil(file.size / LENGTH);
            form_data = new FormData();
            form_data.append('action','chunk_upload_file');
            form_data.append('file',blob);
            form_data.append('fileId',fileId);
            form_data.append('segno',blob_num);
            form_data.append('start',start-LENGTH);
			$.ajax({
				url: "/gw/chunk_upload.php",
				type: 'post',
				data: form_data,
				processData: false,
				contentType: false,
				dataType: 'json',
				success: function (json) {
					if(json.code==0){
                    	var progress;
		                var progressObj = $('#upload_'+op).parents('.up_btn').find(".up_finish").get(0);
		                if(total_blob_num == 1){
		                    progress = 100;
		                }else{
		                    progress = Math.min(100,(blob_num/total_blob_num)* 100 );
		                }
		                progressObj.style.width = progress+'%';
						$('#upload_'+op).parents('.up_btn').find(".up_finish").html(parseInt(progress));
		                var t = setTimeout(function(){
		                    if(start < file.size && is_stop === 0){
		                        sendFile(cutFile(file),file,fileId);
		                    }else{
		                        setTimeout(t);
		                    }
		                },500);
						if(progress == 100){
							var index = filetitle.lastIndexOf(".");
							var suffix = filetitle.substr(index+1);
							var v_type=253;
							if(suffix=="mp3"){
								v_type=254;
							}else if(suffix=="mp4"){
								v_type=253;
							}
							$.ajax({
								url: url,
								type: 'post',
								data: {v_title:filetitle,v_type:v_type,v_name:res_json.filename,v_file_path:res_json.fileUrl,v_file_insert_size:sec_format(res_json.playtime_seconds)},
								dataType: 'json',
								success: function (d) {
									var $_this=$('#upload_'+op);
									$_this.parents('.up_btn').find(".up_progress").hide();
									$_this.parents('.up_btn').find(".video_box").html('<span class="label-box" style="max-width: 120px;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;word-break: keep-all;"><a href="../qmdd2018/index.php?r=gfMaterial/video_player&id='+d.id+'" target="_blank" title="'+filetitle+'">'+filetitle+'</a></span>');
									$_this.parents('.up_btn').find('.input-text').eq(0).val(d.id);
									$_this.parents('.up_btn').find('.input-text').eq(1).val(d.file_format);
									$_this.parents('.up_btn').find('.input-text').eq(2).val(d.duration);
									$_this.parents('.up_btn').next('td').html(d.file_format);
									$_this.parents('.up_btn').next('td').next('td').html(d.duration+'分钟');
									fnUpdateProgram();
								}
							});
						}
                    }else if(json.error>0){
						sendFile(blob,file,fileId);
					}else{
		                sendFile(blob,file,fileId);
                    }
                    blob_num  += 1;
				}
			});
        }
    }
};
var sec_format=function(s){
	s=s-1;
	var result='';
	if(s<=60){
		result=s+'"';
	}else{
		result=parseInt(s/60)+"'"+(s%60)+"\"";
	}
	console.log(s);
	console.log(result);
	return result;
};

// 音频素材上传
we.materialAudio = function(fnback) {
    var op='up'+new Date().getTime()+parseInt(Math.random()*100000);
    var html='<input id="upload_'+op+'" type="file" name="uploadify">';
    document.write(html);
    $('#upload_'+op).uploadifive({
        //'debug': true,
        'formData': {},
        'multi': true,
        'uploadLimit':0,
        'uploadScript': materialAudioUrl,
        'fileTypeExts': '*.mp3;*.wma;*.wav;*.amr',
        'width': 89,
        'height': 29,
        'buttonText': '本地上传',
        //'overrideEvents': ['onUploadError'],
        //'onUploadError': onUploadError,
        'onUploadComplete': function(file, data) {
            var data = $.parseJSON(data);
            if (data.status==1) {
                if(fnback==undefined || fnback==''){
                    $('#material-main').prepend('<li>'+
                        '<div class="pic"><img data-src="'+data.allpath+'" src="'+baseUrl+'/static/admin/img/i-audio.png"></div>'+
                        '<div class="info">'+
                            '<div class="title">'+
                                '<input class="input-check check-item" type="checkbox" value="'+data.id+'">'+
                                '<input id="title-'+data.id+'" class="input-text" type="text" value="'+data.title+'" readonly>'+
                            '</div>'+
                            '<div class="duration">'+data.duration+'</div>'+
                            '<div class="date">'+data.date+'</div>'+
                        '</div>'+
                        '<div class="bar">'+
                            '<a class="fa fa-pencil" href="javascript:;" onclick="fnChangeTitle(\''+data.id+'\', this);"></a>'+
                            '<a class="fa fa-exchange" href="javascript:;" onclick="fnChangeGroupShow(\''+data.id+'\', this);"></a>'+
                            '<a class="fa fa-download" href="'+data.allpath+'" target="_blank"></a>'+
                            '<a class="fa fa-trash-o" href="javascript:;" onclick="we.dele(\''+data.id+'\', deleteUrl);"></a>'+
                        '</div>'+
                    '</li>');
                }else{
                    fnback.call(this,data);
                }
            } else {
                we.msg('error', data.msg);
            }
            //alert(typeof(datas));
        }
    });
};


// 电子书素材上传
we.materialDoc = function(fnback) {
    var op='up'+new Date().getTime()+parseInt(Math.random()*100000);
    var html='<input id="upload_'+op+'" type="file" name="uploadify">';
    document.write(html);
    $('#upload_'+op).uploadifive({
        //'debug': true,
        'formData': {},
        'multi': true,
        'uploadLimit':0,
        'uploadScript': materialDocUrl,
        'fileTypeExts': '*.txt;*.doc;*.docx',
        'width': 89,
        'height': 29,
        'buttonText': '本地上传',
        //'overrideEvents': ['onUploadError'],
        //'onUploadError': onUploadError,
        'onUploadComplete': function(file, data) {
            var data = $.parseJSON(data);
            if (data.status==1) {
                if(fnback==undefined || fnback==''){
                    $('#material-main').prepend('<li>'+
                        '<div class="pic"><img data-src="'+data.allpath+'" src="'+baseUrl+'/static/admin/img/i_doc.jpg"></div>'+
                        '<div class="info">'+
                            '<div class="title">'+
                                '<input class="input-check check-item" type="checkbox" value="'+data.id+'">'+
                                '<input id="title-'+data.id+'" class="input-text" type="text" value="'+data.title+'" readonly>'+
                            '</div>'+
                            '<div class="duration">'+data.duration+'</div>'+
                            '<div class="date">'+data.date+'</div>'+
                        '</div>'+
                        '<div class="bar">'+
                            '<a class="fa fa-pencil" href="javascript:;" onclick="fnChangeTitle(\''+data.id+'\', this);"></a>'+
                            '<a class="fa fa-exchange" href="javascript:;" onclick="fnChangeGroupShow(\''+data.id+'\', this);"></a>'+
                            '<a class="fa fa-download" href="'+data.allpath+'" target="_blank"></a>'+
                            '<a class="fa fa-trash-o" href="javascript:;" onclick="we.dele(\''+data.id+'\', deleteUrl);"></a>'+
                        '</div>'+
                    '</li>');
                }else{
                    fnback.call(this,data);
                }
            } else {
                we.msg('error', data.msg);
            }
            //alert(typeof(datas));
        }
    });
};



// 上传APP
we.uploadapp = function(op,file_prefix,file_savepath,file_sitepath,fnback,limit) {
    if(file_prefix==undefined){ file_prefix=''; }
    if(file_savepath==undefined){ file_savepath=''; }
    if(file_sitepath==undefined){ file_sitepath=''; }
    var multi=true;
    var delete_btn='<i onclick="$(this).parent().remove();fnUpdateServicePic();return false;"></i>';
    if(limit==undefined || limit==''){ limit=0; multi=false; delete_btn='';}
    var html='<div id="upload_box_'+op+'" class="upload fl"><input id="upload_'+op+'" type="file" name="uploadify"></div>'+
        '<br class="cb">';
    if($('#upload_pic_'+op).length==0){
        html='<div class="upload_img fl" id="upload_pic_'+op+'"></div>'+html;
    }
    if($('#box_'+op).length>0){
        $('#box_'+op).html(html);
    }else{
        document.write(html);
    }
    $('#upload_'+op).uploadifive({
        //'debug': true,
        'formData': {},
        'multi': multi,
        'uploadLimit':limit,
        'uploadScript': uppicUrl+'&savepath='+file_savepath+'&sitepath='+file_sitepath+'&prefix='+file_prefix,
        'width': 61,
        'height': 24,
        'fileTypeExts': '*.apk;*.ipd',
        'buttonText': '上传',
        //'overrideEvents': ['onUploadError'],
        //'onUploadError': onUploadError,
        'onUploadComplete': function(file, data) {
            var data = $.parseJSON(data);
            if (data.status==1) {
                if(fnback==undefined || fnback==''){
                    $('#'+op).val(data.savename).trigger('blur');
                    // $('#upload_pic_'+op).html('<a href="'+data.allpath+'" target="_blank"><img src="'+data.allpath+'" width="100">'+delete_btn+'</a>');
                   // $("#AndroidPhone_url").attr("value",data.filepath);
                   var all_path = data.allpath.substring(0,27)+data.allpath.substring(28);
                    $("#AndroidPhone_url").attr("value",all_path);
                }else{
                    fnback.call(this,data);
                    $('#'+op).trigger('blur');
                }
            } else {
                we.msg('error', data.msg);
            }
            //alert(typeof(datas));
        }
    });
};

we.reload = function() {
    window.location.reload(true);
};

we.back = function(url) {
    url = url || indexUrl;
    window.location.href = url;
    //window.history.go(-1);
};
we.next = function(page) {
    var page1=page-1;
    var item=$('.box-detail-bd').find('.box-detail-tab-item');
    var item_title=$('.box-detail-tab').find('li');
    $('.box-detail-tab').find('li').removeClass('current');
    item_title.eq(page).addClass('current');
    item.eq(page1).hide();
    item.eq(page).show();
};
fnAgreement = function(obj) {
    if($(obj).is(':checked')){
        $('#shenhe').removeAttr('disabled');
        $('#shenhe').css({'background-color':'#368EE0','border-color':'#368EE0','cursor':'default'});
    }
    else{
        $('#shenhe').attr('disabled','disabled');
        $('#shenhe').css({'background-color':'#ccc','border-color':'#ccc','cursor':'no-drop'});
    }
}

we.implode=function(glue, pieces) {
  var i = ''
  var retVal = ''
  var tGlue = ''
  if (arguments.length === 1) {
    pieces = glue
    glue = ''
  }
  if (typeof pieces === 'object') {
    if (Object.prototype.toString.call(pieces) === '[object Array]') {
      return pieces.join(glue)
    }
    for (i in pieces) {
      retVal += tGlue + pieces[i]
      tGlue = glue
    }
    return retVal
  }
  return pieces
}


we.strtotime=function(b,d){function k(a){var b=a.split(" ");a=b[0];var c=b[1].substring(0,3),d=/\d+/.test(a),f=("last"===a?-1:1)*("ago"===b[2]?-1:1);d&&(f*=parseInt(a,10));if(g.hasOwnProperty(c)&&!b[1].match(/^mon(day|\.)?$/i))return e["set"+g[c]](e["get"+g[c]]()+f);if("wee"===c)return e.setDate(e.getDate()+7*f);if("next"===a||"last"===a)b=f,c=h[c],"undefined"!==typeof c&&(c-=e.getDay(),0===c?c=7*b:0<c&&"last"===a?c-=7:0>c&&"next"===a&&(c+=7),e.setDate(e.getDate()+c));else if(!d)return!1;return!0}var a,
e,h,g;if(!b)return!1;b=b.replace(/^\s+|\s+$/g,"").replace(/\s{2,}/g," ").replace(/[\t\r\n]/g,"").toLowerCase();a=/^(\d{1,4})([\-\.\/:])(\d{1,2})([\-\.\/:])(\d{1,4})(?:\s(\d{1,2}):(\d{2})?:?(\d{2})?)?(?:\s([A-Z]+)?)?$/;if((a=b.match(a))&&a[2]===a[4])if(1901<a[1])switch(a[2]){case "-":return 12<a[3]||31<a[5]?!1:new Date(a[1],parseInt(a[3],10)-1,a[5],a[6]||0,a[7]||0,a[8]||0,a[9]||0)/1E3;case ".":return!1;case "/":return 12<a[3]||31<a[5]?!1:new Date(a[1],parseInt(a[3],10)-1,a[5],a[6]||0,a[7]||0,a[8]||
0,a[9]||0)/1E3}else if(1901<a[5])switch(a[2]){case "-":return 12<a[3]||31<a[1]?!1:new Date(a[5],parseInt(a[3],10)-1,a[1],a[6]||0,a[7]||0,a[8]||0,a[9]||0)/1E3;case ".":return 12<a[3]||31<a[1]?!1:new Date(a[5],parseInt(a[3],10)-1,a[1],a[6]||0,a[7]||0,a[8]||0,a[9]||0)/1E3;case "/":return 12<a[1]||31<a[3]?!1:new Date(a[5],parseInt(a[1],10)-1,a[3],a[6]||0,a[7]||0,a[8]||0,a[9]||0)/1E3}else switch(a[2]){case "-":if(12<a[3]||31<a[5]||70>a[1]&&38<a[1])return!1;b=0<=a[1]&&38>=a[1]?+a[1]+2E3:a[1];return new Date(b,
parseInt(a[3],10)-1,a[5],a[6]||0,a[7]||0,a[8]||0,a[9]||0)/1E3;case ".":if(70<=a[5])return 12<a[3]||31<a[1]?!1:new Date(a[5],parseInt(a[3],10)-1,a[1],a[6]||0,a[7]||0,a[8]||0,a[9]||0)/1E3;if(60>a[5]&&!a[6]){if(23<a[1]||59<a[3])return!1;b=new Date;return new Date(b.getFullYear(),b.getMonth(),b.getDate(),a[1]||0,a[3]||0,a[5]||0,a[9]||0)/1E3}return!1;case "/":if(12<a[1]||31<a[3]||70>a[5]&&38<a[5])return!1;b=0<=a[5]&&38>=a[5]?+a[5]+2E3:a[5];return new Date(b,parseInt(a[1],10)-1,a[3],a[6]||0,a[7]||0,a[8]||
0,a[9]||0)/1E3;case ":":if(23<a[1]||59<a[3]||59<a[5])return!1;b=new Date;return new Date(b.getFullYear(),b.getMonth(),b.getDate(),a[1]||0,a[3]||0,a[5]||0)/1E3}if("now"===b)return null===d||isNaN(d)?(new Date).getTime()/1E3|0:d|0;if(!isNaN(a=Date.parse(b)))return a/1E3|0;a=/^([0-9]{4}-[0-9]{2}-[0-9]{2})[ t]([0-9]{2}:[0-9]{2}:[0-9]{2}(\.[0-9]+)?)([\+-][0-9]{2}(:[0-9]{2})?|z)/;if(a=b.match(a))if("z"===a[4]?a[4]="Z":a[4].match(/^([+-][0-9]{2})$/)&&(a[4]+=":00"),!isNaN(a=Date.parse(a[1]+"T"+a[2]+a[4])))return a/
1E3|0;e=d?new Date(1E3*d):new Date;h={sun:0,mon:1,tue:2,wed:3,thu:4,fri:5,sat:6};g={yea:"FullYear",mon:"Month",day:"Date",hou:"Hours",min:"Minutes",sec:"Seconds"};a=b.match(/([+-]?\d+\s(years?|months?|weeks?|days?|hours?|minutes?|min|seconds?|sec|sunday|sun\.?|monday|mon\.?|tuesday|tue\.?|wednesday|wed\.?|thursday|thu\.?|friday|fri\.?|saturday|sat\.?)|(last|next)\s(years?|months?|weeks?|days?|hours?|minutes?|min|seconds?|sec|sunday|sun\.?|monday|mon\.?|tuesday|tue\.?|wednesday|wed\.?|thursday|thu\.?|friday|fri\.?|saturday|sat\.?))(\sago)?/gi);
if(!a)return!1;d=0;for(b=a.length;d<b;d++)if(!k(a[d]))return!1;return e.getTime()/1E3};


we.rawurlencode=function(str) {
  str = (str + '')
    .toString();
  return encodeURIComponent(str)
    .replace(/!/g, '%21')
    .replace(/'/g, '%27')
    .replace(/\(/g, '%28')
    .replace(/\)/g, '%29')
    .replace(/\*/g, '%2A');
};

we.trim=function(str, charlist) {

  var whitespace, l = 0, i = 0;
  str += '';

  if (!charlist) {
    // default list
    whitespace =
      ' \n\r\t\f\x0b\xa0\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u200b\u2028\u2029\u3000';
  } else {
    // preg_quote custom list
    charlist += '';
    whitespace = charlist.replace(/([\[\]\(\)\.\?\/\*\{\}\+\$\^\:])/g, '$1');
  }

  l = str.length;
  for (i = 0; i < l; i++) {
    if (whitespace.indexOf(str.charAt(i)) === -1) {
      str = str.substring(i);
      break;
    }
  }

  l = str.length;
  for (i = l - 1; i >= 0; i--) {
    if (whitespace.indexOf(str.charAt(i)) === -1) {
      str = str.substring(0, i + 1);
      break;
    }
  }

  return whitespace.indexOf(str.charAt(0)) === -1 ? str : '';
};

we.date=function(a,b){var d,e,c=this,f=["Sun","Mon","Tues","Wednes","Thurs","Fri","Satur","January","February","March","April","May","June","July","August","September","October","November","December"],g=/\\?(.?)/gi,h=function(a,b){return e[a]?e[a]():b},i=function(a,b){for(a=String(a);a.length<b;)a="0"+a;return a};return e={d:function(){return i(e.j(),2)},D:function(){return e.l().slice(0,3)},j:function(){return d.getDate()},l:function(){return f[e.w()]+"day"},N:function(){return e.w()||7},S:function(){var a=e.j(),b=a%10;return 3>=b&&1==parseInt(a%100/10,10)&&(b=0),["st","nd","rd"][b-1]||"th"},w:function(){return d.getDay()},z:function(){var a=new Date(e.Y(),e.n()-1,e.j()),b=new Date(e.Y(),0,1);return Math.round((a-b)/864e5)},W:function(){var a=new Date(e.Y(),e.n()-1,e.j()-e.N()+3),b=new Date(a.getFullYear(),0,4);return i(1+Math.round((a-b)/864e5/7),2)},F:function(){return f[6+e.n()]},m:function(){return i(e.n(),2)},M:function(){return e.F().slice(0,3)},n:function(){return d.getMonth()+1},t:function(){return new Date(e.Y(),e.n(),0).getDate()},L:function(){var a=e.Y();return 0===a%4&0!==a%100|0===a%400},o:function(){var a=e.n(),b=e.W(),c=e.Y();return c+(12===a&&9>b?1:1===a&&b>9?-1:0)},Y:function(){return d.getFullYear()},y:function(){return e.Y().toString().slice(-2)},a:function(){return d.getHours()>11?"pm":"am"},A:function(){return e.a().toUpperCase()},B:function(){var a=3600*d.getUTCHours(),b=60*d.getUTCMinutes(),c=d.getUTCSeconds();return i(Math.floor((a+b+c+3600)/86.4)%1e3,3)},g:function(){return e.G()%12||12},G:function(){return d.getHours()},h:function(){return i(e.g(),2)},H:function(){return i(e.G(),2)},i:function(){return i(d.getMinutes(),2)},s:function(){return i(d.getSeconds(),2)},u:function(){return i(1e3*d.getMilliseconds(),6)},e:function(){throw"Not supported (see source code of date() for timezone on how to add support)"},I:function(){var a=new Date(e.Y(),0),b=Date.UTC(e.Y(),0),c=new Date(e.Y(),6),d=Date.UTC(e.Y(),6);return a-b!==c-d?1:0},O:function(){var a=d.getTimezoneOffset(),b=Math.abs(a);return(a>0?"-":"+")+i(100*Math.floor(b/60)+b%60,4)},P:function(){var a=e.O();return a.substr(0,3)+":"+a.substr(3,2)},T:function(){return"UTC"},Z:function(){return 60*-d.getTimezoneOffset()},c:function(){return"Y-m-d\\TH:i:sP".replace(g,h)},r:function(){return"D, d M Y H:i:s O".replace(g,h)},U:function(){return 0|d/1e3}},this.date=function(a,b){return c=this,d=void 0===b?new Date:b instanceof Date?new Date(b):new Date(1e3*b),a.replace(g,h)},this.date(a,b)}
function strtotime(a,b){function o(a,b,c){var d,e=h[b];"undefined"!=typeof e&&(d=e-g.getDay(),0===d?d=7*c:d>0&&"last"===a?d-=7:0>d&&"next"===a&&(d+=7),g.setDate(g.getDate()+d))}function p(a){var b=a.split(" "),c=b[0],d=b[1].substring(0,3),e=/\d+/.test(c),f="ago"===b[2],h=("last"===c?-1:1)*(f?-1:1);if(e&&(h*=parseInt(c,10)),i.hasOwnProperty(d)&&!b[1].match(/^mon(day|\.)?$/i))return g["set"+i[d]](g["get"+i[d]]()+h);if("wee"===d)return g.setDate(g.getDate()+7*h);if("next"===c||"last"===c)o(c,d,h);else if(!e)return!1;return!0}var c,d,e,f,g,h,i,j,k,l,m,n=!1;if(!a)return n;if(a=a.replace(/^\s+|\s+$/g,"").replace(/\s{2,}/g," ").replace(/[\t\r\n]/g,"").toLowerCase(),d=a.match(/^(\d{1,4})([\-\.\/\:])(\d{1,2})([\-\.\/\:])(\d{1,4})(?:\s(\d{1,2}):(\d{2})?:?(\d{2})?)?(?:\s([A-Z]+)?)?$/),d&&d[2]===d[4])if(d[1]>1901)switch(d[2]){case"-":return d[3]>12||d[5]>31?n:new Date(d[1],parseInt(d[3],10)-1,d[5],d[6]||0,d[7]||0,d[8]||0,d[9]||0)/1e3;case".":return n;case"/":return d[3]>12||d[5]>31?n:new Date(d[1],parseInt(d[3],10)-1,d[5],d[6]||0,d[7]||0,d[8]||0,d[9]||0)/1e3}else if(d[5]>1901)switch(d[2]){case"-":return d[3]>12||d[1]>31?n:new Date(d[5],parseInt(d[3],10)-1,d[1],d[6]||0,d[7]||0,d[8]||0,d[9]||0)/1e3;case".":return d[3]>12||d[1]>31?n:new Date(d[5],parseInt(d[3],10)-1,d[1],d[6]||0,d[7]||0,d[8]||0,d[9]||0)/1e3;case"/":return d[1]>12||d[3]>31?n:new Date(d[5],parseInt(d[1],10)-1,d[3],d[6]||0,d[7]||0,d[8]||0,d[9]||0)/1e3}else switch(d[2]){case"-":return d[3]>12||d[5]>31||d[1]<70&&d[1]>38?n:(f=d[1]>=0&&d[1]<=38?+d[1]+2e3:d[1],new Date(f,parseInt(d[3],10)-1,d[5],d[6]||0,d[7]||0,d[8]||0,d[9]||0)/1e3);case".":return d[5]>=70?d[3]>12||d[1]>31?n:new Date(d[5],parseInt(d[3],10)-1,d[1],d[6]||0,d[7]||0,d[8]||0,d[9]||0)/1e3:d[5]<60&&!d[6]?d[1]>23||d[3]>59?n:(e=new Date,new Date(e.getFullYear(),e.getMonth(),e.getDate(),d[1]||0,d[3]||0,d[5]||0,d[9]||0)/1e3):n;case"/":return d[1]>12||d[3]>31||d[5]<70&&d[5]>38?n:(f=d[5]>=0&&d[5]<=38?+d[5]+2e3:d[5],new Date(f,parseInt(d[1],10)-1,d[3],d[6]||0,d[7]||0,d[8]||0,d[9]||0)/1e3);case":":return d[1]>23||d[3]>59||d[5]>59?n:(e=new Date,new Date(e.getFullYear(),e.getMonth(),e.getDate(),d[1]||0,d[3]||0,d[5]||0)/1e3)}if("now"===a)return null===b||isNaN(b)?0|(new Date).getTime()/1e3:0|b;if(!isNaN(c=Date.parse(a)))return 0|c/1e3;if(g=b?new Date(1e3*b):new Date,h={sun:0,mon:1,tue:2,wed:3,thu:4,fri:5,sat:6},i={yea:"FullYear",mon:"Month",day:"Date",hou:"Hours",min:"Minutes",sec:"Seconds"},k="(years?|months?|weeks?|days?|hours?|minutes?|min|seconds?|sec|sunday|sun\\.?|monday|mon\\.?|tuesday|tue\\.?|wednesday|wed\\.?|thursday|thu\\.?|friday|fri\\.?|saturday|sat\\.?)",l="([+-]?\\d+\\s"+k+"|"+"(last|next)\\s"+k+")(\\sago)?",d=a.match(new RegExp(l,"gi")),!d)return n;for(m=0,j=d.length;j>m;m++)if(!p(d[m]))return n;return g.getTime()/1e3};



/*根据出生日期算出年龄*/
function jsGetAge(strBirthday){       
    var returnAge;
    var strBirthdayArr=strBirthday.split("-");
    var birthYear = strBirthdayArr[0];
    var birthMonth = strBirthdayArr[1];
    var birthDay = strBirthdayArr[2];
    
    d = new Date();
    var nowYear = d.getFullYear();
    var nowMonth = d.getMonth() + 1;
    var nowDay = d.getDate();
    
    if(nowYear == birthYear){
        returnAge = 0;//同年 则为0岁
    }
    else{
        var ageDiff = nowYear - birthYear ; //年之差
        if(ageDiff > 0){
            if(nowMonth == birthMonth) {
                var dayDiff = nowDay - birthDay;//日之差
                if(dayDiff < 0)
                {
                    returnAge = ageDiff - 1;
                }
                else
                {
                    returnAge = ageDiff ;
                }
            }
            else
            {
                var monthDiff = nowMonth - birthMonth;//月之差
                if(monthDiff < 0)
                {
                    returnAge = ageDiff - 1;
                }
                else
                {
                    returnAge = ageDiff ;
                }
            }
        }
        else
        {
            returnAge = -1;//返回-1 表示出生日期输入错误 晚于今天
        }
    }
    
    return returnAge;//返回周岁年龄
    
}