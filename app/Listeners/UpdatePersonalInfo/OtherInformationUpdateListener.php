<?php

namespace App\Listeners\UpdatePersonalInfo;

use App\Events\PersonalInfoUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OtherInformationUpdateListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     *
     * @param  PersonalInfoUpdated  $event
     * @return void
     */
    public function handle(PersonalInfoUpdated $event)
    {
        if ($this->request->otherinfos !== null) {
            $arr = [];

            foreach ($this->request->otherinfos as $key => $value) {
                $bool = ! data_get($value, 'id') && ! data_get($value, 'skill') && ! data_get($value, 'recognition') && ! data_get($value, 'membership');

                if ($bool) {
                    DB::table('other_infos')->where('id', data_get($value, 'id'))->delete();
                } elseif (! $bool && count($value) > 0) {
                    array_push($arr, data_get($value, 'id'));
                    $event->pi->otherinfos()->updateOrCreate(['id' => data_get($value, 'id')], $value);
                }
            }

            DB::table('other_infos')->where('personal_information_id', $this->request->id)->whereNotIn('id', $arr)->delete();
        }
    }
}
