@extends('layouts.app')
@section('title')
@section('activeHome')
    active border-2 border-bottom border-primary
@endsection
@section('content')
    <div class="container py-4">
        <table id="example" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Office</th>
                    <th>Age</th>
                    <th>Start date</th>
                    <th>Salary</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Tiger Nixon</td>
                    <td>System Architect</td>
                    <td>Edinburgh</td>
                    <td>61</td>
                    <td>2011/04/25</td>
                    <td>$320,800</td>
                </tr>
                <!-- Add more rows as needed -->
            </tbody>
        </table>
    </div>


    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                responsive: true,
                ordering: false,
                autoWidth: false,
            });
        });
    </script>


@endsection
