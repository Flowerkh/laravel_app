@extends('type1')
@section('content')
    <style>
        th{text-align: center;}
        .chk {text-align: center;}
    </style>
    <script type="text/javascript" src="/js/authAddpage_script.js"></script>
    <script type="text/javascript" src="/js/loading_script.js"></script>
    <div class="container-fluid">
        <h1 class="h3 mb-1 text-gray-800">그룹 권한 추가하기</h1>
        <div class="card-header">
            @if(!empty($group_data))
                <input type="text" class="form-control w-25" aria-describedby="basic-addon2" id="group_title" value="{{$group_data->title}}"><span id="dupli_chk"> </span>
            @else
                <input type="text" class="form-control w-25" placeholder="그룹명 입력..." aria-describedby="basic-addon2" id="group_title"><span id="dupli_chk"> </span>
            @endif

        </div>
        <table class="table">
            <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col">읽기</th>
                <th scope="col">쓰기</th>
                <th scope="col">수정</th>
                <th scope="col">삭제</th>
                <th scope="col">업로드</th>
                <th scope="col">다운로드</th>
            </tr>
            </thead>
            <tbody>
            {!! $menu_list !!}
            </tbody>
        </table>
        <div class="card-body">
            <div class="card-header py-4">
                @if(!empty($gp))
                    <a href="#;" class="btn btn-success" onclick="group_update(this,{{$gp}})">수정</a>
                @else
                    <a href="#;" class="btn btn-primary" onclick="group_update(this,0)">추가</a>
                @endif
                <a href="/group/group" class="btn btn-secondary">목록</a>
            </div>
        </div>
    </div>
@endsection


