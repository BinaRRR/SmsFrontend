<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class RecipientController extends Controller
{
    public function index() : View
    {
        $json = Http::get("http://localhost:5202/api/recipient")->json();
        // dd($json);
        return view('recipients', ["recipients" => $json]);
    }
}
