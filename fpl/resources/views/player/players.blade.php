@extends('layouts.app')

@section('title', 'Page Title')

@section('content')
    <table id="dynamictable" class="table table-sm table-striped table-bordered" style="width:100%">
        <thead>
        <tr>
            <th class="th-1">Team</th>
            <th class="th-1">Position</th>
            <th class="th-2">Player</th>
            <th class="th-1">Price</th>
            <th class="th-1">% Own</th>
            <th class="th-1">Mins</th>
            <th class="th-1">Points</th>
            <th class="th-1">PPG</th>
            <th class="th-1">PP90</th>
        </tr>
        </thead>
        <tbody>
        @foreach($players as $player)
            @if ($player->transfer->status == 'a')
                @php ($status = '')
            @else
                @php ($status = 'table-danger')
            @endif
            <tr id="player-row-{{ $player->id }}">
                <td>{{ $player->team_short_name }}</td>
                <td>{{ $player->position }}</td>
                <td class="{{ $status  }}"><a href="/player/{{ $player->id }}">{{ $player->second_name }}</a><button class="float-right btn btn-outline-primary btn-sm">Add to watchlist</button></td>
                <td class="text-right">{{ $player->transfer->now_cost }}</td>
                <td class="text-right">{{ $player->transfer->selected_by_percent }}</td>
                <td class="text-right">{{ $player->minutes }}</td>
                <td class="text-right">{{ $player->total_points }}</td>
                <td class="text-right">{{ $player->points_per_game }}</td>
                <td class="text-right">{{ $player->points_per90_minutes }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

@section('extrajs')
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dynamictable').DataTable();
        } );
    </script>
@endsection