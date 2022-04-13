<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use Illuminate\Http\Request;

class Search extends Controller
{
    public function search(Request $request)
    {
        $data = Channel::where('name', 'LIKE','%'.$request->keyword.'%')->get();
        // dd('search');
        if (!$data) {
            return response()->json('no record found');
        }
        return response()->json($data); 
    }
}
