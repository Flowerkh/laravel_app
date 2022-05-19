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
function removeLoding() {
    $("#mask").remove();
    $("#loadingImg").remove();
}
function LoadingWithMask() {
    var maskHeight = $(document).height();
    var maskWidth  = window.document.body.clientWidth;
    var mask       ="<div id='mask' style='position:absolute; z-index:9000; background-color:#000000; display:none; left:0; top:0;'></div>";
    var loadingImg ='';

    loadingImg +="<div id='loadingImg'>";
    loadingImg +=" <img src='/img/loading.gif' style='position: relative; display: block; margin: 0px auto;'/>";
    loadingImg +="</div>";

    $('body').append(mask).append(loadingImg)

    $('#mask').css({'width' : maskWidth,'height': maskHeight,'opacity' :'0.3'});
    $('#mask').show();
    $('#loadingImg').show();
}

$(function() {
    $('#btn_login').on("click", function() {
        check_login();
    });
});
