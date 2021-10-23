<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function __construct()
    {
        //check if user is logged in
        $this->middleware('auth');
    }
    
    public function index(){
        // echo "this is the contact page";
        return view("contact");
    }
}
