<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        'App\Events\PersonalInfoRegistered' => [
            'App\Listeners\CreatePersonalInfo\FamilyBackgroundCreateListener',
            'App\Listeners\CreatePersonalInfo\EducationalBackgroundCreateListener',
            'App\Listeners\CreatePersonalInfo\EligibilityCreateListener',
            'App\Listeners\CreatePersonalInfo\WorkExperienceCreateListener',
            'App\Listeners\CreatePersonalInfo\VoluntaryWorkCreateListener',
            'App\Listeners\CreatePersonalInfo\LearningAndDevelopmentCreateListener',
            'App\Listeners\CreatePersonalInfo\OtherInformationCreateListener',
            'App\Listeners\CreatePersonalInfo\PDSQuestionCreateListener',
        ],
        'App\Events\PersonalInfoUpdated' => [
            'App\Listeners\UpdatePersonalInfo\FamilyBackgroundUpdateListener',
            'App\Listeners\UpdatePersonalInfo\EducationalBackgroundUpdateListener',
            'App\Listeners\UpdatePersonalInfo\EligibilityUpdateListener',
            'App\Listeners\UpdatePersonalInfo\WorkExperienceUpdateListener',
            'App\Listeners\UpdatePersonalInfo\VoluntaryWorkUpdateListener',
            'App\Listeners\UpdatePersonalInfo\LearningAndDevelopmentUpdateListener',
            'App\Listeners\UpdatePersonalInfo\OtherInformationUpdateListener',
            'App\Listeners\UpdatePersonalInfo\PDSQuestionUpdateListener',
        ],
        'App\Events\EditRequestApproved' => [
            'App\Listeners\EditRequestApprovedListener',
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
