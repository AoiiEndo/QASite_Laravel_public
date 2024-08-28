<div id="exercises-profile-list">
    <h1>My Exercises</h1>
    <div class="tabs">
        <a href="#" id="exercise-management-btn" class="tab-link active">Cleated</a>
        <a href="#" id="exercise-favorite-btn" class="tab-link">My Favorite</a>
    </div>
    {{-- 演習問題一覧タブ(自分の作成した) --}}
    <div id="exercises-management" class="tab-content">
        @include('exercises._list')
    </div>
    {{-- 演習問題一覧タブ(お気に入り) --}}
    <div id="exercises-favorite" class="tab-content" style="display:none;">
        @include('exercises._listFavorite')
    </div>
</div>