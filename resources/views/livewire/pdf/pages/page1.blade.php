<style>
    /* CSS เฉพาะหน้า 1 */
    .page1-container {
        color: #000;
        line-height: 1.4;
        padding: 10mm;
    }

    .page1-header-title {
        font-weight: 300;
        margin-bottom: 5px;
    }

    .page1-table {
        border-collapse: collapse;
        width: 100%;
        margin-top: 30px;
    }

    .page1-table th,
    .page1-table td {
        border: 1px solid #000 !important;
        padding: 8px 10px;
        font-size: 10pt;
    }

    .page1-table th {
        background-color: #f2f2f2;
    }

    .footer-note {
        margin-top: 50px;
        font-size: 14pt;
    }
</style>

<div class="pdf-page page-break page1-container">
    <div class="text-center" style="margin-top: 30px;">
        <div class="page1-header-title" style="font-size: 11pt;">รายละเอียดการเก็บเงิน {{ $level_name ?? '-' }}
            ทุกแผนกวิชา</div>
        <div class="page1-header-title" style="font-size: 11pt;">ภาคเรียนที่ {{ $semester ?? '-' }}/{{ $year ?? '-' }}
        </div>
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
            @php 
                $count = 1; 
                $generalFees = [];
                $tuitionFees = [];
                $generalTotal = 0;
                $tuitionTotal = 0;

                // แยกประเภทรายการ
                if (isset($fees) && is_array($fees)) {
                    foreach ($fees as $fee) {
                        if (str_starts_with($fee['name'], 'ค่าลงทะเบียน')) {
                            $tuitionFees[] = $fee;
                            $tuitionTotal += (float)$fee['amount'];
                        } else {
                            $generalFees[] = $fee;
                            $generalTotal += (float)$fee['amount'];
                        }
                    }
                }
            @endphp
            
            {{-- 1. กลุ่มค่าใช้จ่ายทั่วไป --}}
            @foreach ($generalFees as $fee)
                <tr>
                    <td class="text-center">{{ $count++ }}</td>
                    <td>{{ $fee['name'] }}</td>
                    <td class="text-right">{{ number_format((float) $fee['amount'], 0) }}&nbsp;&nbsp;-</td>
                </tr>
            @endforeach

            {{-- 2. รวมรายจ่ายต่างๆ (เฉพาะกลุ่มทั่วไป) - ซ่อนสำหรับ ปวช. ตามคำขอ --}}
            @if(!str_contains($level_name ?? '', 'ปวช'))
                <tr class="font-bold">
                    <td colspan="2" class="text-center" style="padding: 12px;"> รวมรายจ่ายต่าง ๆ </td>
                    <td class="text-right">{{ number_format($generalTotal, 0) }}&nbsp;&nbsp;-</td>
                </tr>
            @endif

            {{-- 3. กลุ่มค่าลงทะเบียน --}}
            @foreach ($tuitionFees as $fee)
                <tr>
                    <td class="text-center">{{ $count++ }}</td>
                    <td>{{ $fee['name'] }}</td>
                    <td class="text-right">{{ number_format((float) $fee['amount'], 0) }}&nbsp;&nbsp;-</td>
                </tr>
            @endforeach

            {{-- 4. รวมทั้งสิ้น (ก่อนค่าปรับ) --}}
            <tr class="font-bold">
                <td colspan="2" class="text-center" style="padding: 12px;"> 
                    รวมทั้งสิ้น 
                    @if(!isset($late_fee_props) || !$late_fee_props['show'] || $late_fee_props['type'] == 'daily')
                        ({{ $baht_text ?? '' }})
                    @endif
                </td>
                <td class="text-right">{{ number_format($total_amount ?? 0, 0) }}&nbsp;&nbsp;-</td>
            </tr>

            {{-- 5. ส่วนแสดงค่าปรับ (สำหรับ ปวช./ปวส.) --}}
            @if (isset($late_fee_props) && $late_fee_props['show'] && $late_fee_props['type'] != 'daily')
                
                {{-- Header คั่น: ช่วงวันที่ --}}
                <tr class="font-bold">
                    <td colspan="3" class="text-center" style="padding: 10px; background-color: #fff; border-bottom: 1px solid #000;">
                        {{ $late_fee_range ?? '' }} เพิ่มค่าปรับลงทะเบียนล่าช้า
                    </td>
                </tr>

                {{-- รายการค่าปรับ --}}
                <tr>
                    <td class="text-center">{{ $count++ }}</td>
                    <td>ค่าปรับลงทะเบียนล่าช้า</td>
                    <td class="text-right">{{ $late_fee_props['amount_flat'] }}&nbsp;&nbsp;-</td>
                </tr>

                {{-- รวมทั้งสิ้นสุทธิ (รวมค่าปรับ) --}}
                <tr class="font-bold">
                    <td colspan="2" class="text-center" style="padding: 12px;"> 
                        รวมทั้งสิ้น ({{ $grand_baht_text ?? '' }})
                    </td>
                    <td class="text-right">{{ number_format($grand_total ?? ($total_amount ?? 0), 0) }}&nbsp;&nbsp;-</td>
                </tr>

            @endif
        </tbody>
    </table>

    <div class="footer-note" style="text-align: left; font-size: 11pt; margin-top: 30px; margin-left: 5%;">
        <div style="margin-bottom: 5px;">1. *หมายเหตุ ค่าธรรมเนียมจ่ายผ่านธนาคาร 10 บาท</div>

        {{-- แสดงผลค่าปรับตามข้อมูลที่ Pre-calculate มาจาก Controller --}}
        @if (isset($late_fee_props) && $late_fee_props['show'])

            @if ($late_fee_props['type'] == 'daily')
                {{-- === แบบรายวัน (ป.ตรี) === --}}
                <div style="margin-top: 5px;">
                    2. ค่าปรับลงทะเบียนล่าช้าตั้งแต่วันที่ {{ $late_fee_props['header_date'] }} เป็นต้นไป มีดังนี้
                </div>
                <div style="margin-left: 20px; margin-top: 5px; display: block;">
                    @if (!empty($late_fee_props['schedule']))
                        @foreach ($late_fee_props['schedule'] as $item)
                            <div style="display: block; width: 100%; margin-bottom: 2px;">
                                - วันที่ {{ $item['date_full'] }} {{ $item['is_last'] ? 'เป็นต้นไป' : '' }} ค่าปรับ
                                {{ $item['amount'] }} บาท
                            </div>
                        @endforeach
                    @endif
                </div>
            @else
                {{-- === แบบเหมาจ่าย (ปวช/ปวส) === --}}
                <div style="margin-top: 5px;">
                    2. ค่าปรับลงทะเบียนล่าช้าตั้งแต่วันที่ {{ $late_fee_props['header_date'] }} เป็นต้นไป จำนวน
                    {{ $late_fee_props['amount_flat'] }} บาท
                </div>
            @endif

        @endif
    </div>
</div>