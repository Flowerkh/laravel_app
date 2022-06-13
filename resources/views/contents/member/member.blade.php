@extends('type1')
@section('content')
    <div class="card shadow">
        <input type="hidden" id="u_idx" value=""/>
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">관리자 리스트</h3>
        </div>
        <div class="card-body">
            @foreach($user_list AS $data)
                <div class="card-header py-4">
                    <span class="text btn btn-info disabled" style="width: 10%;">{{$data->team}}</span>
                    <span class="text btn btn-dark" style="width:25%;" data-toggle="modal" data-target="#user_info" onclick="userInfo({{$data->u_idx}});">{{$data->email}}</span>
                </div>
            @endforeach
        </div>
    </div>
@endsection
@include('modal.userInfo')
<script type="text/javascript" src="/js/user_script.js"></script>
<script type="text/javascript" src="/js/loading_script.js"></script>
