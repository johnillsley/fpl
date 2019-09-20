@extends('layouts.app')

@section('title', 'Page Title')

@section('content')
    <table class="table table-sm table-striped">
        <tbody>
        @foreach($weeks as $week)
            <tr class="row">
                <td class="col-sm-2"><a href="/fixtures/{{ $week->id }}">{{ $week->name }}</a></td>
                <td class="col-sm-2">{{ date("F j, g:i a", $week->deadline_time_epoch) }}</td>
                <td class="col-sm-1text-right">{{ round($week->average_entry_score) }}</td>
                <td class="col-sm-1 text-right">{{ $week->highest_score }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection