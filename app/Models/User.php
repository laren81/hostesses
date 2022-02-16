<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use RTippin\Messenger\Contracts\MessengerProvider;
use RTippin\Messenger\Traits\Messageable;
use RTippin\Messenger\Traits\Search;
use Illuminate\Database\Eloquent\Builder;
use DB;

use App\Notifications\GeneratePassword as GeneratePasswordNotification;

class User extends Authenticatable implements MessengerProvider
{
    use HasFactory, Notifiable, SoftDeletes, Messageable, Search;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'first_name','last_name','role_id','phone','email','password','profile_completed','active'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

   
    public static function getProviderSettings(): array
    {
        return [
            'alias' => 'user',
            'searchable' => true,
            'friendable' => true,
            'devices' => true,
            'default_avatar' => public_path('vendor/messenger/images/users.png'),
            'cant_message_first' => [],
            'cant_search' => [],
            'cant_friend' => [],
        ];
    }
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function sendPasswordGenerationNotification($token)
    {
        $this->notify(new GeneratePasswordNotification($token));
    }
    
    public function documents()
    {
        return $this->morphMany('App\Document', 'documentable');
    }
    
    public function role(){
        return $this->belongsTo('App\Models\Role');
    }
    
    public function getProviderName(): string{
        return strip_tags(ucwords($this->first_name." ".$this->last_name));
    }
    
    public static function getProviderSearchableBuilder(Builder $query, string $search,array $searchItems){
        $query->where(function (Builder $query) use ($searchItems) {
            foreach ($searchItems as $item) {
                $query->orWhere('first_name', 'LIKE', "%{$item}%")
                ->orWhere('last_name', 'LIKE', "%{$item}%");
            }
        })->orWhere('email', '=', $search);
    }
    
    
    public function unreadThreads(){
        
        return DB::table('threads')->leftJoin('participants','participants.thread_id','=','threads.id')->where('owner_id',$this->id)->whereRaw('participants.last_read<threads.updated_at')->select([DB::raw('count(distinct(threads.id)) as count_unread_threads')])->first()->count_unread_threads;
    }
    
    public function jobs(){
        return $this->hasMany('App\Models\Jobs');
    }
    
    public function hostess(){
        return $this->hasOne('App\Models\Hostess');
    }
}
