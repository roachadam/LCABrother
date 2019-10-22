<?php

namespace App\Http\Controllers;

class ContactController extends Controller
{
    public function userContacts()
    {
        $org = auth()->user()->organization;
        $members = $org->getActiveMembers();
        return view('user.userInfo.contact', compact('members'));
    }
}
