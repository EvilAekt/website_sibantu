<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DonaturController extends Controller
{
    public function dashboard()
    {
        $userId = auth()->id();

        // Get successful donations
        $donations = Transaction::where('user_id', $userId)
            ->where('status', 'success')
            ->with('campaign')
            ->latest()
            ->take(5)
            ->get();

        // Calculate stats
        $totalDonated = Transaction::where('user_id', $userId)
            ->where('status', 'success')
            ->sum('amount');

        $campaignsSupported = Transaction::where('user_id', $userId)
            ->where('status', 'success')
            ->distinct('campaign_id')
            ->count('campaign_id');

        // Monthly donation (this month)
        $monthlyDonated = Transaction::where('user_id', $userId)
            ->where('status', 'success')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('amount');

        // Favorite campaigns (most donated to)
        $favoriteCampaigns = Transaction::where('user_id', $userId)
            ->where('status', 'success')
            ->selectRaw('campaign_id, SUM(amount) as total_donated, COUNT(*) as donation_count')
            ->groupBy('campaign_id')
            ->orderByDesc('total_donated')
            ->take(3)
            ->with('campaign')
            ->get();

        return view('user.dashboard', compact(
            'donations',
            'totalDonated',
            'campaignsSupported',
            'monthlyDonated',
            'favoriteCampaigns'
        ));
    }

    public function history(Request $request)
    {
        $query = Transaction::where('user_id', auth()->id())
            ->with('campaign')
            ->latest();

        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        $donations = $query->paginate(15)->withQueryString();

        return view('user.history', compact('donations'));
    }
}
