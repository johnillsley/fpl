@extends('layouts.app')

@section('title', 'Page Title')

@section('content')
    <canvas id="chartjs" class="chartjs"></canvas>
@endsection

@section('extrajs')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script>
        new Chart(document.getElementById("chartjs"),{!! $chart !!});
    </script>
@endsection