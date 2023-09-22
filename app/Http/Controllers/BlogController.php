<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Blogcategory;
use App\Models\Category;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $categories = Category::select('id', 'categoryName')->get();
        $blogs = Blog::orderBy('id', 'desc')->with(['cat', 'user'])->limit(6)->get(['id', 'title', 'post_excerpt', 'slug', 'user_id', 'featuredImage']);
        return view('home')->with(['categories' => $categories, 'blogs' => $blogs]);
    }
    public function singleBlog(Request $request, $slug)
    {
        $categories = Category::select('id', 'categoryName')->get();
        $blog =   Blog::where('slug', $slug)->with(['cat', 'tag', 'user'])->first(['id', 'title', 'user_id', 'featuredImage', 'post']);
        $category_ids = [];
        foreach ($blog->cat as $category) {
            array_push($category_ids, $category->id);
        }
        $relatedBlogs =  Blog::with('user')->where('id','!=',$blog->id)->whereHas('cat', function ($q) use($category_ids) {
            $q->whereIn('category_id', $category_ids);
        })->orderBy('id', 'desc')
            ->get(['id', 'title', 'post_excerpt', 'slug', 'user_id', 'featuredImage']);
        return view('singleblog')->with(['categories' => $categories, 'blog' => $blog, 'relatedBlogs' => $relatedBlogs]);
    }
}
