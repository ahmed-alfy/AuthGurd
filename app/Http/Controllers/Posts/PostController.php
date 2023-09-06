<?php

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostsRequests\StoringPostRequest;
use App\Interface\PostInterface;
use App\Repositry\PostRepositry;

class PostController extends Controller
{
    public function __construct(public PostInterface $postInterface){
        // $this->middleware(['ApiAuth:worker']);
        $this->middleware(['auth:worker']);
    }

    public function store(StoringPostRequest $request){

        try{
        return $this->postInterface->store($request);
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
}
