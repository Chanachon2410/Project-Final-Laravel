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
            ['major_code' => '2201', 'major_name' => 'การบัญชี'],
            ['major_code' => '2202', 'major_name' => 'การตลาด'],
            ['major_code' => '2910', 'major_name' => 'เทคโนโลยีธุรกิจดิจิทัล'],
            ['major_code' => '2211', 'major_name' => 'ธุรกิจค้าปลีก'],
            ['major_code' => '2401', 'major_name' => 'โลจิสติกส์'],
            ['major_code' => '2216', 'major_name' => 'การจัดการสำนักงานดิจิทัล'],
            ['major_code' => '2602', 'major_name' => 'การออกแบบ'],
            ['major_code' => '2608', 'major_name' => 'ดิจิทัลกราฟิก'],
            ['major_code' => '2504', 'major_name' => 'อาหารและโภชนาการ'],
            ['major_code' => '2804', 'major_name' => 'แฟชั่นและสิ่งทอ'],
            ['major_code' => '2406', 'major_name' => 'คหกรรมศาสตร์'],
            ['major_code' => '2701', 'major_name' => 'การโรงแรม'],
            ['major_code' => '2901', 'major_name' => 'เทคโนโลยีสารสนเทศ'],
            ['major_code' => '2212', 'major_name' => 'ภาษาต่างประเทศธุรกิจบริการ'],

            // === ปวส. (รหัส 3xxx) ===
            // อ้างอิงจากไฟล์ ส1-1_เทคโนโลยีสารสนเทศ.pdf
            ['major_code' => '3201', 'major_name' => 'การบัญชี'],
            ['major_code' => '3202', 'major_name' => 'การตลาด'],
            ['major_code' => '3910', 'major_name' => 'เทคโนโลยีธุรกิจดิจิทัล'],
            ['major_code' => '3211', 'major_name' => 'การจัดการธุรกิจค้าปลีก'],
            ['major_code' => '3401', 'major_name' => 'การจัดการโลจิสติกส์และซัพพลายเชน'],
            ['major_code' => '3216', 'major_name' => 'การจัดการสำนักงานดิจิทัล'],
            ['major_code' => '3619', 'major_name' => 'ออกแบบนิเทศศิลป์'],
            ['major_code' => '3608', 'major_name' => 'ดิจิทัลกราฟิก'],
            ['major_code' => '3504', 'major_name' => 'อาหารและโภชนาการ'],
            ['major_code' => '3804', 'major_name' => 'เทคโนโลยีออกแบบแฟชั่นและเครื่องแต่งกาย'],
            ['major_code' => '3406', 'major_name' => 'การบริหารงานคหกรรมศาสตร์'],
            ['major_code' => '3701', 'major_name' => 'การโรงแรม'],
            ['major_code' => '3901', 'major_name' => 'เทคโนโลยีสารสนเทศ'],
            ['major_code' => '3212', 'major_name' => 'ภาษาและการจัดการธุรกิจระหว่างประเทศ'],

            // === ปริญญาตรี (ต่อเนื่อง) (รหัส 4xxx) ===
            // อ้างอิงจากเอกสาร ป-ตรี ปี 1.pdf และ ป-ตรี ปี 2.pdf
            ['major_code' => '4201', 'major_name' => 'การบัญชี(ต่อเนื่อง)'],
            ['major_code' => '4204', 'major_name' => 'เทคโนโลยีธุรกิจดิจิทัล(ต่อเนื่อง)'],
            ['major_code' => '4214', 'major_name' => 'การจัดการโลจิสติกส์(ต่อเนื่อง)'],
            ['major_code' => '4211', 'major_name' => 'การจัดการธุรกิจค้าปลีก(ต่อเนื่อง)'],
            ['major_code' => '4320', 'major_name' => 'ดิจิทัลกราฟิก(ต่อเนื่อง)'],
            ['major_code' => '4404', 'major_name' => 'เทคโนโลยีอาหารและโภชนาการ(ต่อเนื่อง)'],
            ['major_code' => '4701', 'major_name' => 'การโรงแรม(ต่อเนื่อง)'],
        ];

        foreach ($majors as $major) {
            Major::updateOrCreate(['major_code' => $major['major_code']], $major);
        }
    }
}