<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnswerPolicy
{
    use HandlesAuthorization;

    public function setBestAnswer(User $user, Answer $answer)
    {
        // 例: ユーザーが質問者である場合にのみ認可
        return $user->user_id === $answer->user_id;
    }
}
