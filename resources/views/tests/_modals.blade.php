{{-- テスト追加 --}}
<div class="modal fade" id="addTestModal" tabindex="-1" aria-labelledby="addTestModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: gray;">
            <div class="modal-header">
                <h5 class="modal-title" id="addTestModalLabel">テスト追加</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addTestForm">
                    @csrf
                    <div class="mb-3">
                        <label for="test_name" class="form-label">テスト名<span class="required">*</span></label>
                        <input type="text" class="form-control" id="test_name" name="test_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="category_id" class="form-label">カテゴリ<span class="required">*</span></label>
                        <select class="form-select" id="category_id" name="category_id" required></select>
                    </div>
                    <div class="mb-3">
                        <label for="test_date" class="form-label">テスト実施日<span class="required">*</span></label>
                        <input type="text" class="form-control" id="test_date" name="test_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="target_score" class="form-label">目標得点<span class="required">*</span></label>
                        <input type="text" class="form-control" id="target_score" name="target_score" required>
                    </div>
                    <div class="mb-3">
                        <label for="result_score" class="form-label">結果得点</label>
                        <input type="text" class="form-control" id="result_score" name="result_score">
                    </div>
                    <button type="submit" class="btn btn-primary">追加</button>
                </form>
            </div>
        </div>
    </div>
</div>    

{{-- カテゴリ追加 --}}
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true" style="display:none;">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: gray;">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">カテゴリ追加</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addCategoryForm">
                    @csrf
                    <div class="mb-3">
                        <label for="category_name" class="form-label">カテゴリ名<span class="required">*</span></label>
                        <input type="text" class="form-control" id="category_name" name="category_name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">追加</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- テスト編集 --}}
@foreach ($tests as $test)
    <div class="modal fade" id="editTestModal-{{ $test->id }}" tabindex="-1" aria-labelledby="editTestModalLabel-{{ $test->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color: gray;">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTestModalLabel-{{ $test->id }}">テスト編集</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editTestForm-{{ $test->id }}">
                        @csrf
                        <div class="mb-3">
                            <label for="test_name-{{ $test->id }}" class="form-label">テスト名</label>
                            <input type="text" class="form-control" id="test_name-{{ $test->id }}" name="test_name" value="{{ $test->test_name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="category_id-{{ $test->id }}" class="form-label">カテゴリ</label>
                            <select class="form-select" id="category_id-{{ $test->id }}" name="category_id" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ $category->id == $test->category_id ? 'selected' : '' }}>
                                        {{ $category->category_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="test_date-{{ $test->id }}" class="form-label">実施日</label>
                            <input type="date" class="form-control" id="test_date-{{ $test->id }}" name="test_date" value="{{ $test->test_date }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="target_score-{{ $test->id }}" class="form-label">目標得点</label>
                            <input type="txet" class="form-control" id="target_score-{{ $test->id }}" name="target_score" value="{{ $test->target_score }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="actual_score-{{ $test->id }}" class="form-label">結果得点</label>
                            <input type="text" class="form-control" id="actual_score-{{ $test->id }}" name="actual_score" value="{{ $test->actual_score }}">
                        </div>
                        <button type="button" class="btn btn-primary saveEditTest" data-test-id="{{ $test->id }}">保存</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

{{-- カテゴリ一覧編集 --}}
@foreach ($categories as $category)
    <div class="modal fade" id="editCategoryModal-{{ $category->id }}" tabindex="-1" aria-labelledby="editCategoryModalLabel-{{ $category->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color: gray;">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel-{{ $category->id }}">カテゴリ編集</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editCategoryForm-{{ $category->id }}">
                        @csrf
                        <div class="mb-3">
                            <label for="Category_name-{{ $category->id }}" class="form-label">カテゴリ名</label>
                            <input type="text" class="form-control" id="Category_name-{{ $category->id }}" name="category_name" value="{{ $category->category_name }}" required>
                        </div>
                        <input name="category_id" value="{{ $category->id }}" type="hidden">
                        <button type="button" class="btn btn-primary saveEditCategory" data-test-id="{{ $category->id }}">保存</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach