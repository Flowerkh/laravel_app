function check_login() {
    if (!$('input[name=email]').val()) {
        alert('아이디를 입력해주세요.');
        $('input[name=email]').focus();
        return;
    }
    if (!$('input[name=user_pw]').val()) {
        alert('비밀번호를 입력해주세요.');
        $('input[name=user_pw]').focus();
        return;
    }

    $.ajax({
        type :'post',
        url:'/login',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        dataType : 'json',
        data: $.param({
            email: $('input[name=email]').val(),
            password: $('input[name=user_pw]').val()
        }),
        success : function (data) {
            if (data.result == 'ok') {
                alert(data.message);
                location.href="/main";
            } else {
                alert(data.message);
                removeLoding();
            }
        },beforeSend:function(){
            LoadingWithMask();
        },error: function(request,status,error) {
            console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
        }
    })
}

$(function() {
    $('#btn_login').on("click", function() {
        check_login();
    });
});
