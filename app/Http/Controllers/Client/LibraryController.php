<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Bag;
use App\Models\Basket;
use App\Models\Book;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->id ?? null;
        if ($id != null) {
            $book = Book::where("basket_id", $id)->get();
        } else {
            $book = Book::all();
        }
        $bag = [
            'baskets' => Bag::where("parent_id", null)->get(),
            'books' => $book,
        ];
        return view("library", $bag);
    }
}
