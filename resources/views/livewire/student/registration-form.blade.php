<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">


            @if($structures->isEmpty())
                <div class="text-center py-10 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="text-gray-500">ไม่พบรายการใบแจ้งหนี้สำหรับสาขา/ชั้นปีของคุณในขณะนี้</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700 border-b">
                                <th class="p-4">รายการ</th>
                                <th class="p-4">ภาคเรียน/ปี</th>
                                <th class="p-4 text-right">ยอดชำระ (บาท)</th>
                                <th class="p-4 text-center">กำหนดชำระ</th>
                                <th class="p-4 text-center">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($structures as $struct)
                                <tr class="border-b hover:bg-gray-50 transition">
                                    <td class="p-4 font-medium text-blue-700">{{ $struct->name }}</td>
                                    <td class="p-4">{{ $struct->semester }}/{{ $struct->year }}</td>
                                    <td class="p-4 text-right font-bold text-gray-800">{{ number_format($struct->total_amount, 2) }}</td>
                                    <td class="p-4 text-center text-sm text-gray-600">
                                        @if($struct->payment_end_date)
                                            {{ \Carbon\Carbon::parse($struct->payment_end_date)->addYears(543)->format('d/m/Y') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="p-4 text-center">
                                        <button wire:click="selectStructure({{ $struct->id }})" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 text-sm font-bold shadow-sm transition flex items-center gap-2 mx-auto">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                            </svg>
                                            สั่งพิมพ์ใบแจ้งชำระเงิน
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Hidden Print Area -->
    @if($paymentStructure)
        <div id="invoice-print-area" class="hidden">
            @php
                $mappedFees = $paymentStructure->items->where('is_subject', false)->map(function($item) {
                    return ['name' => $item->name, 'amount' => $item->amount];
                })->values()->toArray();

                $mappedSubjects = [];
                foreach($paymentStructure->items as $item) {
                     if($item->is_subject && $item->subject) {
                         $mappedSubjects[] = [
                             'code' => $item->subject->subject_code,
                             'name' => $item->subject->subject_name,
                             'credit' => $item->subject->credit,
                             'hour_theory' => $item->subject->hour_theory,
                             'hour_practical' => $item->subject->hour_practical,
                             'amount' => $item->amount
                         ];
                     }
                }

                if (!function_exists('convertBahtToThai')) {
                    function convertBahtToThai($number) {
                        $txtNum = ['ศูนย์','หนึ่ง','สอง','สาม','สี่','ห้า','หก','เจ็ด','แปด','เก้า','สิบ'];
                        $txtDigit = ['','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน'];
                        $number = str_replace(",","",$number);
                        $number = explode(".",$number);
                        $num = $number[0];
                        $len = strlen($num);
                        $bahtText = "";
                        for($i=0;$i<$len;$i++){
                            $n = substr($num, $i, 1);
                            if($n!=0){
                                if($i==($len-1) && $n==1){ $bahtText .= "เอ็ด"; }
                                elseif($i==($len-2) && $n==2){ $bahtText .= "ยี่"; }
                                elseif($i==($len-2) && $n==1){ $bahtText .= ""; }
                                else{ $bahtText .= $txtNum[$n]; }
                                $bahtText .= $txtDigit[$len-$i-1];
                            }
                        }
                        return $bahtText . "บาทถ้วน";
                    }
                }
                $bahtText = convertBahtToThai($paymentStructure->total_amount);

                $layoutData = [
                    'level_name' => $paymentStructure->level->name ?? '-',
                    'major_name' => $paymentStructure->major->major_name ?? '-',
                    'semester' => $paymentStructure->semester,
                    'year' => $paymentStructure->year,
                    'fees' => $mappedFees,
                    'subjects' => $mappedSubjects,
                    'total_amount' => $paymentStructure->total_amount,
                    'baht_text' => $bahtText,
                    'payment_start_date' => $paymentStructure->payment_start_date ? \Carbon\Carbon::parse($paymentStructure->payment_start_date)->format('d/m/Y') : '-',
                    'payment_end_date' => $paymentStructure->payment_end_date ? \Carbon\Carbon::parse($paymentStructure->payment_end_date)->format('d/m/Y') : '-',
                    'student_name' => $student->firstname . ' ' . $student->lastname,
                    'student_code' => $student->student_code,
                    'group_code' => $paymentStructure->custom_ref2 ?? (($paymentStructure->level->name ?? '') . ' ' . ($paymentStructure->major->major_code ?? '')),
                    'all_majors' => $allMajors, // ส่งข้อมูลสาขาวิชาไปให้ PDF
                ];
            @endphp
            @include('livewire.pdf.invoice-main', $layoutData)
        </div>
    @endif

    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('print-requested', () => {
                setTimeout(() => {
                    const printArea = document.getElementById('invoice-print-area');
                    if (!printArea) return;

                    // ตั้งชื่อไฟล์สำหรับ Save as PDF
                    const fileName = "ใบแจ้งชำระเงิน_{{ $student->student_code }}";
                    
                    const printWindow = window.open('', '_blank');
                    
                    // สร้างเนื้อหา HTML พร้อม Title และ CSS
                    let html = '<html><head><title>' + fileName + '</title>';
                    
                    // เพิ่ม Style สำหรับซ่อน Header/Footer ของ Browser โดยเฉพาะ
                    html += '<style>@page { size: A4; margin: 0; } body { margin: 0; padding: 0; }</style>';

                    // ดึง CSS ทั้งหมด
                    const styles = document.querySelectorAll('style, link[rel="stylesheet"]');
                    styles.forEach(style => {
                        html += style.outerHTML;
                    });
                    
                    html += '</head><body style="background:white; margin:0; padding:0;">';
                    html += printArea.innerHTML;
                    html += '</body></html>';
                    
                    printWindow.document.write(html);
                    printWindow.document.close();

                    // รอโหลดทรัพยากร
                    printWindow.onload = function() {
                        setTimeout(() => {
                            printWindow.focus();
                            printWindow.print();
                            printWindow.close();
                        }, 500);
                    };
                }, 200);
            });
        });
    </script>
</div>
