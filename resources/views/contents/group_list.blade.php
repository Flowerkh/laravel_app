@extends('type1')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-1 text-gray-800">그룹 권한부여</h1>
        <div class="py-3">
            <a href="/group_auth" class="btn btn-primary btn-icon-split ">
                <span class="text">그룹 추가하기</span>
            </a>
        </div>
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">그룹 리스트</h6>
            </div>
            <div class="card-body">
                @foreach($group_list as $item)
                    <div class="card-header py-4">
                        <a href="/group_auth/{{$item->g_idx}}" class="btn btn-dark w-25">
                            <span class="text">{{$item->title}}</span>
                        </a>
                        <a class="btn btn-outline-primary" data-toggle="modal" data-target="#add_id_list" onclick="find_list({{$item->g_idx}});">ID추가</a>
                        <a href="#;" class="btn btn-outline-danger" onclick="group_del({{$item->g_idx}},this)">삭제</a>
                        <a href="#;" class="btn btn-outline-success" onclick="group_copy({{$item->g_idx}},'{{$item->title}}','ts1')">복사</a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@include('modal.add_id_list')
<script type="text/javascript" src="/js/group_script.js"></script>
<script type="text/javascript" src="/js/loading_script.js"></script>
