<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model {
    protected $table = 'leaves';
    protected $fillable = ['nip','status','date'];
    protected $hidden = [ 'id' ];
}