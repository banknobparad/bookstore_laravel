@extends('layouts.app')
@section('title')
@section('activeHome')
    active border-2 border-bottom border-primary
@endsection
@section('content')
    <style>

    </style>
    <div class="container py-4">
        <section class=" text-center">
            <div class="row py-lg-5">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <h1 class="fw-light">ร้านหนังสือ BookStore</h1>
                </div>
            </div>
        </section>

        <!-- Add this section for the slideshow -->
        <div id="bookCarousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                @foreach ($books as $index => $book)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <img src="/images/{{ $book->image }}" alt="{{ $book->title }}" class="d-block w-100"
                            style="height: 350px; object-fit: cover;">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>{{ $book->title }}</h5>
                        </div>
                    </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#bookCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#bookCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <!-- End of slideshow section -->

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
                                        <a href="{{ route('book.edit', $book->id) }}"
                                            class="btn btn-sm btn-outline-primary">Edit</a>
                                        <a href="{{ route('book.show', $book->id) }}"
                                            class="btn btn-sm btn-outline-primary">View</a>
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
        $(document).ready(function () {
            $('#bookCarousel').carousel({
                interval: 3000, // Set the interval for auto-sliding in milliseconds (adjust as needed)
            });
        });
    </script>
@endsection
