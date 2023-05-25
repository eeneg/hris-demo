<?php

namespace App\Listeners\UpdatePersonalInfo;

use App\ResidentialAddress;
use Illuminate\Http\Request;
use App\Events\PersonalInfoUpdated;

class ResidentialAddressUpdateListener
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
        $residentialaddresstable = array_filter(collect($this->request->residentialaddresstable)->except('id', 'personal_information_id', 'created_at', 'updated_at')->toArray());

        if (count($residentialaddresstable) > 0) {
            $event->pi->residentialaddresstable()->updateOrCreate(['personal_information_id' => $this->request->id], $this->request->residentialaddresstable);
        } elseif (array_key_exists('id', $this->request->residentialaddresstable)) {
            $residentialaddresstable = ResidentialAddress::find($this->request->residentialaddresstable['id']);
            if ($residentialaddresstable) {
                $residentialaddresstable->delete();
            }
        }
    }
}
