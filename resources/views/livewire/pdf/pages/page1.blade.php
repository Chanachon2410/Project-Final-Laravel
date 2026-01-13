<style>
    /* CSS เฉพาะหน้า 1 */
    .page1-container { 
        color: #000; 
        line-height: 1.4; 
        padding: 10mm; /* กำหนดขอบหน้า 1 ที่นี่ */
    }
    .page1-header-title { 
        font-weight: 300; 
        margin-bottom: 5px; 
    }
    
    .page1-table { border-collapse: collapse; width: 100%; margin-top: 30px; }
    .page1-table th, .page1-table td {
        border: 1px solid #000 !important; 
        padding: 8px 10px;
        font-size: 10pt;
    }
    .page1-table th { background-color: #f2f2f2; }
    .footer-note { margin-top: 50px; font-size: 14pt; }
</style>

<div class="pdf-page page-break page1-container">
    <div class="text-center" style="margin-top: 30px;">
        <div class="page1-header-title" style="font-size: 11pt;">รายละเอียดการเก็บเงิน {{ $level_name ?? '-' }} ทุกแผนกวิชา</div>
        <div class="page1-header-title" style="font-size: 11pt;">ภาคเรียนที่ {{ $semester }}/{{ $year }}</div>
        <div class="page1-header-title" style="font-size: 11pt;">วิทยาลัยอาชีวศึกษานครปฐม</div>
    </div>
    
    <table class="page1-table" style="width: 90%; margin: 30px auto 0 auto;">
        <thead>
            <tr>
                <th style="width: 15%;" class="text-center">ลำดับที่</th>
                <th class="text-center">รายการ</th>
                <th style="width: 25%;" class="text-center">จำนวนเงิน</th>
            </tr>
        </thead>
        <tbody>
            @php $count = 1; @endphp
            @if(isset($fees) && is_array($fees))
                @foreach($fees as $fee)
                    <tr>
                        <td class="text-center">{{ $count++ }}</td>
                        <td>{{ $fee['name'] }}</td>
                        <td class="text-right">{{ number_format((float)$fee['amount'], 0) }}&nbsp;&nbsp;-</td>
                    </tr>
                @endforeach
            @endif
            <tr class="font-bold">
                <td colspan="2" class="text-center" style="padding: 12px;"> รวม ({{ $baht_text ?? '' }})</td>
                <td class="text-right">{{ number_format($total_amount ?? 0, 0) }}&nbsp;&nbsp;-</td>
            </tr>
        </tbody>
    </table>

    <div class="text-center font-bold footer-note">
    </div>
</div>