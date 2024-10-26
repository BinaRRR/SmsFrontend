<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LocalizationController extends Controller
{
    public function setLanguage(Request $request) {
        $locale = $request->locale ?? "en";

        $request->session()->put('locale', $locale);

        return redirect()->back();
    }
}
