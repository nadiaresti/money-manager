<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Transaction;
use App\Models\TransactionFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class TransactionController extends Controller
{
    public function index()
    {
        $data = Transaction::orderBy('trans_date', 'desc')->paginate(config('custom.pagination'));
        return view('transaction.index', compact('data'));
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            DB::beginTransaction();
            try {
                // Store data into DB
                $post = $request->except(['file']);
                $post['trans_amount'] = 1000;
                $post['updated_by'] = session()->get('user')['user_id'];
                $post['updated_at'] = date('Y-m-d H:i:s');
                Transaction::validate($post);
                $transaction = Transaction::create($post);

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
                    ->withErrors($e->validator)
                    ->withInput();
            } catch (Exception $e) {
                DB::rollback();
                return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
            }
        }
        return view('transaction.form');
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
                $post['updated_by'] = session()->get('user')['user_id'];
                $post['updated_at'] = date('Y-m-d H:i:s');
                Transaction::validate($post);
                $transaction->update($post);

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
                return redirect()->route('transaction.show', $transaction);
            } catch (ValidationException $e) {
                DB::rollback();
                return redirect()->back()
                    ->withErrors($e->validator)
                    ->withInput();

            } catch (Exception $e) {
                DB::rollback();
                return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
            }
        }
        return view('transaction.form-edit', compact('transaction'));
    }
}