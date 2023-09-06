<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Models\Admin;
use App\Traits\GeneralTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminNotificationController extends Controller
{
    use GeneralTrait;
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        $admin = Admin::find(Auth::guard('admin')->id());
        // dd(Auth::guard('admin'));
        return $this->returnData(200,'notifications',$admin->notifications,'admin\'s notifications');

    }

    public function unreadNotification(){
        $admin = Admin::find(auth('admin')->id());

         return $this->returnData(200,'notifications',$admin->unreadNotifications,'admin\'s notifications');

    }

    public function markRead(){
        $admin = Admin::find(auth('admin')->id());
        foreach ($admin->unreadNotifications as $notification) {
            $notification->markAsRead();
        }
    return $this->returnData(200,'readed',$admin->unreadNotifications,'admin\'s notifications');
    }

    public function deleteNotification($id){

        $admin = Admin::find(auth('admin')->id());

        $notification=$admin->notifications()->where('id',$id)->delete();
        if(!$notification){
            return $this->returnError(201,'E001','not found');
        }
        return $this->returnSuccessMessage(200,'notification deleted');
    }
}
