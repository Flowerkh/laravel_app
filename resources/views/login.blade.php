@include('top')
@if(Auth::check())
    <script>location.href="/main";</script>
@endif
<body class="bg-gradient-primary">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">GECL ADMIN</h1>
                        </div>

                        <div class="form-group">
                            <input type="email" class="form-control form-control-user" id="email" name="email" aria-describedby="emailHelp" placeholder="아이디">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control form-control-user" id="user_pw" name="user_pw" placeholder="비밀번호">
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox small">
                                <input type="checkbox" class="custom-control-input" id="customCheck">
{{--                                <label class="custom-control-label" for="customCheck" style="text-align: center;">Remember Me</label>--}}
                            </div>
                        </div>
                        <button type="button" id="btn_login" class="btn btn-primary btn-user btn-block">로그인</button>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="forgot-password.html">비밀번호 찾기</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="/js/login_script.js"></script>
<script type="text/javascript" src="/js/loading_script.js"></script>
@include('script.script1')
