<style>
    /* --- CSS เฉพาะหน้า 3 --- */
    .page3-container {
        color: #000;
        line-height: 1.2;
        padding: 10mm;
    }

    .page3-table {
        border-collapse: collapse;
        width: 100%;
        margin-bottom: 5px;
        font-size: 10px;
        line-height: 1.2;
    }

    .page3-table th,
    .page3-table td {
        border: 1px solid #000 !important;
        padding: 4px 5px;
        vertical-align: middle;
    }

    /* --- Helper classes --- */
    /* เพิ่ม class นี้ เพื่อสั่งลบ Padding เฉพาะช่องที่ต้องการ */
    .no-padding {
        padding: 0 !important;
    }

    .text-center { text-align: center; }
    .text-right { text-align: right; }
    .text-left { text-align: left; }
    .font-bold { font-weight: bold; }
    .align-top { vertical-align: top !important; }

    .page3-ref-container {
        display: inline-block;
        vertical-align: middle;
    }

    .page3-ref-box {
        display: inline-block;
        width: 15px;
        height: 15px;
        border: 1px solid #000;
        text-align: center;
        line-height: 13px;
        margin-right: -1px;
        font-family: sans-serif;
        font-size: 9pt;
        font-weight: bold;
        vertical-align: middle;
    }
</style>

