@extends('layouts.app')

@section('title', 'Page Title')

@section('content')
    <table class="table table-sm table-striped">
        <caption>Matches</caption>
        <tbody>
        @foreach($fixtures as $fixture)
            @php
                if ($fixture->team_h == $team) {
                    $opponent = $fixture->away_team->name . ' (h)';
                    $difficulty = $fixture->team_h_difficulty;
                } else {
                    $opponent = $fixture->home_team->name . ' (a)';
                    $difficulty = $fixture->team_a_difficulty;
                }
                $result = ($fixture->finished == 1) ? $fixture->team_h_score . ' - ' . $fixture->team_a_score : '';
            @endphp
            <tr>
                <th class="text-right" scope="row">{{ $fixture->week->id }}</th>
                <td>{{ $fixture->fixture_date }} ({{ $fixture->fixture_time }})</td>
                <td>{{ $opponent }}</td>
                <td>{{ $difficulty }}</td>
                <td>{{ $result }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection