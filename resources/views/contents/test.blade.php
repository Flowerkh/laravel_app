@extends('type1')
@section('title')
    테스트
@endsection
@section('content')
    @foreach($td as $item)
        ID : {{$item->id}} <br/>
        VLAUE : {{$item->value}} <br/>
    @endforeach
@endsection
