@extends('type1')

@section('content')
    @if(!empty($auth['x'])) <button>삭제</button> @endif
    @if(!empty($auth['d'])) <button>다운로드</button> @endif
    @if(!empty($auth['u'])) <button>업로드</button> @endif
    @if(!empty($auth['w'])) <button>쓰기</button> @endif
@endsection
