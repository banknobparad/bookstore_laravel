@extends('layouts.app')
@section('title')
@section('content')
    <style>
        .heart-button {
            background-color: transparent;
            : none;
            cursor: pointer;
            outline: none;
            transition: color 0.3s;
        }

        .heart-button.active {
            color: red;
            /* สีที่ต้องการเมื่อปุ่มถูกเลือก */
        }

        .add-to-cart-btn {
            background-color: #212529;
            color: #ffffff;
            padding: 10px 20px;
            : none;
            outline: none;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
        }

        .add-to-cart-btn.active {
            background-color: #ffffff;
            color: #212529;
        }
    </style>
    <div class="container">
        <div class="row flex-row flex-wrap g-3">
            <div class="col-3 p-3">

                <div class="row">
                    <img src="/images/{{ $show_book->image }}" alt="{{ $show_book->title }}" class="card-img-top"
                        style="height: 350px; object-fit: cover;">
                </div>

            </div>
            <div class="col-1 p-3"></div>
            <div class="col-5 p-3">

                <div class="row">
                    <h1 class="title-topic" style="font-size: 22px; font-weight: 700; margin-top: 10px; color: #003a70;">
                        {{ $show_book->title }}</h1>
                </div>
                <div class="row py-3">
                    <p style="font-size: 16px;">ผู้เขียน:
                        <a target="_blank" href="https://www.naiin.com/" class="inline-block link-book-detail">
                            {{ $show_book->author }}
                        </a>
                    </p>
                    <p style="font-size: 16px;">สำนักพิมพ์:
                        <a target="_blank" href="https://www.naiin.com/" class="inline-block link-book-detail">
                            {{ $show_book->publisher }}
                        </a>
                    </p>
                    <p style="font-size: 16px;">หมวดหมู่:
                        @foreach ($show_ctgybook as $category)
                            @if ($category->id == $show_book->ctgy_book)
                                <a target="_blank" href="https://www.naiin.com/" class="inline-block link-book-detail">
                                    {{ $category->name_book }}
                                </a>
                            @endif
                        @endforeach
                    </p>
                    <p style="font-size: 16px;">รีวิว:
                        <a>
                            @php
                                $numStars = rand(1, 5);
                                $starColor = '#eec22a';
                            @endphp
                            @for ($i = 1; $i <= $numStars; $i++)
                                <i class="fa-solid fa-star" style="color: {{ $starColor }};"></i>
                            @endfor
                        </a>
                    </p>
                </div>

            </div>
            <div class="col-3 p-3">

                <div class="row py-2 text-center">
                    @php
                        $originalPrice = $show_book->price; // ราคาที่ดึงมา
                        $randomPrice = $originalPrice + rand(20, 50); // ราคาที่ random ขึ้น (20-50 บาท)
                        $savingAmount = $randomPrice - $originalPrice; // คำนวณผลต่างระหว่างราคา random และราคาที่ดึงมา
                        $savingPercentage = ($savingAmount / $originalPrice) * 100; // คำนวณเปอร์เซ็นต์การประหยัด

                        $formattedOriginalPrice = number_format($originalPrice, 2, '.', ',');
                        $formattedRandomPrice = number_format($randomPrice, 2, '.', ',');
                        $formattedSavingAmount = number_format($savingAmount, 2, '.', ',');
                        $formattedSavingPercentage = number_format($savingPercentage, 2, '.', ',');
                    @endphp

                    <div>
                        <p style="font-size: 30px; font-weight: 700; color: #003a70;">
                            {{ $formattedOriginalPrice }} บาท
                        </p>

                        <p style="font-size: 15px; color: #d60f16; text-decoration: line-through; margin-bottom: 5px;">
                            {{ $formattedRandomPrice }} บาท
                        </p>

                        <p style="font-size: 14px; color: #d60f16; margin-bottom: 10px;">
                            ประหยัด {{ $formattedSavingAmount }} บาท ({{ $formattedSavingPercentage }}%)
                        </p>
                    </div>

                </div>
                <div class="py-2 text-center">
                    <button class="heart-button" onclick="toggleHeart(this)">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="1 0 25 24" width="23" height="24"
                            fill="currentColor">
                            <path
                                d="M12 21.35l-1.45-1.32C5.4 14.25 2 11.36 2 7.5 2 4.42 4.42 2 7.5 2c1.74 0 3.41.81 4.5 2.09C16.09 2.81 17.76 2 19.5 2 22.58 2 25 4.42 25 7.5c0 3.86-3.4 6.75-8.55 12.54L12 21.35z" />
                        </svg>
                    </button>
                    <button class="add-to-cart-btn" onclick="toggleCart(this)">
                        <span>Add to Cart</span>
                        <span class="however"></span>
                    </button>

                </div>

            </div>
            <div class="col-12 p-3">
                <div class="row">
                    <h1 class="title-topic" style="font-size: 16px; font-weight: 600; margin-top: 10px; color: #003a70;">
                        รายละเอียด : {{ $show_book->title }}</h1>
                </div>
                <div class="row">
                    <p style="font-size: 15px;">{{ $show_book->detail }}</p>
                </div>
            </div>
            <hr>
            <div class="col-12 p-3">

                <!-- Display random related books in small cards -->
                <div class="row mt-4">
                    <h2 class="title-topic" style="font-size: 18px; font-weight: 600; margin-top: 10px; color: #003a70;">
                        หนังสือที่เกี่ยวข้อง : {{ $show_book->title }}
                    </h2>
                    @foreach ($random_related_books as $related_book)
                        <div class="col-3 mb-3">
                            <div class="card">
                                <img src="/images/{{ $related_book->image }}" class="card-img-top"
                                    style="height: 250px; object-fit: cover;" alt="{{ $related_book->title }}">
                                <div class="card-body">
                                    <p style="font-weight: bold;">{!! Str::limit($related_book->title, 35) !!}</p>
                                    <p class="card-text" style="font-size: 14px;">ผู้เขียน: {{ $related_book->author }}</p>
                                    <p style="font-size: 14px">{{ number_format($related_book->price, 2, '.', ',') }} บาท
                                    </p>
                                    <a href="{{ route('book.show', $related_book->id) }}"
                                        class="btn btn-primary btn-sm">ดูรายละเอียด</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>


                <script>
                    function toggleHeart(button) {
                        button.classList.toggle('active');
                    }

                    function toggleCart(button) {
                        button.classList.toggle('active');
                        setTimeout(() => {
                            button.classList.remove('active');
                        }, 300);
                    }
                </script>

            @endsection
