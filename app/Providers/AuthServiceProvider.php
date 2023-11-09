<?php

namespace App\Providers;

use App\Models\Blog;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('create-section', function ($user, Blog $blog) {
            return $user->id === $blog->employer->user_id;
        });
        Gate::define('update-section', function ($user, Blog $blog) {
            return $user->id === $blog->employer->user_id || $user->role === "admin";
        });
    }
}
