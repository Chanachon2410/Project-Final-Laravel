<style>
    /* CSS เฉพาะหน้า 2 */
    .page2-container { 
        color: #000; 
        line-height: 1.2; 
        padding: 7mm; /* กำหนดขอบหน้า 2 ที่นี่ */
    }
    .page2-table { border-collapse: collapse; width: 100%; margin-bottom: 5px; }
    .page2-table th, .page2-table td {
        border: 1px solid #000 !important;
        padding: 4px 6px;
        font-size: 10pt;
    }
    
    .page2-ref-container { display: inline-block; vertical-align: middle; }
    .page2-ref-box {
        display: inline-block;
        width: 16px;
        height: 16px;
        border: 1px solid #000;
        text-align: center;
        line-height: 16px;
        margin-right: -1px;
        font-family: monospace;
        font-size: 10pt;
        font-weight: bold;
    }
</style>

<div class="pdf-page page2-container">
    @for($part = 1; $part <= 2; $part++)
        <div style="border: 1px solid #000; padding: 4mm; position: relative; box-sizing: border-box; margin-bottom: 2mm;">
            <table class="w-full" style="border: none;">
                <tr style="border: none;">
                    <td style="width: 60px; vertical-align: top; border: none;">
                        <img src="{{ ($isPdf ?? false) ? public_path('images/logo (1).png') : asset('images/logo (1).png') }}" alt="Logo" style="width: 60px; height: auto;">
                    </td>
                    <td class="text-center" style="border: none; padding-left: 0mm;">
                        <div style="font-size: 14pt; font-weight: 300;">ใบแจ้งการชำระเงินค่าบำรุงการศึกษา</div>
                        <div style="font-size: 12pt; font-weight: 300;">วิทยาลัยอาชีวศึกษานครปฐม</div>
                        <div style="font-size: 10pt; font-weight: 300;">Company Code : 81245</div>
                    </td>
                    <td class="text-right" style="vertical-align: top; width: 180px; border: none; padding-right: 5mm;">
                        <div class="font-bold" style="font-size: 10pt;">ส่วนที่ {{ $part }} (สำหรับ{{ $part == 1 ? 'นักเรียน' : 'ธนาคาร' }})</div>
                        <div style="font-size: 9pt;">ภาคเรียนที่ {{ $semester }} ปีการศึกษา {{ $year }}</div>
                    </td>
                </tr>
            </table>

            <div style="margin: 5px 0; font-size: 9pt;">ชื่อ - นามสกุลนักเรียน : {{ $student_name ?? '................................................................................................' }}</div>
            
            <div style="margin-bottom: 5px; font-size: 9pt;">
                รหัสประจำตัวสอบ (Ref.1) : 
                <div class="page2-ref-container">
                    @php $s_code = str_pad($student_code ?? '', 13, ' ', STR_PAD_RIGHT); @endphp
                    @for($i=0; $i<13; $i++)
                        <div class="page2-ref-box">{{ trim(substr($s_code, $i, 1)) }}</div>
                    @endfor
                </div>
            </div>

            <div style="margin-bottom: 5px; font-size: 9pt;">
                รหัสกลุ่ม (Ref.2) : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <div class="page2-ref-container">
                    @php $g_code = str_pad($group_code ?? '', 6, ' ', STR_PAD_RIGHT); @endphp
                    @for($i=0; $i<6; $i++)
                        <div class="page2-ref-box">{{ trim(substr($g_code, $i, 1)) }}</div>
                    @endfor
                </div>
            </div>

            @if($part == 1)
            <div style="border: 1px solid #000; font-size: 8pt; background-color: #fafafa; margin-bottom: 5px; padding: 3px;">
                <div class="text-center font-bold" style="text-decoration: underline; margin-bottom: 2px;">ตัวอย่างการกรอก Ref.2 ของระดับชั้น {{ $level_name ?? '...' }} ทุกแผนกวิชา</div>
                <table class="w-full" style="border: none;">
                    @if(isset($all_majors) && count($all_majors) > 0)
                        @php
                            $chunks = $all_majors->chunk(3); // แบ่งข้อมูลทีละ 3 สาขาต่อแถว
                        @endphp
                        @foreach($chunks as $chunk)
                            <tr style="border: none;">
                                @foreach($chunk as $major)
                                    <td style="border: none; padding: 1px; width: 33%;">
                                        {{ $major->major_code }} {{ $major->major_name }}
                                    </td>
                                @endforeach
                                {{-- เติมช่องว่างให้ครบ 3 ช่อง ถ้าแถวสุดท้ายไม่เต็ม --}}
                                @for($i = $chunk->count(); $i < 3; $i++)
                                    <td style="border: none; padding: 1px; width: 33%;"></td>
                                @endfor
                            </tr>
                        @endforeach
                    @else
                        {{-- Fallback กรณีไม่มีข้อมูล --}}
                        <tr style="border: none;">
                            <td class="text-center" style="border: none; padding: 5px; color: red;">ไม่พบข้อมูลสาขาวิชา</td>
                        </tr>
                    @endif
                </table>
            </div>
            @else
            <div style="margin: 5px 0;">
                <div class="font-bold" style="color: #0056b3; font-size: 12pt;">ธนาคารกรุงไทย จำกัด (มหาชน)</div>
                <div class="font-bold">Company Code : 81245</div>
            </div>
            @endif

            <table class="page2-table">
                <thead>
                    <tr style="background-color: #f9f9f9;">
                        <th style="width: 8%;">ที่</th>
                        <th>รายการ</th>
                        <th style="width: 25%;">จำนวนเงิน</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">1</td>
                        <td>ค่าบำรุงการศึกษา</td>
                        <td class="text-right">{{ number_format($total_amount ?? 0, 2) }}</td>
                    </tr>
                    <tr class="font-bold">
                        <td colspan="2" class="text-center">เงินสด (ตัวอักษร) ......({{ $baht_text ?? '' }})...... รวม</td>
                        <td class="text-right">{{ number_format($total_amount ?? 0, 2) }}</td>
                    </tr>
                </tbody>
            </table>

            <table class="w-full" style="margin-top: 5px; font-size: 9pt;">
                <tr style="border: none;">
                    <td style="width: 60%; vertical-align: top; border: none;">
                        <div class="font-bold" style="text-decoration: underline;">หมายเหตุ</div>
                        <div style="font-size: 8pt;">
                            - ยอดเงินรวมข้างต้น ยังไม่รวมอัตราค่าธรรมเนียมของธนาคาร 10 บาท<br>
                            - สามารถนำไปชำระเงินได้ที่ธนาคารกรุงไทย จำกัด (มหาชน) ทุกสาขาทั่วประเทศ
                        </div>
                    </td>
                    <td class="text-right" style="vertical-align: bottom; border: none;">
                        <div style="border: 1px solid #000; padding: 5px; text-align: center; width: 200px; float: right;">
                            สำหรับเจ้าหน้าที่ธนาคาร<br><br>
                            ...............................................
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        @if($part == 1)
            <div style="border-bottom: 1px dashed #000; margin: 5mm 0;"></div>
        @endif
    @endfor
    <div class="text-center" style="font-size: 9pt;">
        *** ชำระเงินได้ระหว่างวันที่ {{ $payment_start_date ?? '...' }} - {{ $payment_end_date ?? '...' }} ณ ธนาคารกรุงไทย ทุกสาขาทั่วประเทศ ***
    </div>
</div>