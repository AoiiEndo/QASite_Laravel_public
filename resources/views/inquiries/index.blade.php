@extends('layouts.app')

@section('content')
    <div class="container" style="background-color: #555555;">
        <h1>お問い合わせ内容管理</h1>
        @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <table id="inquiriesTable" class="table table-bordered">
            <thead>
                <tr>
                    <th></th>
                    <th>ID</th>
                    <th>メールアドレス</th>
                    <th>お問い合わせ内容</th>
                    <th>お問い合わせタイプ</th>
                    <th>ステータス</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inquiries as $inquiry)
                    <tr>
                        <td>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#editModal"
                                data-id="{{ $inquiry->id }}"
                                data-email="{{ $inquiry->email }}"
                                data-message="{{ $inquiry->message }}"
                                data-inquiry_type="{{ $inquiry->inquiry_type }}"
                                data-status="{{ $inquiry->status }}"
                                data-answer="{{ $inquiry->answer }}">
                                編集
                            </button>
                        </td>
                        <td>{{ $inquiry->id }}</td>
                        <td>{{ $inquiry->email }}</td>
                        <td>{{ $inquiry->message }}</td>
                        <td>{{ $inquiry->inquiry_type }}</td>
                        <td>{{ $inquiry->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color: gray;">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">お問い合わせ回答</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" class="modal-body">
                        @csrf
                        <input type="hidden" id="inquiry_id" name="inquiry_id">
    
                        <div class="mb-3">
                            <label for="email" class="form-label">メールアドレス</label>
                            <input type="email" id="email" name="email" class="form-control" readonly>
                        </div>
    
                        <div class="mb-3">
                            <label for="message" class="form-label">お問い合わせ内容</label>
                            <textarea id="message" name="message" class="form-control" rows="3" readonly></textarea>
                        </div>
    
                        <div class="mb-3">
                            <label for="inquiry_type" class="form-label">お問い合わせタイプ</label>
                            <input type="text" id="inquiry_type" name="inquiry_type" class="form-control" readonly>
                        </div>
    
                        <div class="mb-3">
                            <label for="status" class="form-label">ステータス</label>
                            <select id="status" name="status" class="form-select" required>
                                <option value="0">未解決</option>
                                <option value="1">解決済み</option>
                            </select>
                        </div>
    
                        <div class="mb-3">
                            <label for="answer" class="form-label">回答</label>
                            <textarea id="answer" name="answer" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="modal-footer">
                            {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button> --}}
                            <button type="submit" class="btn btn-primary">保存する</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>    
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
    $(document).ready(function() {
        $('#inquiriesTable').DataTable({
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

    const editButtons = document.querySelectorAll('button[data-toggle="modal"]');
    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const id = button.getAttribute('data-id');
            const email = button.getAttribute('data-email');
            const message = button.getAttribute('data-message');
            const inquiryType = button.getAttribute('data-inquiry_type');
            const status = button.getAttribute('data-status');
            const answer = button.getAttribute('data-answer');

            const modal = new bootstrap.Modal(document.getElementById('editModal'));
            modal.show();

            // モーダル内のフィールドに値をセット
            document.getElementById('inquiry_id').value = id;
            document.getElementById('email').value = email;
            document.getElementById('message').value = message;
            document.getElementById('inquiry_type').value = inquiryType == 0 ? 'プライバシーポリシーについて' : inquiryType == 1 ? '運営者について' : 'その他';
            document.getElementById('status').value = status;
            document.getElementById('answer').value = answer;
        });
    });


    document.getElementById('editForm').addEventListener('submit', function (event) {
        event.preventDefault(); // フォームのデフォルト送信を防ぐ

        const formData = new FormData(this);

        fetch("{{ route('inquiry.update') }}", {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => response.json())
        .then(data => {
            // モーダルを閉じる
            $('#editModal').modal('hide');

            // 更新されたデータをテーブルに反映
            const inquiryId = formData.get('inquiry_id');
            const statusText = formData.get('status') == '0' ? '未解決' : '解決済み';
            const answer = formData.get('answer');

            const row = document.querySelector(`#inquiriesTable tr[data-id="${inquiryId}"]`);
            if (row) {
                row.querySelector('td:nth-child(5)').innerText = statusText;
                row.querySelector('td:nth-child(6)').innerHTML = '<button class="btn btn-primary" data-toggle="modal" data-target="#editModal" data-id="'+ inquiryId +'" data-email="'+ row.querySelector('td:nth-child(3)').innerText +'" data-message="'+ row.querySelector('td:nth-child(4)').innerText +'" data-inquiry_type="'+ row.querySelector('td:nth-child(5)').innerText +'" data-status="'+ formData.get('status') +'" data-answer="'+ answer +'">編集</button>';
            }

            // 成功メッセージを表示
            alert('お問い合わせ内容が更新されました。');
        })
        .catch(error => {
            // エラーハンドリング
            alert('エラーが発生しました。');
        });
    });
});
</script>
@endsection
