    {{-- @php
        $isPdf = $isPdf ?? false;
    @endphp
    <!DOCTYPE html>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style>
            /* Base PDF Style */
            @page {
                size: A4;
                margin: 0;
            }
            @font-face {
                font-family: 'Sarabun';
                font-style: normal;
                font-weight: normal;
                src: url("file://{{ str_replace('\\', '/', public_path('fonts/Sarabun-Regular.ttf')) }}") format('truetype');
            }
            @font-face {
                font-family: 'Sarabun';
                font-style: normal;
                font-weight: bold;
                src: url("file://{{ str_replace('\\', '/', public_path('fonts/Sarabun-Bold.ttf')) }}") format('truetype');
            }

            body {
                font-family: 'Sarabun', sans-serif;
                font-size: 11pt;
                line-height: 1; 
                margin: 0;
                padding: 0;
                color: #000000;
            }

            .pdf-page {
                width: 210mm;
                height: 296mm; 
                padding: 8mm 10mm; 
                box-sizing: border-box;
                position: relative;
                background: white;
                overflow: hidden;
            }
            
            .page-break { page-break-after: always; }

            /* PREVIEW MODE OVERRIDES */
            @if(!$isPdf)
                body {
                    background-color: transparent;
                }
                .preview-wrapper {
                    background-color: #52525b; 
                    padding: 30px;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    gap: 30px;
                    height: 100%;
                    overflow-y: auto;
                }
                .pdf-page {
                    /* IMPORTANT: Override fixed height for preview to prevent overlap */
                    height: auto !important; 
                    min-height: 297mm;
                    margin: 0 auto;
                    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
                    overflow: visible !important;
                }
                @font-face {
                    font-family: 'Sarabun';
                    src: url('https://fonts.gstatic.com/s/sarabun/v13/DtVjJx26TKEr37c9aAFJn2GN.woff2') format('woff2');
                }
            @endif

            /* Helper Classes */
            .text-center { text-align: center; }
            .text-right { text-align: right; }
            .font-bold { font-weight: bold; }
            .w-full { width: 100%; }
            .border-none { border: none !important; }

            /* Tables */
            table { border-collapse: collapse; width: 100%; }
            .bordered-table th, .bordered-table td {
                border: 1px solid #000000 !important;
                padding: 2px 4px;
                vertical-align: middle;
            }
            
            .ref-box {
                display: inline-block;
                width: 14px;
                height: 14px;
                border: 1px solid #000;
                text-align: center;
                line-height: 14px;
                margin-right: -1px;
                font-family: monospace;
                font-weight: bold;
                font-size: 10pt;
            }

            .cut-line { 
                border-top: 1px dashed #000000; 
                margin: 5px 0; 
                text-align: center; 
                position: relative;
                height: 10px;
            }
            .cut-line span { 
                background: #fff; 
                padding: 0 5px; 
                font-size: 8pt; 
                position: relative; 
                top: -7px; 
            }

            .box-border { border: 1px solid #000; padding: 5px; }
        </style>
    </head>
    <body>

    @if(!$isPdf) <div class="preview-wrapper"> @endif

        <!-- PAGE 1 -->
        <div class="pdf-page page-break">
            <div class="text-center" style="margin-top: 20px;">
                <div style="font-size: 14pt; margin-bottom: 5px;">รายละเอียดการเก็บเงิน {{ $level_name ?? '-' }} ทุกแผนกวิชา</div>
                <div style="font-size: 14pt; margin-bottom: 5px;">ภาคเรียนที่ {{ $semester }}/{{ $year }}</div>
                <div style="font-size: 14pt; margin-bottom: 5px;">วิทยาลัยอาชีวศึกษานครปฐม</div>
            </div>
            
            <br><br>

            <table class="bordered-table" style="width: 95%; margin: 0 auto;">
                <thead>
                    <tr style="background-color: #f2f2f2;">
                        <th style="width: 10%;" class="text-center">ลำดับที่</th>
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
                                <td class="text-right">{{ number_format((float)$fee['amount'], 0) }}</td>
                            </tr>
                        @endforeach
                    @endif
                    <tr class="font-bold">
                        <td colspan="2" class="text-center" style="padding: 8px;">{{ $baht_text ?? '' }}</td>
                        <td class="text-right">{{ number_format($total_amount ?? 0, 0) }}</td>
                    </tr>
                </tbody>
            </table>

            <br><br><br>
            <div class="text-center font-bold" style="font-size: 12pt;">
                *หมายเหตุ ค่าธรรมเนียมจ่ายผ่านธนาคาร 10 บาท
            </div>
        </div>

        <!-- PAGE 2 -->
        <div class="pdf-page page-break">
            @for($part = 1; $part <= 2; $part++)
                <!-- Reduced height to 40% to be extremely safe -->
                <div style="height: 40%; position: relative;">
                    <table class="w-full">
                        <tr>
                            <td style="width: 50px; vertical-align: top;">
                                <div style="width: 40px; height: 40px; border: 1px solid #000; border-radius: 50%; text-align: center; line-height: 40px; font-size: 8pt;">Logo</div>
                            </td>
                            <td class="text-center">
                                <div class="font-bold" style="font-size: 13pt;">ใบแจ้งการชำระเงินค่าบำรุงการศึกษา</div>
                                <div class="font-bold" style="font-size: 11pt;">วิทยาลัยอาชีวศึกษานครปฐม</div>
                                <div class="font-bold" style="font-size: 10pt;">Company Code : 81245</div>
                            </td>
                            <td class="text-right" style="vertical-align: top; width: 140px;">
                                <div class="font-bold" style="font-size: 10pt;">ส่วนที่ {{ $part }} (สำหรับ{{ $part == 1 ? 'นักเรียน' : 'ธนาคาร' }})</div>
                                <div style="font-size: 9pt;">ภาคเรียนที่ {{ $semester }} ปีการศึกษา {{ $year }}</div>
                            </td>
                        </tr>
                    </table>

                    <div style="margin: 3px 0; font-size: 10pt;">ชื่อ - นามสกุลนักเรียน : {{ $student_name ?? '..........................................................' }}</div>
                    
                    <table class="w-full" style="margin-bottom: 3px; font-size: 10pt;">
                        <tr>
                            <td style="width: auto;">Ref.1 : </td>
                            <td>
                                @php $s_code = str_pad($student_code ?? '', 13, ' ', STR_PAD_RIGHT); @endphp
                                @for($i=0; $i<13; $i++) <span class="ref-box">{{ trim(substr($s_code, $i, 1)) }}</span> @endfor
                            </td>
                        </tr>
                        <tr>
                            <td>Ref.2 : </td>
                            <td>
                                @php $g_code = str_pad($group_code ?? '', 6, ' ', STR_PAD_RIGHT); @endphp
                                @for($i=0; $i<6; $i++) <span class="ref-box">{{ trim(substr($g_code, $i, 1)) }}</span> @endfor
                            </td>
                        </tr>
                    </table>

                    @if($part == 1)
                    <div class="box-border" style="font-size: 8pt; background-color: #fafafa; margin-bottom: 3px; padding: 2px;">
                        <div class="text-center font-bold" style="text-decoration: underline;">ตัวอย่างการกรอก Ref.2 ของระดับชั้น {{ $level_name ?? '...' }} ทุกแผนกวิชา</div>
                        <table class="w-full" style="border: none; font-size: 7pt;">
                            <tr>
                                <td class="border-none" style="padding: 0;">2201 สาขาวิชาการบัญชี</td>
                                <td class="border-none" style="padding: 0;">2216 การจัดการสำนักงานดิจิทัล</td>
                            </tr>
                            <tr>
                                <td class="border-none" style="padding: 0;">2202 สาขาวิชาการตลาด</td>
                                <td class="border-none" style="padding: 0;">2602 สาขาวิชาการออกแบบ</td>
                            </tr>
                        </table>
                    </div>
                    @else
                    <div style="margin: 5px 0; font-weight: bold; color: #0056b3; font-size: 9pt;">
                        ธนาคารกรุงไทย จำกัด (มหาชน) &nbsp;&nbsp;&nbsp; Company Code : 81245
                    </div>
                    @endif

                    <table class="bordered-table" style="margin-bottom: 3px; font-size: 10pt;">
                        <thead>
                            <tr style="background-color: #f2f2f2;">
                                <th style="width: 10%;">ที่</th>
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
                            <tr>
                                <td class="text-center">2</td>
                                <td>อื่นๆ</td>
                                <td class="text-right">-</td>
                            </tr>
                            <tr class="font-bold">
                                <td colspan="2" class="text-center" style="background-color: #f9f9f9;">เงินสด (ตัวอักษร) ...({{ $baht_text ?? '' }})... รวม</td>
                                <td class="text-right">{{ number_format($total_amount ?? 0, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="w-full" style="font-size: 8pt;">
                        <tr>
                            <td style="width: 55%; vertical-align: top; border: none;">
                                <div class="font-bold" style="text-decoration: underline;">หมายเหตุ</div>
                                <ul style="margin: 0; padding-left: 15px;">
                                    <li>ยอดเงินรวมข้างต้น ยังไม่รวมอัตราค่าธรรมเนียมของธนาคาร</li>
                                    <li>ผู้ชำระเงินเป็นผู้รับผิดชอบค่าธรรมเนียมในอัตรา 10 บาท</li>
                                </ul>
                            </td>
                            <td style="width: 45%; vertical-align: top; border: none;">
                                <div style="border: 1px solid #000; padding: 3px; text-align: center;">
                                    สำหรับเจ้าหน้าที่ธนาคาร<br>
                                    ผู้รับเงิน..........................................<br>
                                    วันที่..............................................<br>
                                    (ลงลายมือชื่อและประทับตรา)
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                @if($part == 1)
                    <div class="cut-line"><span>✂ ฉีกตามรอยปรุ</span></div>
                @endif
            @endfor
            
            <div class="text-center" style="font-size: 8pt; position: absolute; bottom: 5mm; width: 100%;">
                *** ชำระเงินได้ระหว่างวันที่ {{ $payment_start_date ?? '...' }} - {{ $payment_end_date ?? '...' }} ณ ธนาคารกรุงไทย ทุกสาขาทั่วประเทศ ***
            </div>
        </div>

        <!-- PAGE 3 -->
        <div class="pdf-page">
            <div class="text-center">
                <div class="header-title" style="font-size: 14pt;">วิทยาลัยอาชีวศึกษานครปฐม</div>
                <div class="header-title" style="font-size: 14pt;">บัตรลงทะเบียนรายวิชา</div>
                <table class="w-full">
                    <tr>
                        <td class="text-right" style="border: none; font-size: 10pt;">วันที่ {{ date('d/m') }}/{{ $year }}</td>
                    </tr>
                </table>
                <div style="font-size: 11pt;">ภาคเรียนที่ {{ $semester }} ปีการศึกษา {{ $year }}</div>
            </div>

            <div style="margin: 5px 0; font-size: 10pt;">
                <table class="w-full">
                    <tr>
                        <td style="border: none;">ชื่อ-สกุล {{ $student_name ?? '................................................' }}</td>
                        <td class="text-right" style="border: none;">
                            รหัสประจำตัว 
                            @php $s_code = str_pad($student_code ?? '', 13, ' ', STR_PAD_RIGHT); @endphp
                            @for($i=0; $i<13; $i++) <span class="ref-box" style="width:12px; height:12px; line-height:12px; font-size:9pt;">{{ trim(substr($s_code, $i, 1)) }}</span> @endfor
                        </td>
                    </tr>
                </table>
                <div style="margin-top: 2px;">ประเภทวิชา {{ $major_name ?? '...' }} ................. ชั้น {{ $level_name ?? '...' }}</div>
            </div>

            <table class="bordered-table" style="font-size: 10pt; margin-bottom: 2px;">
                <thead>
                    <tr style="background-color: #f2f2f2;">
                        <th style="width: 8%;">ลำดับ</th>
                        <th style="width: 15%;">รหัสวิชา</th>
                        <th>ชื่อวิชา</th>
                        <th style="width: 8%;">ท</th>
                        <th style="width: 8%;">ป</th>
                        <th style="width: 10%;">นก.</th>
                    </tr>
                </thead>
                <tbody>
                    @php 
                        $totalTheory = 0; $totalPractical = 0; $totalCredit = 0; 
                        $subjects = $subjects ?? [];
                        $maxRows = 8;
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
            
            <table class="w-full" style="margin-top: 2px;">
                <tr>
                    <td style="width: 45%; vertical-align: top; border: none;">
                        <table class="bordered-table" style="font-size: 10pt;">
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
                    <td style="width: 55%; padding-left: 10px; border: none;">
                        <div style="border: 1px solid #000; padding: 3px; text-align: center;">
                            <div class="font-bold" style="font-size: 10pt;">ลงชื่อ</div>
                            <table class="w-full" style="margin-top: 5px; font-size: 9pt; border: none;">
                                <tr>
                                    <td class="border-none">.........................................<br>นักศึกษา</td>
                                    <td class="border-none">.........................................<br>ครูที่ปรึกษา</td>
                                </tr>
                            </table>
                            <div style="margin-top: 5px; font-size: 9pt;">.........................................<br>งานทะเบียน</div>
                        </div>
                    </td>
                </tr>
            </table>
            
            <div class="text-center" style="font-size: 8pt; margin-top: 2px;">
                * ชำระเงินได้ระหว่างวันที่ {{ $payment_start_date ?? '...' }} - {{ $payment_end_date ?? '...' }} ณ ธนาคารกรุงไทย ทุกสาขาทั่วประเทศ
            </div>

            <div style="margin-top: 5px; border-top: 1px dashed #000; padding-top: 5px;">
                <div class="text-center font-bold" style="font-size: 10pt;">ส่วนนี้สำหรับนักศึกษาเก็บไว้เป็นหลักฐานการลงทะเบียน</div>
                <table class="w-full" style="font-size: 9pt; margin-top: 2px;">
                    <tr>
                        <td style="border: none;">ชื่อนักศึกษา {{ $student_name ?? '....................................' }} รหัส {{ $student_code ?? '................' }} ชั้น {{ $level_name ?? '...' }}</td>
                    </tr>
                    <tr>
                        <td style="border: none;">สาขาวิชา {{ $major_name ?? '....................................' }} ได้ชำระเงินลงทะเบียนแล้ว</td>
                    </tr>
                    <tr>
                        <td style="border: none;">ธนาคารกรุงไทย ทุกสาขาทั่วประเทศ เมื่อวันที่.........../.........../...........</td>
                    </tr>
                    <tr>
                        <td class="text-right" style="border: none; padding-top: 5px;">
                            รับหลักฐานไว้แล้ว................................................เจ้าหน้าที่งานทะเบียน<br>
                            วันที่........../........../……..
                        </td>
                    </tr>
                </table>
            </div>
        </div>

    @if(!$isPdf) </div> @endif

    </body>
    </html> --}}
