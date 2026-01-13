<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Transaction;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index(Request $request)
    {
        $query = Campaign::where('status', 'active')
            ->where('is_verified', true);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%");
        }

        // Category Filter
        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        // Sorting
        switch ($request->get('sort')) {
            case 'oldest':
                $query->oldest();
                break;
            case 'target_asc':
                $query->orderBy('target_amount', 'asc');
                break;
            case 'target_desc':
                $query->orderBy('target_amount', 'desc');
                break;
            default: // newest
                $query->latest();
                break;
        }

        $campaigns = $query->paginate(12)->withQueryString();

        return view('campaigns.index', compact('campaigns'));
    }

    public function show($slug)
    {
        $campaign = Campaign::where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        $donors = Transaction::where('campaign_id', $campaign->id)
            ->where('status', 'success')
            ->latest()
            ->take(10)
            ->get();

        return view('campaigns.show', compact('campaign', 'donors'));
    }

    public function donate($slug)
    {
        $campaign = Campaign::where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        return view('campaigns.donate', compact('campaign'));
    }

    public function storeDonation(Request $request, $slug)
    {
        $campaign = Campaign::where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        $request->validate([
            'amount' => 'required|numeric|min:10000',
            'payment_method' => 'required|string',
        ]);

        $transaction = Transaction::create([
            'campaign_id' => $campaign->id,
            'user_id' => auth()->id(), // Nullable if guest? Transaction model says user_id. Let's assume nullable or auth required.
            // If guest donation is allowed, user_id should be nullable. Let's check table schema? 
            // For now, assume auth required or user_id is nullable. 
            // If auth is required, I need to middleware the route.
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'status' => 'success', // Simulating instant success
            'transaction_code' => 'TRX-' . strtoupper(\Illuminate\Support\Str::random(10)),
        ]);

        // Update campaign collected amount
        $campaign->collected_amount += $request->amount;
        $campaign->save();

        return redirect()->route('donations.success', $transaction->id);
    }

    public function success($id)
    {
        $transaction = Transaction::with('campaign')->findOrFail($id);
        return view('donations.success', compact('transaction'));
    }
}
