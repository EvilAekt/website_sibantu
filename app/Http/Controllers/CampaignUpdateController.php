<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\CampaignUpdate;
use Illuminate\Http\Request;

class CampaignUpdateController extends Controller
{
    public function store(Request $request, $campaign_id)
    {
        $campaign = Campaign::where('fundraiser_id', auth()->id())->findOrFail($campaign_id);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $campaign->updates()->create([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return back()->with('success', 'Kabar terbaru berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $update = CampaignUpdate::findOrFail($id);

        // Authorization check
        if ($update->campaign->fundraiser_id !== auth()->id()) {
            abort(403);
        }

        $update->delete();

        return back()->with('success', 'Kabar terbaru dihapus.');
    }
}
