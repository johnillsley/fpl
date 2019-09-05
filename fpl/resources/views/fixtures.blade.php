@extends('layouts.app')

@section('title', 'Page Title')

@section('content')
    <table class="table table-sm table-striped">
        <tbody>
        @foreach($fixtures as $fixture)
        <tr class="row">
            <td class="col-sm-3">{{ $fixture->fixture_date }}</td>
            <td class="col-sm-1 text-right">{{ $fixture->fixture_time }}</td>
            <td class="col-sm-2 text-right"><a href="/team/{{ $fixture->team_h }}">{{ $fixture->home_team->name }}</a></td>
            <td class="col-sm-1 text-center">{{ $fixture->team_h_score }}</td>
            <td class="col-sm-1 text-center">{{ $fixture->team_a_score }}</td>
            <td class="col-sm-2"><a href="/team/{{ $fixture->team_a }}">{{ $fixture->away_team->name }}</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
@endsection