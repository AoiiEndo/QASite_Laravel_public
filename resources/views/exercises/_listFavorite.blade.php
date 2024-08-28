<div id="exercises-favorite-list" style="background-color: #2b3649; padding: 5%;">
    @if ($favoriteExercises->isEmpty())
        <p>該当する演習問題はありません。</p>
    @else
        @foreach ($favoriteExercises as $favoriteExercise)
            <div class="question" id="exercise-{{ $favoriteExercise->id }}" onclick="location.href='{{ route('exercises.show', ['id' => $favoriteExercise->id]) }}'">
                <div class="question-header">
                    <h2>{{ $favoriteExercise->title }}</h2>
                </div>
                <div class="info">
                    <span class="created-at" data-timestamp="{{ $favoriteExercise->created_at }}">{{ $favoriteExercise->created_at->diffForHumans() }}</span>
                    <span>{{ $favoriteExercise->user->name }}</span>
                </div>
            </div>
        @endforeach
    @endif
</div>