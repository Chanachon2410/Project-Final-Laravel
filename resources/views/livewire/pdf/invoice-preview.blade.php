@php
    $major = \App\Models\Major::find($major_id);
    $level = \App\Models\Level::find($level_id);
    $totalAmount = $this->calculateTotal();
    $bahtText = $this->getBahtText();

    // Prepare data for the layout
    $layoutData = [
        'level_name' => $level->name ?? '-',
        'major_name' => $major->major_name ?? '-',
        'semester' => $semester,
        'year' => $year,
        'fees' => $fees, // $fees structure: [['name' => '...', 'amount' => ...], ...]
        'subjects' => $selectedSubjects, // Structure matches layout expectation
        'total_amount' => $totalAmount,
        'baht_text' => $bahtText,
        'payment_start_date' => $payment_start_date ? \Carbon\Carbon::parse($payment_start_date)->format('d/m/Y') : '...',
        'payment_end_date' => $payment_end_date ? \Carbon\Carbon::parse($payment_end_date)->format('d/m/Y') : '...',
        
        // Mock data for preview since student is not selected yet
        'student_name' => null, 
        'student_code' => null,
        'group_code' => null,
    ];
@endphp

@include('livewire.pdf.invoice-layout', $layoutData)