<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseLog extends Model
{
    protected $fillable = [
        'case_file_id',
        'user_id',
        'action',
    ];

    public function case()
    {
        return $this->belongsTo(CaseFile::class, 'case_file_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function caseFile()
{
    return $this->belongsTo(CaseFile::class);
}
}
