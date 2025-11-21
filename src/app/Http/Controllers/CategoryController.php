<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
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

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $data = $request->validated();
        $category = $this->service->update($category, $data);

        return redirect('/')->with('success', 'Вы успешно обновили категорию');
    }

    public function destroy(Category $category)
    {
        $check = $this->service->destroy($category);
        if ($check) {
            $message = 'Вы успешно удалили категорию';
        } else {
            $message = 'Не удалось удалить категорию';
        }

        return redirect('/')->with('success', $message);
    }
}
