<div id="question-list">
    <h2>My Questions</h2>
    @if ($questions->isEmpty())
        <p style="padding: 5%;">作成した問題がありません。</p>
    @else
        @foreach($questions as $question)
            <div class="question {{ !is_null($question->best_answer_id) ? 'resolved' : '' }}" id="question-{{ $question->id }}" onclick="location.href='{{ route('questions.show', ['id' => $question->id]) }}'">
                <div class="question-header">
                    <h2>{{ $question->title }}</h2>
                    <div class="tags">
                        @foreach($question->tags as $tag)
                            <span class="tag">{{ $tag }}</span>
                        @endforeach
                    </div>
                </div>
                <div class="info">
                    <span class="created-at" data-timestamp="{{ $question->created_at }}">{{ $question->created_at->diffForHumans() }}</span>
                    <span>{{ $user->name }}</span>
                </div>
            </div>
        @endforeach
    @endif
</div>