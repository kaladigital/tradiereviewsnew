<?php
/**
 * Created by PhpStorm.
 * User: brainfors
 * Date: 5/3/21
 * Time: 6:07 PM
 */

namespace App\Http\Controllers\Admin;
use Auth;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth_admin');
    }

    public function index()
    {
        return view('admin.index');
    }
}