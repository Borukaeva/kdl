<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Analysis;
use App\Models\Complex;
use App\Models\Method;
use App\Models\Unit;
use App\Models\Type;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Biomaterial;
use App\Models\TestTube;
use App\Models\User;

class HomeController extends Controller
{
    //
    public function index()
    {
        $posts_count = Post::all()->count();
        $categories_count = Category::all()->count();
        $biomat= Biomaterial::all()->count();
        $tube = TestTube::all()->count();
        $users = User::all()->count();
        $analysis = Analysis::all()->count();
        $complex = Complex::all()->count();
        $unit = Unit::all()->count();
        $method = Method::all()->count();


        return view('admin.home.index',[
            'posts_count' => $posts_count,
            'categories_count'=>$categories_count,
            'biomat' =>$biomat,
            'tube'=>$tube,
            'users'=>$users,
            'analysis'=>$analysis,
            'complex'=>$complex,
            'unit'=>$unit,
            'method'=>$method,

        ]);
    }
}
