<?php

namespace App\Http\Controllers;

use App\Models\book;
use App\Models\bookcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Phattarachai\LineNotify\Facade\Line;

use function Symfony\Component\String\b;

class BookController extends Controller
{
    public function index(Request $request)
    {
        // 'title' คือ ชื่อคอลัมน์ที่ต้องการค้นหา
        // 'LIKE' คือ operator ที่บอกให้ SQL ทำการค้นหาที่มีค่าในคอลัมน์ title ที่ตรงกับรูปแบบที่กำหนดใน %$searchTerm%
        // "%$searchTerm%" คือ รูปแบบที่ต้องการค้นหา, % ใช้เพื่อแทนจำนวนตัวอักษรที่ไม่รู้ว่าจะเป็นอะไรก็ได้ทั้งหมดทั้งน้อย.
        
        $ctgy_book = bookcategory::get();
        $searchTerm = $request->input('search');

        if ($searchTerm) {
            $books = Book::where('title', 'LIKE', "%$searchTerm%")->get();

            if ($books->isEmpty()) {
                return view('index', compact('ctgy_book', 'books'))->with('message', 'ไม่พบข้อมูลการค้นหา: ' . $searchTerm);
            }
        } else {
            $books = Book::all();
        }

        foreach ($books as $book) {
            $book->formatted_updated_at = Carbon::parse($book->updated_at)->diffForHumans();
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

        return redirect()->route('book.index')->with('notification', notify()->success('แก้ไขข้อมูลสำเร็จ 👍', 'ข้อความแจ้งเตือน!!!'));
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

        book::where('id', $id)->update($input);
        $message = 'อัปเดตข้อมูลหนังสือ ' . $request->title . ' สำเร็จ!';

        Line::send($message);

        return redirect()->route('book.index')->with('notification', notify()->success('แก้ไขข้อมูลสำเร็จ 👍', 'ข้อความแจ้งเตือน!!!'));
    }

    function delete($id)
    {
        $book = Book::find($id);

        if ($book) {
            $book->delete();

            $message = 'ลบข้อมูลหนังสือ ' . $book->title . ' สำเร็จ!';

            Line::send($message);
        } else {
            $message = 'ไม่พบข้อมูลหนังสือที่ต้องการลบ';

            Line::send($message);
        }

        return redirect()->back();
    }

    public function reportbook()
    {
        $report_books = book::get();
        $report_books_grgy = bookcategory::get();

        return view('reportbook', compact('report_books', 'report_books_grgy'));
    }

    public function filter(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $report_books = Book::whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date)
            ->get();

        return view('reportbook', compact('report_books'));
    }
}
