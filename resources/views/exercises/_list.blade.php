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
                    @if ($exercise->user->id !== auth()->id())
                        @if (in_array($exercise->user->id, $followedUserIds))
                            <span class="followed-user">
                                {{ $exercise->user->name }}
                                <span style="color:#fe0505">&hearts;</span>
                                @if (in_array($exercise->id, $favoriteExerciseIds))
                                    <span style="color:#fffb00">&#9733;</span>
                                @else
                                    <span style="color:#fdfdfd">&#9733;</span>
                                @endif
                            </span>
                        @else
                            <span class="followed-user">
                                {{ $exercise->user->name }}
                                <span style="color:#fdfdfd">&hearts;</span>
                                @if (in_array($exercise->id, $favoriteExerciseIds))
                                    <span style="color:#fffb00">&#9733;</span>
                                @else
                                    <span style="color:#fdfdfd">&#9733;</span>
                                @endif
                            </span>
                        @endif
                    @endif
                </div>
            </div>
        @endforeach
    @endif
</div>