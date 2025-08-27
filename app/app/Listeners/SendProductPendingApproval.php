<?php

namespace App\Listeners;

use App\Events\ProductCreated;
use App\Models\User;
use App\Notifications\ProductPendingApproval;

class SendProductPendingApproval
{
    public function handle(ProductCreated $event): void
    {
        // notify all admins via database notification (queued)
        User::where('role', 'admin')
            ->get()
            ->each(function (User $admin) use ($event) {
                $admin->notify(new ProductPendingApproval($event->product));
            });
    }
}
