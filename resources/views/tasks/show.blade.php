@extends('layouts.app')

@section('content')

    <h1>id = {{ $task->id }} の内容詳細ページ</h1>

    <table class="table table-bordered">
        <tr>
            <th>id</th>
            <td>{{ $task->id }}</td>
        </tr>
        <tr>
            <th>ステータス</th>
            <td>{{ $task->status }}</td>
        </tr>
        
        <tr>
            <th>内容（やるべき事）</th>
            <td>{{ $task->content }}</td>
        </tr>
    </table>
        <div class="btn-group">{!! link_to_route('tasks.edit', 'このタスクを編集', ['id' => $task->id], ['class' => 'btn btn-success']) !!}</div>
        {!! Form::model($task, ['route' => ['tasks.destroy', $task->id], 'method' => 'delete']) !!}
        {!! Form::submit('削除', ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!}
@endsection