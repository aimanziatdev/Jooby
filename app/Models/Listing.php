<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Listing extends Model {
    use HasFactory;
    protected $fillable = ['title','company','location','website','email','tags','description','logo','user_id','type','salary_min','salary_max'];
    public function scopeFilter($query, array $filters) {
        if($filters['tag'] ?? false) $query->where('tags','like','%'.request('tag').'%');
        if($filters['search'] ?? false) {
            $query->where('title','like','%'.request('search').'%')
                ->orWhere('description','like','%'.request('search').'%')
                ->orWhere('tags','like','%'.request('search').'%')
                ->orWhere('company','like','%'.request('search').'%');
        }
        if($filters['type'] ?? false) $query->where('type', request('type'));
    }
    public function user() { return $this->belongsTo(User::class,'user_id'); }
    public function applications() { return $this->hasMany(Application::class); }
}
