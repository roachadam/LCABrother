<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Goals;
use Illuminate\Http\Request;
use App\Mail\GoalsNotify;
use App\Events\GoalsNotifSent;
use App\Mail\AcademicsSpecificStanding;
use App\Mail\AcademicsNotify;
use App\User;

class NotifyController extends Controller
{
    public function index(Goals $goals)
    {
        return view('notify.index', compact('goals'));
    }

    public function send(Request $request, Goals $goals)
    {

        $attributes = request()->validate([
            'goal_type' => 'required',
            'threshhold' => 'required',
        ]);
        $sent = false;
        $users = auth()->user()->organization->users;
        foreach ($users as $user) {
            switch ($attributes['goal_type']) {
                case 'points_goal':
                    if ($user->getInvolvementPoints() < $attributes['threshhold']) {
                        $sent = true;
                        Mail::to($user->email)->queue(
                            new GoalsNotify($user, 'Involvement Goal', $user->getInvolvementPoints(), $goals->points_goal)
                        );
                    }
                    break;
                case 'study_goal':
                    if (false) {
                        $sent = true;
                        Mail::to($user->email)->queue(
                            new GoalsNotify($user, 'Study Hours Goal', $user->getInvolvementPoints(), $goals->points_goal)
                        );
                    }
                    break;
                case 'service_hours_goal':
                    if ($user->getServiceHours() < $attributes['threshhold']) {
                        $sent = true;
                        Mail::to($user->email)->queue(
                            new GoalsNotify($user, 'Service Hours Goal', $user->getServiceHours(), $goals->service_hours_goal)
                        );
                    }
                    break;
                case 'service_money_goal':
                    if ($user->getMoneyDonated() < $attributes['threshhold']) {
                        $sent = true;
                        Mail::to($user->email)->queue(
                            new GoalsNotify($user, 'Money Donated Goal', $user->getMoneyDonated(), $goals->service_money_goal)
                        );
                    }
                    break;
            }
            Event(new GoalsNotifSent($sent));
        }
        return back();
    }

    public function sendAll(Goals $goals)
    {
        $users = auth()->user()->organization->users;

        $sent = false;
        foreach ($users as $user) {
            if ($user->getInvolvementPoints() < $goals->points_goal) {
                $sent = true;
                Mail::to($user->email)->queue(
                    new GoalsNotify($user, 'Involvement Goal', $user->getInvolvementPoints(), $goals->points_goal)
                );

            }
            if (false) {
                $sent = true;
                Mail::to($user->email)->queue(
                    new GoalsNotify($user, 'Study Hours Goal', $user->getInvolvementPoints(), $goals->points_goal)
                );
            }
            if ($user->getServiceHours() < $goals->service_hours_goal) {
                $sent = true;
                Mail::to($user->email)->queue(
                    new GoalsNotify($user, 'Service Hours Goal', $user->getServiceHours(), $goals->service_hours_goal)
                );
            }
            if ($user->getMoneyDonated() < $goals->service_money_goal) {
                $sent = true;
                Mail::to($user->email)->queue(
                    new GoalsNotify($user, 'Money Donated Goal', $user->getMoneyDonated(), $goals->service_money_goal)
                );
            }
        }
        Event(new GoalsNotifSent($sent));
        return back();
    }


    public function academicsNotifyAll(Request $request)
    {
        $users = auth()->user()->organization->users;

        foreach ($users as $user) {
            if ($user->academics->isNotEmpty()) {
                Mail::to($user->email)->queue(
                    new AcademicsNotify($user->latestAcademics())
                );
            }
        }
        return back();
    }

    public function academicsNotifySelected(Request $request, User $users)
    {
        $attributes = $request->validate([
            'users' => 'required'
        ]);

        foreach ($attributes['users'] as $userID) {
            $user = User::find($userID);
            if ($user->academics->isNotEmpty()) {
                Mail::to($user->email)->queue(
                    new AcademicsNotify($user->latestAcademics())
                );
            }
        }
        return back();
    }

    public function academicsNotifySpecificStanding(Request $request)
    {
        $attributes = request()->validate([
            'body' => 'required',
            'subject' => 'required',
            'academicStanding' => 'required',
        ]);

        $users = auth()->user()->organization->users;

        foreach ($users as $user) {
            if ($user->latestAcademics()->Current_Academic_Standing == $attributes['academicStanding']) {
                Mail::to($user->email)->queue(
                    new AcademicsSpecificStanding($attributes, $user->latestAcademics())
                );
            }
        }
        return redirect('/academics/manage');
    }
}
