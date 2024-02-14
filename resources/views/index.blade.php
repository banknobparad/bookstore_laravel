@extends('layouts.app')
@section('title')
@section('activeHome')
    active border-2 border-bottom border-primary
@endsection
@section('content')
    <style>

    </style>
    <div class="container py-4">
        <section class="py-5 text-center">
            <div class="row py-lg-5">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <h1 class="fw-light">Album example</h1>
                    <p class="lead text-muted">Something short and leading about the collection below—its contents, the
                        creator, etc. Make it short and sweet, but not too short so folks don’t simply skip over it
                        entirely.</p>
                    <p>
                        <a href="#" class="btn btn-primary my-2">Main call to action</a>
                        <a href="#" class="btn btn-secondary my-2">Secondary action</a>
                    </p>
                </div>
            </div>
        </section>


        <div class="container">
            <div class="row flex-row flex-wrap g-3">
                @foreach ($books as $book)
                    <div class="col col-md-3">
                        <div class="card draggable" style="width: 288px;">
                            <img src="/images/{{ $book->image }}" alt="{{ $book->title }}" class="card-img-top"
                                style="height: 350px; object-fit: cover;">

                            <div class="card-body">
                                <p style="font-weight: bold;">{{ $book->title }}</p>
                                <p>{{ $book->author }}</p>
                                <p>{{ number_format($book->price, 2, '.', ',') }} บาท</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a href="{{ route('book.edit', $book->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <a href="{{ route('book.show', $book->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                                    </div>
                                    <small class="text-muted">
                                        {{ (new DateTime($book->created_at))->diff(new DateTime())->format('%i นาทีที่แล้ว') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
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
