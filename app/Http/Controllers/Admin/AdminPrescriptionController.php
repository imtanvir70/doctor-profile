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
            $s = trim($request->search);
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

        // Recent & Today's Serials for 1-click patient auto-fill
        $recentSerials = Serial::latest()->take(25)->get();

        // Generate next safe prescription sequence
        $year = date('Y');
        $count = Prescription::whereYear('created_at', $year)->count() + 1;
        $nextPrescriptionNo = 'RX-' . $year . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
        while (Prescription::where('prescription_no', $nextPrescriptionNo)->exists()) {
            $count++;
            $nextPrescriptionNo = 'RX-' . $year . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
        }

        return view('admin.prescriptions.create', compact('chambers', 'serial', 'nextPrescriptionNo', 'recentSerials'));
    }

    public function store(Request $request)
    {
        // 1. Safe data filtering: Strip any empty medicine or investigation rows before validation
        $rawMedicines = $request->input('medicines', []);
        $cleanMedicines = array_values(array_filter($rawMedicines, function($m) {
            return is_array($m) && !empty(trim($m['name'] ?? ''));
        }));

        $rawInvestigations = $request->input('investigations', []);
        $cleanInvestigations = array_values(array_filter($rawInvestigations, function($inv) {
            return is_array($inv) && !empty(trim($inv['name'] ?? ''));
        }));

        // Avoid duplicate prescription number conflict
        $rxNo = $request->input('prescription_no');
        if (Prescription::where('prescription_no', $rxNo)->exists()) {
            $year = date('Y');
            $count = Prescription::whereYear('created_at', $year)->count() + rand(2, 50);
            $rxNo = 'RX-' . $year . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
        }

        $request->merge([
            'prescription_no' => $rxNo,
            'medicines' => $cleanMedicines,
            'investigations' => $cleanInvestigations,
        ]);

        $validated = $request->validate([
            'prescription_no' => 'required|string|unique:prescriptions,prescription_no',
            'serial_id' => 'nullable|exists:serials,id',
            'chamber_id' => 'nullable|exists:chambers,id',
            'patient_name' => 'required|string|max:150',
            'patient_phone' => 'nullable|string|max:20',
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
            'medicines.*.name' => 'required|string|max:200',
            'medicines.*.dose' => 'nullable|string|max:100',
            'medicines.*.timing' => 'nullable|string|max:100',
            'medicines.*.duration' => 'nullable|string|max:100',
            'medicines.*.instructions' => 'nullable|string|max:255',
            'investigations' => 'nullable|array',
            'investigations.*.name' => 'nullable|string|max:200',
            'investigations.*.instructions' => 'nullable|string|max:255',
            'special_advice' => 'nullable|string',
            'next_visit_date' => 'nullable|date',
            'doctor_notes' => 'nullable|string',
        ], [
            'medicines.required' => 'অন্তত একটি ওষুধের নাম প্রদান করতে হবে / At least one medicine is required.',
            'medicines.min' => 'অন্তত একটি ওষুধের নাম প্রদান করতে হবে / At least one medicine is required.',
            'patient_name.required' => 'রোগীর নাম প্রদান করা আবশ্যক / Patient name is required.',
        ]);

        if (empty($validated['patient_phone'])) {
            $validated['patient_phone'] = 'N/A';
        }

        if (empty($validated['chamber_id'])) {
            $defaultChamber = Chamber::where('is_active', true)->orderBy('display_order')->first();
            if ($defaultChamber) {
                $validated['chamber_id'] = $defaultChamber->id;
            }
        }

        $prescription = Prescription::create($validated);

        // If linked to serial, mark serial as completed
        if ($prescription->serial_id) {
            Serial::where('id', $prescription->serial_id)->update(['status' => 'completed']);
        }

        if ($request->input('action') === 'save_and_print') {
            return redirect()->route('admin.prescriptions.print', $prescription->id);
        }

        return redirect()->route('admin.prescriptions.show', $prescription->id)
            ->with('success', "Digital Prescription {$prescription->prescription_no} created successfully!");
    }

    public function show($id)
    {
        $prescription = Prescription::with(['chamber', 'serial.chamber'])->findOrFail($id);
        $profile = DrProfile::first();
        $chamber = $prescription->chamber 
            ?? $prescription->serial?->chamber 
            ?? Chamber::where('is_active', true)->orderBy('display_order')->first();

        return view('admin.prescriptions.show', compact('prescription', 'profile', 'chamber'));
    }

    public function edit($id)
    {
        $prescription = Prescription::with(['chamber', 'serial'])->findOrFail($id);
        $chambers = Chamber::where('is_active', true)->get();
        return view('admin.prescriptions.edit', compact('prescription', 'chambers'));
    }

    public function update(Request $request, $id)
    {
        $prescription = Prescription::findOrFail($id);

        // Safe filtering of empty rows
        $rawMedicines = $request->input('medicines', []);
        $cleanMedicines = array_values(array_filter($rawMedicines, function($m) {
            return is_array($m) && !empty(trim($m['name'] ?? ''));
        }));

        $rawInvestigations = $request->input('investigations', []);
        $cleanInvestigations = array_values(array_filter($rawInvestigations, function($inv) {
            return is_array($inv) && !empty(trim($inv['name'] ?? ''));
        }));

        $request->merge([
            'medicines' => $cleanMedicines,
            'investigations' => $cleanInvestigations,
        ]);

        $validated = $request->validate([
            'prescription_no' => 'required|string|unique:prescriptions,prescription_no,' . $prescription->id,
            'chamber_id' => 'nullable|exists:chambers,id',
            'patient_name' => 'required|string|max:150',
            'patient_phone' => 'nullable|string|max:20',
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
            'medicines.*.name' => 'required|string|max:200',
            'medicines.*.dose' => 'nullable|string|max:100',
            'medicines.*.timing' => 'nullable|string|max:100',
            'medicines.*.duration' => 'nullable|string|max:100',
            'medicines.*.instructions' => 'nullable|string|max:255',
            'investigations' => 'nullable|array',
            'investigations.*.name' => 'nullable|string|max:200',
            'investigations.*.instructions' => 'nullable|string|max:255',
            'special_advice' => 'nullable|string',
            'next_visit_date' => 'nullable|date',
            'doctor_notes' => 'nullable|string',
        ], [
            'medicines.required' => 'অন্তত একটি ওষুধের নাম প্রদান করতে হবে / At least one medicine is required.',
            'medicines.min' => 'অন্তত একটি ওষুধের নাম প্রদান করতে হবে / At least one medicine is required.',
            'patient_name.required' => 'রোগীর নাম প্রদান করা আবশ্যক / Patient name is required.',
        ]);

        if (empty($validated['patient_phone'])) {
            $validated['patient_phone'] = 'N/A';
        }

        if (empty($validated['chamber_id'])) {
            $defaultChamber = Chamber::where('is_active', true)->orderBy('display_order')->first();
            if ($defaultChamber) {
                $validated['chamber_id'] = $defaultChamber->id;
            }
        }

        $prescription->update($validated);

        if ($request->input('action') === 'save_and_print') {
            return redirect()->route('admin.prescriptions.print', $prescription->id);
        }

        return redirect()->route('admin.prescriptions.show', $prescription->id)
            ->with('success', "Prescription {$prescription->prescription_no} updated successfully!");
    }

    public function print($id)
    {
        $prescription = Prescription::with(['chamber', 'serial.chamber'])->findOrFail($id);
        $profile = DrProfile::first();
        $chamber = $prescription->chamber 
            ?? $prescription->serial?->chamber 
            ?? Chamber::where('is_active', true)->orderBy('display_order')->first();

        return view('admin.prescriptions.print', compact('prescription', 'profile', 'chamber'));
    }

    public function destroy($id)
    {
        $prescription = Prescription::findOrFail($id);
        $prescription->delete();
        return redirect()->route('admin.prescriptions.index')->with('success', 'Prescription deleted successfully.');
    }
}
