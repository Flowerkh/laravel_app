function userInfo(u_idx) {
    $('#user_info_modal').html('');
    var selec = '';
    $.ajax({
        type:'POST',
        url:'/member/info',
        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        dataType:'json',
        data:{u_idx:u_idx},
        success : function (data) {
            if(data.result=='fail') $('#id_list').html('<tr id="no_list"><td rowspan="3">그룹에 등록된 사원이 없습니다.</td></tr>');
            $('#u_idx').val(data.user_info.u_idx);
            $('#user_info_modal').html(
                '<select class="form-control w-25" name="team_o">\n' +
                '   <option value="">팀 선택</option>\n' +
                '   <option value="ts1" '+(data.user_info.team == "ts1" ? "selected" : "" )+'>ts1</option>\n' +
                '   <option value="ople" '+(data.user_info.team == "ople" ? "selected" : "" )+'>ople</option>\n' +
                '   <option value="jp" '+(data.user_info.team == "jp" ? "selected" : "" )+'>jp</option>\n' +
                '   <option value="ts2" '+(data.user_info.team == "ts2" ? "selected" : "" )+'>ts2</option>\n' +
                '</select>' +
                '<input type="text" className="form-control" name="u_name" value="'+data.user_info.email+'" readonly>' +
                '<input type="text" className="form-control" name="email" value="'+data.user_info.u_name+'">'
            );
            removeLoding();
        },beforeSend:function(){
            $('#user_info_modal').append("<img src='/img/loading.gif' id='loading_img' style='position: relative; display: block; margin: 0px auto;'/>");
        },complete: function() {
            $('#loading_img').remove();
        },error: function(request,status,error) {
            console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
        }
    });
}
