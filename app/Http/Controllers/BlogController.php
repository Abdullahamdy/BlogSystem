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
        $relatedBlogs =  Blog::with('user')->where('id', '!=', $blog->id)->whereHas('cat', function ($q) use ($category_ids) {
            $q->whereIn('category_id', $category_ids);
        })
            ->limit(5)
            ->orderBy('id', 'desc')
            ->get(['id', 'title', 'post_excerpt', 'slug', 'user_id', 'featuredImage']);
        return view('singleblog')->with(['categories' => $categories, 'blog' => $blog, 'relatedBlogs' => $relatedBlogs]);
    }


    public function categoryIndex(Request $request, $categoryName, $id)
    {
        $categories = Category::select('id', 'categoryName')->get();
        $blogs =  Blog::with('user')->whereHas('cat', function ($q) use ($id) {
            $q->where('category_id', $id);
        })
            ->orderBy('id', 'desc')
            ->select('id', 'title',  'slug', 'user_id', 'featuredImage')->paginate(3);
        return view('category')->with(['categories' => $categories, 'categoryName' => $categoryName, 'blogs' => $blogs]);
    }
    public function tagIndex(Request $request, $tagName, $id)
    {
        $categories = Category::select('id', 'categoryName')->get();
        $blogs =  Blog::with('user')->whereHas('tag', function ($q) use ($id) {
            $q->where('tag_id', $id);
        })
            ->orderBy('id', 'desc')
            ->select('id', 'title',  'slug', 'user_id', 'featuredImage')->paginate(3);
        return view('tag')->with(['categories' => $categories, 'tagName' => $tagName, 'blogs' => $blogs]);
    }

    public function allblogs()
    {
        $categories = Category::select('id', 'categoryName')->get();
        $blogs =  Blog::orderBy('id', 'desc')->with(['cat', 'user'])
            ->select('id', 'title',  'slug', 'user_id', 'featuredImage')->paginate(3);
        return view('blogs')->with(['categories' => $categories, 'blogs' => $blogs]);;
    }

    public function search(Request $request)
    {
        $str = $request->str;
        $blogs =  Blog::orderBy('id', 'desc')->with(['cat', 'user'])
            ->select('id', 'title',  'slug', 'user_id', 'featuredImage');
            if(!$str) return $blogs->get();

            $blogs->where('title', 'LIKE', "%{$str}%")
            ->orWhereHas('cat',function($q) use($str){
                $q->where('categoryName',$str);

            })->orWhereHas('tag',function($q)use($str){
                $q->where('tagname',$str);
            });
        
        return $blogs->get();
    }
}
