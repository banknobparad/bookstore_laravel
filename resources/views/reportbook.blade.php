@extends('layouts.app')
@section('title')

@section('activeReport')
    active border-2 border-bottom border-primary
@endsection

@section('content')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.0/css/dataTables.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/3.0.0/css/buttons.dataTables.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">

    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.0/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.0/js/buttons.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.0/js/buttons.print.min.js"></script>

    <style>
        .table-th-color th {
            background-color: #343a40;
            /* สีพื้นหลังส่วนหัวตาราง */
            color: #e4e7ec;
            /* สีของข้อความในส่วนหัวตาราง */
        }
    </style>
    <div class="container">
        <h1 class="text-center pt-4">Report Data Book</h1>
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
                    <th scope="col">Num</th>
                    <th scope="col">Title</th>
                    <th scope="col">Author Name</th>
                    <th scope="col">Publisher</th>
                    <th scope="col">Date Add</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($report_books as $book)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->author }}</td>
                        <td>{{ $book->publisher }}</td>
                        <td>{{ $book->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        new DataTable('#example', {
            responsive: true,
            ordering: false,
            autoWidth: false,
            layout: {
                topStart: {
                    buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                }
            },
            pdfMake: {
                font: 'Bai Jamjuree'
            }
        });
    </script>


@endsection
