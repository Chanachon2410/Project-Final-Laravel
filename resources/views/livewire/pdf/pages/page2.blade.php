<style>
    /* CSS เฉพาะหน้า 2 */
    .page2-container {
        color: #000;
        line-height: 1.2;
        padding: 7mm;
        /* กำหนดขอบหน้า 2 ที่นี่ */
    }

    .page2-table {
        border-collapse: collapse;
        width: 100%;
        margin-bottom: 5px;
    }

    .page2-table th,
    .page2-table td {
        border: 1px solid #000 !important;
        padding: 4px 6px;
        font-size: 10pt;
    }

    .page2-ref-container {
        display: inline-block;
        vertical-align: middle;
    }

    .page2-ref-box {
        display: inline-block;
        width: 16px;
        height: 16px;
        border: 1px solid #000;
        text-align: center;
        line-height: 14px;
        margin-right: -1px;
        font-family: 'TH Sarabun PSK';
        font-size: 10pt;
        font-weight: bold;
        vertical-align: middle;
        /* แก้ปัญหาช่องว่างกับช่องมีเลขไม่เท่ากัน */
    }
</style>

<div class="pdf-page page2-container">
    @for ($part = 1; $part <= 2; $part++)
        @if ($part == 1)
            {{-- ================= ส่วนที่ 1 (นักเรียน) ================= --}}
            <div
                style="border: 1px solid #000; padding: 4mm; position: relative; box-sizing: border-box; margin-bottom: 2mm;">
                <table class="w-full" style="border: none; margin-bottom: 15px;">
                    <tr style="border: none;">
                        <td style="width: 80px; vertical-align: top; border: none;">
                            <img src="{{ $isPdf ?? false ? public_path('images/logo (1).png') : asset('images/logo (1).png') }}"
                                alt="Logo" style="width: 80px; height: auto;">
                        </td>
                        <td class="text-center" style="border: none; padding-left: 0mm;">
                            <div style="font-size: 14pt; font-weight: 300; margin-bottom: 5px;">
                                ใบแจ้งการชำระเงินค่าบำรุงการศึกษา</div>
                            <div style="font-size: 12pt; font-weight: 300; margin-bottom: 5px;">วิทยาลัยอาชีวศึกษานครปฐม
                            </div>
                            <div style="font-size: 10pt; font-weight: 300;">Company Code : 81245</div>
                        </td>
                        <td class="text-right"
                            style="vertical-align: top; width: 180px; border: none; padding-right: 5mm;">
                            <div class="font-bold" style="font-size: 10pt;">ส่วนที่ 1 (สำหรับนักเรียน)</div>
                            <div style="font-size: 9pt;">ภาคเรียนที่ {{ $semester }} ปีการศึกษา {{ $year }}
                            </div>
                        </td>
                    </tr>
                </table>

                <table style="width: 100%; border: none; margin-bottom: 8px; font-size: 9pt;">
                    <tr style="border: none;">
                        <td style="width: 130px; border: none; padding-bottom: 5px; vertical-align: middle;">ชื่อ -
                            นามสกุลนักเรียน</td>
                        <td
                            style="width: 20px; border: none; text-align: center; padding-bottom: 5px; vertical-align: middle;">
                            :</td>
                        <td style="border: none; padding-bottom: 5px; vertical-align: middle;">
                            {{ $title ?? '' ? $title . ' ' : '' }}{{ $student_name ?? '................................................................................................' }}
                        </td>
                    </tr>
                    <tr style="border: none;">
                        <td style="border: none; padding-bottom: 5px; vertical-align: middle;">รหัสประจำตัวสอบ (Ref.1)
                        </td>
                        <td style="border: none; text-align: center; padding-bottom: 5px; vertical-align: middle;">:
                        </td>
                        <td style="border: none; padding-bottom: 5px; vertical-align: middle;">
                            <div class="page2-ref-container" style="height: 18px;">
                                @php $s_code = $student_code ?? ''; @endphp
                                @for ($i = 0; $i < strlen($s_code); $i++)
                                    <div class="page2-ref-box">{{ substr($s_code, $i, 1) }}</div>
                                @endfor
                            </div>
                        </td>
                    </tr>
                    <tr style="border: none;">
                        <td style="border: none; padding-bottom: 5px; vertical-align: middle;">รหัสกลุ่ม (Ref.2)</td>
                        <td style="border: none; text-align: center; padding-bottom: 5px; vertical-align: middle;">:
                        </td>
                        <td style="border: none; padding-bottom: 5px; vertical-align: middle;">
                            <div class="page2-ref-container" style="height: 18px;">
                                @php $g_code = $group_code ?? ''; @endphp
                                @for ($i = 0; $i < strlen($g_code); $i++)
                                    <div class="page2-ref-box">{{ substr($g_code, $i, 1) }}</div>
                                @endfor
                            </div>
                        </td>
                    </tr>
                </table>

                <div
                    style="border: 1px solid #000; font-size: 9.5pt; background-color: #fafafa; margin-bottom: 5px; padding: 3px;">
                    <div class="text-center font-bold"
                        style="text-decoration: underline; margin-bottom: 5px; font-size: 10pt;">ตัวอย่างการกรอก Ref.2
                        ของระดับชั้น {{ $level_name ?? '...' }} ทุกแผนกวิชา</div>
                    <table class="w-full" style="border: none; font-size: 9.5pt;">
                        @if (isset($all_majors) && count($all_majors) > 0)
                            {{-- แปลงเป็น Collection ถ้ายังไม่ได้เป็น เพื่อใช้ chunk --}}
                            @php 
                                $majorsCollection = collect($all_majors); 
                                $chunks = $majorsCollection->chunk(3); 
                            @endphp
                            @foreach ($chunks as $chunk)
                                <tr style="border: none;">
                                    @foreach ($chunk as $major)
                                        <td style="border: none; padding: 1px; width: 33%;">{{ $major->major_code }}
                                            สาขาวิชา{{ $major->major_name }}</td>
                                    @endforeach
                                    @for ($i = $chunk->count(); $i < 3; $i++)
                                        <td style="border: none; padding: 1px; width: 33%;"></td>
                                    @endfor
                                </tr>
                            @endforeach
                        @else
                            <tr style="border: none;">
                                <td class="text-center" style="border: none; padding: 5px; color: red;">
                                    ไม่พบข้อมูลสาขาวิชา สำหรับระดับชั้น {{ $level_name ?? '-' }}</td>
                            </tr>
                        @endif
                    </table>
                </div>

                <table class="page2-table">
                    <thead>
                        <tr style="background-color: #f9f9f9;">
                            <th style="width: 8%;">ที่</th>
                            <th>รายการ</th>
                            <th style="width: 25%;">จำนวนเงิน</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            // คำนวณยอดทั่วไป (Total - Tuition)
                            $totalGeneralAmount = ($total_amount ?? 0) - ($total_tuition_amount ?? 0);
                        @endphp
                        <tr>
                            <td class="text-center">1</td>
                            <td>ค่าบำรุงการศึกษา</td>
                            <td class="text-right">{{ number_format($totalGeneralAmount, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="text-center">2</td>
                            <td>อื่นๆ</td>
                            <td class="text-right">{{ number_format($total_tuition_amount ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="text-center">3</td>
                            <td>ค่าปรับลงทะเบียนล่าช้า (เหตุชำระหลังวันที่ {{ $late_fee_props['header_date'] ?? 'กำหนด' }})</td>
                            <td class="text-right"></td>
                        </tr>
                        <tr class="font-bold">
                            <td colspan="2" class="text-center" style="vertical-align: bottom; padding: 25px 5px 5px 5px;">
                                เงินสด (ตัวอักษร)
                                .................................................................................................... รวม
                            </td>
                            <td class="text-right" style="vertical-align: bottom; padding-bottom: 5px;"></td>
                        </tr>
                    </tbody>
                </table>

                <table class="w-full" style="margin-top: 5px; font-size: 9pt;">
                    <tr style="border: none;">
                        <td style="width: 60%; vertical-align: top; border: none;">
                            <div class="font-bold" style="text-decoration: underline;">หมายเหตุ</div>
                            <div style="font-size: 7.5pt;">
                                - ยอดเงินรวมข้างต้น ยังไม่รวมอัตราค่าธรรมเนียมของธนาคาร 10 บาท<br>
                                - ผู้ชำระเป็นผู้รับผิดชอบค่าธรรมเนียมในอัตรา 10 บาท อัตราเดียวทั่วประเทศ<br>
                                - สามารถนำไปชำระเงินได้ที่ธนาคารกรุงไทย จำกัด (มหาชน) ทุกสาขาทั่วประเทศ<br>
                                - กรณีมีเหตุขัดข้องไม่สามารถชำระเงินได้ กรุณาติดต่อที่ Call Center ธ.กรุงไทย โทร.
                                02-111-1111<br>
                                - หากเกินกำหนดวันรับชำระเงินให้นักเรียนไปติดต่อที่งานทะเบียนของโรงเรียน
                            </div>
                        </td>
                        <td class="text-right" style="vertical-align: bottom; border: none;">
                            <div
                                style="border: 1px solid #000; padding: 8px; text-align: center; width: 220px; float: right; font-size: 8.5pt; line-height: 2.0;">
                                สำหรับเจ้าหน้าที่ธนาคาร<br>
                                ผู้รับเงิน ...............................................<br>
                                วันที่ .................................................<br>
                                (ลงลายมือชื่อและประทับตรา)
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div style="border-bottom: 1px dashed #000; margin: 5mm 0;"></div>
        @else
            {{-- ================= ส่วนที่ 2 (ธนาคาร) - เพิ่มกรอบเหมือนส่วนที่ 1 ================= --}}
            <div
                style="border: 1px solid #000; padding: 4mm; position: relative; box-sizing: border-box; margin-bottom: 2mm;">
                <table style="width: 100%; border-collapse: collapse; border: none;">
                    {{-- Row 1: Header --}}
                    <tr style="border: none;">
                        <td colspan="3" style="padding: 0 0 10px 0;">
                            <table style="width: 100%; border: none;">
                                <tr>
                                    <td style="width: 80px; vertical-align: top;">
                                        <img src="{{ $isPdf ?? false ? public_path('images/logo (1).png') : asset('images/logo (1).png') }}"
                                            alt="Logo" style="width: 70px; height: auto;">
                                    </td>
                                    <td style="text-align: center; vertical-align: top;">
                                        <div style="font-size: 14pt; font-weight: normal; margin-bottom: 5px;">
                                            ใบแจ้งการชำระเงินค่าบำรุงการศึกษา</div>
                                        <div style="font-size: 12pt; font-weight: normal;">วิทยาลัยอาชีวศึกษานครปฐม
                                        </div>
                                    </td>
                                    <td style="width: 200px; text-align: right; vertical-align: top;">
                                        <div style="font-size: 11pt; font-weight: bold;">ส่วนที่ 2 (สำหรับธนาคาร)</div>
                                        <div style="font-size: 10pt;">ภาคเรียนที่ {{ $semester }} ปีการศึกษา
                                            {{ $year }}</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{-- Row 2: Bank Info & Student Info --}}
                    <tr style="height: 100px;">
                        <td colspan="3" style="border: none; padding: 0;">
                            <table style="width: 100%; border-collapse: collapse; border: none;">
                                <tr>
                                    {{-- ฝั่งซ้าย: ข้อมูลธนาคาร --}}
                                    <td
                                        style="width: 40%; border: none; padding: 10px 10px 10px 0; vertical-align: middle;">
                                        <table style="width: 100%;">
                                            <tr>
                                                <td style="width: 70px; vertical-align: middle;">
                                                    <img src="{{ $isPdf ?? false ? public_path('images/KTB_2-removebg-preview.png') : asset('images/KTB_2-removebg-preview.png') }}"
                                                        alt="KTB" style="width: 60px; height: auto;">
                                                </td>
                                                <td style="vertical-align: middle;">
                                                    <div style="font-size: 10pt; font-weight: normal;">ธนาคารกรุงไทย
                                                        จำกัด (มหาชน)</div>
                                                    <div style="font-size: 10pt; font-weight: normal; color: #000;">
                                                        Company Code : 81245</div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    {{-- ฝั่งขวา: ข้อมูลนักเรียน (ใส่กรอบแยก) --}}
                                    <td
                                        style="width: 60%; padding: 10px 0 10px 10px; vertical-align: middle; border: none;">
                                        <div style="border: 1px solid #000; padding: 10px;">
                                            <table style="width: 100%; font-size: 9pt; border-collapse: collapse;">
                                                <tr>
                                                    <td
                                                        style="width: 110px; padding-bottom: 8px; white-space: nowrap; vertical-align: middle;">
                                                        ชื่อ-นามสกุลนักเรียน</td>
                                                    <td
                                                        style="width: 10px; padding-bottom: 8px; text-align: center; vertical-align: middle;">
                                                        :</td>
                                                    <td
                                                        style="padding-bottom: 8px; vertical-align: middle; white-space: nowrap;">
                                                        {{ $title ?? '' ? $title . ' ' : '' }}{{ $student_name ?? '..........................................................' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        style="padding-bottom: 8px; white-space: nowrap; vertical-align: middle;">
                                                        เลขรหัสนักศึกษา (Ref.1)</td>
                                                    <td
                                                        style="padding-bottom: 8px; text-align: center; vertical-align: middle;">
                                                        :</td>
                                                    <td style="padding-bottom: 8px; vertical-align: middle;">
                                                        <div class="page2-ref-container"
                                                            style="display: inline-block;">
                                                            @php $s_code = $student_code ?? ''; @endphp
                                                            @for ($i = 0; $i < strlen($s_code); $i++)
                                                                <div class="page2-ref-box">
                                                                    {{ substr($s_code, $i, 1) }}</div>
                                                            @endfor
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="white-space: nowrap; vertical-align: middle;">รหัสกลุ่ม
                                                        (Ref.2)</td>
                                                    <td style="text-align: center; vertical-align: middle;">:</td>
                                                    <td style="vertical-align: middle;">
                                                        <div class="page2-ref-container"
                                                            style="display: inline-block;">
                                                            @php $g_code = $group_code ?? ''; @endphp
                                                            @for ($i = 0; $i < strlen($g_code); $i++)
                                                                <div class="page2-ref-box">
                                                                    {{ substr($g_code, $i, 1) }}</div>
                                                            @endfor
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{-- Row 3: Money Section --}}
                    <tr style="border: 1px solid #000;">
                        {{-- ช่อง 1: เงินสด (ตัวอักษร) --}}
                        <td
                            style="width: 45%; border-right: 1px solid #000; padding: 5px; vertical-align: top; height: 100px; position: relative;">
                            <div style="font-size: 10pt;">เงินสด (ตัวอักษร)</div>
                            <div style="text-align: center; position: absolute; bottom: 8px; width: 95%; font-size: 10pt;">
                                ............................................................................................
                            </div>
                        </td>

                        {{-- ช่อง 2: เงินสด (ตัวเลข) --}}
                        <td
                            style="width: 25%; border-right: 1px solid #000; padding: 0; vertical-align: top; height: 100px; position: relative;">
                            <div style="font-size: 10pt; padding: 5px; text-align: center;">เงินสด (ตัวเลข)</div>
                            <div
                                style="border-top: 1px solid #000; padding: 5px; text-align: center; position: absolute; bottom: 0; width: 100%; height: 73px; display: flex; align-items: flex-end; justify-content: center; padding-bottom: 8px;">
                                ........................................
                            </div>
                        </td>

                        {{-- ช่อง 3: สำหรับเจ้าหน้าที่ --}}
                        <td style="width: 30%; padding: 5px; vertical-align: top; height: 100px;">
                            <div style="font-size: 10pt; text-align: center;">สำหรับเจ้าหน้าที่ธนาคาร</div>
                            <div style="margin-top: 40px; text-align: center; font-size: 10pt;">

                            </div>
                        </td>
                    </tr>
                </table>

                <div style="text-align: center; padding: 5px 0 0 0; font-size: 9pt; line-height: 1.4;">
                    @if(isset($payment_normal_range) && $payment_normal_range != '-')
                        <div>
                            ***สามารถนำใบนำฝากนี้ไปชำระเงินได้ที่ธนาคารกรุงไทยทุกสาขา*** 
                            ภายในวันที่ {{ $payment_normal_range }} 
                            จำนวนเงิน {{ number_format($total_amount ?? 0, 0) }}.- บาท
                        </div>
                    @endif

                    @if(isset($late_fee_props) && $late_fee_props['show'])
                        <div style="margin-top: 2px;">
                            @if($late_fee_props['type'] == 'daily')
                                ***(ลงทะเบียนล่าช้า) ภายในวันที่ {{ $late_fee_range }} 
                                คิดค่าปรับล่าช้าวันละ {{ $late_fee_props['amount_flat'] }} บาท 
                                (สูงสุด {{ $late_fee_props['max_days'] ?? 15 }} วัน)***
                            @else
                                ***(ลงทะเบียนล่าช้า) สามารถนำใบนำฝากนี้ไปชำระเงินได้ที่ธนาคารกรุงไทยทุกสาขา*** 
                                ภายในวันที่ {{ $late_fee_range }} 
                                จำนวนเงิน {{ number_format($grand_total ?? 0, 0) }}.- บาท
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        @endif
    @endfor
</div>
