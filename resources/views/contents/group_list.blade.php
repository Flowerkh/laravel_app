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
                        <a href="#;" class="btn btn-danger" onclick="group_del({{$item->g_idx}})">삭제</a>
                        <a href="#;" class="btn btn-danger" onclick="group_copy({{$item->g_idx}})">복사</a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@include('modal.add_id_list')
<script type="text/javascript">
    function group_del(idx){
        if(confirm("해당 그룹을 삭제하시겠습니까?")) {
            location.href="/group_del/"+idx;
        }
    }
    function group_copy(idx){
        //ajax
        console.log(idx);
    }
</script>
