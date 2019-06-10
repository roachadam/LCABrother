<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class NewsLetterController extends Controller
{
    public function create(){
        $users = auth()->user()->organization->getVerifiedMembers();
        return view('newsletter.create', compact('users'));
    }

    public function store(Request $request){
        $attributes = $request->all();
        $newsLetterAtt = [
            'name' => $attributes['name']
        ];
        $newsLetter = auth()->user()->organization->addNewsletter($newsLetterAtt);

        if(isset($attributes['all'])){
            $users = auth()->user()->organization->users;
            foreach($users as $user)
            {
                $newsLetter->subscribers()->create([
                    'user_id' => $user->id
                ]);
                dump($user->name);
            }
        }
        elseif(isset($attributes['allUsers'])){
            $users = auth()->user()->organization->getVerifiedMembers();
            foreach($users as $user)
            {
                $newsLetter->subscribers()->create([
                    'user_id' => $user->id
                ]);
                dump($user->name);

            }
        }
        elseif(isset($attributes['allAlumni'])){
            $users = auth()->user()->organization->alumni;
            foreach($users as $user)
            {
                $newsLetter->subscribers()->create([
                    'user_id' => $user->id
                ]);
                dump($user->name);

            }
        }
        else{
            foreach($attributes['subscribers'] as $userId)
            {
                $user = User::find($userId);
                $newsLetter->subscribers()->create([
                    'user_id' => $user->id
                ]);
                dump($user->name);

            }
        }
    }
    public function send(){
        return view('newsletter.send');
    }
}
