<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debate extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'pro_user_id',
        'con_user_id',
        'judge_id',
        'status',
        'started_at',
        'ends_at',
        'winner_id',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function proUser()
    {
        return $this->belongsTo(User::class, 'pro_user_id');
    }

    public function conUser()
    {
        return $this->belongsTo(User::class, 'con_user_id');
    }

    public function judge()
    {
        return $this->belongsTo(User::class, 'judge_id');
    }

    public function winner()
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    public function arguments()
    {
        return $this->hasMany(DebateArgument::class);
    }
}
