<?php

namespace App\Models\Manage;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Ticket\TicketActivity;
use Illuminate\Support\Facades\DB;
use App\Models\Manage\UserRole;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $fillable = [ 'name', 'email', 'password', 'api_token' ];

    protected $hidden = [ 'password', 'remember_token', 'api_token' ];

    protected $casts = [ 'email_verified_at' => 'datetime' ];

    /**
     * Returns the roles assigned to the current user.
     */
    public function roles() {
        return $this->belongsToMany(Role::class, 'user_role')
                    ->using(UserRole::class)
                    ->withTimestamps();
    }

    /**
     * Determines if the user is assigned to the specified role/s.
     */
    public function hasRole($roleNames) {
        $roles = $this->roles;
        $roleNames = is_array($roleNames) ? array_map('strtolower', $roleNames) : $roleNames;

        foreach ($roles as $role) {
            if(
                (is_array($roleNames) && in_array(strtolower($role->name), $roleNames))
                ||
                (is_string($roleNames) && strcasecmp($roleNames, $role->name) == 0)
                ) {
                return true;
            }
        }
        return false;
    }

    public function tickets() {
        $latest_activity = TicketActivity::select('ticket_id', DB::raw(' MAX(created_at) as max_date'))
            ->groupBy('ticket_id');

        $recent = $this
            ->hasMany(TicketActivity::class, 'assignee_id')
            ->joinSub($latest_activity, 'latest_activity', function($q) {
                $q->on('latest_activity.ticket_id', '=', 'ticket_activity.ticket_id')
                ->on('latest_activity.max_date', '=', 'ticket_activity.created_at');
            })
            ->get();

        return $recent->pluck('ticket');
    }

    public function count_tickets()
    {
        $latest_activity = TicketActivity::select('ticket_id', DB::raw(' MAX(created_at) as max_date'))
            ->groupBy('ticket_id');

        $recent = $this
            ->hasMany(TicketActivity::class, 'assignee_id')
            ->joinSub($latest_activity, 'latest_activity', function($q) {
                $q->on('latest_activity.ticket_id', '=', 'ticket_activity.ticket_id')
                    ->on('latest_activity.max_date', '=', 'ticket_activity.created_at');
            })->where('ticket_activity.status_id',4)
            ->get();

        return $recent->count();
    }

    public static function storeFromRequest(Request $request)
    {
        $instance = parent::storeFromRequest($request);

        RoleUser::create([
            'role_id' => $request['role_id'],
            'user_id' => $instance->id
        ]);
    }

    public static function updateFromRequest(Request $request, $id)
    {
        $instance = parent::updateFromRequest($request, $id);

        if($instance) {
            $user_role = $instance->roles->first();
            $user_role->update($request->only(['role_id']))->save();
        }

        return $instance;
    }

        /**
     * The channels the user receives notification broadcasts on.
     *
     * @return string
     */
    public function receivesBroadcastNotificationsOn()
    {
        return 'App.User.'.$this->id;
    }

    public function routeNotificationForMail($notification)
    {
        return $this->email;
    }
}
