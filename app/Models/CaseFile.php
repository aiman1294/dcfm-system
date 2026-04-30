<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseFile extends Model
{
    //
    protected $fillable = ['case_title', 'case_description', 'case_priority', 'case_status', 'user_id'];


}
