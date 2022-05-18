<div class="modal fade" id="add_id_list" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" xmlns="http://www.w3.org/1999/html">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">그룹 리스트</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                <div class="input-group">
                    <input type="text" class="form-control bg-light border-1" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <button type="button" class="btn btn-primary">추가하기</button>
                </div>
            </form>
            <div class="modal-body">

                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">아이디</th>
                        <th scope="col">이름</th>
                        <th scope="col">팀</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody id="id_list">

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function add_id(idx) {
        $("#id_list").empty();
        $.ajax({
            type:'POST',
            url:'/group_list',
            headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            dataType : 'json',
            data: $.param({
                idx : idx
            }),
            success : function (data){
                data.result.forEach (function (el, i) {
                    $('#id_list').append(
                        '<tr>' +
                        '<th scope="row">'+el.email+'</th>' +
                        '<td>'+el.u_name+'</td><td>'+el.team+'</td>' +
                        '<td><span class="badge badge-danger" onclick="del('+el.ug_idx+')">X</span></td>' +
                        '</tr>')
                })
            },beforeSend:function(){
                $('#id_list').append("<img src='/img/loading.gif' id='loading_img' style='position: relative; display: block; margin: 0px auto;'/>");
            },complete: function() {
                $('#loading_img').remove();
            },error: function(request,status,error) {
                console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            }
        });
    }
    function del(ug_idx){
        console.log(ug_idx);
    }
</script>
