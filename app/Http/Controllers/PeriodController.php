<?php

namespace App\Http\Controllers;

use App\Models\Period;
use Illuminate\Http\Request;

class PeriodController extends Controller
{
	public function index()
	{
		$data = Period::orderBy('updated_at', 'desc')->paginate(config('custom.pagination'));
		return view('period.index', [
			'data' => $data,
			'title' => 'Period',
		]);
	}

	public function show(Period $period)
	{
		return view('period.show', [
			'title' => $period->account_name,
			'period' => $period,
		]);
	}

	public function create()
	{
		return view('period.create', [
			'title' => 'Create Period',
		]);
	}

	public function store(Request $request)
	{
		$post = $request->all();
		$post['updated_by'] = session()->get('user')['user_id'];
		$post['updated_at'] = now()->format('Y-m-d H:i:s');
		$validate = Period::validate($post);
		if ($validate->fails()) {
			return redirect()->back()->with('error', print_r($validate->errors()->all(), true))->withInput();
		}
		if (!Period::create($post)) {
			return redirect()->back()->with('error', 'Failed save Period!');
		}
		return redirect()->route('period.index')
			->with('success', 'Success create new Period!');
	}

	public function edit(Period $account)
	{
		return view('account.create', [
			'title' => "Update: $account->account_name",
			'account' => $account,
		]);
	}

	public function update(Request $request, Period $account)
	{
		$post = $request->all();
		$post['updated_by'] = session()->get('user')['user_id'];
		$post['updated_at'] = now()->format('Y-m-d H:i:s');
		$validate = Period::validate($post, $account->account_id);
		if ($validate->fails()) {
			return redirect()->back()->with('error', print_r($validate->errors()->all(), true))->withInput();
		}
		if (!$account->update($post)) {
			return redirect()->back()->with('error', 'Failed update Account!');
		}
		return redirect()->route('account.index')
			->with('success', 'Success update Account!');
	}

	public function destroy(Period $account)
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
