// ###############################################
// URLをグローバル宣言
// ###############################################
window.routes = {
    exercisesStore: "exercises/store",
    exerciseGet: "exercises/get",
};

// ###############################################
// LaTeX表示
// ###############################################
document.getElementById('content').addEventListener('input', function() {
    var input = document.getElementById('content').value;
    var preview = document.getElementById('preview');
    
    var latexContent = input.replace(/\$(.*?)\$/g, '\\[$1\\]');
    preview.innerHTML =  latexContent;
    
    MathJax.typesetPromise([preview]).catch(function(err) {
    });
});

// ###############################################
// 作成
// ###############################################
document.getElementById('saveExerciseBtn').addEventListener('click', function () {
    const form = document.getElementById('createExerciseForm');
    const formData = new FormData(form);
    formData.append('public_status', document.getElementById('public_status').checked ? 1 : 0);

    fetch(window.routes.exercisesStore, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('演習問題を作成しました。');
            fetch(window.routes.exerciseGet, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const exercisesList = document.getElementById('exercises-list');
                    exercisesList.innerHTML = '';

                    data.exercises.forEach(exercise => {
                        const exerciseDiv = document.createElement('div');
                        exerciseDiv.classList.add('question');
                        exerciseDiv.id = `exercise-${exercise.id}`;
                        exerciseDiv.setAttribute('onclick', `location.href='/exercises/${exercise.id}'`);
                        const createdAtFormatted = dayjs(exercise.created_at).fromNow();
                        
                        exerciseDiv.innerHTML = `
                            <div class="question-header">
                                <h2>${exercise.title}</h2>
                            </div>
                            <div class="info">
                                <span class="created-at" data-timestamp="${exercise.created_at}">${createdAtFormatted}</span>
                                <span>${exercise.user.name}</span>
                            </div>
                        `;
                        
                        exercisesList.appendChild(exerciseDiv);
                    });
                }
            });
        }
    })
    .catch(error => {
        alert('予想外のエラーが発生しました。');
    });
});
document.addEventListener('DOMContentLoaded', function() {
    $(document).ready(function() {
        $('#exercisesTable').DataTable({
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