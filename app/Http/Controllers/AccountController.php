<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
	public function index(Request $request)
	{
		$where = [];
		if (!empty($request->group_id)) {
			$where[] = ['group_id', '=', $request->group_id];
		}
		$data = Account::where($where)->orderBy('updated_at', 'desc')->paginate(config('custom.pagination'));
		return view('account.index', [
			'data' => $data,
		]);
	}

	public function show(Account $account)
	{
		return view('account.show', [
			'account' => $account,
		]);
	}

	public function create()
	{
		return view('account.form');
	}

	public function store(Request $request)
	{
		$post = $request->all();
		$post['updated_by'] = session()->get('user')['user_id'];
		$post['updated_at'] = now()->format('Y-m-d H:i:s');
		$validate = Account::validate($post);
		if ($validate->fails()) {
			return redirect()->back()->with('error', print_r($validate->errors()->all(), true))->withInput();
		}
		if (!Account::create($post)) {
			return redirect()->back()->with('error', 'Failed save Account!');
		}
		return redirect()->route('account.index')
			->with('success', 'Success create new Account!');
	}

	public function edit(Account $account)
	{
		return view('account.form', [
			'account' => $account,
		]);
	}

	public function update(Request $request, Account $account)
	{
		$post = $request->all();
		$post['updated_by'] = session()->get('user')['user_id'];
		$post['updated_at'] = now()->format('Y-m-d H:i:s');
		$validate = Account::validate($post, $account->account_id);
		if ($validate->fails()) {
			return redirect()->back()->with('error', print_r($validate->errors()->all(), true))->withInput();
		}
		if (!$account->update($post)) {
			return redirect()->back()->with('error', 'Failed update Account!');
		}
		return redirect()->route('account.index')
			->with('success', 'Success update Account!');
	}

	public function destroy(Account $account)
    {
		if (!$account->isDeletable()) {
			return redirect()->back()->with('error', 'Failed delete account! Account has transaction.');
		}
        // Delete the account
        $account->delete();

        // Redirect or return response
        return redirect()->route('account.index')->with('success', 'Account deleted successfully');
    }
}
