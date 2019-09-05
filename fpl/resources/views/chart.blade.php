@extends('layouts.app')

@section('title', 'Page Title')

@section('content')
    <div id="series_chart_div" style="height: 850px;"></div>
@endsection

@section('extrajs')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable({!! $chart->data !!});
        var options = {!! $chart->options !!};
        var chart = new google.visualization.{{ $chart->type }}(document.getElementById('series_chart_div'));
        chart.draw(data, options);
    }
</script>
@endsection