<?php

namespace App\Http\Controllers\Modules;

use App\Books;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BookOperationController extends Controller
{
    public function createBook()
    {
        return view('modules.admin.createbook');
    }

    public function saveBook(Request $request)
    {
        //dd($request->all());

        $validator = Validator::make($request->all(), [
            'name_of_book' => 'required',
            'image_of_book' => 'required|mimes:png,jpg,jpeg',
        ], $messages = [
            'name_of_book.required' => 'The name of book field is required.',
            'image_of_book.required' => 'The image of book field is required.',
            'image_of_book.mimes' => 'The file image must be in png, jpg, jpeg format.',
        ]);

        if ($validator->fails()) {
            return redirect('/createBook')
                ->withErrors($validator)
                ->withInput();
        } else {
            $fileName = $request->image_of_book->getClientOriginalName();

            $book = Books::create([
                'user_id' => 1,
                'name_of_book' => $request->name_of_book,
                'image_of_book' => $fileName,
                'is_borrowed' => 0
            ]);

            $request->image_of_book->move(public_path('img/books/' . $book->id), $fileName);

            return redirect('/home')->with('success', 'Book has been added successfully!');
        }
    }

    public function editBook($id)
    {
        $book = Books::find($id);

        return view('modules.admin.editbook', [
            'book' => $book
        ]);
    }

    public function updateBook(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name_of_book' => 'required',
            'image_of_book' => 'required|mimes:png,jpg,jpeg',
        ], $messages = [
            'name_of_book.required' => 'The name of book field is required.',
            'image_of_book.required' => 'The image of book field is required.',
            'image_of_book.mimes' => 'The file image must be in png, jpg, jpeg format.',
        ]);

        if ($validator->fails()) {
            return redirect('/editBook' . '/' . $id)
                ->withErrors($validator)
                ->withInput();
        } else {
            $fileName = $request->image_of_book->getClientOriginalName();

            $book = Books::where('id', $id)->update([
                'name_of_book' => $request->name_of_book,
                'image_of_book' => $fileName,
            ]);

            $request->image_of_book->move(public_path('img/books/' . $id), $fileName);

            return redirect('/home')->with('success', 'Book has been edit successfully!');
        }
    }

    public function borrowBook($id)
    {
        Books::where('id', $id)->update([
            'user_id' => Auth::user()->id,
            'is_borrowed' => 1
        ]);
    }

    public function unborrowBook($id)
    {
        Books::where('id', $id)->update([
            'user_id' => 1,
            'is_borrowed' => 0
        ]);
    }

    public function deleteBook($id)
    {
        Books::where('id', $id)->update([
            'user_id' => 1,
            'is_borrowed' => 0
        ]);

        Books::find($id)->delete();
    }
}
