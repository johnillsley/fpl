@extends('layouts.app')

@section('title', 'Page Title')

@section('content')
    <h1>Fixtures for {{$week->name}}</h1>
    @include('subviews.fixtures', ['fixtures' => $fixtures])
@endsection