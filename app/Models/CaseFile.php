<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseFile extends Model
{
    //
    protected $fillable = ['case_title', 'case_description', 'case_priority', 'case_status', 'user_id','judge_id', 'hearing_date', 'judge_notes', 'verdict',];
    protected $casts = [
    'hearing_date' => 'date',
];

    public function judge(){
        return $this->belongsTo(User::class, 'judge_id');
    }

    public function logs()
    {
    return $this->hasMany(CaseLog::class);
    }
}
