@extends('layouts.app')

@section('title', 'Page Title')

@section('content')
    <div class="club_badge"><img src="https://fantasy.premierleague.com/dist/img/badges/badge_{{$player->club->code  }}_80.png" /></div>
    <h1>{{ $player->first_name . ' ' . $player->second_name }}</h1>
    <h2> {{ $player->club->name }} ({{ $player->position }})</h2>

    <div name="overall">
        <div class="player_image"><img src="https://platform-static-files.s3.amazonaws.com/premierleague/photos/players/110x140/p{{ $player->code }}.png" /></div>
        <div id="player_overall">
        <h4>Overall</h4>
        <dl class="row">
            <dt class="col-sm-3">Price</dt>
            <dd class="col-sm-3">£{{ $player->transfer->now_cost }}</dd>
            <dt class="col-sm-3">Overall points</dt>
            <dd class="col-sm-3">{{ $player->total_points }} <span class="ranking">{{ $player->ranking("total_points") }}</span></dd>
            <dt class="col-sm-3">Status</dt>
            <dd class="col-sm-3">{{ $player->transfer->status }}</dd>
            <dt class="col-sm-3">Minutes played</dt>
            <dd class="col-sm-3">{{ $player->minutes }}</dd>
            <dt class="col-sm-3">Form</dt>
            <dd class="col-sm-3">{{ $player->form }} <span class="ranking">{{ $player->ranking("form") }}</span></dd>
            <dt class="col-sm-3">Points per game</dt>
            <dd class="col-sm-3">{{ $player->points_per_game }} <span class="ranking">{{ $player->ranking("points_per_game") }}</span></dd>
            <dt class="col-sm-3">Points per 90 minutes</dt>
            <dd class="col-sm-3">{{ $player->points_per90_minutes }}</dd>
            <dt class="col-sm-3">Points this week</dt>
            <dd class="col-sm-3">{{ $player->event_points }} <span class="ranking">{{ $player->ranking("event_points") }}</span></dd>
            <dt class="col-sm-3">Last updated</dt>
            <dd class="col-sm-3">{{ date("F j, g:i a", strtotime($player->updated_at)) }}</dd>
        </dl>
    </div>

    <div id="player_stats">
    <h4>Stats</h4>
        <dl class="row">
            <dt class="col-sm-3">Goals scored</dt>
            <dd class="col-sm-3">{{ $player->goals_scored }}</dd>
            <dt class="col-sm-3">Assists</dt>
            <dd class="col-sm-3">{{ $player->assists }}</dd>
            <dt class="col-sm-3">Clean sheets</dt>
            <dd class="col-sm-3">{{ $player->clean_sheets }}</dd>
            <dt class="col-sm-3">Goals conceded</dt>
            <dd class="col-sm-3">{{ $player->goals_conceded }}</dd>
            <dt class="col-sm-3">Own goals</dt>
            <dd class="col-sm-3">{{ $player->own_goals }}</dd>
            <dt class="col-sm-3">Penalties saved</dt>
            <dd class="col-sm-3">{{ $player->penalties_saved }} / {{ $player->penalties_saved + $player->penalties_missed }}</dd>
            <dt class="col-sm-3">Cards</dt>
            <dd class="col-sm-3"><span class="text-danger">&FilledSmallSquare;</span>{{ $player->red_cards }}
                <span class="text-warning">&FilledSmallSquare;</span>{{ $player->yellow_cards }}</dd>
            <dt class="col-sm-3">Bonus points</dt>
            <dd class="col-sm-3">{{ $player->bonus }} <span class="ranking">{{ $player->ranking("bonus") }}</span></dd>
            <dt class="col-sm-3">Bonus point system</dt>
            <dd class="col-sm-3">{{ $player->bps }} <span class="ranking">{{ $player->ranking("bps") }}</span></dd>
            <dt class="col-sm-3">Influence</dt>
            <dd class="col-sm-3">{{ $player->influence }} <span class="ranking">{{ $player->ranking("influence") }}</span></dd>
            <dt class="col-sm-3">Creativity</dt>
            <dd class="col-sm-3">{{ $player->creativity }} <span class="ranking">{{ $player->ranking("creativity") }}</span></dd>
            <dt class="col-sm-3">Threat</dt>
            <dd class="col-sm-3">{{ $player->threat }} <span class="ranking">{{ $player->ranking("threat") }}</span></dd>
            <dt class="col-sm-3">ICT Index</dt>
            <dd class="col-sm-3">{{ $player->ict_index }} <span class="ranking">{{ $player->ranking("ict_index") }}</span></dd>
        </dl>
        <div id="performance_chart_div"></div>
    </div>

    <div id="player_transfers">
    <h4>Transfers</h4>
        <dl class="row">
            <dt class="col-sm-3">Total transfers in</dt>
            <dd class="col-sm-3">{{ $player->transfer->transfers_in }}</dd>
            <dt class="col-sm-3">Transfers in this game week</dt>
            <dd class="col-sm-3">{{ $player->transfer->transfers_in_event }}</dd>
            <dt class="col-sm-3">Total transfers out</dt>
            <dd class="col-sm-3">{{ $player->transfer->transfers_out }}</dd>
            <dt class="col-sm-3">Transfers out this game week</dt>
            <dd class="col-sm-3">{{ $player->transfer->transfers_out_event }}</dd>
            <dt class="col-sm-3">Total net transfers in</dt>
            <dd class="col-sm-3">{{ $player->transfer->transfers_in - $player->transfer->transfers_out }}</dd>
            <dt class="col-sm-3">Net transfers in this week</dt>
            <dd class="col-sm-3">{{ $player->transfer->transfers_in_event - $player->transfer->transfers_out_event }}</dd>
            <dt class="col-sm-3">Net transfers in this week</dt>
            <dd class="col-sm-3">{{ $player->transfer->transfers_in_event - $player->transfer->transfers_out_event }}</dd>
            <dt class="col-sm-3">Selected by</dt>
            <dd class="col-sm-3">{{ $player->transfer->selected_by_percent }}%</dd>
            <dt class="col-sm-3">Last updated</dt>
            <dd class="col-sm-3">{{ date("F j, g:i a", strtotime($player->transfer->updated_at)) }}</dd>
        </dl>
        <div id="transfers_chart_div"></div>
    </div>
    <dl class="row">
        @foreach($player->getAttributes() as $name => $value)
            <dt class="col-sm-3">{{ $name }}</dt>
            <dd class="col-sm-9">{{ $player->$name }}</dd>
        @endforeach
            @foreach($player->transfer->getAttributes() as $name => $value)
                <dt class="col-sm-3">{{ $name }}</dt>
                <dd class="col-sm-9">{{ $player->transfer->$name }}</dd>
        @endforeach
    </dl>
@endsection

@section('extrajs')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable({!! $performance->data !!});
        var options = {
            width: '100%',
            height: 400,
            legend: { position: 'top', maxLines: 3 },
            bar: { groupWidth: '75%' },
            isStacked: true,
            vAxis: {format: '0', title: 'Week points'},
            hAxis: {title: 'Week number'},
        };
        var chart = new google.visualization.ColumnChart(document.getElementById('performance_chart_div'));
        chart.draw(data, options);

        var data = google.visualization.arrayToDataTable({!! $transfers->data !!});
        var options = {
            width: '100%',
            height: 800,
            vAxis: {title: 'Transfers'},
            hAxis: {title: 'Time'},
            curveType: 'function'
        };
        var chart = new google.visualization.LineChart(document.getElementById('transfers_chart_div'));
        chart.draw(data, options);
    }
</script>
@endsection