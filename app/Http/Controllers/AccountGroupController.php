<?php

namespace App\Http\Controllers;

use App\Models\AccountGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AccountGroupController extends Controller
{
	public function index()
	{
		$data = AccountGroup::all();
		return view('account_group.index', [
			'data' => $data,
		]);
	}

	public function create()
	{
		return view('account_group.form');
	}

	public function store(Request $request)
	{
		$post = $request->all();
		$post['updated_by'] = Auth::id();
		$post['updated_at'] = now()->format('Y-m-d H:i:s');
		$validate = AccountGroup::validate($post);
		if ($validate->fails()) {
			return redirect()->back()->withErrors(print_r($validate->errors()->all(), true))->withInput();
		}
		if (!AccountGroup::create($post)) {
			return redirect()->back()->with('error', 'Failed save Account Group!');
		}
		return redirect()->route('account-group.index')
			->with('success', 'Success create new Account Group!');
	}

	public function show(AccountGroup $accountGroup)
	{
		return view('account_group.show', [
			'accountGroup' => $accountGroup,
		]);
	}

	public function edit(AccountGroup $accountGroup)
	{
		return view('account_group.form', [
			'accountGroup' => $accountGroup,
		]);
	}

	public function update(Request $request, AccountGroup $accountGroup)
	{
		$post = $request->all();
		$post['updated_by'] = Auth::id();
		$post['updated_at'] = now()->format('Y-m-d H:i:s');
		$validate = AccountGroup::validate($post, $accountGroup->account_id);
		if ($validate->fails()) {
			return redirect()->back()->with('error', print_r($validate->errors()->all(), true))->withInput();
		}
		if (!$accountGroup->update($post)) {
			return redirect()->back()->with('error', 'Failed update Account Group!');
		}
		return redirect()->route('account-group.index')
			->with('success', 'Success update Account Group!');
	}

}
