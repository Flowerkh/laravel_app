<div class="modal fade" id="add_id_list" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" xmlns="http://www.w3.org/1999/html">
    <input type="hidden" id="group_idx" value=""/>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">그룹 리스트</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="input-group">
                <input type="text" class="form-control col-xs-2" id="add_id_input" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button type="button" class="btn btn-primary" onclick="addId()">추가하기</button>
                </div>
            </div>

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
                    <tbody id="id_list"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
