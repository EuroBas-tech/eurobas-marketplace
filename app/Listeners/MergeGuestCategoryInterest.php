<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use App\Model\UserCategoryInterest;

class MergeGuestCategoryInterest
{
    public function handle($event)
    {
        $user    = $event->user;
        $guestId = session()->getId();

        $records = UserCategoryInterest::where('guest_id', $guestId)->get();

        foreach ($records as $record) {
            UserCategoryInterest::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'category_id' => $record->category_id,
                ],
                [
                    'score' => DB::raw('score + ' . $record->score),
                ]
            );
        }

        UserCategoryInterest::where('guest_id', $guestId)->delete();
    }
}
