<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model {
    protected $table = 'contracts';
    protected $fillable = ['nip','date_start','date_end'];
    protected $hidden = [ 'id' ];
}