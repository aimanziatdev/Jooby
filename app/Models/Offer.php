<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Offer extends Model {
    use HasFactory;
    protected $fillable = ['from_user_id','to_user_id','subject','message','status','salary_min','salary_max'];
    public function sender() { return $this->belongsTo(User::class,'from_user_id'); }
    public function receiver() { return $this->belongsTo(User::class,'to_user_id'); }
}
