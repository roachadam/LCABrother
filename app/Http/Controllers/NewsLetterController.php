<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\NewsLetter;
use Mail;
use Illuminate\Support\Carbon;
use App\Mail\NewsLetterGeneric;
class NewsLetterController extends Controller
{
    public function index(){
        $newsletters = auth()->user()->organization->newsletter;
        return view('newsletter.index', compact('newsletters'));
    }

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
            }
        }
        elseif(isset($attributes['allUsers'])){
            $users = auth()->user()->organization->getVerifiedMembers();
            foreach($users as $user)
            {
                $newsLetter->subscribers()->create([
                    'user_id' => $user->id
                ]);

            }
        }
        elseif(isset($attributes['allAlumni'])){
            $users = auth()->user()->organization->alumni;
            foreach($users as $user)
            {
                $newsLetter->subscribers()->create([
                    'user_id' => $user->id
                ]);

            }
        }
        else{
            foreach($attributes['subscribers'] as $userId)
            {
                $user = User::find($userId);
                $newsLetter->subscribers()->create([
                    'user_id' => $user->id
                ]);
            }
        }
    }
    public function edit(NewsLetter $newsletter){
        return view('newsletter.edit', compact('newsletter'));
    }
    public function subscribers(NewsLetter $newsletter){
        $subscribersz = $newsletter->subscribers;
        return view('newsletter.subscribers', compact('subscribersz', 'newsletter'));
    }
    public function showSend(){
        $newsletters = auth()->user()->organization->newsletter;
        return view('newsletter.send', compact('newsletters'));
    }

    public function send(Request $request){
        $attributes = $request->all();

        $newsletter = NewsLetter::find($attributes['newsletterId']);
        $newsletter->last_email_sent = Carbon::now();
        $newsletter->save();
        foreach($newsletter->subscribers as $subscriber){
            Mail::to($subscriber->user->email)->queue(
                new NewsLetterGeneric($newsletter, $attributes['body'])
            );
            if(env('MAIL_HOST', false) == 'smtp.mailtrap.io'){
                sleep(5);
            }
        }
        return redirect('/newsletter');
    }

}
