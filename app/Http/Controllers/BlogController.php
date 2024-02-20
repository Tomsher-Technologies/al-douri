<?php
namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    function __construct()
    {
        // $this->middleware('permission:news');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->session()->put('last_url', url()->full());

        $blogs = Blog::orderBy('id','desc')->paginate(15);
        return view('backend.blog_system.blog.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.blog_system.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image'         => 'required',
            'title'         => 'required',
            'ar_title'      => 'required',
            'content'       => 'required',
            'ar_content'    => 'required',
            'news_date'     => 'required'
        ],['*.required' => 'This field is required']);

        $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->title));
        $same_slug_count = Blog::where('slug', 'LIKE', $slug . '%')->count();
        $slug_suffix = $same_slug_count ? '-' . $same_slug_count + 1 : '';
        $slug .= $slug_suffix;

        $saveData = [
            'slug'                  => $slug,
            'title'                 => $request->title,
            'ar_title'              => $request->ar_title,
            'content'               => $request->content,
            'ar_content'            => $request->ar_content,
            'blog_date'             => $request->news_date,
            'image'                 => $request->image,
            'seo_title'             => $request->meta_title,
            'og_title'              => $request->og_title, 
            'twitter_title'         => $request->twitter_title, 
            'seo_description'       => $request->meta_description, 
            'og_description'        => $request->og_description, 
            'twitter_description'   => $request->twitter_description, 
            'keywords'              => $request->keywords,
            'meta_image'            => $request->meta_image
        ];
        
        $blog = Blog::create($saveData);
        // die;
        flash(translate('News Created Successfully'))->success();
        return redirect()->route('news.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $blog = Blog::find($id);
        return view('backend.blogs.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $blog = Blog::find($request->blog);
        $request->validate([
            'image' => 'nullable|max:1024',
            'title' => 'required',
            'ar_title' => 'required',
            'content' => 'required',
            'ar_content' => 'required',
            'news_date' => 'required', 
            'status' => 'required',
        ],[
            'image.uploaded' => 'File size should be less than 1 MB'
        ]);

        $blog->title                = $request->title;
        $blog->ar_title             = $request->ar_title;
        $blog->content              = $request->content;
        $blog->ar_content           = $request->ar_content;
        $blog->status               = $request->status;
        $blog->blog_date            = $request->news_date;
        $blog->seo_title            = $request->seotitle;
        $blog->og_title             = $request->ogtitle; 
        $blog->twitter_title        = $request->twtitle;
        $blog->seo_description      = $request->seodescription;
        $blog->og_description       = $request->og_description;
        $blog->twitter_description  = $request->twitter_description; 
        $blog->keywords             = $request->seokeywords;
    
        if ($request->hasFile('image')) {
            $image = uploadImage($request, 'image', 'blogs');
            deleteImage($blog->image);
            $blog->image = $image;
        }

        $blog->save();

        return redirect()->route('news.index')->with('status','Blog details updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $blog = Blog::find($request->blog);
        $img = $blog->image;
        if ($blog->delete()) {
            deleteImage($img);
        }
        return redirect()->route('news.index')->with([
            'status' => "Blog Deleted"
        ]);
    }
}
