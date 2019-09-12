@extends('layouts.app')

@section('title', 'Page Title')

@section('content')
    <table id="dynamictable" class="table table-sm table-striped table-bordered" style="width:100%">
        <caption>List of players</caption>
        <thead>
        <tr>
            <th scope="col">Team</th>
            <th scope="col">Position</th>
            <th scope="col">Player</th>
            <th scope="col">Price</th>
            <th scope="col">% Own</th>
            <th scope="col">Mins</th>
            <th scope="col">Points</th>
            <th scope="col">PPG</th>
            <th scope="col">PP90</th>
            <th scope="col">BPS</th>
        </tr>
        </thead>
        <tbody>
        @foreach($players as $player)
            @if ($player->transfer->status == 'a')
                @php ($status = '')
            @else
                @php ($status = 'table-danger')
            @endif
            <tr id="playerid-{{ $player->id }}">
                <td><a href="/team/{{ $player->team }}">{{ $player->club->short_name }}</a></td>
                <td><a href="/position/{{ $player->element_type }}">{{ $player->position }}</a></td>
                <td class="{{ $status  }}"><a href="/player/{{ $player->id }}">{{ $player->second_name }}</a>
                    <?php
                        $button_style = ($player->watchlist) ? 'btn-success' : 'btn-outline-primary';
                        echo Form::button('Watchlist',[
                        'player' => $player->id ,
                        'class'=>'btn ' . $button_style . ' btn-sm float-right watchlist-btn'
                        ])  
                    ?>
                </td>
                <td class="text-right">{{ $player->transfer->now_cost }}</td>
                <td class="text-right">{{ $player->transfer->selected_by_percent }}</td>
                <td class="text-right">{{ $player->minutes }}</td>
                <td class="text-right">{{ $player->total_points }}</td>
                <td class="text-right">{{ $player->points_per_game }}</td>
                <td class="text-right">{{ $player->points_per90_minutes }}</td>
                <td class="text-right">{{ $player->bps }}</td>
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
            $('#dynamictable').DataTable({
                "order": [6, 'DESC'],
                "stateSave": true
            });
            $(".watchlist-btn").click(function() {
                var playerId = $(this).attr("player");
                $.ajax({
                    type:'POST',
                    url:'/watchlist/' + playerId,
                    data: {"_token": "{{ csrf_token() }}",},
                    success:function(data){
                        var todo = jQuery.parseJSON(data);
                        if (todo.inwatchlist) {
                            $("button[player=" + todo.player + "]").removeClass("btn-outline-primary").addClass("btn-success");
                        } else {
                            $("button[player=" + todo.player + "]").removeClass("btn-success").addClass("btn-outline-primary");
                        }
                    }
                });
            })
        } );
    </script>
@endsection