<?php

namespace App\Console\Commands;

use App\Models\AddDiscount;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateDiscountStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'discount:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update discount status to inactive if finish date has passed.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();

        // Update all discounts where finish date has passed and status is still active
        AddDiscount::where('discount_status', 'active')
            ->where('finishDate', '<', $now)
            ->update(['discount_status' => 'inactive']);

        $this->info('Discount statuses updated successfully.');
    }
}
