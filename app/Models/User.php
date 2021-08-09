<?php

namespace App\Models;

use App\Observers\LogObserver;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'active_at' => 'datetime',
        'profile_photo_path' => 'json',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public static function boot()
    {
        parent::boot();

        User::observe(LogObserver::class);
    }

    public function userable()
    {
        return $this->morphTo();
    }

    public function session()
    {
        return $this->hasOne(Session::class, 'user_id');
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class, 'user_id');
    }

    public function logs()
    {
        return $this->hasMany(UserLog::class, 'user_id')
            ->orderBy('created_at', 'DESC');
    }

    public function createBy()
    {
        return User::find($this->created_by);
    }

    public function updateBy()
    {
        return User::find($this->updated_by);
    }

    public function deleteBy()
    {
        return User::find($this->deleted_by);
    }

    public function scopeVerified($query)
    {
        return $query->where('email_verified', 1);
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function avatars()
    {
        $photo = User::find($this->id)->profile_photo_path['filename'];

        $path = asset(config('custom.files.avatars.file'));
        if (!empty($photo)) {
            $path = Storage::url(config('custom.files.avatars.path').$photo);
        }

        return $path;
    }

    public function customConfig()
    {
        $config = [
            'active' => config('custom.label.active.'.$this->active),
            'email_verified' => config('custom.label.email_verified.'.$this->email_verified),
            'gender' => config('custom.label.gender.'.$this->profile->gender),
        ];

        return $config;
    }
}
