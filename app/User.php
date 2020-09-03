<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    protected $fillable = ['company_id','division_id','religion_id','country_id','nip','member_name',
                            'gender','email','phone','address','date_birth','date_join','photo_profile',
                            'status','level'];

    public function company(){
        return $this->hasOne('App\Models\Company', 'id', 'company_id');
    }

    public function division(){
        return $this->hasOne('App\Models\Division', 'id', 'division_id');
    }

    public function religion(){
        return $this->hasOne('App\Models\Religion', 'id', 'religion_id');
    }

    public function country(){
        return $this->hasOne('App\Models\Countries', 'id', 'country_id');
    }

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    public function educationalBackgrounds()
    {
        return $this->hasMany('App\EducationalBackground', 'nip', 'nip');
    }
}
