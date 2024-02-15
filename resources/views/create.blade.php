@extends('layouts.app')
@section('title')
@section('activeCreate')
    active border-2 border-bottom border-primary
@endsection
@section('content')
    <style>
        .image-preview {
            max-width: 100%;
            /* ทำให้รูปภาพไม่เกินความกว้างของ container */
            max-height: 200px;
            /* กำหนดความสูงสูงสุดของรูปภาพ */
            margin-top: 10px;
            /* ระยะห่างด้านบน */
            border: 1px solid #ddd;
            /* เส้นขอบ */
            border-radius: 5px;
            /* ขอบมน */
            padding: 5px;
            /* ระยะห่างขอบ */
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #ced4da;
            border-bottom-color: #0d6efd;
            /* สีขอบล่างเมื่อ focus */
        }

        .form-group {
            margin-bottom: 15px;
            /* ระยะห่างระหว่างกลุ่มฟอร์ม */
        }

        .image-preview {
            max-width: 100%;
            max-height: 200px;
            margin-top: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 5px;
        }
    </style>
    <div class="container d-flex flex-column">
        <div class="card shadow-sm rounded-3 my-auto col-md-7 mx-auto">
            <div class="card-header p-3 h4" style="color: #0d6efd">
                Add New Book
            </div>
            <div class="card-body p-4">
                <form action="{{ route('book.store') }}" method="POST" class="row" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group col-lg-6">
                        <label class="form-control-label" for="form-group-input">Title</label>
                        <input type="text" class="form-control" id="form-group-input" name="title">

                        @error('title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-lg-6">
                        <label class="form-control-label" for="form-group-input">Author</label>
                        <input type="text" class="form-control" id="form-group-input" name="author">

                        @error('author')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-lg-8">
                        <label class="form-control-label" for="form-group-input">Publisher</label>
                        <input type="text" class="form-control" id="form-group-input" name="publisher">

                        @error('publisher')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-lg-4">
                        <label class="form-control-label" for="form-group-input">Category</label>
                        <select class="form-control" name="ctgy_book">
                            <option value="" selected disabled>{{ __('Select Category Book') }}</option>
                            @foreach ($ctgybook as $item)
                                <option value="{{ $item->id }}" {{ old('ctgy_book') == $item->id ? 'selected' : '' }}>
                                    {{ $item->name_book }}
                                </option>
                            @endforeach
                        </select>

                        @error('ctgy_book')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-lg-12">
                        <label class="form-control-label" for="form-group-input">Detail</label>
                        <textarea class="form-control" id="form-group-input" name="detail" rows="5"></textarea>

                        @error('detail')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-lg-7">
                        <label class="form-control-label" for="form-group-input">Image</label>
                        <input type="file" name="image" class="form-control" placeholder="image">

                        @error('image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-lg-5">
                        <label class="form-control-label" for="form-group-input">Price</label>
                        <input type="number" name="price" class="form-control" placeholder="price">

                        @error('price')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-lg-7">
                        <img class="image-preview" src="#" alt="Preview Image">
                    </div>


                    <div class="form-group col-lg-12">
                        <button type="submit" class="btn btn-dark float-end " for="form-group-input">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('input[type="file"]').change(function(e) {
                var fileName = e.target.files[0].name;
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('.image-preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });
        });
    </script>
@endsection
