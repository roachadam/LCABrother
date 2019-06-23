<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\UserValidated;
use App\Listeners\UserWasValidated;
use App\Events\MemberDeclined;
use App\Listeners\MemberWasDeclined;
use App\Listeners\DuplicatedGuestWasInvited;
use App\Events\DuplicateGuestInvited;
use App\Events\GoalsNotifSent;
use App\Listeners\GoalsEmailWasSent;
use App\Events\MemberAnsweredSurvey;
use App\Listeners\EmailCreatorIfAllMembersRespond;
use App\Listeners\CheckForExistingAcademicModel;
use App\Events\OverrideAcademics;
use App\Listeners\NotifyOverrideAcademics;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UserValidated::class => [
            UserWasValidated::class,
            CheckForExistingAcademicModel::class,
        ],
        MemberDeclined::class => [
            MemberWasDeclined::class,
        ],
        DuplicateGuestInvited::class => [
            DuplicatedGuestWasInvited::class
        ],
        GoalsNotifSent::class => [
            GoalsEmailWasSent::class
        ],
        MemberRemovedFromOrg::class => [
            EmailRemovedMember::class
        ],
        MemberAnsweredSurvey::class => [
            EmailCreatorIfAllMembersRespond::class
        ],
        OverrideAcademics::class => [
            NotifyOverrideAcademics::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
