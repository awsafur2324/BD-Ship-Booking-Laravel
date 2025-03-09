<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\ShipDetail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class dashbordController extends Controller
{
    //
    function adminDashboard(Request $request)
    {
        // Top short data
        $totalShip = ShipDetail::count();
        $successBooking = Invoice::where('payment_status', 'Success')->count();
        $totalEarning = Invoice::where('payment_status', 'Success')->sum('payable');
        $manager = User::where(['role' => 'manager', 'email_verified' => 'true', 'manager_verified' => 'true'])->count();
        $user_count = User::where('role', 'user')->count();

        // Date-based earnings calculation
        $earnings = Invoice::selectRaw('departure_points.departure_date as date, SUM(invoices.payable) as total')
            ->join('departure_points', 'invoices.departure_id', '=', 'departure_points.id')
            ->where('invoices.payment_status', 'Success')
            ->groupBy('departure_points.departure_date')
            ->orderBy('departure_points.departure_date')
            ->get();

        // Extract labels (dates) and data (earnings)
        $labels = $earnings->map(function ($item) {
            return Carbon::parse($item->date)->format('d-m-Y');
        })->toArray();
        $data = $earnings->pluck('total')->toArray();

        return view('pages.dashboard.dashboard-admin', compact(
            'totalShip',
            'successBooking',
            'totalEarning',
            'manager',
            'user_count',
            'labels',
            'data'
        ));
    }

    function managerDashboard(Request $request)
    {
        $user_id = $request->header('id');
        // Top short data
        $totalShip = ShipDetail::where('user_id', $user_id)->count();
        $result = DB::table('invoices')
            ->join('ship_details', 'invoices.shipDetails_id', '=', 'ship_details.id')
            ->selectRaw('
            COUNT(*) as successBooking,
            SUM(CASE WHEN invoices.payment_status = "Success" THEN invoices.payable ELSE 0 END) as totalEarning
        ')
            ->where('ship_details.user_id', $user_id)
            ->where('invoices.payment_status', 'Success')
            ->first();

        // Extract values
        $successBooking = $result->successBooking ?? 0;
        $totalEarning = $result->totalEarning ?? 0;

        // Date-based earnings calculation
        $earnings = Invoice::selectRaw('departure_points.departure_date as date, SUM(invoices.payable) as total')
            ->join('departure_points', 'invoices.departure_id', '=', 'departure_points.id')
            ->join('ship_details', 'invoices.shipDetails_id', '=', 'ship_details.id')
            ->where('ship_details.user_id', $user_id)
            ->where('invoices.payment_status', 'Success')
            ->groupBy('departure_points.departure_date')
            ->orderBy('departure_points.departure_date')
            ->get();

        // Extract labels (dates) and data (earnings)
        $labels = $earnings->map(function ($item) {
            return Carbon::parse($item->date)->format('d-m-Y');
        })->toArray();
        $data = $earnings->pluck('total')->toArray();

        return view('pages.dashboard.dashboard-manager', compact(
            'totalShip',
            'successBooking',
            'totalEarning',
            'labels',
            'data'
        ));
    }

    function userDashboard(Request $request)
    {
        $user_id = $request->header('id');

        $totalBooking = DB::table('invoices')
            ->where('user_id', $user_id)
            ->count();

        // Fetch upcoming bookings (based on some condition, e.g., departure date in the future)
        $upcomingBooking = DB::table('invoices')
            ->join('departure_points', 'invoices.departure_id', '=', 'departure_points.id')
            ->where('invoices.user_id', $user_id)
            ->where('departure_points.departure_date', '>', now('Asia/Dhaka'))
            ->count();

        // Fetch total refund amount
        $totalRefunds = DB::table('refund_histories')
            ->join('invoices', 'refund_histories.invoices_id', '=', 'invoices.id')
            ->where('invoices.user_id', $user_id)
            ->sum('refund_histories.refund_amount');

        // Fetch data for the chart
        $totalAmounts = Invoice::where('user_id', $user_id)->sum('total');
        $payableAmounts = Invoice::where('user_id', $user_id)->sum('payable');
        $discountAmounts = $totalAmounts - $payableAmounts;
        
        // Pass data to the view
        return view('pages.dashboard.dashboard-user', [
            'totalBooking' => $totalBooking,
            'upcomingBooking' => $upcomingBooking,
            'totalRefunds' => $totalRefunds,
            'totalAmounts' => $totalAmounts,
            'payableAmounts' => $payableAmounts,
            'discountAmounts' => $discountAmounts,
        ]);
    }
}
