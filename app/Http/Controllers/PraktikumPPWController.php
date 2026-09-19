<?php 
namespace App\Http\Controllers; 
use Illuminate\Http\Request;

class PraktikumPPWController extends Controller
{
    public function index()
    {
        return view('praktikumppw.index');
    }
}