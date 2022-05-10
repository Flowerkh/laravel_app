@include('top')
<body class="bg-gradient-primary">

<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">GECL ADMIN</h1>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control form-control-user" id="user_id" name="user_id" aria-describedby="emailHelp" placeholder="아이디">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control form-control-user" id="user_pw" name="user_pw" placeholder="비밀번호">
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox small">
                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                <label class="custom-control-label" for="customCheck" style="text-align: center;">Remember Me</label>
                            </div>
                        </div>
                        <button type="button" id="btn_login" class="btn btn-primary btn-user btn-block">로그인</button>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="forgot-password.html">Forgot Password?</a>
                        </div>
                        <div class="text-center">
                            <a class="small" href="register.html">Create an Account!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function check_login() {
        if (!$('input[name=user_id]').val()) {
            alert('아이디를 입력해주세요.');
            $('input[name=user_id]').focus();
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
                id: $('input[name=user_id]').val(),
                password: $('input[name=user_pw]').val()
            }),
            success : function (data) {
                if (data.result == 'ok') {
                    location.href="/main";
                } else {
                    alert(data.message);
                }
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
</script>
@include('script.script1')
