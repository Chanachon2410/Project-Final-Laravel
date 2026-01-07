<style>
    /* CSS เฉพาะหน้า 3 */
    .page3-container { 
        color: #000; 
        line-height: 1.2; 
        padding: 15mm; /* กำหนดขอบหน้า 3 ที่นี่ */
    }
    .page3-table { border-collapse: collapse; width: 100%; margin-bottom: 5px; }
    .page3-table th, .page3-table td {
        border: 1px solid #000 !important;
        padding: 4px 6px;
        font-size: 10pt;
    }
    .page3-ref-container { display: inline-block; vertical-align: middle; }
    .page3-ref-box {
        display: inline-block;
        width: 14px;
        height: 14px;
        border: 1px solid #000;
        text-align: center;
        line-height: 14px;
        margin-right: -1px;
        font-family: monospace;
        font-size: 9pt;
        font-weight: bold;
    }
</style>

<div class="pdf-page page3-container">
    <div class="text-center">
        <div class="font-bold" style="font-size: 14pt;">วิทยาลัยอาชีวศึกษานครปฐม</div>
        <div class="font-bold" style="font-size: 14pt;">บัตรลงทะเบียนรายวิชา</div>
        <div class="text-right" style="font-size: 10pt;">วันที่ {{ date('d/m') }}/{{ $year }}</div>
        <div class="text-center" style="font-size: 11pt;">ภาคเรียนที่ {{ $semester }} ปีการศึกษา {{ $year }}</div>
    </div>

    <div style="margin: 8px 0; font-size: 10pt;">
        <table class="w-full">
            <tr>
                <td style="border: none !important;">ชื่อ-สกุล {{ $student_name ?? '..........................................................' }}</td>
                <td class="text-right" style="border: none !important;">
                    รหัสประจำตัว 
                    <div class="page3-ref-container">
                        @php $s_code = str_pad($student_code ?? '', 13, ' ', STR_PAD_RIGHT); @endphp
                        @for($i=0; $i<13; $i++)
                            <div class="page3-ref-box">{{ trim(substr($s_code, $i, 1)) }}</div>
                        @endfor
                    </div>
                </td>
            </tr>
        </table>
        <div style="margin-top: 3px;">
            ประเภทวิชา {{ $major_name ?? '...' }} สาขาวิชา .......................................... ชั้น {{ $level_name ?? '...' }}
        </div>
    </div>

    <table class="page3-table">
        <thead>
            <tr style="background-color: #f9f9f9;">
                <th style="width: 8%;">ลำดับ</th>
                <th style="width: 15%;">รหัสวิชา</th>
                <th>ชื่อวิชา</th>
                <th style="width: 6%;">ท</th>
                <th style="width: 6%;">ป</th>
                <th style="width: 10%;">นก.</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $totalTheory = 0; $totalPractical = 0; $totalCredit = 0; 
                $subjects = $subjects ?? [];
                $maxRows = 8; /* Reduced rows to fit */
            @endphp
            @foreach($subjects as $index => $subj)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ $subj['code'] }}</td>
                    <td>{{ $subj['name'] }}</td>
                    <td class="text-center">{{ $subj['hour_theory'] }}</td>
                    <td class="text-center">{{ $subj['hour_practical'] }}</td>
                    <td class="text-center">{{ $subj['credit'] }}</td>
                </tr>
                @php 
                    $totalTheory += $subj['hour_theory']; 
                    $totalPractical += $subj['hour_practical']; 
                    $totalCredit += $subj['credit']; 
                @endphp
            @endforeach
            @for($i = count($subjects); $i < $maxRows; $i++)
                <tr><td class="text-center">&nbsp;</td><td></td><td></td><td></td><td></td><td></td></tr>
            @endfor
            <tr class="font-bold" style="background-color: #f9f9f9;">
                <td colspan="3" class="text-right">รวม</td>
                <td class="text-center">{{ $totalTheory }}</td>
                <td class="text-center">{{ $totalPractical }}</td>
                <td class="text-center">{{ $totalCredit }}</td>
            </tr>
        </tbody>
    </table>
    
    <table class="w-full" style="margin-top: 5px;">
        <tr>
            <td style="width: 45%; vertical-align: top; border: none !important;">
                <table class="page3-table">
                    <tr>
                        <td>ค่าบำรุงการศึกษา</td>
                        <td class="text-right">{{ number_format($total_amount ?? 0, 0) }} บาท</td>
                    </tr>
                    <tr>
                        <td>ค่าใช้จ่ายอื่นๆ</td>
                        <td class="text-right">- บาท</td>
                    </tr>
                    <tr class="font-bold">
                        <td>รวมจำนวนเงินทั้งสิ้น</td>
                        <td class="text-right">{{ number_format($total_amount ?? 0, 0) }} บาท</td>
                    </tr>
                </table>
            </td>
            <td style="width: 55%; padding-left: 10px; border: none !important;">
                <div style="border: 1px solid #000; padding: 5px; text-align: center;">
                    <div class="font-bold" style="font-size: 10pt;">ลงชื่อ</div>
                    <table class="w-full" style="margin-top: 10px; font-size: 9pt; border:none !important;">
                        <tr>
                            <td style="border: none !important;">.........................................<br>นักศึกษา</td>
                            <td style="border: none !important;">.........................................<br>ครูที่ปรึกษา</td>
                        </tr>
                    </table>
                    <div style="margin-top: 10px; font-size: 9pt;">
                        .........................................<br>งานทะเบียน
                    </div>
                </div>
            </td>
        </tr>
    </table>
    
    <div class="text-center" style="font-size: 9pt; margin-top: 5px;">
        * ชำระเงินได้ระหว่างวันที่ {{ $payment_start_date ?? '...' }} - {{ $payment_end_date ?? '...' }} ณ ธนาคารกรุงไทย ทุกสาขาทั่วประเทศ
    </div>

    <!-- Receipt Slip Bottom -->
    <div style="margin-top: 10px; border-top: 1px dashed #000; padding-top: 5px;">
        <div class="text-center font-bold" style="font-size: 10pt;">ส่วนนี้สำหรับนักศึกษาเก็บไว้เป็นหลักฐานการลงทะเบียน</div>
        <table class="w-full" style="margin-top: 5px; font-size: 9pt;">
            <tr>
                <td style="border: none !important;">ชื่อนักศึกษา {{ $student_name ?? '....................................' }} รหัส {{ $student_code ?? '................' }} ชั้น {{ $level_name ?? '...' }}</td>
            </tr>
            <tr>
                <td style="border: none !important;">สาขาวิชา {{ $major_name ?? '....................................' }} ได้ชำระเงินลงทะเบียนแล้ว</td>
            </tr>
            <tr>
                <td style="border: none !important;">ธนาคารกรุงไทย ทุกสาขาทั่วประเทศ เมื่อวันที่.........../.........../...........</td>
            </tr>
            <tr>
                <td class="text-right" style="padding-top: 5px; border: none !important;">
                    รับหลักฐานไว้แล้ว................................................เจ้าหน้าที่งานทะเบียน<br>
                    วันที่........../........../..........
                </td>
            </tr>
        </table>
    </div>
</div>