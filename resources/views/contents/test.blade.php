@extends('type1')
@section('title')
    테스트
@endsection
@section('content')
    @foreach($ad_group as $item)
        title : {{$item->email}} <br/>
        create_t : {{$item->u_name}} <br/>
    @endforeach
@endsection


