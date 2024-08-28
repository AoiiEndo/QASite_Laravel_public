{{-- 作成モーダル --}}
<div class="modal fade" id="createExerciseModal" tabindex="-1" aria-labelledby="createExerciseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: gray;">
            <div class="modal-header">
                <h5 class="modal-title" id="createExerciseModalLabel">演習問題を作成</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createExerciseForm">
                    @csrf
                    <div class="form-group">
                        <label for="title">タイトル<span class="required">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="content">内容<span class="required">*</span>(LaTeXコードを使用する場合は\$で囲んでください。)</label>
                        <textarea id="content" name="content" rows="10" required placeholder="Content"></textarea>
                        <div id="preview" class="preview mt-3"></div>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="public_status" name="public_status">
                        <label class="form-check-label" for="public_status">公開</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                <button type="button" class="btn btn-primary" id="saveExerciseBtn">保存</button>
            </div>
        </div>
    </div>
</div>

