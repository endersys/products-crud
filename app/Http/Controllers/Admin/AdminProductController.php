<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function index() {
        return view('admin.index');
    }

    public function edit() {
        return view('admin.edit');
    }
}