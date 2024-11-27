<?php

namespace App\Http\Controllers;

use App\Helpers\GeneralHelper;
use Exception;
use App\Models\Transaction;
use App\Models\TransactionFile;
use App\Models\Config;
use App\Models\TransactionTransfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $where = [];
        if (!empty($request->start_date)) {
            $where[] = ['trans_date', '>=', date('Y-m-d', strtotime($request->start_date))];
        }
        if (!empty($request->end_date)) {
            $where[] = ['trans_date', '<=', date('Y-m-d', strtotime($request->end_date))];
        }
        if (!empty($request->trans_type)) {
            $where[] = ['trans_type', '=', $request->trans_type];
        }
        if (!empty($request->category_id)) {
            $where[] = ['category_id', '=', $request->category_id];
        }
        $data = Transaction::where($where)->orderByRaw('trans_date desc, updated_at desc')->paginate(config('custom.pagination'));
        return view('transaction.index', compact('data'));
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            DB::beginTransaction();
            try {
                // Store data into DB
                $post = $request->except(['file', 'destination_id', 'admin_fee']);
                $post['trans_amount'] = GeneralHelper::assertNumber($request->trans_amount);
                $post['updated_by'] = session()->get('user')['user_id'];
                $post['updated_at'] = date('Y-m-d H:i:s');
                Transaction::validate($post);
                $transaction = Transaction::create($post);

                if ($request->trans_type == Transaction::TYPE_TRANSFER) {
                    // Store data into transfer table
                    $transfer = new TransactionTransfer();
                    $transfer->trans_id = $transaction->trans_id;
                    $transfer->destination_id = $request->destination_id;
                    $transfer->admin_fee = GeneralHelper::assertNumber($request->admin_fee);
                    $transfer->save();

                    // Store fee as expense transaction
                    if ($transfer->admin_fee > 0) {
                        $transaction->postFee();
                    }
                }

                // Store file
                if (($request->hasFile('file'))) {
                    // Modify file name
                    $extension = $request->file('file')->getClientOriginalExtension();
                    $file_name = $transaction->trans_id . time() . '.' . $extension;
                    $file_type = $request->file('file')->getClientMimeType();
                    $file_type = explode('/', $file_type)[0];
                    // Store the file into DB
                    $file['trans_id'] = $transaction->trans_id;
                    $file['file_name'] = $file_name;
                    $file['file_type'] = $file_type;
                    TransactionFile::validate($file);
                    TransactionFile::create($file);
                    // Store the file into storage
                    if ($request->file('file')->isValid()) {
                        $request->file('file')->storeAs('uploads', $file_name, 'public');
                    }
                }

                DB::commit();
                return redirect()->route('transaction.index')
                    ->with('success', 'Transaction created');
            } catch (ValidationException $e) {
                DB::rollback();
                return redirect()->back()
                    ->with('error', implode('<br>', $e->validator->errors()->all()))
                    ->withInput();
            } catch (Exception $e) {
                DB::rollback();
                return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
            }
        }
        $config = Config::getConfig();
        return view('transaction.form', compact('config'));
    }

    public function show(Transaction $transaction)
    {
        return view('transaction.show', compact('transaction'));
    }

    public function edit(Transaction $transaction, Request $request)
    {
        if ($request->isMethod('post')) {
            DB::beginTransaction();
            try {
                // Store data into DB
                $post = $request->except(['old_file', 'file', 'destination_id', 'admin_fee']);
                $post['trans_amount'] = GeneralHelper::assertNumber($request->trans_amount);
                $post['updated_by'] = session()->get('user')['user_id'];
                $post['updated_at'] = date('Y-m-d H:i:s');
                Transaction::validate($post);
                $transaction->update($post);

                // Store data into transfer table
                if ($request->trans_type == Transaction::TYPE_TRANSFER && (!empty($transaction->transfer))) {
                    // Update if old data is transfer
                    $transfer = $transaction->transfer;
                    $transfer->destination_id = $request->destination_id;
                    $transfer->admin_fee = GeneralHelper::assertNumber($request->admin_fee);
                    $transfer->update();
                    // Update fee transaction
                    if (isset($transfer->fee) && ($transfer->admin_fee <= 0)) {
                        $transfer->fee->delete();
                    } else {
                        $transaction->postFee();
                    }
                } else if ($request->trans_type == Transaction::TYPE_TRANSFER) {
                    // Store if old data is not transfer
                    $transfer = new TransactionTransfer();
                    $transfer->trans_id = $transaction->trans_id;
                    $transfer->destination_id = $request->destination_id;
                    $transfer->admin_fee = GeneralHelper::assertNumber($request->admin_fee);
                    $transfer->save();
                    // Store fee transaction
                    if ($transfer->admin_fee > 0) {
                        $transaction->postFee();
                    }
                }

                // If fee transfer, update data transfer
                if ($transaction->transfer_id) {
                    $fee_transfer = $transaction->fee;
                    $fee_transfer->admin_fee = $transaction->trans_amount;
                    $fee_transfer->update();
                }

                // If old file is deleted, remove from storage and DB
                if (!empty($transaction->file) && empty($request->old_file)) {
                    $filePath = 'uploads/' . $transaction->file->file_name;
                    if (Storage::exists($filePath)) {
                        Storage::delete($filePath);
                    }
                    $transaction->file->delete();
                }
                // Store new file
                if (($request->hasFile('file'))) {
                    // Modify file name
                    $extension = $request->file('file')->getClientOriginalExtension();
                    $file_name = $transaction->trans_id . time() . '.' . $extension;
                    $file_type = $request->file('file')->getClientMimeType();
                    $file_type = explode('/', $file_type)[0];
                    // Store the file into DB
                    $file['trans_id'] = $transaction->trans_id;
                    $file['file_name'] = $file_name;
                    $file['file_type'] = $file_type;
                    TransactionFile::validate($file);
                    TransactionFile::create($file);
                    // Store the file into storage
                    if ($request->file('file')->isValid()) {
                        $request->file('file')->storeAs('uploads', $file_name, 'public');
                    }
                }

                DB::commit();
                return redirect()->route('transaction.show', $transaction)
                    ->with('success', 'Transaction updated.');
            } catch (ValidationException $e) {
                DB::rollback();
                return redirect()->back()
                    ->with('error', implode('<br>', $e->validator->errors()->all()))
                    ->withInput();

            } catch (Exception $e) {
                DB::rollback();
                return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
            }
        }
        return view('transaction.form-edit', compact('transaction'));
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->back()->with('success', 'Success! Transaction deleted.');
    }
}