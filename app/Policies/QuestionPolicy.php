<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Question;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuestionPolicy
{
    use HandlesAuthorization;
    /**
     * Determine if the given question can be updated by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Question  $question
     * @return bool
     */
    public function update(User $user, Question $question)
    {
        return $user->id === $question->user_id;
    }
}
