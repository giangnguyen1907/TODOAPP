<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\App;
use App\Http\Resources\TodosCollection;
class TodosController extends Controller
{
    public function index(){
          $todos= App::get();
          // TodosCollection::collection($todos);
          // return response()->json($todos);
          return TodosCollection::collection($todos);
    }

    public function add(Request $req)
    {    
         $todo = new App;  
         $todo->text = $req->text;
         $todo->isDone = $req->isDone;
         $todo->user_id= $req->user_id;
         $todo->created_at = now();
         $todo->updated_at = now();
         $todo->save();
         $todos = App::get();
         return TodosCollection::collection($todos);
    }

    public function remove(Request $req)
    {    
         $stod =App::find($req->id)->delete();
         // $stod = App::where('id',$req->id);
         $todos = App::get();
         return TodosCollection::collection($todos);
         // $todo = new App;  
         // $todo->text = $req->text;
         // $todo->isDone = $req->isDone;
         // $todo->created_at = now();
         // $todo->updated_at = now();
         // $todo->save();
         // $todos = App::get();
         // return TodosCollection::collection($todos);
    }
    public function update(Request $req)
    {   
        $todo = App::where('id',$req->id)->update(['text'=>$req->text]);
        //$todo->text = $req->text;
        //$todo->save();
        $todos = App::get();
        return TodosCollection::collection($todos);
    }
     public function status(Request $req)
    {   
        if($req->isDone==0)
        {
            $todo = App::where('id',$req->id)->first();
            $todo->isDone=0;
        //$todo->text = $req->text;
            $todo->save();
        } else {
            $todo = App::where('id',$req->id)->first();
            $todo->isDone=1; 
        //$todo->text = $req->text;
            $todo->save();
        }
        // $todo = App::where('id',$req->id)->update(['isDone'=>$req->isDone]);
        //$todo->text = $req->text;
        //$todo->save();
        $todos = App::get();
        return TodosCollection::collection($todos);
    }
    
} 
