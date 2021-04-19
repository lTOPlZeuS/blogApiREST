<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Article as ArticleResource;
use App\Http\Resources\ArticleCollection;
use App\Models\Article;

class ArticleController extends Controller
{
    private static $rule = [
            'title' => 'required|string|unique:articles|max:255',
            'body' => 'required',
    ];
    private static $messages=[
            'required'=>'El campo :attribute es obligatorio.',
            'unique'=> 'El campo title es unico',
    ];
    public function index(){
        return new ArticleCollection(Article::paginate(10));
    }
    public function show(Article $article){
        return response()->json(new ArticleResource($article),200);
    }
    public function store(Request $request){
        $request->validate(self::$rule,self::$messages);
        $article = Article::create($request->all());
        return response()->json($article, 201);
    }
    public function update(Request $request, Article $article){
        $article->update($request->all());
        return response()->json($article, 200);
    }
    public function delete(Article $article){
        $article->delete();
        return response()->json(null, 204);
    }
}
