<?php

namespace App\Http\Controllers;

use App\VisitorModel;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    public function VisitorIndex()
    {
        $visitorData = json_decode(VisitorModel::orderBy('id','desc')->take(50)->get());
        return view('visitor',['visitorData'=>$visitorData]);
    }
}
