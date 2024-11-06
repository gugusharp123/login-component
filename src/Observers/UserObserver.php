<?php

namespace Avalon\LrvLogin\Observers;

use Avalon\LrvLogin\Services\EmailService;
use App\Models\User;

class UserObserver
{
    protected $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        $this->emailService->sendEmail([
            'email_from' => env('MAIL_FROM_ADDRESS', 'no-reply@example.org'),
            'email_to' => $user->email,
            'email_subject' => $userData['subject'],
            'email_content' => $userData['content']
        ]);
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        
    }
}
