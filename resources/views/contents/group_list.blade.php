@extends('type1')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-1 text-gray-800">그룹 권한부여</h1>

        <a href="#" class="btn btn-primary btn-icon-split">
            <span class="text">권한 수정하기</span>
        </a>
        <a href="#" class="btn btn-success btn-icon-split">
            <span class="text">권한 부여하기</span>
        </a>
        <div></div>
        <div></div>
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">그룹 리스트</h6>
            </div>
            <div class="card-body">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="radio" id="a1" value="" checked><label class="form-check-label" for="a1">group_1</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="radio" id="a2" value=""><label class="form-check-label" for="a2">group_2</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="radio" id="a3" value=""><label class="form-check-label" for="a3">group_2</label>
                </div>
            </div>
        </div>
    </div>

@endsection
