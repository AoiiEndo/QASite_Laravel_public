<div id="exercises-list" style="background-color: #2b3649; padding: 5%;">
    @if ($exercises->isEmpty())
        <p>該当する演習問題はありません。</p>
    @else
        @foreach ($exercises as $exercise)
            <div class="question" id="exercise-{{ $exercise->id }}" onclick="location.href='{{ route('exercises.show', ['id' => $exercise->id]) }}'">
                <div class="question-header">
                    <h2>{{ $exercise->title }}</h2>
                </div>
                <div class="info">
                    <span class="created-at" data-timestamp="{{ $exercise->created_at }}">{{ $exercise->created_at->diffForHumans() }}</span>
                    <span>{{ $exercise->user->name }}</span>
                </div>
            </div>
        @endforeach
    @endif
</div>