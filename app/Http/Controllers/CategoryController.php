<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
	public function index()
	{
		$category = Category::orderBy('updated_at', 'desc')->paginate(config('custom.pagination'));
		return view('category.index', compact('category'));
	}

	public function show(Category $category)
	{
		return view('category.show', compact('category'));
	}

	public function create()
	{
		$categories = Category::where(['parent_id' => 0])->get();
		return view('category.form', compact('categories'));
	}

	public function store(Request $request)
	{
		$post = $request->all();
		$post['updated_by'] = session()->get('user')['user_id'];
		$post['updated_at'] = now()->format('Y-m-d H:i:s');
		$validate = Category::validate($post);
		if ($validate->fails()) {
			return redirect()->back()->with('error', print_r($validate->errors()->all(), true))->withInput();
		}
		if (!Category::create($post)) {
			return redirect()->back()->with('error', 'Failed save Category!');
		}
		return redirect()->route('category.index')
			->with('success', 'Success create new Category!');
	}

	public function edit(Category $category)
	{
		$categories = Category::where(['parent_id' => 0])->get();
		return view('category.form', compact('category', 'categories'));
	}

	public function update(Request $request, Category $category)
	{
		$post = $request->all();
		$post['updated_by'] = session()->get('user')['user_id'];
		$post['updated_at'] = now()->format('Y-m-d H:i:s');
		$validate = Category::validate($post, $category->category_id);
		if ($validate->fails()) {
			return redirect()->back()->with('error', print_r($validate->errors()->all(), true))->withInput();
		}
		if (!$category->update($post)) {
			return redirect()->back()->with('error', 'Failed update Category!');
		}
		return redirect()->route('category.index')
			->with('success', 'Success update Category!');
	}

	public function destroy(Category $category)
    {
		if (!$category->isDeletable()) {
			return redirect()->back()->with('error', 'Failed delete Category! Category has transaction.');
		}
        // Delete the category
        $category->delete();

        // Redirect or return response
        return redirect()->route('category.index')->with('success', 'Category deleted successfully');
    }
}
