@extends('layouts.app')

@section('title')
@endsection

@section('activeHome')
    active border-2 border-bottom border-primary
@endsection

@section('content')
    <style>
        .btn-outline-primary {
            transition: background-color 0.3s, color 0.3s;
        }

        .btn-outline-primary.active {
            background-color: #007bff;
            color: #fff;
            /* เพิ่มสไตล์อื่น ๆ ตามต้องการ */
        }

        .card {
            transition: transform 0.3s;
        }

        .card:hover {
            transform: scale(1.05);
        }
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
                    <button type="button" class="btn btn-outline-primary" data-target="all"
                        onclick="showAllBooks()">แสดงทั้งหมด</button>
                    <span style="color:rgb(50, 53, 50)">|</span>
                    @forelse ($ctgy_book as $category)
                        <button type="button" class="btn btn-outline-primary" data-target="{{ $category->id }}"
                            onclick="filterByCategory('{{ $category->id }}')">{{ $category->name_book }}</button>
                    @empty
                        {{-- เอาไว้แก้ไขถ้าไม่มีเนื้อหา --}}
                    @endforelse
                </div>

                <div class="col-md-3 mb-3">
                    <form action="{{ route('book.index') }}" method="GET">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="ค้นหาหนังสือ" name="search"
                                value="{{ request('search') }}">
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
                                       Update: {{ $book->formatted_updated_at }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- <script>
        function filterByCategory(categoryId) {
            $('.col').hide();
            $('.col[data-category="' + categoryId + '"]').show();
        }

        function showAllBooks() {
            $('.col').show();
        }
    </script> --}}

    <script>
        function filterByCategory(categoryId) {
            // ลบคลาส active จากทุกปุ่ม
            $('.btn-outline-primary').removeClass('active');

            // เพิ่มคลาส active ให้กับปุ่มที่ถูกคลิก
            $('[data-target="' + categoryId + '"]').addClass('active');

            // ซ่อนทั้งหมดก่อน
            $('.col').hide();

            // แสดงเฉพาะ element ที่ตรงกับ categoryId
            $('.col[data-category="' + categoryId + '"]').show();

            // เพิ่มโค้ด "However" ที่คุณต้องการทำ
            console.log("Filter by category: " + categoryId);
            // เช่นแสดงข้อความหรือปรับปรุงข้อมูลตามต้องการ
        }

        function showAllBooks() {
            // ลบคลาส active จากทุกปุ่ม
            $('.btn-outline-primary').removeClass('active');

            // เพิ่มคลาส active ให้กับปุ่ม "แสดงทั้งหมด"
            $('[data-target="all"]').addClass('active');

            // แสดงทั้งหมด
            $('.col').show();

            // เพิ่มโค้ด "However" ที่คุณต้องการทำ
            console.log("Show all books");
            // เช่นแสดงข้อความหรือปรับปรุงข้อมูลตามต้องการ
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
