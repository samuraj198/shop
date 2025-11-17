<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(private CategoryService $service)
    {}

    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();
        $category = $this->service->store($data);

        return redirect('/')->with('success', 'Вы успешно создали категорию');
    }

    public function update(UpdateCategoryRequest $request)
    {
        $data = $request->validated();
        $category = $this->service->update($data['id'], $data['name']);

        return redirect('/')->with('success', 'Вы успешно обновили категорию');
    }

    public function destroy(int $id)
    {
        $message = $this->service->destroy($id);

        return redirect('/')->with('success', $message);
    }
}
