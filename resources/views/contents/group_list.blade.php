@extends('type1')

@section('content')
    <div class="container-fluid">
        <div class="py-3">
            <a href="/group/auth" class="btn btn-primary btn-icon-split ">
                <span class="text">그룹 추가하기</span>
            </a>
        </div>
        <div class="card shadow">
            <div class="card-header py-3">
                <h3 class="m-0 font-weight-bold text-primary">그룹 리스트</h3>
            </div>
            <div class="card-body">
                @foreach($group_list as $item)
                    <div class="card-header py-4">
                        @if(session()->get('team')=='ts1')<span class="text btn btn-info disabled" style="width: 10%;">{{$item->team}}</span>@endif
                        <a href="/group/auth/{{$item->g_idx}}" class="btn btn-dark" style="width:25%;">
                            <span class="text">{{$item->title}}</span>
                        </a>
                        <a class="btn btn-outline-primary" data-toggle="modal" data-target="#add_id_list" onclick="findList({{$item->g_idx}});">ID추가</a>
                        <a href="#;" class="btn btn-outline-danger" onclick="groupDel({{$item->g_idx}},this)">삭제</a>
                        <a href="#;" class="btn btn-outline-success" onclick="groupCopy({{$item->g_idx}},'{{$item->title}}')">복사</a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@include('modal.add_id_list')
<script type="text/javascript" src="/js/group_script.js"></script>
<script type="text/javascript" src="/js/loading_script.js"></script>
