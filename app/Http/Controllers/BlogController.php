<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use App\Tag;
use Auth;
use Config;
use Illuminate\Http\Request;

use App\Http\Requests;
use Image;
use League\Flysystem\Exception;
use Response;
use Validator;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::paginate(8);
        return view('blog-list', ['posts'=>$posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Post::class);
        return view('blog-new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $action = $request->get('action');
        if ($action=="post"){
            $data = $request->all();
            $validator = Validator::make($data,[
                'title' => 'required',
                'summary' => 'required',
                'body' => 'required',
                'image' => 'required|image',
//                'tags.*.slug' => 'required|exist:tags,slug',
//                'category' => 'required|exist:categories,slug'
            ]);
            if ($validator->fails())
                return Response::json(['status'=>'error','detail'=>$validator->errors()->first()]);
            try{
                $image = $request->file('image');
                $filename = Auth::user()->id.'-'.time().'.'.$image->getClientOriginalExtension();
                Image::make($image)->save(public_path(Config::get('image.dir.post')).$filename);
                Image::make($image)->fit(230,130)->save(public_path(Config::get('image.dir.post')).'thumb/'.$filename);
                $post = new Post();
                $post->user_id = Auth::user()->id;
                $post->title = $data['title'];
                $post->image = $filename;
                $post->summary = $data['summary'];
                $post->body = $data['body'];
//                foreach ($data['tags'] as $tag){
//                    $post->tags->attach($tag);
//                }
//                $post->category = $data['category'];
                $post->save();
            } catch (Exception $ex){
                    return Response::json(['status'=>'error']);
            }
            return Response::json(['status'=>'success']);
        } else if ($action=="category"){
            return $this->newCategory($request->all());
        } else if ($action=="tag"){
            return $this->newTag($request->all());
        } else {
            return Response::json(['status'=>'error', 'detail'=>'No action']);
        }
    }

    private function newCategory($data){
        $validator = Validator::make($data,[
            'name' => 'required',
            'slug' => 'required|unique:categories,slug'
        ]);
        if ($validator->fails())
            return Response::json(['status'=>'error','detail'=>$validator->errors()->first()]);
        $category = new Category();
        $category->name = $data['name'];
        $category->slug = $data['slug'];
        if($category->save())
            return Response::json(['status'=>'success','category'=>$category]);
        return Response::json(['status'=>'error']);
    }

    private function newTag($data){
        $validator = Validator::make($data,[
            'name' => 'required',
            'slug' => 'required|unique:tags,slug'
        ]);
        if ($validator->fails())
            return Response::json(['status'=>'error','detail'=>$validator->errors()->first()]);
        $tag = new Tag();
        $tag->slug = $data['slug'];
        $tag->name = $data['name'];
        if($tag->save())
            return Response::json(['status'=>'success','tag'=>$tag]);
        return Response::json(['status'=>'error']);
    }

    private function newPost($data){

    }

    /**
     * Display the specified resource.
     *
     * @param Post $post
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function show(Post $post)
    {
        return view('blog-post',['post'=>$post]);
    }

    public function listTags(){
        return Tag::all();
    }

    public function listCategories(){
        return Category::all();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Post $post
     * @return \Illuminate\Http\JsonResponse
     * @internal param int $id
     */
    public function update(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'image' => 'required|image',
            'body' => 'required',
            'tags' => '',
            'category' => ''
        ]);
        if ($validator->fails())
            return Response::json(['status'=>'error','detail'=>$validator->errors()->first()]);
        try{
            $post->title = $request->get('title');
            $post->image = $request->get('image');
            $post->body = $request->get('body');
            foreach ($request->get('tags') as $tag){
                $post->tags->attach($tag);
            }
            $post->category = $request->get('category');
            $post->save();
        } catch (Exception $ex){
            return Response::json(['status'=>'error']);
        }
        return Response::json(['status'=>'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Post $post
     * @return \Illuminate\Http\JsonResponse
     * @internal param Post $blog
     * @internal param int $id
     */
    public function destroy(Post $post)
    {
        $this->authorize('destroy', $post);
        if ($post->delete())
            return Response::json(['status'=>'success']);
        return Response::json(['status'=>'error']);
    }
}
