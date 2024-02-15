@extends('layouts.app')
@section('title')

@section('activeReport')
    active border-2 border-bottom border-primary
@endsection

@section('content')


    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>


    <div class="container">
        <table id="example" class="display">
            <thead>
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

        <script defer>
            $(document).ready(function() {
                $('#example').DataTable({
                    responsive: true,
                    ordering: false,
                    autoWidth: false,
                });
            });
        </script>
    </div>
@endsection
