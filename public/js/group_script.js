
function groupDel(idx,obj) {
    if(confirm("해당 그룹을 삭제하시겠습니까?")) {
        $.ajax({
            url: '/group/del',
            type: 'delete',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            dataType: 'json',
            data: {idx: idx},
            success: function (data) {
                alert(data.msg);
                if(data.result) {
                    removeLoding();
                    $(obj).parent().remove();
                } else {
                    removeLoding();
                }
            },beforeSend:function(){
                LoadingWithMask();
            },error: function(request,status,error) {
                console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            }
        });
    }
}

function groupCopy(idx,title) {
    if(confirm("해당 그룹을 복사하시겠습니까?")) {
        $.ajax({
            type:'POST',
            url:'/group/copy',
            headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            dataType : 'json',
            data: {
                idx:idx,
                title:title
            },
            success : function (data) {
                if(data.result=='ok') {
                    $('.card-body').append('<div class="card-header py-4">\n' +
                        '                        <a href="/group/auth/'+data.data.g_idx+'" class="btn btn-dark w-25">\n' +
                        '                            <span class="text">'+data.data.title+'</span>\n' +
                        '                        </a>\n' +
                        '                        <a class="btn btn-outline-primary" data-toggle="modal" data-target="#add_id_list" onclick="findList('+data.data.g_idx+');">ID추가</a>\n' +
                        '                        <a href="#;" class="btn btn-outline-danger" onclick="groupDel('+data.data.g_idx+',this)">삭제</a>\n' +
                        '                        <a href="#;" class="btn btn-outline-success" onclick="groupCopy('+data.data.g_idx+',\''+data.data.title+'\',\''+data.data.team+'\')">복사</a>\n' +
                        '                    </div>');
                    removeLoding();
                } else {
                    removeLoding();
                }
            },beforeSend:function(){
                LoadingWithMask();
            },error: function(request,status,error) {
                console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            }
        });
    }
}

/** modal script */
function findList(idx) {
    $("#id_list").empty();
    $("#add_id_input").val('');
    $("#group_idx").val(idx);
    $.ajax({
        type:'POST',
        url:'/group/member/list',
        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        dataType : 'json',
        data: {idx : idx},
        success : function (data){
            if(data.result=='') $('#id_list').append('<tr id="no_list"><td rowspan="3">그룹에 등록된 사원이 없습니다.</td></tr>');
            data.result.forEach (function (el, i) {
                $('#id_list').append(
                    '<tr>' +
                    '<th scope="row">'+el.email+'</th>' +
                    '<td>'+el.u_name+'</td><td>'+el.team+'</td>' +
                    '<td><span class="badge badge-danger" onclick="listDel('+el.ug_idx+',this)">X</span></td>' +
                    '</tr>')
            })
            removeLoding();
        },beforeSend:function(){
            $('#id_list').append("<img src='/img/loading.gif' id='loading_img' style='position: relative; display: block; margin: 0px auto;'/>");
        },complete: function() {
            $('#loading_img').remove();
        },error: function(request,status,error) {
            console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
        }
    });
}

function listDel(ug_idx,obj) {
    if(confirm("해당 그룹에서 제외하시겠습니까?")) {
        $.ajax({
            type:'delete',
            url:'/group/member/del',
            headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            dataType : 'json',
            data: $.param({
                ug_idx : ug_idx
            }),
            success : function (data) {
                if(data.result){
                    $(obj).parent().parent().remove();
                } else {
                    alert('제거에 실패하였습니다.');
                }
            }
        });
    }
}

function addId() {
    var id = $('#add_id_input').val();
    $.ajax({
        type:'PUT',
        url:'/group/member/insert',
        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        dataType : 'json',
        data: {
            id : id,
            g_idx : $("#group_idx").val()
        },
        success : function (data) {
            alert(data.msg);
            if(data.result=='ok') {
                $('#id_list').append(
                    '<tr>' +
                    '<th scope="row">'+data.user_data[0].email+'</th>' +
                    '<td>'+data.user_data[0].u_name+'</td><td>'+data.user_data[0].team+'</td>' +
                    '<td><span class="badge badge-danger" onclick="listDel('+data.user_data.ug_idx+',this)">X</span></td>' +
                    '</tr>');
            }
            $('#no_list').remove()
        }
    });
}
