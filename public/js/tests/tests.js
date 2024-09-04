document.addEventListener('DOMContentLoaded', function () {
    window.routes = {
        categoriesStore: "categories/store",
        testsResults: "tests/results",
        testStore: "tests/store",
        categoriesList: "categories/list",
    };

    // ###############################################
    // 詳細ページ表示
    // ###############################################
    document.querySelectorAll('.question').forEach(function(element) {
        element.addEventListener('click', function() {
            const url = this.getAttribute('data-url');
            window.location.href = url;
        });
    });
    document.querySelectorAll('.exercise').forEach(function(element) {
        element.addEventListener('click', function() {
            const exerciseId = this.getAttribute('data-exercise-id');
            window.location.href = `/exercises/${exerciseId}`;
        });
    });
    document.querySelectorAll('.favorite-exercise').forEach(function(element) {
        element.addEventListener('click', function() {
            const url = this.getAttribute('data-url'); 
            window.location.href = url;
        });
    });

    // その他の初期化コード
    dayjs.extend(dayjs_plugin_relativeTime);
    dayjs.locale('ja');

    // ###############################################
    // タブの表示切り替え(質問 & テスト)
    // ###############################################
    const myQuestionsBtn = document.getElementById('my-questions-btn');
    const testsBtn = document.getElementById('tests-btn');
    const exerciseBtn = document.getElementById('my-exercise-btn');
    const myQuestionsDiv = document.getElementById('question-list');
    const testsDiv = document.getElementById('tests');
    const exerciseDiv = document.getElementById('exercises-list');

    function showMyQuestions() {
        myQuestionsDiv.style.display = 'block';
        testsDiv.style.display = 'none';
        exerciseDiv.style.display = 'none';
        myQuestionsBtn.classList.add('active');
        testsBtn.classList.remove('active');
        exerciseBtn.classList.remove('active');
    }

    function showTests() {
        myQuestionsDiv.style.display = 'none';
        testsDiv.style.display = 'block';
        exerciseDiv.style.display = 'none';
        myQuestionsBtn.classList.remove('active');
        testsBtn.classList.add('active');
        exerciseBtn.classList.remove('active');
    }

    function showExercise() {
        myQuestionsDiv.style.display = 'none';
        testsDiv.style.display = 'none';
        exerciseDiv.style.display = 'block';
        myQuestionsBtn.classList.remove('active');
        testsBtn.classList.remove('active');
        exerciseBtn.classList.add('active');
    }

    // 初期表示で My Questions タブを表示
    showMyQuestions();

    myQuestionsBtn.addEventListener('click', function(event) {
        event.preventDefault();
        showMyQuestions();
    });

    testsBtn.addEventListener('click', function(event) {
        event.preventDefault();
        showTests();
    });

    exerciseBtn.addEventListener('click', function(event) {
        event.preventDefault();
        showExercise();
    });

    // ###############################################
    // カテゴリ追加
    // ###############################################
    const addCategoryForm = document.getElementById('addCategoryForm');
    addCategoryForm.addEventListener('submit', function(event) {
        event.preventDefault();

        let formData = new FormData(this);

        fetch(window.routes.categoriesStore, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(errorData => {
                    throw errorData;
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                alert('カテゴリが正常に追加されました。');
                // カテゴリセレクトボックス更新
                updateCategorySelectBox();
                updateCategoryTable();
            } else {
                alert('カテゴリの追加に失敗しました。');
            }
        })
        .catch(error => {
            if (error.errors) {
                const messages = Object.values(error.errors).flat();
                alert("エラーが発生しました。");
            } else {
                alert('予期しないエラーが発生しました。');
            }
        });
    });

    // ###############################################
    // カテゴリをロード
    // ###############################################
    function updateCategorySelectBox() {
        fetch(window.routes.categoriesList)
        .then(response => {
            if (!response.ok) {
                throw new Error('カテゴリの取得に失敗しました。');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                const categories = data.category;

                // テスト追加モーダルのセレクトボックス
                const addTestSelect = document.getElementById('category_id');
                addTestSelect.innerHTML = '';
                addTestSelect.appendChild(new Option('選択してください', '', true, true));

                // テスト編集モーダルのセレクトボックス
                document.querySelectorAll('[id^="category_id-"]').forEach(select => {
                    select.innerHTML = '';
                    select.appendChild(new Option('選択してください', '', true, true));
                });

                // テスト結果のセレクトボックス
                const testResultsSelect = document.getElementById('categories');
                testResultsSelect.innerHTML = '';

                // 上記３つのセレクトボックスを更新
                categories.forEach(category => {
                    const newOption = new Option(category.category_name, category.id);
                    addTestSelect.add(newOption.cloneNode(true));

                    document.querySelectorAll('[id^="category_id-"]').forEach(select => {
                        select.add(newOption.cloneNode(true));
                    });

                    testResultsSelect.add(newOption.cloneNode(true));
                });
            } else {
                alert('カテゴリの追加に失敗しました');
            }
        })
        .catch(error => {
            alert(error.message);
        });
    }
    
    // カテゴリセレクトボックスをprofile画面読み込み時にロード
    updateCategorySelectBox();

    // ###############################################
    // カレンダーの読み込み
    // ###############################################
    flatpickr('#test_date', {
        enableTime: false,
        dateFormat: "Y-m-d",
        locale: "ja"
    });

    // ###############################################
    // テスト追加
    // ###############################################
    const addTestForm = document.getElementById('addTestForm');
    addTestForm.addEventListener('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(this);
        fetch(window.routes.testStore, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(errorData => {
                    throw errorData;
                });
            }
            return response.json();
        })
        .then(data => {
            alert(data.message);
            // テーブルの再描画
            appendTestToTable(data.test);
        })
        .catch(error => {
            if (error.errors) {
                const messages = Object.values(error.errors).flat();
                alert(messages.join('\n'));
            }
        });
    });

    // ###############################################
    // テストデータ追加処理後のテーブル再描画
    // ###############################################
    function appendTestToTable(test) {
        const tableBody = document.querySelector('#testTable tbody');
        const newRow = tableBody.insertRow();
    
        newRow.innerHTML = `
            <td>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#editTestModal-${test.id}">編集</button>
            </td>
            <td>${test.test_name}</td>
            <td>${test.category.category_name}</td>
            <td>${test.target_score}</td>
            <td>${test.actual_score || '-'}</td>
            <td>${test.test_date}</td>
        `;
    
        addEditButtonEventListener(newRow.querySelector('button'), test.id);
    }

    // ###############################################
    // テストデータ編集
    // ###############################################
    document.querySelectorAll('.saveEditTest').forEach(button => {
        button.addEventListener('click', function() {
            const testId = this.dataset.testId;
            const form = document.getElementById(`editTestForm-${testId}`);
            testUpdate = `tests/update/${testId}`
            const formData = new FormData(form);
    
            fetch(testUpdate, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(errorData => {
                        throw errorData;
                    });
                }
                return response.json();
            })
            .then(data => {
                alert(data.message);
                // テーブルの再描画
                updateTestInTable(data.test);
            })
            .catch(error => {
                if (error.errors) {
                    const messages = Object.values(error.errors).flat();
                    alert(messages.join('\n'));
                }
            });
        });
    });

    // ###############################################
    // テストデータ編集のテーブル再描画
    // ###############################################
    function updateTestInTable(test) {
        const row = document.querySelector(`#testTable button[data-bs-target="#editTestModal-${test.id}"]`).closest('tr');
    
        row.cells[1].textContent = test.test_name;
        row.cells[2].textContent = test.category.category_name;
        row.cells[3].textContent = test.target_score;
        row.cells[4].textContent = test.actual_score || '-';
        row.cells[5].textContent = test.test_date;
    }

    // ###############################################
    // テスト管理 & テスト結果 & カテゴリ一覧　タブ切り替え
    // ###############################################
    const testManagementBtn = document.getElementById('test-management-btn');
    const testResultsBtn = document.getElementById('test-results-btn');
    const categoryListBtn = document.getElementById('category-list-btn');
    const testManagementDiv = document.getElementById('test-management');
    const testResultsDiv = document.getElementById('test-results');
    const categoryListDiv = document.getElementById('category-list');

    function showTestManagement() {
        testManagementDiv.style.display = 'block';
        testResultsDiv.style.display = 'none';
        categoryListDiv.style.display = 'none';
        testManagementBtn.classList.add('active');
        testResultsBtn.classList.remove('active');
        categoryListBtn.classList.remove('active');
    }

    function showTestResults() {
        testManagementDiv.style.display = 'none';
        testResultsDiv.style.display = 'block';
        categoryListDiv.style.display = 'none';
        testManagementBtn.classList.remove('active');
        testResultsBtn.classList.add('active');
        categoryListBtn.classList.remove('active');
    }

    function showCategoryList() {
        testManagementDiv.style.display = 'none';
        testResultsDiv.style.display = 'none';
        categoryListDiv.style.display = 'block';
        testManagementBtn.classList.remove('active');
        testResultsBtn.classList.remove('active');
        categoryListBtn.classList.add('active');
    }

    // デフォルトでテスト管理画面を表示
    showTestManagement();

    testManagementBtn.addEventListener('click', showTestManagement);
    testResultsBtn.addEventListener('click', showTestResults);
    categoryListBtn.addEventListener('click', showCategoryList);

    // ###############################################
    // 作成した演習問題　& お気に入り　タブ切り替え
    // ###############################################
    const exerciseManagementBtn = document.getElementById('exercise-management-btn');
    const exerciseFavoriteBtn = document.getElementById('exercise-favorite-btn');
    const exercisesListDiv = document.getElementById('exercises-management');
    const exercisesFavoriteListDiv = document.getElementById('exercises-favorite');

    function showExercisesList() {
        exerciseManagementBtn.classList.add('active');
        exerciseFavoriteBtn.classList.remove('active');
        exercisesListDiv.style.display = 'block';
        exercisesFavoriteListDiv.style.display = 'none';
    }

    function showExercisesFavoriteList() {
        exerciseManagementBtn.classList.remove('active');
        exerciseFavoriteBtn.classList.add('active');
        exercisesListDiv.style.display = 'none';
        exercisesFavoriteListDiv.style.display = 'block';
    }

    showExercisesList();

    exerciseManagementBtn.addEventListener('click', showExercisesList);
    exerciseFavoriteBtn.addEventListener('click', showExercisesFavoriteList);


    // ###############################################
    // カテゴリ選択の結果表示処理(グラフ)
    // ###############################################
    let chartInstance = null;
    document.getElementById('loadTestResults').addEventListener('click', function() {
        const selectedCategories = Array.from(document.getElementById('categories').selectedOptions).map(option => option.value);

        if (selectedCategories.length === 0) {
            document.getElementById('noCategorySelected').style.display = 'block';
            return;
        } else {
            document.getElementById('noCategorySelected').style.display = 'none';
        }
    
        fetch(window.routes.testsResults, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ categories: selectedCategories })
        })
        .then(response => response.json())
        .then(data => {
            const ctx = document.getElementById('testResultsChart').getContext('2d');
            
            const datasets = data.map((testResult, index) => {
                const color = randomColor();
                return {
                    label: testResult.test_name,
                    borderColor: color,
                    backgroundColor: color,
                    fill: false,
                    data: testResult.results.map(result => ({
                        x: result.date,
                        y: result.score
                    }))
                };
            });
    
            if (chartInstance) {
                chartInstance.data.datasets = datasets;
                chartInstance.update();
            } else {
                chartInstance = new Chart(ctx, {
                    type: 'line',
                    data: {
                        datasets: datasets
                    },
                    options: {
                        scales: {
                            x: {
                                type: 'time',
                                time: {
                                    unit: 'day'
                                }
                            },
                            y: {
                                beginAtZero: true,
                                max: 200
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        },
                        animation: {
                            onComplete: function() {
                                document.getElementById('testResultsChart').style.backgroundColor = '#fff';
                            }
                        }
                    }
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });

    // ###############################################
    // 適当な色を出力
    // ###############################################
    function randomColor() {
        return 'rgb(' + Math.floor(Math.random() * 256) + ',' +
                       Math.floor(Math.random() * 256) + ',' +
                       Math.floor(Math.random() * 256) + ')';
    }
    
    // ###############################################
    // カテゴリ編集
    // ###############################################
    document.querySelectorAll('.saveEditCategory').forEach(button => {
        button.addEventListener('click', function() {
            const testId = this.dataset.testId;
            const form = document.getElementById(`editCategoryForm-${testId}`);
            testUpdate = `categories/update/${testId}`
            const formData = new FormData(form);
    
            fetch(testUpdate, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(errorData => {
                        throw errorData;
                    });
                }
                return response.json();
            })
            .then(data => {
                alert(data.message);
                // テーブルの再描画
                updateTestTable(data.test);
                updateCategoryTable(data.categories);
                updateCategorySelectBox()
            })
            .catch(error => {
                if (error.errors) {
                    const messages = Object.values(error.errors).flat();
                    alert(messages.join('\n'));
                } else {
                    alert('予期しないエラーが発生しました。');
                }
            });
        });
    });

    // ###############################################
    // カテゴリ更新後にテストテーブルの情報を更新
    // ###############################################
    function updateTestTable(tests) {
        const table = $('#testTable').DataTable();
        table.clear();
    
        tests.forEach(test => {
            table.row.add([
                `<button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#editTestModal-${test.id}">編集</button>`,
                test.test_name,
                test.category.category_name,
                test.target_score,
                test.actual_score,
                test.test_date
            ]).draw();
        });
    }
    // ###############################################
    // カテゴリ更新後にカテゴリテーブルの情報を更新
    // ###############################################
    function updateCategoryTable(categories) {
        const table = $('#categoryTable').DataTable();
        table.clear();
    
        categories.forEach(category => {
            table.row.add([
                `<button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#editCategoryModal-${category.id}">編集</button>`,
                category.category_name,
                formatDate(category.updated_at)
            ]).draw();
        });
    }

    // ###############################################
    // 日付データを正しい形に変換
    // ###############################################
    function formatDate(dateString) {
        const date = new Date(dateString);
    
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0'); // 月は0から始まるので1を足す
        const day = String(date.getDate()).padStart(2, '0');
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
        const seconds = String(date.getSeconds()).padStart(2, '0');
    
        return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
    }

    // ###############################################
    // モーダル表示処理
    // ###############################################
    const addCategoryBtn = document.getElementById('addCategoryBtn');
    const addTestBtn = document.getElementById('addTestBtn');
    const testModals = document.querySelectorAll('[id^="editTestModal-"]');
    
    if (addCategoryBtn) {
        addCategoryBtn.addEventListener('click', function() {
            const modal = new bootstrap.Modal(document.getElementById('addCategoryModal'));
            modal.show();
        });
    }

    if (addTestBtn) {
        addTestBtn.addEventListener('click', function() {
            const modal = new bootstrap.Modal(document.getElementById('addTestModal'));
            modal.show();
        });
    }

    testModals.forEach(modal => {
        const editTestBtn = document.querySelector(`#editTestBtn-${modal.id.split('-')[1]}`);
        if (editTestBtn) {
            editTestBtn.addEventListener('click', function() {
                const modalInstance = new bootstrap.Modal(modal);
                modalInstance.show();
            });
        }
    });
});

