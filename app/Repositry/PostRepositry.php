<?php

namespace App\Repositry;

use App\Models\Post;
use App\Models\Admin;
use App\Models\PostPhotos;
use App\Traits\GeneralTrait;
use App\Interface\PostInterface;
use App\Notifications\AdminPost;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;


class PostRepositry implements PostInterface{

    use GeneralTrait;
    public function storePost($validator){

        $post = $validator->except('photos');
        $post['worker_id'] = Auth::guard('worker')->id();

        return $post = Post::create($post);

    }

    public function storePostPhotos($validator){

        $photos = [];

        foreach($validator->file('photos') as $photo){
            $photos [] = $photo->store('posts');
        }
        return $photos;
    }

    public function sendAdminNotification($post){

        $admins = Admin::get();
        Notification::send($admins, new AdminPost(auth('worker')->user(),$post));
    }

    public function store($validator){

        try{

        DB::beginTransaction();
        $post = $this->storePost($validator);
        $post_id = $post->id;
        if($validator->has('photos')){
            $photos = $this->storePostPhotos($validator);
            foreach($photos as $photo ){
                PostPhotos::create(['post_id'=>$post_id,'photo'=>$photo]);
            }

        }
        $this->sendAdminNotification($post);
        DB::commit();
        return $this->returnSuccessMessage(200,'post add sucsessfully');

    }catch(\Exception $e){

        DB::rollBack();
        return $this->returnError('202','exception',$e->getMessage());
    }

    }

}
