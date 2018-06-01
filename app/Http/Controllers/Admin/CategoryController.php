<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\QuestionStatus;
use App\Http\Requests\StoreCategory;
use App\Http\Requests\UpdateCategory;

class CategoryController extends Controller
{

    protected $breadcrumbs;

    function __construct () {
        $this->breadcrumbs = collect([
            ['name' => 'Панель управления', 'url' => route('admin.dashboard')],
            ['name' => 'Категории', 'url' => route('admin.categories.index')],
        ]);
    }

    public function index() {
        $categories = Category::withCount(['newQuestions', 'hiddenQuestions', 'questions'])->get();

    	return view('admin.categories.index', [
    		'pagetitle' => 'Список категорий',
    		'breadcrumbs' => $this->breadcrumbs,
            'categories' => $categories,
    	]);
    }

    public function create() {
    	return view('admin.categories.create', [
    		'pagetitle' => 'Создать категорию',
    		'breadcrumbs' => $this->breadcrumbs,
    	]);
    }

    public function store(StoreCategory $request) {
    	$category = Category::create($request->all());

    	return redirect()->route('admin.categories.edit', $category->id)
    		->with('success', 'Категория успешно создана');
    }

    public function edit(Category $category) {
    	return view('admin.categories.edit', [
    		'pagetitle' => 'Редактировать Категорию',
    		'breadcrumbs' => $this->breadcrumbs,
    		'category' => $category,
    	]);
    }

    public function update(UpdateCategory $request, Category $category) {
    	$category->fill($request->all());
    	$category->save();

    	return redirect()->route('admin.categories.edit', $category)
    		->with('success', 'Категория успешно изменена');
    }

    public function destroy($id) {
    	Category::destroy($id);

    	return redirect()->back();
    }

}