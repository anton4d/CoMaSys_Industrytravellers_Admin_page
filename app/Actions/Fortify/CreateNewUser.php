<?php

namespace App\Actions\Fortify;

use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules, ProfileValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            ...$this->profileRules(),
            'password' => $this->passwordRules(),
        ])->validate();

        return User::create([
            'name'     => $input['name'],
            'email'    => $input['email'],
            'password' => $input['password'],
            'can_manage_locations' => $input['can_manage_locations'] ?? false,
            'can_manage_brands'    => $input['can_manage_brands'] ?? false,
            'can_manage_discounts' => $input['can_manage_discounts'] ?? false,
            'can_manage_users'     => $input['can_manage_users'] ?? false,
            'can_manage_admins'    => $input['can_manage_admins'] ?? false,
            'is_super_admin'       => $input['is_super_admin'] ?? false,
        ]);
    }
}
