<?php

namespace App\Http\Controllers;

use App\Models\Slug;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function redirectToLink(Request $request)
    {
        $slug = Slug::where('slug', $request->slug)->first();

        if (is_null($slug)) {
            return view('404');
        }

        $counter = $slug->counter + 1;
        $slug->counter = $counter;
        $slug->save();

        return redirect($slug->link);

    }
}
