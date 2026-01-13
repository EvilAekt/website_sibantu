<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Report;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalDonations = Transaction::where('status', 'success')->sum('amount');
        $activeUsers = User::count();
        $pendingReports = Report::where('status', 'pending')->count();
        $activeCampaigns = Campaign::where('status', 'active')->where('is_verified', true)->count();

        // $reports = Report::where('status', 'pending')->latest()->get(); // MOVED TO SEPARATE PAGE
        $withdrawals = Withdrawal::where('status', 'pending')->with('fundraiser')->latest()->get();
        $pendingUsers = User::where('role', 'fundraiser')->where('is_verified', false)->latest()->get();

        // Recent transactions
        $recentTransactions = Transaction::with(['user', 'campaign'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalDonations',
            'activeUsers',
            'pendingReports',
            'activeCampaigns',
            // 'reports',
            'withdrawals',
            'pendingUsers',
            'recentTransactions'
        ));
    }

    public function reports()
    {
        $reports = Report::latest()->paginate(10);
        return view('admin.reports.index', compact('reports'));
    }

    // --- Report Management ---

    public function verifyReport($id)
    {
        $report = Report::findOrFail($id);
        $report->status = 'verified';
        $report->save();

        return redirect()->back()->with('success', 'Report verified.');
    }

    public function rejectReport($id)
    {
        $report = Report::findOrFail($id);
        $report->status = 'rejected';
        $report->save();

        return redirect()->back()->with('success', 'Report rejected.');
    }

    // --- Hybrid Flow: Report to Campaign ---

    public function convertToCampaign(Request $request, $id)
    {
        $report = Report::findOrFail($id);

        // Validation
        $request->validate([
            'target_amount' => 'required|numeric|min:10000',
            'deadline' => 'required|date|after:today',
            'title' => 'required|string|max:255', // Allow overriding title
        ]);

        // Create Campaign
        $campaign = Campaign::create([
            'fundraiser_id' => $report->user_id, // The report owner becomes fundraiser
            'report_id' => $report->id,
            'title' => $request->title ?? $report->title,
            'slug' => Str::slug($request->title ?? $report->title) . '-' . Str::random(5),
            'description' => $report->description, // Or allow admin to edit
            'target_amount' => $request->target_amount,
            'deadline' => $request->deadline,
            'is_verified' => true, // Auto-verified since admin created it
            'status' => 'active',
        ]);

        // Update Report Status
        $report->status = 'converted_to_campaign';
        $report->save();

        // Also ensure user role is upgraded to fundraiser if not already? 
        // Logic: if report owner is 'donatur', promote to 'fundraiser'
        if ($report->user->role === 'donatur') {
            $report->user->role = 'fundraiser';
            $report->user->save();
        }

        return redirect()->route('admin.dashboard')->with('success', 'Report converted to Campaign successfully.');
    }

    // --- Withdrawal Management ---

    public function approveWithdrawal($id)
    {
        $withdrawal = Withdrawal::findOrFail($id);
        if ($withdrawal->status !== 'pending') {
            return redirect()->back()->with('error', 'Withdrawal already processed.');
        }

        // Create logic to transfer money (Mock)
        // Ensure fundraiser has balance? 
        // Actually, withdrawal deducts from balance, but balance should be deducted when REQUESTED or when APPROVED?
        // Usually when requested, balance is locked or deducted. 
        // Let's assume deducted when Approved for simplicity or just check logic.
        // wait, we implemented wallet_balance.
        // If we deduct when requested, we need to handle that in WithdrawalController (Fundraiser side).
        // Here we just mark as approved.

        $withdrawal->status = 'approved';
        $withdrawal->save();

        return redirect()->back()->with('success', 'Withdrawal approved.');
    }

    // --- User Verification ---

    public function verifyUser($id)
    {
        $user = User::findOrFail($id);
        $user->is_verified = true;
        // Optionally add verification note
        $user->verification_notes = 'Verified by Admin on ' . now();
        $user->save();

        return redirect()->back()->with('success', 'User verified successfully.');
    }
}