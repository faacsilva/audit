<?php

namespace Faacsilva\Audit\Traits;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Faacsilva\Audit\Persistence\ActivityLog;

trait Activity
{
    /**
     * Save an activity into database
     *
     * @param string $description
     * @param array  $param
     * @return void
     */
    static public function save($description, $param=null)
    {
        ActivityLog::create([
            'datetime' => Carbon::now(),
            'ip_address' => request()->ip(),
            'username' => (Auth::user()) ? Auth::user()->name : 'system' ,
            'origin' => (isset($param['origin'])) ? $param['origin'] : 'undefined',
            'event' => (isset($param['event'])) ? $param['event'] : 'undefined',
            'description' => $description
        ]);
    }
}