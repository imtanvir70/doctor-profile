<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prescription;
use App\Models\Serial;
use App\Models\Chamber;
use App\Models\DrProfile;

class AdminPrescriptionController extends Controller
{
    public function index(Request $request)
    {
        $query = Prescription::with('chamber')->latest();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('patient_name', 'like', "%{$s}%")
                  ->orWhere('patient_phone', 'like', "%{$s}%")
                  ->orWhere('prescription_no', 'like', "%{$s}%")
                  ->orWhere('diagnosis', 'like', "%{$s}%");
            });
        }

        $prescriptions = $query->paginate(15)->withQueryString();
        return view('admin.prescriptions.index', compact('prescriptions'));
    }

    public function create(Request $request)
    {
        $chambers = Chamber::where('is_active', true)->get();
        $serial = null;
        if ($request->filled('serial_id')) {
            $serial = Serial::find($request->serial_id);
        }

        // Generate next prescription no
        $year = date('Y');
        $count = Prescription::whereYear('created_at', $year)->count() + 1;
        $nextPrescriptionNo = 'RX-' . $year . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);

        return view('admin.prescriptions.create', compact('chambers', 'serial', 'nextPrescriptionNo'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'prescription_no' => 'required|string|unique:prescriptions,prescription_no',
            'serial_id' => 'nullable|exists:serials,id',
            'chamber_id' => 'nullable|exists:chambers,id',
            'patient_name' => 'required|string|max:150',
            'patient_phone' => 'required|string|max:20',
            'patient_age' => 'nullable|integer|min:1|max:120',
            'patient_gender' => 'required|string',
            'patient_address' => 'nullable|string|max:255',
            'consultation_date' => 'required|date',
            'bp_systolic' => 'nullable|string|max:20',
            'bp_diastolic' => 'nullable|string|max:20',
            'pulse' => 'nullable|string|max:20',
            'weight' => 'nullable|string|max:20',
            'temperature' => 'nullable|string|max:20',
            'blood_sugar' => 'nullable|string|max:50',
            'spo2' => 'nullable|string|max:20',
            'chief_complaints' => 'nullable|string',
            'clinical_history' => 'nullable|string',
            'diagnosis' => 'nullable|string',
            'medicines' => 'required|array|min:1',
            'medicines.*.name' => 'required|string',
            'medicines.*.dose' => 'nullable|string',
            'medicines.*.timing' => 'nullable|string',
            'medicines.*.duration' => 'nullable|string',
            'medicines.*.instructions' => 'nullable|string',
            'investigations' => 'nullable|array',
            'investigations.*.name' => 'nullable|string',
            'investigations.*.instructions' => 'nullable|string',
            'special_advice' => 'nullable|string',
            'next_visit_date' => 'nullable|date',
            'doctor_notes' => 'nullable|string',
        ]);

        // Filter empty investigations
        if (isset($validated['investigations'])) {
            $validated['investigations'] = array_values(array_filter($validated['investigations'], function($item) {
                return !empty($item['name']);
            }));
        }

        $prescription = Prescription::create($validated);

        // If linked to serial, mark serial as completed
        if ($prescription->serial_id) {
            Serial::where('id', $prescription->serial_id)->update(['status' => 'completed']);
        }

        return redirect()->route('admin.prescriptions.show', $prescription->id)
            ->with('success', "Digital Prescription {$prescription->prescription_no} created successfully!");
    }

    public function show($id)
    {
        $prescription = Prescription::with(['chamber', 'serial'])->findOrFail($id);
        $profile = DrProfile::first();
        return view('admin.prescriptions.show', compact('prescription', 'profile'));
    }

    public function print($id)
    {
        $prescription = Prescription::with(['chamber', 'serial'])->findOrFail($id);
        $profile = DrProfile::first();
        return view('admin.prescriptions.print', compact('prescription', 'profile'));
    }

    public function destroy($id)
    {
        $prescription = Prescription::findOrFail($id);
        $prescription->delete();
        return redirect()->route('admin.prescriptions.index')->with('success', 'Prescription deleted.');
    }
}

