<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Models\Post;
use App\Traits\GeneralTrait;
use App\Notifications\AdminPost;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostStatusRequest;
use Illuminate\Support\Facades\Notification;


class PostStatusController extends Controller
{
    use GeneralTrait;
    public function changeStatus(PostStatusRequest $request){
        $post = Post::find($request->post_id)->first();
        $post->update([
            'status'=>$request->status,
            'reject_reason'=>$request->reject_reason??NUll,
        ]);
        if($post){
            Notification::send($post->worker, new AdminPost($post->worker,$post));
            return $this->returnData(200,'post',$post,'post is '.$request->status);
        }else{
            return  $this->returnError(403,'f0012','failed to update post');
        }
    }
}
