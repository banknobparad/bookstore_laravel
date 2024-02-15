@extends('layouts.app')

@section('title')
@endsection

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
        <div class="container">
            <div class="row flex-row flex-wrap g-3">
                <div class="col-md-9 mb-3">
                    @forelse ($ctgy_book as $category)
                        <button type="button" class="btn btn-outline-primary"
                            onclick="filterByCategory('{{ $category->id }}')">{{ $category->name_book }}</button>
                    @empty
                        {{-- เอาไว้แก้ไขถ้าไม่มีเนื้อหา --}}
                    @endforelse
                    <button type="button" class="btn btn-outline-primary" onclick="showAllBooks()">แสดงทั้งหมด</button>
                </div>
                <div class="col-md-3 mb-3">
                    <form action="{{ route('book.index') }}" method="GET">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="ค้นหาหนังสือ" name="search" value="{{ request('search') }}">
                            <button class="btn btn-outline-primary" type="submit">ค้นหา</button>
                        </div>
                    </form>
                    
                </div>
                <div class="text-center">
                    @if (isset($message))
                        <h3>{{ $message }}</h3>
                        <i class="magnifying-glass fa-solid fa-magnifying-glass text-muted fa-3x"></i>
                    @endif
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row flex-row flex-wrap g-3">
                @foreach ($books as $book)
                    <div class="col col-md-3" data-category="{{ $book->ctgy_book }}">
                        <div class="card draggable" style="width: 288px;">
                            <a href="{{ route('book.delete', $book->id) }}" class="btn btn-danger btn-sm"
                                style="position: absolute; top: 5px; right: 4px;"
                                onclick="return confirmWithSweetAlert('{{ $book->id }}');">
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                            <img src="/images/{{ $book->image }}" alt="{{ $book->title }}" class="card-img-top"
                                style="height: 350px; object-fit: cover;">
                            <div class="card-body">
                                <p style="font-weight: bold;">{!! Str::limit($book->title, 35) !!}</p>
                                <p>{{ $book->author }}</p>
                                <p style="font-size: 14px;">{{ number_format($book->price, 2, '.', ',') }} บาท</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a href="{{ route('book.edit', $book->id) }}"
                                            class="btn btn-sm btn-outline-primary">Edit</a>
                                        <a href="{{ route('book.show', $book->id) }}"
                                            class="btn btn-sm btn-outline-primary">View</a>
                                    </div>
                                    <small class="text-muted">
                                        {{ (new DateTime($book->updated_at))->diff(new DateTime())->format('%i นาทีที่แล้ว') }}
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
        // Filter books by category
        function filterByCategory(categoryId) {
            $('.col').hide();
            $('.col[data-category="' + categoryId + '"]').show();
        }

        // Show all books
        function showAllBooks() {
            $('.col').show();
        }
    </script>

    <script>
        // Confirm with SweetAlert function
        function confirmWithSweetAlert(bookId) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('book.delete', '') }}/" + bookId;
                }
            });
            return false;
        }
    </script>

    <script>
        // DataTable initialization
        $(document).ready(function() {
            $('#example').DataTable({
                responsive: true,
                ordering: false,
                autoWidth: false,
            });
        });
    </script>
@endsection
