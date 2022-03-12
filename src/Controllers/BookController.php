<?php

namespace Lincms\Controllers;

use Illuminate\Http\Request;
use Lincms\Models\Book;
use Lincms\Requests\BookRequest;
use Pyjhyssc\Traits\ApiResponse;

class BookController extends LinController
{
    use ApiResponse;

    protected $table = Book::class;

    public function index()
    {
        return Book::query()->orderByDesc('id')->get();
    }


    public function store(BookRequest $request)
    {
        $param = $request->getParam();
        Book::query()->create($param);

        return $this->message('添加成功');
    }


    public function show($id)
    {
        return Book::query()->findOrFail($id);
    }


    public function update(Request $request, $id)
    {
        $model = Book::query()->findOrFail($id);
        $param = $request->only(['title', 'summary', 'author', 'image']);
        $model->fill($param)->save();

        return $this->message('修改成功');
    }


    public function destroy($id)
    {
        Book::destroy($id);

        return $this->message('删除成功');
    }

}
