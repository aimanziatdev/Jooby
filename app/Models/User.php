<?php
namespace App\Models;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = ['name','email','password','type','company_name','bio','linkedin','portfolio','avatar','phone'];
    protected $hidden = ['password','remember_token'];
    protected $casts = ['email_verified_at' => 'datetime'];
    public function listings() { return $this->hasMany(Listing::class); }
    public function projects() { return $this->hasMany(Project::class); }
    public function applications() { return $this->hasMany(Application::class); }
    public function offersReceived() { return $this->hasMany(Offer::class,'to_user_id'); }
    public function offersSent() { return $this->hasMany(Offer::class,'from_user_id'); }
    public function isCompany() { return $this->type === 'company'; }
    public function isPerson() { return $this->type === 'person'; }
    public function displayName() { return $this->isCompany() ? $this->company_name : $this->name; }
}
