<?php

namespace App\Providers;

use App\Models\Question;
use App\Models\Answer;
use App\Policies\QuestionPolicy;
use App\Policies\AnswerPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Question::class => QuestionPolicy::class,
        Answer::class => AnswerPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
