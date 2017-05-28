@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Rates for {{ ucfirst($rates->first()->province) }}</div>

                <table class="table"> 
                    <thead>
                        <tr>
                            <th>Start</th>
                            <th>PST</th>
                            <th>HST</th>
                            <th>GST</th>
                            <th>Applicable</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($rates as $rate)
                        <tr>
                            <td>{{ $rate->start }}</td>
                            <td>{{ $rate->pst }}</td>
                            <td>{{ $rate->hst }}</td>
                            <td>{{ $rate->gst }}</td>
                            <th scope="row">{{ $rate->applicable }}</th>
                            <td>{{ $rate->created_at }}</td>
                            <td>{{ $rate->updated_at }}</td>
                            <td><a href="{{ route("rates.edit", ['rate' => $rate->id]) }}">Edit</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
