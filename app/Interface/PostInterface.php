<?php

namespace App\Interface;

interface PostInterface {


    public function storePost($validator);
    public function storePostPhotos($validator);
    public function sendAdminNotification($post);
    public function store($validator);

}
