@extends('layouts.app')

@section('content')
<div class="container">
    <h1>お気に入り演習問題</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($favoriteExercises->isEmpty())
        <p>お気に入りに登録された演習問題はありません。</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>内容</th>
                    <th>作成日</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($favoriteExercises as $exercise)
                    <tr>
                        <td>{{ $exercise->id }}</td>
                        <td>{{ Str::limit($exercise->contents, 50) }}</td>
                        <td>{{ $exercise->created_at->format('Y-m-d H:i:s') }}</td>
                        <td>
                            <form action="{{ route('exercises.favorites.destroy', $exercise->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('お気に入りから削除しますか？')">削除</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
