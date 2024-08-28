<div id="tests">
    <h1>Tests</h1>
    <div class="tabs">
        <a href="#" id="test-management-btn" class="tab-link active">テスト管理</a>
        <a href="#" id="test-results-btn" class="tab-link">テスト結果</a>
        <a href="#" id="category-list-btn" class="tab-link">カテゴリ一覧</a>
    </div>
    {{-- テスト管理タブ --}}
    <div id="test-management" class="tab-content">
        <div style="margin-bottom: 3%;display:felx;">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="addTestModalLabel" id="addTestBtn">テスト追加</button>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="addCategoryModalLabel" id="addCategoryBtn">カテゴリ追加</button>
        </div>
        <table id="testTable" class="display">
            <thead>
                <tr>
                    <th></th>
                    <th>テスト名</th>
                    <th>カテゴリ</th>
                    <th>目標点数</th>
                    <th>実際の点数</th>
                    <th>実施日</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tests as $test)
                    <tr>
                        <td>
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#editTestModal-{{ $test->id }}">編集</button>
                        </td>
                        <td>{{ $test->test_name }}</td>
                        <td>{{ $test->category->category_name }}</td>
                        <td>{{ $test->target_score }}</td>
                        <td>{{ $test->actual_score }}</td>
                        <td>{{ $test->test_date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- テスト結果タブ --}}
    <div id="test-results" class="tab-content" style="display:none;">
        <h2>Tests Result</h2>
        <form id="testResultsForm">
            @csrf
            <label for="categories">カテゴリを選択:</label>
            <select class="form-select" id="categories" name="categories" multiple style="margin:10px 0;">
                @if ($categories->isEmpty())
                    <option disabled>登録済みカテゴリがありません</option>
                @else
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                    @endforeach
                @endif
            </select>
            <button type="button" id="loadTestResults" class="btn btn-primary">結果表示</button>
        </form>
        <canvas id="testResultsChart"></canvas>
        <div id="noCategorySelected" style="display:none;">カテゴリを選択してください。</div>
    </div>
    {{-- カテゴリ一覧 --}}
    <div class="tab-content" id="category-list">
        <table id="categoryTable" class="display">
            <thead>
                <tr>
                    <th></th>
                    <th>カテゴリ名</th>
                    <th>最終更新</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#editCategoryModal-{{ $category->id }}">編集</button>
                        </td>
                        <td>{{ $category->category_name }}</td>
                        <td>{{ $category->updated_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- モーダル --}}
    @include('tests._modals')
</div>