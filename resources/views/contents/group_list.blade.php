@extends('type1')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-1 text-gray-800">그룹 권한부여</h1>
        <div class="py-3">
            <a href="#" class="btn btn-primary btn-icon-split ">
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
                        <a href="#;" id="{{$item->g_idx}}" class="btn btn-success">
                            <span class="text">{{$item->title}}</span>
                        </a>
                        <a class="btn btn-primary" data-toggle="modal" data-target="#add_id_list" onclick="add_id({{$item->g_idx}});">ID추가</a>
                        삭제
                        복사
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@include('modal.add_id_list')
