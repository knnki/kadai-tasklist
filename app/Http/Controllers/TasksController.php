<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;    // 追加

class tasksController extends Controller
{
    // getでtasks/にアクセスされた場合の「一覧表示処理」
    public function index()
    {
        $data = [];
        if (\Auth::check()) {
           
                $user = \Auth::user();
                $tasks = $user->tasks()->paginate();
               //$tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(25);
            
                $data = [
                    'user' => $user,
                    'tasks' => $tasks,
                ];
            
            //$tasks = Task::orderBy('id', 'desc')->paginate(25);
            
            return view('tasks.index', [
                'tasks' => $tasks,
            ]);
            
            
        }
        
        return view('welcome', $data);
        
        
    }

    // getでtasks/createにアクセスされた場合の「新規登録画面表示処理」
    public function create()
    {
        $task = new Task;

        return view('tasks.create', [
            'task' => $task,
        ]);
    }

    // postでtasks/にアクセスされた場合の「新規登録処理」
    public function store(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|max:11', //2019.6.11追加
            'status' => 'required|max:10', 
            'content' => 'required|max:191',
        ]);
        
        
        $task = new Task;
        $task->user_id = $request->user_id;//2019.6.11追加
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();

        return redirect('/');
    }

    // getでtasks/idにアクセスされた場合の「取得表示処理」
    public function show($id)
    {
        $task = Task::find($id);
        if (\Auth::id() === $task->user_id) {
            return view('tasks.show', [
                'task' => $task,
            ]);
        }else{
            return redirect('/');
        }
    }

    // getでtasks/id/editにアクセスされた場合の「更新画面表示処理」
    public function edit($id)
    {
        
        $task = Task::find($id);
        if (\Auth::id() === $task->user_id) {
            return view('tasks.edit', [
                'task' => $task,
            ]);
        }else{
            return redirect('/');
        }
    }

    // putまたはpatchでtasks/idにアクセスされた場合の「更新処理」
    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        if (\Auth::id() === $task->user_id) {
            $this->validate($request, [
                'user_id' => 'required|max:11', //2019.6.11追加
                'status' => 'required|max:10', 
                'content' => 'required|max:191',
            ]);
        
            $task = Task::find($id);
            $task->user_id = $request->user_id;//2019.6.11追加
            $task->status = $request->status;
            $task->content = $request->content;
            $task->save();
        }

        return redirect('/');
    }


    // deleteでtasks/idにアクセスされた場合の「削除処理」
    public function destroy($id)
    {
        $task = Task::find($id);
        if (\Auth::id() === $task->user_id) {
           $task->delete();
        }else{
            return redirect('/');
        }
        return redirect('/');
    }
}