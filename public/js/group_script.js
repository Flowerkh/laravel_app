
function group_del(idx,obj) {
    if(confirm("해당 그룹을 삭제하시겠습니까?")) {
        $.ajax({
            url: '/group_del',
            type: 'delete',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            dataType: 'json',
            data: {idx: idx},
            success: function (data) {
                alert(data.msg);
                if(data.result){
                    $(obj).parent().remove();
                }
            }
        });
    }
}

function group_copy(idx) {
    //ajax
    console.log(idx);
    //if(confirm("해당 그룹을 복사하시겠습니까?")) {}
}

/** modal script */
function find_list(idx) {
    $("#id_list").empty();
    $("#add_id_input").val('');
    $("#group_idx").val(idx);
    $.ajax({
        type:'POST',
        url:'/group_list',
        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        dataType : 'json',
        data: $.param({
            idx : idx
        }),
        success : function (data){
            data.result.forEach (function (el, i) {
                $('#id_list').append(
                    '<tr>' +
                    '<th scope="row">'+el.email+'</th>' +
                    '<td>'+el.u_name+'</td><td>'+el.team+'</td>' +
                    '<td><span class="badge badge-danger" onclick="list_del('+el.ug_idx+',this)">X</span></td>' +
                    '</tr>')
            })
        },beforeSend:function(){
            $('#id_list').append("<img src='/img/loading.gif' id='loading_img' style='position: relative; display: block; margin: 0px auto;'/>");
        },complete: function() {
            $('#loading_img').remove();
        },error: function(request,status,error) {
            console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
        }
    });
}

function list_del(ug_idx,obj) {
    if(confirm("해당 그룹에서 제외하시겠습니까?")) {
        $.ajax({
            type:'delete',
            url:'/group_list_del',
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

function add_id() {
    var id = $('#add_id_input').val();
    $.ajax({
        type:'PUT',
        url:'/group_add_id',
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
                    '<td><span class="badge badge-danger" onclick="list_del('+data.user_data.ug_idx+',this)">X</span></td>' +
                    '</tr>');
            }
        }
    });
}
