@extends('type1')
@section('title')
    테스트
@endsection
@section('content')
    @foreach($ad_group as $item)
        title : {{$item->id}} <br/>
        create_t : {{$item->value}} <br/>
    @endforeach
@endsection


