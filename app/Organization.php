<?php

namespace App;

use App\Role;
use App\User;
use App\Goals;
use App\ServiceEvent;
use App\Involvement;
use App\Event;
use App\Survey;
use App\Academics;
use App\CalendarItem;
use App\NewsLetter;
use App\AttendanceEvent;
use App\Semester;
use App\Tasks;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = ['name', 'owner_id'];

    public function attendanceEvent()
    {
        return $this->hasMany(AttendanceEvent::class);
    }

    public function addAttendanceEvent($attributes)
    {
        return $this->AttendanceEvent()->create($attributes);
    }

    public function newsletter()
    {
        return $this->hasMany(NewsLetter::class);
    }

    public function addNewsletter($attributes)
    {
        return $this->NewsLetter()->create($attributes);
    }

    public function calendarItem()
    {
        return $this->hasMany(CalendarItem::class);
    }

    public function addCalendarItem($attributes)
    {
        return $this->calendarItem()->create($attributes);
    }

    public function calendarCatagories()
    {
        return $this->hasMany(CalendarCatagory::Class);
    }

    public function setCalendarCategories()
    {
        $this->addCalendarCategory('General', '#3fb06e');
        $this->addCalendarCategory('Meeting', '#3d91c9');
        $this->addCalendarCategory('Philanthropy', '#f9af2b');
        $this->addCalendarCategory('Socials', '#f05131');
        $this->addCalendarCategory('Ritual', '#4d5857');
    }

    public function addCalendarCategory($name, $color)
    {
        return $this->calendarCatagories()->create(['name' => $name, 'color' => $color]);
    }

    public function survey()
    {
        return $this->hasMany(Survey::class);
    }

    public function addSurvey($attributes)
    {
        return $this->survey()->create($attributes);
    }

    public function discussion()
    {
        return $this->hasMany(Discussion::class);
    }

    public function category()
    {
        return $this->hasMany(Category::class);
    }


    public function addRole($name)
    {
        return $this->roles()->create(['name' => $name]);
    }

    public function createAdmin()
    {
        $role = $this->addRole('Admin');
        $role->setAdminPermissions();
    }

    public function createBasicUser()
    {
        $role = $this->addRole('Basic');
        $role->setBasicPermissions();
    }

    public function getVerifiedMembers()
    {
        $members = $this->users()->where('organization_verified', 1)->get();
        return $members;
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function alumni()
    {
        return $this->users()->where('organization_verified', '=', '2');
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function roles()
    {
        return $this->hasMany(Role::class);
    }

    public function setGoals($attributes)
    {
        $goals = Goals::create($attributes);
        $this->goals()->save($goals);
    }

    public function goals()
    {
        return $this->hasOne(Goals::class);
    }

    public function serviceEvents()
    {
        return $this->hasMany(ServiceEvent::Class);
    }


    public function getActiveServiceEvents()
    {
        $activeSemester = $this->getActiveSemester();
        $activeServiceEvents = $this->serviceEvents()->where('created_at', '>', $activeSemester->start_date)->get();
        return $activeServiceEvents;
    }

    public function addInvolvementEvent($attributes, $newServiceEvents = null)
    {
        if ($newServiceEvents === null && $this->involvement->where('name', $attributes['name'])->isEmpty()) {
            return $this->involvement()->create($attributes);
        } else if ($newServiceEvents->where('name', $attributes['name'])->isEmpty()) {
            return $this->involvement()->create($attributes);
        }
    }

    public function involvement()
    {
        return $this->hasMany(Involvement::Class);
    }

    public function semester()
    {
        return $this->hasMany(Semester::class);
    }

    public function getActiveSemester()
    {
        return Semester::where([
            'organization_id' => $this->id,
            'active' => '1'
        ])->first();
    }

    public function addSemester($attributes)
    {
        return $this->semester()->create($attributes);
    }

    public function addEvent($attributes)
    {
        return $this->event()->create($attributes);
    }

    public function event()
    {
        return $this->hasMany(Event::Class);
    }

    public function getAverages()
    {
        $users = $this->getVerifiedMembers();
        $attributes = [];
        $count = 0;
        $tempService = 0;
        $tempMoney = 0;
        $tempPoints = 0;
        foreach ($users  as $user) {
            $count++;
            $tempService += $user->getServiceHours();
            $tempMoney += $user->getMoneyDonated();
            $tempPoints += $user->getInvolvementPoints();
        }
        $attributes['service'] = $tempService / $count;
        $attributes['money'] =  $tempMoney / $count;
        $attributes['points'] = $tempPoints / $count;

        return $attributes;
    }

    public function getTotals()
    {
        $users = $this->users;
        $attributes = [];
        $tempService = 0;
        $tempMoney = 0;
        $tempPoints = 0;
        foreach ($users  as $user) {
            $tempService += $user->getServiceHours();
            $tempMoney += $user->getMoneyDonated();
            $tempPoints += $user->getInvolvementPoints();
        }
        $attributes['service'] = $tempService;
        $attributes['money'] = $tempMoney;
        $attributes['points'] = $tempPoints;

        return $attributes;
    }

    public function getArrayOfServiceHours()
    {
        $users = $this->users;
        $attributes = [];
        $count = 0;
        $collection = collect();
        foreach ($users  as $user) {
            $collection->push($user->getServiceHours());
        }
        return $collection->toArray();
    }

    public function academics()
    {
        return $this->hasMany(Academics::Class);
    }

    public function academicStandings()
    {
        return $this->hasMany(AcademicStandings::class);
    }

    public function addAcademicStandings($attributes)
    {
        return $this->academicStandings()->create($attributes);
    }

    public function getStandingsAsc()
    {
        return $this->academicStandings()->orderBy('Term_GPA_Min', 'desc')->get();
    }

    public function getStandingsDsc()
    {
        return $this->academicStandings()->orderBy('Term_GPA_Min', 'asc')->get();
    }

    public function tasks()
    {
        return $this->hasMany(Tasks::class);
    }

    public function createTask($attributes)
    {
        return $this->tasks()->create($attributes);
    }
}
