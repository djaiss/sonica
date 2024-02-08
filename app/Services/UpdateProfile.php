<?php

namespace App\Services;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\MustVerifyEmail;

/**
 * Update the information about the user.
 */
class UpdateProfile extends BaseService
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $email,
        public string $locale,
    ) {
    }

    public function execute(): void
    {
        $this->update();
    }

    private function update(): void
    {
        auth()->user()->first_name = $this->firstName;
        auth()->user()->last_name = $this->lastName;
        auth()->user()->locale = $this->locale;
        auth()->user()->save();

        if (auth()->user()->email !== $this->email) {
            auth()->user()->email_verified_at = null;
            auth()->user()->email = $this->email;
            auth()->user()->save();

            event(new Registered(auth()->user() instanceof MustVerifyEmail));
        }
    }
}
