<?php

namespace Database\Seeders;

use App\Models\Major;
use Illuminate\Database\Seeder;

class MajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $majors = [
            // === ปวช. (รหัส 2xxx) ===
            // อ้างอิงจากรายการในหน้า PDF ปวช. (ถ้ามี) หรือ map ให้สอดคล้องกับ ปวส.
            ['major_code' => '2201', 'major_name' => 'สาขาวิชาการบัญชี'],
            ['major_code' => '2202', 'major_name' => 'สาขาวิชาการตลาด'],
            ['major_code' => '2910', 'major_name' => 'สาขาวิชาเทคโนโลยีธุรกิจดิจิทัล'],
            ['major_code' => '2211', 'major_name' => 'สาขาวิชาธุรกิจค้าปลีก'],
            ['major_code' => '2401', 'major_name' => 'สาขาวิชาโลจิสติกส์'],
            ['major_code' => '2216', 'major_name' => 'สาขาวิชาการจัดการสำนักงานดิจิทัล'],
            ['major_code' => '2602', 'major_name' => 'สาขาวิชาการออกแบบ'],
            ['major_code' => '2608', 'major_name' => 'สาขาวิชาดิจิทัลกราฟิก'],
            ['major_code' => '2504', 'major_name' => 'สาขาวิชาอาหารและโภชนาการ'],
            ['major_code' => '2804', 'major_name' => 'สาขาวิชาแฟชั่นและสิ่งทอ'],
            ['major_code' => '2406', 'major_name' => 'สาขาวิชาคหกรรมศาสตร์'],
            ['major_code' => '2701', 'major_name' => 'สาขาวิชาการโรงแรม'],
            ['major_code' => '2901', 'major_name' => 'สาขาวิชาเทคโนโลยีสารสนเทศ'],
            ['major_code' => '2212', 'major_name' => 'สาขาวิชาภาษาต่างประเทศธุรกิจบริการ'],

            // === ปวส. (รหัส 3xxx) ===
            // อ้างอิงจากไฟล์ ส1-1_เทคโนโลยีสารสนเทศ.pdf
            ['major_code' => '3201', 'major_name' => 'สาขาวิชาการบัญชี'],
            ['major_code' => '3202', 'major_name' => 'สาขาวิชาการตลาด'],
            ['major_code' => '3910', 'major_name' => 'สาขาวิชาเทคโนโลยีธุรกิจดิจิทัล'],
            ['major_code' => '3211', 'major_name' => 'สาขาวิชาการจัดการธุรกิจค้าปลีก'],
            ['major_code' => '3401', 'major_name' => 'สาขาวิชาการจัดการโลจิสติกส์และซัพพลายเชน'],
            ['major_code' => '3216', 'major_name' => 'สาขาวิชาการจัดการสำนักงานดิจิทัล'],
            ['major_code' => '3619', 'major_name' => 'สาขาวิชาออกแบบนิเทศศิลป์'],
            ['major_code' => '3608', 'major_name' => 'สาขาวิชาดิจิทัลกราฟิก'],
            ['major_code' => '3504', 'major_name' => 'สาขาวิชาอาหารและโภชนาการ'],
            ['major_code' => '3804', 'major_name' => 'สาขาวิชาเทคโนโลยีออกแบบแฟชั่นและเครื่องแต่งกาย'],
            ['major_code' => '3406', 'major_name' => 'สาขาวิชาการบริหารงานคหกรรมศาสตร์'],
            ['major_code' => '3701', 'major_name' => 'สาขาวิชาการโรงแรม'],
            ['major_code' => '3901', 'major_name' => 'สาขาวิชาเทคโนโลยีสารสนเทศ'],
            ['major_code' => '3212', 'major_name' => 'สาขาวิชาภาษาและการจัดการธุรกิจระหว่างประเทศ'],
        ];

        foreach ($majors as $major) {
            Major::updateOrCreate(['major_code' => $major['major_code']], $major);
        }
    }
}