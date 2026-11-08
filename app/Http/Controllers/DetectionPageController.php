<?php

namespace App\Http\Controllers;

class DetectionPageController extends Controller
{
    public function index()
    {
        return view('detection.index');
    }
}