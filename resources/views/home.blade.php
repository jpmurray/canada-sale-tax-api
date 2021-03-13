@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Endpoint stats</div>
            
                <table class="table">
                    <thead>
                        <tr>
                            <th>Endpoint</th>
                            <th># hits</th>
                            <th>Last used</th>
                        </tr>
                    </thead>
            
                    <tbody>
                        @foreach($stats as $stat)
                        <tr>
                            <td>{{ $stat->endpoint }}</td>
                            <td>{{ $stat->hits }}</td>
                            <td>{{ $stat->updated_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
