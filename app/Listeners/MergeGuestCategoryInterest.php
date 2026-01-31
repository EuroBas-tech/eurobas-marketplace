<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\CPU\Helpers;
use Illuminate\Support\Facades\DB;
use App\Model\UserCategoryInterest;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MergeGuestCategoryInterest
{
    public function handle($event)
    {
        $user    = $event->user;
        $guestId = Helpers::deviceId();

        Log::debug($guestId);

        $records = UserCategoryInterest::where('guest_id', $guestId)->get();

        Log::debug($records);

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

        Log::debug('done');

        UserCategoryInterest::where('guest_id', $guestId)->delete();
    }
}
