<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Models\Tweet;
use App\Models\Models\Follower;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(User $user)
     {
         $all_users = $user->getAllUsers(auth()->user()->id);

         return view('users.index', [
             'all_users'  => $all_users
         ]);
     }

     // フォロー
     public function follow(User $user,$id)
     {
       $user = User::find($id);
       //var_dump($user);
       $follower = auth()->user();
       //フォローしているか
       $is_following = $follower->isFollowing($user->id);
       if(!$is_following) {
          //フォローしていなければする
           $follower->follow($user->id);
           return back();
       }
      }

     // フォロー解除
     public function unfollow(User $user,$id)
     {
       $user = User::find($id);
       //var_dump($user);
       $follower = auth()->user();
       // フォローしているか
       $is_following = $follower->isFollowing($user->id);
       if($is_following) {
           // フォローしていればフォローを解除する
           $follower->unfollow($user->id);
           return back();
      }
     }

     public function show(User $user, Tweet $tweet, Follower $follower)
    {
        $login_user = auth()->user();
        $is_following = $login_user->isFollowing($user->id);
        $is_followed = $login_user->isFollowed($user->id);
        $timelines = $tweet->getUserTimeLine($user->id);
        $tweet_count = $tweet->getTweetCount($user->id);
        $follow_count = $follower->getFollowCount($user->id);
        $follower_count = $follower->getFollowerCount($user->id);

        return view('users.show', [
            'user'           => $user,
            'is_following'   => $is_following,
            'is_followed'    => $is_followed,
            'timelines'      => $timelines,
            'tweet_count'    => $tweet_count,
            'follow_count'   => $follow_count,
            'follower_count' => $follower_count
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /** public function show($id)
    * {
    *    //
    * }
    **/

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function edit(User $user)
        {
            return view('users.edit', ['user' => $user]);
        }

        public function update(Request $request, User $user)
        {
            $data = $request->all();
            $validator = Validator::make($data, [
                'screen_name'   => ['required', 'string', 'max:50', Rule::unique('users')->ignore($user->id)],
                'name'          => ['required', 'string', 'max:255'],
                'profile_image' => ['file', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
                'email'         => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)]
            ]);
            $validator->validate();
            $user->updateProfile($data);

            return redirect('users/'.$user->id);
        }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     //ユーザー削除管理者
     public function shows(User $user)
     {
         $all_users = $user->getAllUsers(auth()->user()->id);
         return view('users.index', [
             'all_users'  => $all_users
         ]);
     }
     public function destroy(User $user)
     {
         $user->delete();
         return redirect()->route('users.index');
     }

     public function delete(User $user)
    {
        $user->delete();
        return redirect()->route('login');
    }
}
