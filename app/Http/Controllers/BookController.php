<?php

namespace App\Http\Controllers;

use App\Models\book;
use App\Models\bookcategory;
use Illuminate\Http\Request;

use Phattarachai\LineNotify\Facade\Line;


class BookController extends Controller
{
    public function index(Request $request)
    {
        $ctgy_book = bookcategory::get();
        $searchTerm = $request->input('search');

        // 'title' คือ ชื่อคอลัมน์ที่ต้องการค้นหา
        // 'LIKE' คือ operator ที่บอกให้ SQL ทำการค้นหาที่มีค่าในคอลัมน์ title ที่ตรงกับรูปแบบที่กำหนดใน %$searchTerm%
        // "%$searchTerm%" คือ รูปแบบที่ต้องการค้นหา, % ใช้เพื่อแทนจำนวนตัวอักษรที่ไม่รู้ว่าจะเป็นอะไรก็ได้ทั้งหมดทั้งน้อย.

        if ($searchTerm) {
            $books = Book::where('title', 'LIKE', "%$searchTerm%")->get();

            if ($books->isEmpty()) {
                return view('index', compact('ctgy_book', 'books'))->with('message', 'ไม่พบข้อมูลการค้นหา: ' . $searchTerm);
            }
        } else {
            $books = Book::all();
        }

        return view('index', compact('books', 'ctgy_book'));
    }

    function show($id)
    {
        $show_ctgybook = bookcategory::get();

        $show_book = book::find($id);

        $random_related_books = book::inRandomOrder()
            ->where('ctgy_book', $show_book->ctgy_book)
            ->where('id', '!=', $show_book->id)
            ->limit(4)
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

    function delete($id)
    {
        book::where('id', $id)->delete();
        return redirect()->back();
    }

    public function reportbook(Request $request)
    {
        $report_books = Book::whereDate('created_at', now()->toDateString())->get();
    
        // สร้างข้อมูลสำหรับ Morris.js
        $morrisData = [];
        foreach ($report_books as $book) {
            $morrisData[] = [
                'label' => $book->title,
                'value' => 1, // หรือใช้จำนวนทั้งหมดของหนังสือที่เพิ่มในวันนี้
            ];
        }
    
        // สร้างข้อมูลสำหรับ Chart.js
        $chartData = [
            'labels' => $report_books->pluck('title'),
            'datasets' => [
                [
                    'label' => 'จำนวนหนังสือ',
                    'data' => $report_books->count(), // หรือใช้จำนวนทั้งหมดของหนังสือที่เพิ่มในวันนี้
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'borderWidth' => 1,
                ],
            ],
        ];
    
        $showGraph = $request->input('graph', false);
    
        return view('reportbook', compact('report_books', 'morrisData', 'chartData', 'showGraph'));
    }
    
}
