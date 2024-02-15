@extends('layouts.app')
@section('title')

@section('activeReport')
    active border-2 border-bottom border-primary
@endsection

@section('content')
    <style>
        .table-th-color th {
            background-color: #343a40;
            /* สีพื้นหลังส่วนหัวตาราง */
            color: #e4e7ec;
            /* สีของข้อความในส่วนหัวตาราง */
        }
    </style>
    <div class="container">
        <h1 class="text-center pt-4">Report Data</h1>
        <hr>
        <form action="{{ route('books.filter') }}" method="GET">
            <div class="row pb-3">
                <div class="col-md-5 pt-4">
                    <a href="{{ route('books.reportbook') }}" class="btn btn-success mr-2">All Books</a>
                    </a>

                </div>
                <div class="col-md-3">
                    <label>Start Date:</label>
                    <input type="date" name="start_date" class="form-control">
                </div>
                <div class="col-md-3">
                    <label>End Date:</label>
                    <input type="date" name="end_date" class="form-control">
                </div>

                <div class="col-md-1 pt-4">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>

            </div>
        </form>
        <table id="example" class="table table-bordered table-hover table-striped display">
            <thead class="table-th-color">
                <tr>
                    <th>ชื่อหนังสือ</th>
                    <th>ผู้แต่ง</th>
                    <th>วันที่เพิ่ม</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($report_books as $book)
                    <tr>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->author }}</td>
                        <td>{{ $book->created_at }}</td>
                    </tr>
                @endforeach
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
