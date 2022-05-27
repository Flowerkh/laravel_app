<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true" xmlns="http://www.w3.org/1999/html">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">로그아웃</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">정말로 로그아웃을 진행하시겠습니까?</div>
            <div class="modal-footer">
                <form method="POST" action="{{route('logout')}}">
                    @csrf
                    <button type="submit" class="btn btn-primary">로그아웃</button>
                </form>
                <button class="btn btn-secondary" type="button" data-dismiss="modal">취소</button>
            </div>
        </div>
    </div>
</div>
