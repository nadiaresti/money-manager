<?php

namespace App\Http\Controllers;

use App\Helpers\GeneralHelper;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SiteController extends Controller
{
    public function index()
    {
        $income_pie = $income_label = $expense_pie = $expense_label = [];
        $periods = GeneralHelper::getPeriods(5);

        // Fetch total income/expense
        $total_income = Transaction::calculateTotal(Transaction::TYPE_INCOME);
        $total_expense = Transaction::calculateTotal(Transaction::TYPE_EXPENSE);

        // Fetch total by category
        $income = Transaction::fetchTotalbyCategory(Transaction::TYPE_INCOME);
        foreach ($income as $each) {
            $income_pie[] = $each->trans_amount;
            $income_label[] = $each->category_name;
        }
        $expense = Transaction::fetchTotalbyCategory(Transaction::TYPE_EXPENSE);
        foreach ($expense as $each) {
            $expense_pie[] = $each->trans_amount;
            $expense_label[] = $each->category_name;
        }

        // Calculate different amount from last period
        $income_period = Transaction::fetchTotalbyPeriod(Transaction::TYPE_INCOME, 2);
        $curr_period = isset($income_period[end($periods)]) ? $income_period[end($periods)] : 0;
        $last_period = isset($income_period[count($periods) - 1]) ? $income_period[count($periods) - 1] : 0;
        $income_diff = $curr_period - $last_period;

        $expense_period = Transaction::fetchTotalbyPeriod(Transaction::TYPE_EXPENSE, 2);
        $curr_period = isset($expense_period[end($periods)]) ? $expense_period[end($periods)] : 0;
        $last_period = isset($expense_period[count($periods) - 1]) ? $expense_period[count($periods) - 1] : 0;
        $expense_diff = $curr_period - $last_period;

        return view('site.home', [
            'title' => 'Welcome',
            'periods' => $periods,
            'total_income' => $total_income,
            'total_expense' => $total_expense,
            'income_pie' => $income_pie,
            'income_label' => $income_label,
            'expense_pie' => $expense_pie,
            'expense_label' => $expense_label,
            'income_diff' => $income_diff,
            'expense_diff' => $expense_diff,
        ]);
    }

    public function changePassword()
    {
        return view('site.change_password');
    }

    public function updatePassword(Request $request)
    {
        // Note: if function validate false, it will auto return $errors in view
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'confirmed'],
        ], [
            'current_password.current_password' => 'The current password you entered is incorrect.',
        ]);

        // Update passwor in DB
        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success-password', 'Password changed successfully.');
    }
}
