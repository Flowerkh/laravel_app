function checkLogin() {
    if (!$('input[name=email]').val()) {
        alert('아이디를 입력해주세요.');
        $('input[name=email]').focus();
        return false;
    }
    if( !isValidEmailAddress($('input[name=email]').val()) ) {
        alert('이메일 형식이 아닙니다');
        return false;
    }
    if (!$('input[name=user_pw]').val()) {
        alert('비밀번호를 입력해주세요.');
        $('input[name=user_pw]').focus();
        return false;
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

function isValidEmailAddress(emailAddress) {
    var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    return pattern.test(emailAddress);
}

$(function() {
    $('#btn_login').on("click", function() {
        checkLogin();
    });
});
