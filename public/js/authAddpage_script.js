function menu_ChekedList(menu_chk){
    let newMenu = [];
    let currentNum = 0;

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

    return newMenu;
}

function groupUpdate(obj,gp) {
    let menu_chk = $(obj).parent().parent().parent().find('table>tbody>tr>td>input:checkbox:checked');
    var newMenu = '';
    var title = $('#group_title').val();

    if(!title){
        alert('그룹명을 입력해주세요.');
        $('#group_title').focus();
        return false;
    }

    if(menu_chk.length==0){
        alert('권한 설정을 해주세요.');
        return false;
    }
    newMenu = menu_ChekedList(menu_chk);
    if(confirm("해당 작업을 진행하겠습니까?")) {
        if (gp > 0) {
            groupModify(newMenu, title, gp);
        } else {
            groupInsert(newMenu, title);
        }
    }
}

function groupInsert(insert_value,title,team) {
    var team_o = $("select[name=team_o]").val();
    if($("select[name=team_o]").val()=='') team_o = '';

    $.ajax({
        url:'/group/insert',
        type:'put',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        dataType: 'json',
        data:{res:insert_value,title:title,team:team,team_o:team_o},
        success: function (data) {
            alert(data.msg);
            if(data.result=='ok'){
                location.href='/group';
            } else {
                removeLoding();
            }
        },beforeSend:function(){
            LoadingWithMask();
        }
    });
}

function groupModify(update_value,title,gp) {
    var team_o = $("select[name=team_o]").val();
    if($("select[name=team_o]").val()=='') team_o = '';

    $.ajax({
        url:'/group/modify',
        type:'put',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        dataType: 'json',
        data:{res:update_value,title:title,gp:gp,team_o:team_o},
        success: function (data) {
            alert(data.msg);
            if(data.result=='ok'){
                location.href='/group/auth/'+gp;
            } else {
                removeLoding();
            }
        },beforeSend:function(){
            LoadingWithMask();
        }
    });
}

$(function(){
    $('#dup_chk').on("click",function() {
        $.ajax({
            url:'/group/duplicate',
            type:'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            dataType: 'json',
            data:{title:$('#group_title').val()},
            success: function (data) {
                if(data.result=='ok'){
                    $('#dupli_chk').html('사용가능한 타이틀 명');
                    $('#dupli_chk').attr('style', 'color:#199894b3');
                } else if(data.result=='trim'){
                    $('#dupli_chk').html('제목을 입력해주세요');
                    $('#dupli_chk').attr('style', 'color:#f82a2aa3');
                } else {
                    $('#dupli_chk').html('중복된 타이틀 명');
                    $('#dupli_chk').attr('style', 'color:#f82a2aa3');
                }
            }
        });
    });
});
