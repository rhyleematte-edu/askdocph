<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DoctorApplication;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminAnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $fromDate = $request->query('from_date');
        $toDate = $request->query('to_date');

        // Base query for applications with date filtering
        $query = DoctorApplication::query();

        if ($fromDate) {
            $query->where('created_at', '>=', Carbon::parse($fromDate)->startOfDay());
        }
        if ($toDate) {
            $query->where('created_at', '<=', Carbon::parse($toDate)->endOfDay());
        }

        // 1. Core KPIs
        $stats = [
            'total'     => (clone $query)->count(),
            'approved'  => (clone $query)->where('status', 'approved')->count(),
            'pending'   => (clone $query)->where('status', 'pending')->count(),
            'rejected'  => (clone $query)->where('status', 'rejected')->count(),
            'psych'     => (clone $query)->where(function($q) {
                                $q->where('professional_titles', 'LIKE', '%Psych%');
                           })->count(),
        ];

        // 2. Specialty Distribution (Top 5)
        $specialties = (clone $query)
            ->select('professional_titles', DB::raw('count(*) as count'))
            ->groupBy('professional_titles')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get();

        // 3. Demographic Distribution (Gender)
        // We join with users to get gender data
        $demographics = DB::table('doctor_applications')
            ->join('users', 'doctor_applications.user_id', '=', 'users.id')
            ->when($fromDate, function($q) use ($fromDate) {
                return $q->where('doctor_applications.created_at', '>=', Carbon::parse($fromDate)->startOfDay());
            })
            ->when($toDate, function($q) use ($toDate) {
                return $q->where('doctor_applications.created_at', '<=', Carbon::parse($toDate)->endOfDay());
            })
            ->select('users.gender', DB::raw('count(*) as count'))
            ->groupBy('users.gender')
            ->get();

        // 4. Formatting output for gender split
        $genderMap = [
            'male' => 'Male',
            'female' => 'Female',
            'other' => 'Other',
            'prefer_not_say' => 'Undisclosed'
        ];
        
        $genderData = [];
        foreach($demographics as $d) {
            $label = $genderMap[$d->gender] ?? ucfirst($d->gender ?: 'Unknown');
            $genderData[] = ['label' => $label, 'count' => $d->count];
        }

        return view('admin.analytics', compact('stats', 'specialties', 'genderData', 'fromDate', 'toDate'));
    }
}
