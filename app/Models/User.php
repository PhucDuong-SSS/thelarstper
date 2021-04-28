<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{


    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'organization_id',
        'full_name',
        'email',
        'password',
        'address',
        'date_of_birth'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role', 'user_id', 'role_id');
    }
    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id');
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function isSuperAdmin()
    {
        return $this->roles->contains('name', 'admin');
    }
    public function isOrganization()
    {
        return $this->roles->contains('name', 'organization_admin');
    }

    public function isWriter()
    {
        return $this->roles->contains('name', 'writer');
    }

    public function hasPermissionContains($permissionValue)
    {
        // Admin has all permissions
        if ($this->isSuperAdmin()) return true;

        $roles = $this->roles;
        foreach ($roles as $key => $role) {
            $permissions = $role->permissions;
            foreach ($permissions as $key => $permission) {

                if ($permission->name === $permissionValue) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
