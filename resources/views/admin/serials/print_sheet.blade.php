<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Daily Serial Sheet - {{ $date }} | Dr. Abu Hanif Rakib</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    @media print {
      .no-print { display: none !important; }
      body { padding: 0; font-size: 12px; }
      @page { margin: 1cm; size: A4 portrait; }
    }
    body { font-family: 'Inter', sans-serif; color: #000; background: #fff; }
    .print-header { border-bottom: 2px solid #0F3B66; padding-bottom: 12px; margin-bottom: 16px; }
    table { width: 100%; border-collapse: collapse; }
    th, td { border: 1px solid #cbd5e1; padding: 8px 10px; }
    th { background-color: #f1f5f9; font-weight: 700; }
  </style>
</head>
<body class="p-4">

  <div class="no-print mb-4 d-flex justify-content-between align-items-center">
    <a href="{{ route('admin.serials.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back to Queue</a>
    <button onclick="window.print()" class="btn btn-primary btn-sm"><i class="bi bi-printer"></i> Print Daily Sheet</button>
  </div>

  <div class="print-header d-flex justify-content-between align-items-end">
    <div>
      <h2 class="h4 fw-bold mb-1 text-primary">Dr. Abu Hanif Rakib</h2>
      <div class="small fw-semibold">Consultant Medicine Specialist • BMDC Reg: 84321</div>
      <div class="small text-muted">{{ $chamber ? $chamber->name_en . ' (' . $chamber->address_en . ')' : 'All Chambers Daily Queue Sheet' }}</div>
    </div>
    <div class="text-end">
      <div class="h5 fw-bold mb-0">Daily Serial Roster</div>
      <div class="small fw-semibold text-danger">Date: {{ date('F d, Y (l)', strtotime($date)) }}</div>
      <div class="small text-muted">Total Patients: {{ count($serials) }}</div>
    </div>
  </div>

  <table class="table-sm">
    <thead>
      <tr>
        <th style="width: 5%;">SL#</th>
        <th style="width: 18%;">Serial Code</th>
        <th style="width: 25%;">Patient Name</th>
        <th style="width: 15%;">Contact Phone</th>
        <th style="width: 10%;">Age/Sex</th>
        <th style="width: 15%;">Visit Type</th>
        <th style="width: 12%;">Attended</th>
      </tr>
    </thead>
    <tbody>
      @forelse($serials as $idx => $s)
        <tr>
          <td class="text-center fw-bold">{{ $idx + 1 }}</td>
          <td class="fw-bold">{{ $s->serial_number }}</td>
          <td><strong>{{ $s->patient_name }}</strong></td>
          <td>{{ $s->patient_phone }}</td>
          <td>{{ $s->patient_age ? $s->patient_age . 'y' : '-' }} / {{ strtoupper(substr($s->patient_gender, 0, 1)) }}</td>
          <td class="text-capitalize">{{ $s->visit_type }}</td>
          <td class="text-center">
            <span style="display: inline-block; width: 18px; height: 18px; border: 1.5px solid #000; border-radius: 3px;"></span>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="7" class="text-center py-4">No appointment serials recorded for this date.</td>
        </tr>
      @endforelse
    </tbody>
  </table>

  <div class="mt-5 pt-4 d-flex justify-content-between text-muted small">
    <div>Generated: {{ date('Y-m-d H:i') }} • Chamber Reception Desk Copy</div>
    <div>Receptionist Signature: _________________________</div>
  </div>

</body>
</html>

