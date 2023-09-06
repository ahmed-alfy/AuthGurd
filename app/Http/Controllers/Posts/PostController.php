<?php

namespace App\Http\Controllers\Posts;

use App\Models\Post;
use App\Interface\PostInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostsRequests\StoringPostRequest;

class PostController extends Controller
{
    public function __construct(public PostInterface $postInterface){
        // $this->middleware(['ApiAuth:worker']);
        $this->middleware(['auth:worker']);
    }

    public function index(){
    $posts = Post::latest()->get();
        return response()->json(['post\'s'=>$posts]);
    }

    public function approved(){
        $posts = Post::latest()
        ->where('status','approved')
        ->get()
        ->makeHidden('status');
            return response()->json(['post\'s'=>$posts]);
        }
    public function store(StoringPostRequest $request){

        try{
        return $this->postInterface->store($request);
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
}
