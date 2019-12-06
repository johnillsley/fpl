@extends('layouts.app')

@section('title', 'Page Title')

@section('content')
    @include('subviews.players', ['players' => $players])
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