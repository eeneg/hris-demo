<?php

namespace App\Listeners\UpdatePersonalInfo;

use App\Events\PersonalInfoUpdated;
use App\permanentaddresstable;
use Illuminate\Http\Request;

class PermanentAddressUpdateListener
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
     * @param  object  $event
     * @return void
     */
    public function handle(PersonalInfoUpdated $event)
    {
        $permanentaddresstable = array_filter(collect($this->request->permanentaddresstable)->except('id', 'personal_information_id', 'created_at', 'updated_at')->toArray());

        if (count($permanentaddresstable) > 0) {
            $event->pi->permanentaddresstable()->updateOrCreate(['personal_information_id' => $this->request->id], $this->request->permanentaddresstable);
        } elseif (array_key_exists('id', $this->request->permanentaddresstable)) {
            $permanentaddresstable = PermanentAddress::find($this->request->permanentaddresstable['id']);
            if ($permanentaddresstable) {
                $permanentaddresstable->delete();
            }
        }
    }
}
