<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
Use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_approved',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
             'is_approved' => 'boolean',
            'password' => 'hashed',
        ];
    }

       public function proDebates()
    {
        return $this->hasMany(Debate::class, 'pro_user_id');
    }

    public function conDebates()
    {
        return $this->hasMany(Debate::class, 'con_user_id');
    }

    public function judgedDebates()
    {
        return $this->hasMany(Debate::class, 'judge_id');
    }

    public function arguments()
    {
        return $this->hasMany(DebateArgument::class);
    }
}
