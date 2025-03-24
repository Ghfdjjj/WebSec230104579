<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddCreditRequest;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of transactions.
     */
    public function index(Request $request)
    {
        $transactions = Transaction::with(['user', 'processor', 'purchase'])
                                 ->orderBy('created_at', 'desc')
                                 ->paginate(15);

        return view('admin.transactions.index', compact('transactions'));
    }

    /**
     * Display the specified transaction.
     */
    public function show(Transaction $transaction)
    {
        $transaction->load(['user', 'processor', 'purchase.product']);
        return view('admin.transactions.show', compact('transaction'));
    }

    /**
     * Add credit to a user's account.
     */
    public function addCredit(AddCreditRequest $request, User $user)
    {
        try {
            DB::beginTransaction();

            $transaction = Transaction::addCredit(
                $user,
                $request->validated('amount'),
                $request->user(),
                $request->validated('description')
            );

            DB::commit();
            return back()->with('success', "Successfully added ${$request->amount} credit to {$user->name}'s account.");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to add credit: ' . $e->getMessage());
        }
    }
}
