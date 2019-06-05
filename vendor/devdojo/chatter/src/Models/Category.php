<?php

namespace DevDojo\Chatter\Models;

use App\Organization;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'chatter_categories';
    protected $guarded = [];
    public $timestamps = true;
    public $with = 'parents';


    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
    public function discussions()
    {
        return $this->hasMany(Models::className(Discussion::class), 'chatter_category_id');
    }

    public function parents()
    {
        return $this->hasMany(Models::classname(self::class), 'parent_id')->orderBy('order', 'asc');
    }
}
