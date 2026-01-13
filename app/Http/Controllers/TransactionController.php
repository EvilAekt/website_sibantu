<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function store(Request $request, $slug)
    {
        $campaign = Campaign::where('slug', $slug)->firstOrFail();

        $request->validate([
            'amount' => 'required|numeric|min:1000',
            'payment_method' => 'required|string',
            'name' => 'nullable|string', // Guest or User
            'email' => 'nullable|email',
        ]);

        $transaction = Transaction::create([
            'campaign_id' => $campaign->id,
            'user_id' => auth()->id(), // Check if user logged in
            'transaction_code' => 'TRX-' . Str::upper(Str::random(10)),
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
        ]);

        // Redirect to a simulation page or show success message with Instructions
        return redirect()->route('payment.simulation', $transaction->transaction_code);
    }

    public function simulation($code)
    {
        $transaction = Transaction::where('transaction_code', $code)->firstOrFail();

        if ($transaction->status === 'success') {
            return redirect()->route('campaigns.show', $transaction->campaign->slug)
                ->with('success', 'Donation already received!');
        }

        return view('payment.simulation', compact('transaction'));
    }

    public function callback(Request $request, $code)
    {
        $transaction = Transaction::where('transaction_code', $code)->firstOrFail();

        if ($transaction->status === 'pending') {
            DB::transaction(function () use ($transaction) {
                // 1. Update Transaction
                $transaction->status = 'success';
                $transaction->save();

                // 2. Increment Campaign Collected Amount
                $campaign = $transaction->campaign;
                $campaign->collected_amount += $transaction->amount;
                $campaign->save();

                // 3. Increment Fundraiser Wallet
                $fundraiser = $campaign->fundraiser;
                $fundraiser->wallet_balance += $transaction->amount;
                $fundraiser->save();
            });
        }

        return redirect()->route('campaigns.show', $transaction->campaign->slug)
            ->with('success', 'Thank you! Payment verified successfully.');
    }
}
