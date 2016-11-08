<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use App\Tag;
use Auth;
use Config;
use Illuminate\Auth\Access\AuthorizationException;
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
                'tags.*.slug' => 'exists:tags,slug',
                'category' => 'exists:categories,slug'
            ]);
            if ($validator->fails())
                return Response::json(['status'=>'error','detail'=>$validator->errors()->first()]);
            try{
                $image = $request->file('image');
                $filename = Auth::user()->id.'-'.time().'.'.$image->getClientOriginalExtension();
                Image::make($image)->save(public_path(Config::get('image.dir.post')).$filename);
                Image::make($image)->fit(360,240)->save(public_path(Config::get('image.dir.postThumb')).$filename);
                $post = new Post();
                $post->user_id = Auth::user()->id;
                $post->title = $data['title'];
                $post->image = $filename;
                $post->summary = $data['summary'];
                $post->body = $data['body'];
                if ($request->has('category'))$post->category_slug = $data['category'];
                $post->save();
                if ($request->has('tags'))
                foreach ($data['tags'] as $tag){
                    $post->tags()->attach($tag);
                }
            } catch (Exception $ex){
                    return Response::json(['status'=>'error']);
            }
            return Response::json(['status'=>'success']);
        } else if ($action=="category"){
            return $this->newCategory([
                'name'=>$request->get('name'),
                'slug'=>str_slug($request->get('name'))
            ]);
        } else if ($action=="tag"){
            return $this->newTag([
                'name'=>$request->get('name'),
                'slug'=>str_slug($request->get('name'))
            ]);
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

    public function editCategory(Category $category, Request $request){
        $data = $request->all();
        if ($data['slug']!=$category['slug']){
            $rule = [
                'name' => 'required',
                'slug' => 'required|unique:categories,slug'
            ];
        } else {
            $rule = [
                'name' => 'required',
                'slug' => 'required'
            ];
        }
        $validator = Validator::make($data,$rule);
        if ($validator->fails())
            return Response::json(['status'=>'error','detail'=>$validator->errors()->first()]);
        $category->name = $data['name'];
        $category->slug = $data['slug'];
        if($category->save())
            return Response::json(['status'=>'success','category'=>$category]);
        return Response::json(['status'=>'error']);
    }

    public function deleteCategory(Category $category){
        try{
            $this->authorize('delete', $category);
        }catch (AuthorizationException $authorizationExceptionex){
            //return Response::json(['status'=>'error','detail'=>'unauthorize']);
            return redirect()->back()->with('message','Unathorized');
        }

        if ($category->delete()){
            return redirect()->back()->with('message','Success Delete');
        }
        return redirect()->back()->with('message','Error');
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

    public function editTag(Tag $tag, Request $request){
        $data = $request->all();
        if ($data['slug']!=$tag['slug']){
            $rule = [
                'name' => 'required',
                'slug' => 'required|unique:tags,slug'
            ];
        } else {
            $rule = [
                'name' => 'required',
                'slug' => 'required'
            ];
        }
        $validator = Validator::make($data,$rule);
        if ($validator->fails())
            return Response::json(['status'=>'error','detail'=>$validator->errors()->first()]);
        $tag->slug = $data['slug'];
        $tag->name = $data['name'];
        if($tag->save())
            return Response::json(['status'=>'success','tag'=>$tag]);
        return Response::json(['status'=>'error']);
    }
    public function deleteTag(Tag $tag){
        try{
            $this->authorize('delete', $tag);
        }catch (AuthorizationException $authorizationExceptionex){
            return redirect()->back()->with('message','Unathorized');
            //return Response::json(['status'=>'error','detail'=>'unauthorize']);
        }

        if ($tag->delete()){
            return redirect()->back()->with('message','Success Delete');
            //return Response::json(['status'=>'success']);
        }
        return redirect()->back()->with('message','Error');
        //return Response::json(['status'=>'error']);
    }

    public function showTag(Tag $tag){
        return view('blog-list', ['posts'=>$tag->posts()->paginate(8)]);
    }

    public function showCategory(Category $category){
        return view('blog-list', ['posts'=>$category->posts()->paginate(8)]);
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

    public function managePosts(){
        $tags  = Tag::all();
        $categories = Category::all();
        $posts = Post::with(['category','tags','user'])->get();
        return view('blog-manage',['posts'=>$posts,'tags'=>$tags,'categories'=>$categories]);
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
            'image' => 'image',
            'body' => 'required',
            'tags' => '',
            'category' => ''
        ]);
        $data = $request->all();
        $validator = Validator::make($data,[
            'title' => 'required',
            'summary' => 'required',
            'body' => 'required',
            'image' => 'image',
//                'tags.*.slug' => 'required|exist:tags,slug',
//                'category' => 'required|exist:categories,slug'
        ]);
        if ($validator->fails())
            return Response::json(['status'=>'error','detail'=>$validator->errors()->first()]);
        try{
            $post->user_id = Auth::user()->id;
            $post->title = $data['title'];
            $post->summary = $data['summary'];
            $post->body = $data['body'];
            if ($request->hasFile('image')){
                $image = $request->file('image');
                $filename = Auth::user()->id.'-'.time().'.'.$image->getClientOriginalExtension();
                Image::make($image)->save(public_path(Config::get('image.dir.post')).$filename);
                Image::make($image)->fit(230,130)->save(public_path(Config::get('image.dir.postThumb')).$filename);
                $post->image = $filename;
            }

//                foreach ($data['tags'] as $tag){
//                    $post->tags->attach($tag);
//                }
//                $post->category = $data['category'];
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
        $this->authorize('delete', $post);
        if ($post->delete())
            return redirect()->back()->with('message','Success');
        return redirect()->back()->with('message','Error delete post');
    }
}
