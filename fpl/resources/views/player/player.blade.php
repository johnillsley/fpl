@extends('layouts.app')

@section('title', 'Page Title')

@section('content')
    <dl class="row">
        @foreach($player->getAttributes() as $name => $value)
            <dt class="col-sm-3">{{ $name }}</dt>
            <dd class="col-sm-9">{{ $player->$name }}</dd>
        @endforeach
    </dl>
@endsection