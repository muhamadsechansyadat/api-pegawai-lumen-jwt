<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model {
    protected $table = 'members';
    protected $fillable = ['company_id','division_id','religion_id','country_id','nip','member_name',
                            'gender','email','phone','address','date_birth','date_join','photo_profile',
                            'status','level'];
    // protected $hidden = [ 'id' ];

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

    public function educationalBackground(){
        return $this->hasMany('App\EducationalBackground', 'nip', 'nip');
    }
}