// ###############################################
// データテーブル描画
// ###############################################
document.addEventListener('DOMContentLoaded', function() {
    $(document).ready(function() {
        $('#testTable').DataTable({
            paging: true,
            searching: true,
            info: true,
            lengthChange: true,
            language: {
                "decimal": "",
                "emptyTable": "テーブルにデータがありません",
                "info": "全 _TOTAL_ 件中 _START_ から _END_ まで表示",
                "infoEmpty": "0 件中 0 から 0 まで表示",
                "infoFiltered": "（全 _MAX_ 件からフィルタリング）",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "_MENU_ 件表示",
                "loadingRecords": "読み込み中...",
                "processing": "処理中...",
                "search": "検索:",
                "zeroRecords": "一致するレコードがありません",
                "paginate": {
                    "first": "先頭",
                    "last": "最終",
                    "next": "次",
                    "previous": "前"
                },
                "aria": {
                    "sortAscending": ": 昇順でソート",
                    "sortDescending": ": 降順でソート"
                }
            }
        });
        $('#categoryTable').DataTable({
            paging: true,
            searching: true,
            info: true,
            lengthChange: true,
            language: {
                "decimal": "",
                "emptyTable": "テーブルにデータがありません",
                "info": "全 _TOTAL_ 件中 _START_ から _END_ まで表示",
                "infoEmpty": "0 件中 0 から 0 まで表示",
                "infoFiltered": "（全 _MAX_ 件からフィルタリング）",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "_MENU_ 件表示",
                "loadingRecords": "読み込み中...",
                "processing": "処理中...",
                "search": "検索:",
                "zeroRecords": "一致するレコードがありません",
                "paginate": {
                    "first": "先頭",
                    "last": "最終",
                    "next": "次",
                    "previous": "前"
                },
                "aria": {
                    "sortAscending": ": 昇順でソート",
                    "sortDescending": ": 降順でソート"
                }
            }
        });
    });
});