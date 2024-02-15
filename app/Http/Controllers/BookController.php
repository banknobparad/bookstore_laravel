<?php

namespace App\Http\Controllers;

use App\Models\book;
use App\Models\bookcategory;
use Illuminate\Http\Request;

use Phattarachai\LineNotify\Facade\Line;


class BookController extends Controller
{
    function index()
    {
        $books = book::get();
        // dd($books);
        return view('index', compact('books'));
    }

    function show($id)
    {
        $show_ctgybook = bookcategory::get();

        $show_book = book::find($id);
        
        // Fetch random related books with the same ctgy_book
        $random_related_books = book::inRandomOrder()
            ->where('ctgy_book', $show_book->ctgy_book)
            ->where('id', '!=', $show_book->id)
            ->limit(4) // Adjust the limit as needed
            ->get();

        return view('show', compact('show_book', 'show_ctgybook', 'random_related_books'));
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
            [
                'ctgy_book' => 'required',
                'title' => 'required',
                'author' => 'required',
                'publisher' => 'required',
                'detail' => 'required',
                'image' => 'required',
                'price' => 'required',

            ],
            [
                'ctgy_book.required' => 'กรุณากรอกข้อมูล',
                'title.required' => 'กรุณากรอกข้อมูล',
                'author.required' => 'กรุณากรอกข้อมูล',
                'publisher.required' => 'กรุณากรอกข้อมูล',
                'detail.required' => 'กรุณากรอกข้อมูล',
                'image.required' => 'กรุณากรอกข้อมูล',
                'price.required' => 'กรุณากรอกข้อมูล',
            ]
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

        book::create($input);


        Line::send('บันทึกข้อมูลหนังสือ ' . $request->title . ' สำเร็จ!');

        return redirect()->route('book.index');
    }

    function edit($id)
    {
        $ctgybook_edit = bookcategory::get();
        $books_edit = book::with('ctgybook')->findOrFail($id);

        // dd($books_edit);

        return view('edit', compact('ctgybook_edit', 'books_edit'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'ctgy_book' => 'required',
                'title' => 'required',
                'author' => 'required',
                'publisher' => 'required',
                'detail' => 'required',
                'price' => 'required',

            ],
            [
                'ctgy_book.required' => 'กรุณากรอกข้อมูล',
                'title.required' => 'กรุณากรอกข้อมูล',
                'author.required' => 'กรุณากรอกข้อมูล',
                'publisher.required' => 'กรุณากรอกข้อมูล',
                'detail.required' => 'กรุณากรอกข้อมูล',
                'price.required' => 'กรุณากรอกข้อมูล',
            ]
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
        } else {
            unset($input['image']);
        }

        $message = 'อัปเดตข้อมูลหนังสือ ' . $request->title . ' สำเร็จ!';

        Line::send($message);

        book::where('id', $id)->update($input);
        return redirect()->route('book.index');
    }
}
