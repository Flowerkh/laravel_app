@extends('type1')
@section('content')
    <style>
        th{text-align: center;}
        .chk {text-align: center;}
    </style>
    <div class="container-fluid">
        <h1 class="h3 mb-1 text-gray-800">그룹 권한 추가하기</h1>
        <div class="card-header">
            <input type="text" class="form-control w-25" placeholder="그룹명 입력..." aria-describedby="basic-addon2" id="group_title">
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
                @if(Request::get('gp'))
                    <a href="#;" class="btn btn-success" onclick="group_update(this)">수정</a>
                @else
                    <a href="#;" class="btn btn-primary" onclick="group_add(this)">추가</a>
                @endif
                <a href="/group" class="btn btn-secondary">취소</a>
            </div>
        </div>

    </div>
@endsection
<script type="text/javascript">
    function group_update(obj) {
        let menu_chk = $(obj).parent().parent().parent().find('table>tbody>tr>td>input:checkbox:checked');
        console.log(menu_chk);
    }
    function group_add(obj) {
        let menu_chk = $(obj).parent().parent().parent().find('table>tbody>tr>td>input:checkbox:checked');
        let newMenu = [];
        let currentNum = 0;

        if(menu_chk.length==0){
            alert('권한 설정을 해주세요.');
            return false;
        }

        menu_chk.each(function (el, iVal) {
            var el_data = $(iVal).data('smenu');
            var el_val = $(iVal).val();

            if(currentNum != el_data) {
                currentNum = el_data;
                newMenu[currentNum] = [Number(el_val)];
            } else {
                newMenu[currentNum].push(Number(el_val));
            }
        });
        group_insert(newMenu);
    }

    function group_insert(insert_value) {
        let group_title = $('#group_title').val();
        if(!group_title){
            alert('그룹명을 입력해주세요.');
            $('#group_title').focus();
            return false;
        }

        $.ajax({
            url:'/group_insert',
            type:'put',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            dataType: 'json',
            data:{res:insert_value,title:group_title,team:'ts1'},
            success: function (data) {
                alert(data.msg);
                if(data.result=='ok'){
                    location.href='/group';
                } else {
                    removeLoding();
                }
            },beforeSend:function(){
                LoadingWithMask();
            },
        });
    }
</script>
<script type="text/javascript" src="/js/loading_script.js"></script>
