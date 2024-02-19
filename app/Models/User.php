<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Grade;
use App\Models\Message;
use App\Models\Subject;
use App\Events\ChatSent;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'state',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function getUser($user_id)
    {
        return User::where('id', $user_id)->first();
    }

    public function sendMessage($user_id, $message, $sender)
    {
        $data['sender'] = Auth::user()->id;
        $data['receiver'] = $user_id;
        $data['message'] = $message;
        Message::create($data);
        $receiver= $this->getUser($user_id);
        $sender= $this->getUser($sender);
        \broadcast(new ChatSent($receiver, $message, $sender));
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver');
    }

    public function subjects()
    {
        return $this->hasManyThrough(
            Subject::class, // Target model
            Grade::class,   // Intermediate model
            'user_id',      // Foreign key on grades table
            'id',           // Local key on subjects table
            'id',           // Local key on users table
            'subject_id'    // Foreign key on grades table
        )->select('subjects.*'); // Specify the columns to select from the subjects table

    }





}
