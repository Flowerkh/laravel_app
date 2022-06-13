@extends('type1')
@section('content')
    <style>
        th{text-align: center;}
        .chk {text-align: center;}
    </style>
    <script type="text/javascript" src="/js/authAddpage_script.js"></script>
    <script type="text/javascript" src="/js/loading_script.js"></script>
    <div class="container-fluid">
        <h1 class="h3 mb-1 text-gray-800">그룹 추가하기</h1>
        <div class="card-header">
            @if(!empty($group_data))
                <input type="text" class="form-control w-25" aria-describedby="basic-addon2" id="group_title" value="{{$group_data->title}}"><a href="#;" class="btn btn-primary" id="dup_chk" onclick="">검사</a><span id="dupli_chk"></span>
            @else
                <input type="text" class="form-control w-25" placeholder="그룹명 입력..." aria-describedby="basic-addon2" id="group_title"><a href="#;" class="btn btn-primary" id="dup_chk" onclick="">검사</a><span id="dupli_chk"></span>
            @endif
            @if(session()->get('team')=='ts1')
                <select class="form-control w-25" name="team_o">
                    <option value="">팀 선택</option>
                    <option value="ts1" @if(session()->get('team')=='ts1') selected @endif>ts1</option>
                    <option value="ople" @if(session()->get('team')=='ople') selected @endif>ople</option>
                    <option value="jp" @if(session()->get('team')=='jp') selected @endif>jp</option>
                </select>
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
            {!! $tr_html !!}
            </tbody>
        </table>
        <div class="card-body">
            <div class="card-header py-4">
                @if(!empty($gp))
                    <a href="#;" class="btn btn-success" onclick="groupUpdate(this,{{$gp}})">수정</a>
                @else
                    <a href="#;" class="btn btn-primary" onclick="groupUpdate(this,0)">추가</a>
                @endif
                <a href="/group/" class="btn btn-secondary">목록</a>
            </div>
        </div>
    </div>
@endsection


