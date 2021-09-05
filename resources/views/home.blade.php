@extends('layouts.app')

@section('content')
<div class="container">

    <div class="card mt-4">
        <div class="card-header">
            Report Elevator
        </div>
        <div class="card-block mt-4 p-3">
            <table id="example" class="table table-striped table-bordered" >
                <thead>
                <tr>
                    <th>Current Time</th>
                    <th>Elevator</th>
                    <th>Floor</th>
                    <th>Floors Traveled</th>
                </tr>
                </thead>
                <tbody>
                @foreach($reports as $report)
                    <tr>
                        <td>{{  $report['time'] }}</td>
                        <td>{{  $report['elevator'] }}</td>
                        <td>{{  $report['floor'] }}</td>
                        <td>{{  $report['traveled'] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>


</div>
@endsection
