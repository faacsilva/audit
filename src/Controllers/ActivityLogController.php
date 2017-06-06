<?php

namespace Faacsilva\Audit\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Faacsilva\Audit\Persistence\ActivityLog;

class ActivityLogController extends Controller
{
    /**
     * Retrieve all activities
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $records = (array_key_exists('per_page', $request->all())) ? $request->get('per_page') : 15 ;
        $sort = (array_key_exists('sort', $request->all())) ? $request->get('sort') : 'datetime|desc';
        list($sortColumn, $sortDirection) = explode('|', $sort);

        $collection = Cache::remember('activities', 60, function() use($sortColumn, $sortDirection, $records) {
            return ActivityLog::orderBy($sortColumn, $sortDirection)
                              ->paginate($records);
        });

        if(array_key_exists('filter', $request->all())){
            $filter = $request->get('filter');
            $collection = ActivityLog::where('username', 'LIKE', "%{$filter}%")
                                     ->orWhere('datetime', 'LIKE', "%{$filter}%")
                                     ->orWhere('ip_address', 'LIKE', "%{$filter}%")
                                     ->orWhere('origin', 'LIKE', "%{$filter}%")
                                     ->orWhere('event', 'LIKE', "%{$filter}%")
                                     ->orderBy($sortColumn, $sortDirection)
                                     ->paginate($records);
        }

        if($collection->isEmpty()){
            return response()->json([]);
        }   

        return response()->json($collection);
    }
}