<div class="pdf-page page3-container">
    <table style="width: 100%; border: none !important; margin-bottom: 5px;">
        <tr>
            <td style="width: 20%; border: none !important;"></td>
            <td style="width: 60%; text-align: center; border: none !important; vertical-align: top;">
                <div class="font-bold" style="font-size: 14pt;">วิทยาลัยอาชีวศึกษานครปฐม</div>
                <div class="font-bold" style="font-size: 14pt;">บัตรลงทะเบียนรายวิชา</div>
            </td>
            <td
                style="width: 20%; text-align: right; vertical-align: top; border: none !important; font-size: 7.5pt; line-height: 1.2;">
                วันที่ ........../........../..........<br>
                ภาคเรียนที่ {{ $semester }} ปีการศึกษา {{ $year }}
            </td>
        </tr>
    </table>

    <div style="margin: 5px 0;">
        <table class="w-full" style="font-size: 7.5pt; border-collapse: collapse;">
            <tr>
                <td style="border: none !important; padding: 2px 0;">
                    <div style="display: flex; align-items: flex-end;">
                        <span style="white-space: nowrap;">ชื่อ-สกุล</span>
                        <span
                            style="border-bottom: 1px dotted #000; flex-grow: 1; padding-left: 5px;">{{ $student_name }}</span>
                        
                        <span style="white-space: nowrap; margin-left: 15px; margin-right: 5px;">รหัสประจำตัว</span>
                        <div class="page3-ref-container">
                            @php $s_code = str_pad($student_code ?? '', 13, ' ', STR_PAD_RIGHT); @endphp
                            @for ($i = 0; $i < 13; $i++)
                                @php $char = substr($s_code, $i, 1); @endphp
                                <div class="page3-ref-box">{{ trim($char) === '' ? '' : $char }}</div>
                            @endfor
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <table
            style="width: 100%; margin-top: 3px; font-size: 7.5pt; border: none !important; border-collapse: collapse;">
            <tr>
                <td style="border: none !important; padding: 2px 0; width: 30%;">
                    <div style="display: flex; align-items: flex-end;">
                        <span style="white-space: nowrap;">ประเภทวิชา</span>
                        <span
                            style="border-bottom: 1px dotted #000; flex-grow: 1; margin-left: 5px; text-align: center;">&nbsp;</span>
                    </div>
                </td>
                <td style="border: none !important; padding: 2px 0; width: 30%; padding-left: 10px;">
                    <div style="display: flex; align-items: flex-end;">
                        <span style="white-space: nowrap;">สาขาวิชา</span>
                        <span
                            style="border-bottom: 1px dotted #000; flex-grow: 1; margin-left: 5px; text-align: center;">{{ $major_name }}</span>
                    </div>
                </td>
                <td style="border: none !important; padding: 2px 0; width: 30%; padding-left: 10px;">
                    <div style="display: flex; align-items: flex-end;">
                        <span style="white-space: nowrap;">สาขางาน</span>
                        <span
                            style="border-bottom: 1px dotted #000; flex-grow: 1; margin-left: 5px; text-align: center;">&nbsp;</span>
                    </div>
                </td>
                <td style="border: none !important; padding: 2px 0; width: 10%; padding-left: 10px;">
                    <div style="display: flex; align-items: flex-end;">
                        <span style="white-space: nowrap;">ชั้น</span>
                        <span
                            style="border-bottom: 1px dotted #000; flex-grow: 1; margin-left: 5px; text-align: center;">{{ $level_name }}</span>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <table class="page3-table" style="table-layout: fixed; width: 100%;">
        <thead>
            <tr>
                <th rowspan="2" class="text-center" style="width: 45px;">ลำดับที่</th>
                <th rowspan="2" class="text-center" style="width: 90px;">รหัสวิชา</th>
                <th rowspan="2" class="text-center">ชื่อวิชา</th>
                <th colspan="3" class="text-center" style="width: 140px;">จำนวนช.ม. - หน่วยกิต</th>
            </tr>
            <tr>
                <th class="text-center" style="width: 35px;">ท</th>
                <th class="text-center" style="width: 35px;">ป</th>
                <th class="text-center" style="width: 70px;">หน่วยกิต</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalTheory = 0;
                $totalPractical = 0;
                $totalCredit = 0;
                $subjects = $subjects ?? [];
                $maxRows = 10;
            @endphp

            @foreach ($subjects as $index => $subj)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ $subj['code'] }}</td>
                    <td class="text-left" style="padding-left: 8px;">{{ $subj['name'] }}</td>
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

            @for ($i = count($subjects); $i < $maxRows; $i++)
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endfor

            <!-- แถวรวมแบบที่ 1 -->
            <tr class="font-bold">
                <td></td>
                <td></td>
                <td class="text-center">รวม</td>
                <td class="text-center">{{ $totalTheory }}</td>
                <td class="text-center">{{ $totalPractical }}</td>
                <td class="text-center">{{ $totalCredit }}</td>
            </tr>
            <!-- แถวรวมแบบที่ 2 (ท+ป) -->
            <tr class="font-bold">
                <td></td>
                <td></td>
                <td class="text-center">รวม</td>
                <td colspan="2" class="text-center">{{ $totalTheory + $totalPractical }}</td>
                <td class="text-center">{{ $totalCredit }}</td>
            </tr>
        </tbody>
    </table>

    <table class="page3-table">
        <tbody>
            @php
                $fees = $fees ?? [];
                $maxFeeRows = 5;
                // คำนวณยอดรวม (ถ้าไม่มีตัวแปรส่งมา)
                $total_amount = $total_amount ?? collect($fees)->sum('amount');
                
                // หาจำนวนรายการในตารางที่ 1 เพื่อเริ่มนับต่อ
                $startSequence = (isset($subjects) ? count($subjects) : 0) + 1;
            @endphp

            @for ($i = 0; $i < $maxFeeRows; $i++)
                <tr style="height: 16px;">
                    <td class="text-center" style="width: 25px;">
                        {{ isset($fees[$i]) ? ($startSequence + $i) : '' }}
                    </td>

                    <td class="text-left">
                        {{ isset($fees[$i]) ? $fees[$i]['name'] : '' }}
                    </td>

                    <td class="text-right" style="width: 60px;">
                        {{ isset($fees[$i]) ? number_format($fees[$i]['amount'], 0) : '' }}
                    </td>

                    <td class="text-center" style="width: 30px;">
                        {{ isset($fees[$i]) ? 'บาท' : '' }}
                    </td>

                    @if ($i === 0)
                        <td rowspan="{{ $maxFeeRows + 1 }}" class="align-top no-padding" style="width: 30%;">

                            <div class="font-bold text-center"
                                style="font-size: 11px; padding: 4px 2px; border-bottom: 1px solid #000;">
                                สำหรับงานการเงิน
                            </div>

                            <div style="padding: 4px 5px; font-size: 10px; line-height: 1.5;">
                                <div>ใบเสร็จเล่มที่................................................</div>
                                <div>เลขที่..........................................................</div>
                                <div>วันที่................../................./......................</div>

                                <div class="text-center" style="margin-top: 8px;">
                                    ลงชื่อ......................................<br>
                                    <span class="font-bold">ผู้รับเงิน</span>
                                </div>
                            </div>
                        </td>
                    @endif
                </tr>
            @endfor

            <tr class="font-bold" style="height: 16px; background-color: #f9fafb;">
                <td colspan="2" class="text-center">รวมจำนวนเงินทั้งสิ้น</td>
                <td class="text-right">{{ number_format($total_amount, 0) }}</td>
                <td class="text-center">บาท</td>
            </tr>
        </tbody>
    </table>

    <!-- ส่วนที่เพิ่มใหม่: ลายเซ็นตามรูปภาพ (ปรับให้เล็กลงและตรงขอบ) -->
    <div style="margin-top: 5px;">
        <table style="width: 100%; border-collapse: collapse; border: none !important;">
            <tr>
                <!-- สำหรับเจ้าหน้าที่ธนาคาร -->
                <td style="width: 22%; border: 1px solid #000; vertical-align: top; padding: 0;">
                    <table style="width: 100%; height: 115px; border-collapse: collapse; border: none !important;">
                        <tr>
                            <td style="text-align: center; vertical-align: middle; border-bottom: 1px solid #000; height: 32px; padding: 0 2px;">
                                <div class="font-bold" style="font-size: 9pt;">สำหรับเจ้าหน้าที่ธนาคาร</div>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center; vertical-align: bottom; padding-bottom: 2px; border: none !important;">
                                <div style="margin-bottom: 5px;">..............................</div>
                                <div class="font-bold" style="font-size: 9pt;">ผู้รับเงิน</div>
                            </td>
                        </tr>
                    </table>
                </td>

                <!-- ช่องว่างคั่นกลาง -->
                <td style="width: 2%; border: none !important;"></td>

                <!-- ตารางลงชื่อ 3 ฝ่าย -->
                <td style="width: 76%; vertical-align: top; padding: 0;">
                    <table style="width: 100%; border-collapse: collapse; border: 1px solid #000;">
                        <tr>
                            <th colspan="3" class="text-center font-bold" style="border: 1px solid #000; padding: 0; font-size: 9pt; height: 32px; vertical-align: middle;">ลงชื่อ</th>
                        </tr>
                        <tr>
                            <td class="text-center font-bold" style="border-right: 1px solid #000; width: 33.33%; padding: 8px 3px; font-size: 9pt;">นักศึกษา</td>
                            <td class="text-center font-bold" style="border-right: 1px solid #000; width: 33.33%; padding: 8px 3px; font-size: 9pt;">ครูที่ปรึกษา</td>
                            <td class="text-center font-bold" style="width: 33.33%; padding: 8px 3px; font-size: 9pt;">ทะเบียน</td>
                        </tr>
                        <tr style="height: 65px;">
                            <td class="text-center" style="border-right: 1px solid #000; vertical-align: bottom; padding-bottom: 8px; font-size: 8pt;">
                                <div style="margin-bottom: 12px;">..........................................</div>
                                <div>(..........................................)</div>
                            </td>
                            <td class="text-center" style="border-right: 1px solid #000; vertical-align: bottom; padding-bottom: 8px; font-size: 8pt;">
                                <div style="margin-bottom: 12px;">..........................................</div>
                                <div>(..........................................)</div>
                            </td>
                            <td class="text-center" style="vertical-align: bottom; padding-bottom: 8px; font-size: 8pt;">
                                <div style="margin-bottom: 12px;">..........................................</div>
                                <div>(..........................................)</div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <div class="text-center font-bold" style="font-size: 9pt; margin-top: 10px;">
        * ชำระเงินได้ระหว่างวันที่ {{ $payment_start_date ?? '6 - 31 พฤษภาคม 2568' }} ได้ที่ ณ ธนาคารกรุงไทย ทุกสาขาทั่วประเทศ
    </div>

    <!-- เส้นตัดตามรอย -->
    <div style="text-align: center; margin-top: 5px; margin-bottom: 5px; font-size: 8pt;">
        - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - ตัดตามรอยนี้ - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    </div>

    <!-- ส่วนท้าย: ส่วนนักศึกษาเก็บไว้เป็นหลักฐาน -->
    <div style="font-size: 9pt; line-height: 1.8; padding: 0 20px 0 60px;">
        <div class="text-center font-bold" style="margin-bottom: 5px; font-style: italic; margin-left: -40px;">
            ส่วนนี้นักศึกษาเก็บไว้เป็นหลักฐานการลงทะเบียน
        </div>
        
        <div style="white-space: nowrap;">
            ชื่อนักศึกษา....................................................................รหัส.......................................ชั้น............................
        </div>
        <div style="white-space: nowrap;">
            สาขาวิชา...........................................................................................ได้ชำระเงินลงทะเบียนโดยฝากเงินเข้าบัญชี
        </div>
        <div style="white-space: nowrap;">
            ธนาคารกรุงไทย ทุกสาขาทั่วประเทศ <b>เมื่อวันที่</b>....................................................................................................
        </div>
        <div class="font-bold">
            และรับหลักฐานการลงทะเบียนแล้ว
        </div>
        
        <div style="margin-top: 5px; padding-left: 20%;">
            รับหลักฐานไว้แล้ว..............................................................เจ้าหน้าที่งานทะเบียน
        </div>
        <div style="padding-left: 35%;">
            วันที่............/......................../................
        </div>
    </div>
</div>
