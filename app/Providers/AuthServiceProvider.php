<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Arr;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // Model::class => ModelPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function (User $user, string $ability): ?bool {
            $superAbilities = config('constants.superadmin_abilities', []);
            $superadmins = config('constants.superadmin_usernames', []);

            if (in_array($ability, $superAbilities, true)) {
                return Arr::contains(
                    array_map('strtolower', $superadmins),
                    strtolower($user->username)
                ) ? true : null;
            }

            if ($user->hasRole('Admin')) {
                return true;
            }
            return null;
        });
    }
}
