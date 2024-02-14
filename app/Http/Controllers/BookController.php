<?php

namespace App\Http\Controllers;

use App\Models\book;
use App\Models\bookcategory;
use Illuminate\Http\Request;

class BookController extends Controller
{
    function index()
    {
        return view('index');
    }

    function create()
    {
        $ctgybook = bookcategory::get();
        // dd($ctgybook);
        return view('create', compact('ctgybook'));
    }

    function store(Request $request)
    {
        $request->validate(
            // [
            //     'ctgy_book' => 'required',
            //     'title' => 'required',
            //     'author' => 'required',
            //     'publisher' => 'required',
            //     'detail' => 'required',
            //     'image' => 'required',
            //     'price' => 'required',

            // ],
            // [
            //     'ctgy_book.required' => 'กรุณากรอกข้อมูล',
            //     'title.required' => 'กรุณากรอกข้อมูล',
            //     'author.required' => 'กรุณากรอกข้อมูล',
            //     'publisher.required' => 'กรุณากรอกข้อมูล',
            //     'detail.required' => 'กรุณากรอกข้อมูล',
            //     'image.required' => 'กรุณากรอกข้อมูล',
            //     'price.required' => 'กรุณากรอกข้อมูล',
            // ]
        );
        $input = [
            'ctgy_book' => $request->ctgy_book,
            'title' => $request->title,
            'author' => $request->author,
            'publisher' => $request->publisher,
            'detail' => $request->detail,
            'image' => $request->image,
            'price' => $request->price,
        ];
        
        if ($image = $request->file('image')) {
            $destinationPath = 'images/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = $profileImage;
        }
        
        dd($input);

        book::create($input);
        return redirect()->route('book.index');
    }
}
