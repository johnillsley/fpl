@extends('layouts.app')

@section('title', 'Page Title')

@section('content')
    <table class="table table-sm table-striped">
        <caption>League table</caption>
        <thead>
            <tr>
                <th scope="col" class="text-right">Pos</th>
                <th scope="col">Team</th>
                <th scope="col" class="text-right">Played</th>
                <th scope="col" class="text-right table-success">H W</th>
                <th scope="col" class="text-right table-success">H D</th>
                <th scope="col" class="text-right table-success">H L</th>
                <th scope="col" class="text-right table-success">H F</th>
                <th scope="col" class="text-right table-success">H A</th>
                <th scope="col" class="text-right table-warning">A W</th>
                <th scope="col" class="text-right table-warning">A D</th>
                <th scope="col" class="text-right table-warning">A L</th>
                <th scope="col" class="text-right table-warning">A F</th>
                <th scope="col" class="text-right table-warning">A A</th>
                <th scope="col" class="text-right">GD</th>
                <th scope="col" class="text-right">Points</th>
            </tr>
        </thead>
        <tbody>
        @php
            $position = 1;
        @endphp
        @foreach($teams as $team)
            <tr>
                <th class="text-right" scope="row">{{ $position }}</th>
                <td><a href="/team/{{ $team->id }}">{{ $team->name }}</a></td>
                <td class="text-right">{{ $team->mp }}</td>
                <td class="text-right table-success">{{ $team->hw }}</td>
                <td class="text-right table-success">{{ $team->hd }}</td>
                <td class="text-right table-success">{{ $team->hl }}</td>
                <td class="text-right table-success">{{ $team->hgf }}</td>
                <td class="text-right table-success">{{ $team->hga }}</td>
                <td class="text-right table-warning">{{ $team->aw }}</td>
                <td class="text-right table-warning">{{ $team->ad }}</td>
                <td class="text-right table-warning">{{ $team->al }}</td>
                <td class="text-right table-warning">{{ $team->agf }}</td>
                <td class="text-right table-warning">{{ $team->aga }}</td>
                <td class="text-right">{{ $team->gd }}</td>
                <td class="text-right">{{ $team->points }}</td>
            </tr>
        @php
            $position++;
        @endphp
        @endforeach
        </tbody>
    </table>
@endsection