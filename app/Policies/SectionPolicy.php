<?php

namespace App\Policies;

use App\Models\Blog;
use App\Models\Section;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SectionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        return 
        $user->role === "admin"
        || 
        $user->role === "employer";
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Section $section)
    {
        return 
        $user->role === "admin"
        || 
        $user->role === "employer";
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        
        return 
        $user->role === "admin"
        || 
        $user->role === "employer";
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(?User $user, ?Section $section)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Section $section)
    {
        return 
        $user->role === "admin"
        || 
        $section->blog->employer->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Section $section)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Section $section)
    {
        //
    }
}
