<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class EducationalBackground extends Model {
    protected $table = 'educational_backgrounds';
    protected $fillable = ['nip','educational_name','school_level','school_majors','join_year','graduation_year'];
    // protected $hidden = [ 'id' ];
}