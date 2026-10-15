<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Serial;
use App\Models\Chamber;

class AdminSerialController extends Controller
{
    public function index(Request $request)
    {
        $query = Serial::with('chamber')->latest();

        if ($request->filled('chamber_id')) {
            $query->where('chamber_id', $request->chamber_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('date')) {
            $query->whereDate('preferred_date', $request->date);
        }
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('patient_name', 'like', "%{$s}%")
                  ->orWhere('patient_phone', 'like', "%{$s}%")
                  ->orWhere('serial_number', 'like', "%{$s}%");
            });
        }

        $serials = $query->paginate(15)->withQueryString();
        $chambers = Chamber::all();

        return view('admin.serials.index', compact('serials', 'chambers'));
    }

    public function show($id)
    {
        $serial = Serial::with(['chamber', 'prescription'])->findOrFail($id);
        return view('admin.serials.show', compact('serial'));
    }

    public function updateStatus(Request $request, $id)
    {
        $serial = Serial::findOrFail($id);
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'admin_notes' => 'nullable|string',
        ]);

        $serial->status = $request->status;
        if ($request->filled('admin_notes')) {
            $serial->admin_notes = $request->admin_notes;
        }
        if ($request->status === 'confirmed' && !$serial->sms_sent_at) {
            $serial->sms_sent_at = now();
        }
        $serial->save();

        return back()->with('success', "Serial {$serial->serial_number} status updated to " . ucfirst($request->status) . ".");
    }

    public function printDaily(Request $request)
    {
        $date = $request->get('date', now()->toDateString());
        $chamberId = $request->get('chamber_id');

        $query = Serial::whereDate('preferred_date', $date)->where('status', '!=', 'cancelled');
        if ($chamberId) {
            $query->where('chamber_id', $chamberId);
        }

        $serials = $query->orderBy('serial_number')->get();
        $chamber = $chamberId ? Chamber::find($chamberId) : null;

        return view('admin.serials.print_sheet', compact('serials', 'date', 'chamber'));
    }

    public function destroy($id)
    {
        $serial = Serial::findOrFail($id);
        $serial->delete();
        return back()->with('success', 'Serial entry removed.');
    }
}

