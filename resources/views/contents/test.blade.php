@extends('type1')
@section('title')
    테스트
@endsection
@section('content')
    @foreach($ad_group as $item)
        title : {{$item->title}} <br/>
        create_t : {{$item->create_date}} <br/>
        del_t : {{$item->del_date}} <br/>
    @endforeach
@endsection
