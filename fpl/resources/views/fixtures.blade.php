@extends('layouts.app')

@section('title', 'Page Title')

@section('content')
    <table class="table table-sm table-striped table-bordered">
        @foreach($fixtures as $fixture)
        <tr class="row">
            <td class="col-3">{{ $fixture->fixture_date }}</td>
            <td class="col-1">{{ $fixture->fixture_time }}</td>
            <td class="col text-right"><a href="/team/{{ $fixture->team_h }}">{{ $fixture->home_team->name }}</a></td>
            <td class="col-1">{{ $fixture->team_h_score }}</td>
            <td class="col-1">{{ $fixture->team_a_score }}</td>
            <td class="col"><a href="/team/{{ $fixture->team_a }}">{{ $fixture->away_team->name }}</a></td>
        </tr>
        @endforeach
    </table>
@endsection