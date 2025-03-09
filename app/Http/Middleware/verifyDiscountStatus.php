<?php

namespace App\Http\Middleware;

use App\Models\AddDiscount;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class verifyDiscountStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $now = Carbon::now();

        // Update all discounts where finish date has passed and status is still active
        AddDiscount::where('discount_status', 'active')
            ->where('finishDate', '<', $now)
            ->update(['discount_status' => 'inactive']);

        return $next($request);
    }
}
