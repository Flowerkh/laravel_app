function userInfo(u_idx) {
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
                '<span class="text btn btn-primary">'+data.user_info.team+'</span>' +
                '<span class="text btn btn-primary">'+data.user_info.email+'</span>'
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
