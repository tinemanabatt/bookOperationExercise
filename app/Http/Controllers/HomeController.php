<?php

namespace App\Http\Controllers;

use App\Books;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $getAllBooks = DB::table('books')
            ->join('users', 'users.id', '=', 'books.user_id')
            ->select('books.*', 'users.name')
            ->where('deleted_at', NULL)
            ->get();

        //dd($getAllBooks);
        $getAvailableBooks = Books::all()->where('deleted_at', NULL);
        //dd($getAllBooks);
        return view('home', [
            'books' => $getAllBooks,
            'availableBooks' => $getAvailableBooks
        ]);
    }
}
