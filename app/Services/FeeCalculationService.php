<?php

namespace App\Services;

use App\Models\CreditFee;
use App\Models\Semester;
use App\Models\Student;
use App\Models\StudyPlan;
use App\Models\TuitionFee;
use Carbon\Carbon;

class FeeCalculationService
{
    /**
     * Calculate total tuition fee for a student in a specific semester.
     */
    public function calculateTotal(Student $student, int $semester, int $year): array
    {
        $student->load('level', 'classGroup');
        $levelName = $student->level->name ?? '';

        $tuitionFee = 0;
        $creditFeeTotal = 0;
        $maintenanceFee = 0;
        $totalCredits = 0;
        $feeDetails = [];

        // Check for Semester (for Late Fee)
        $semesterData = Semester::where('semester', $semester)
            ->where('year', $year)
            ->first();

        // 1. Calculate Base Fee based on Level
        if (str_contains($levelName, 'ปวช')) {
            // Vocational: Sum of TuitionFees
            $fees = TuitionFee::where('semester', $semester)
                ->where('year', $year)
                ->get();

            foreach ($fees as $fee) {
                $tuitionFee += $fee->rate_money;
                $feeDetails[] = [
                    'name' => $fee->fee_name,
                    'amount' => $fee->rate_money
                ];
            }

        } elseif (str_contains($levelName, 'ปวส')) {
            // Diploma: (Credits * CreditFee) + Maintenance (Lab Fee)
            
            // Find Credit Fee Settings
            $creditFeeSetting = CreditFee::where('semester', $semester)
                ->where('year', $year)
                ->where('level_id', $student->level_id)
                ->first();

            if ($creditFeeSetting) {
                // Calculate Total Credits from Study Plan
                $studyPlans = StudyPlan::where('class_group_id', $student->class_group_id)
                    ->where('semester', $semester)
                    ->where('year', $year)
                    ->with('subject')
                    ->get();

                foreach ($studyPlans as $plan) {
                    if ($plan->subject) {
                        $totalCredits += $plan->subject->credit;
                    }
                }

                $creditFeeTotal = $totalCredits * $creditFeeSetting->credit_fee;
                $maintenanceFee = $creditFeeSetting->lab_fee;

                $tuitionFee = $creditFeeTotal + $maintenanceFee;

                $feeDetails[] = [
                    'name' => "ค่าหน่วยกิต ($totalCredits หน่วยกิต x {$creditFeeSetting->credit_fee})",
                    'amount' => $creditFeeTotal
                ];
                $feeDetails[] = [
                    'name' => 'ค่าบำรุงการศึกษา (เหมาจ่าย)',
                    'amount' => $maintenanceFee
                ];
            }
        }

        // 2. Calculate Late Fee
        $lateFee = 0;
        if ($semesterData && $semesterData->late_registration_start_date) {
            if (Carbon::now()->gt($semesterData->late_registration_start_date)) {
                $lateFee = $semesterData->late_fee_rate;
                $feeDetails[] = [
                    'name' => 'ค่าปรับลงทะเบียนล่าช้า',
                    'amount' => $lateFee
                ];
            }
        }

        $grandTotal = $tuitionFee + $lateFee;

        return [
            'tuition_fee' => $tuitionFee,
            'late_fee' => $lateFee,
            'total_amount' => $grandTotal,
            'details' => $feeDetails,
            'total_credits' => $totalCredits
        ];
    }

    /**
     * Get Thai Text for amount (Baht).
     */
    public function getThaiBahtText(float $amount): string
    {
        // Simple implementation or use a library like 'baths'
        // For now, returning numeric string with suffix, or implement a basic converter if needed.
        // Let's use a basic converter function here for completeness as requested "ยอดรวมตัวอักษรไทย"
        return $this->bahtText($amount);
    }

    private function bahtText(float $amount): string
    {
        if ($amount <= 0) return 'ศูนย์บาทถ้วน';
        
        $number = number_format($amount, 2, '.', '');
        $numbers = explode('.', $number);
        $integer = $numbers[0];
        $fraction = $numbers[1];

        $bahtText = '';
        if ($integer > 0) {
            $bahtText .= $this->readNumber($integer) . 'บาท';
        }
        
        if ($fraction > 0) {
            $bahtText .= $this->readNumber($fraction) . 'สตางค์';
        } else {
            $bahtText .= 'ถ้วน';
        }

        return $bahtText;
    }

    private function readNumber($number)
    {
        $read = ['ศูนย์', 'หนึ่ง', 'สอง', 'สาม', 'สี่', 'ห้า', 'หก', 'เจ็ด', 'แปด', 'เก้า'];
        $unit = ['', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน'];
        
        $text = '';
        $length = strlen($number);
        
        for ($i = 0; $i < $length; $i++) {
            $digit = $number[$i];
            $position = $length - $i - 1;
            
            if ($digit != 0) {
                if ($position == 1 && $digit == 1) {
                    $text .= ''; // Skip 'neung' for sib
                } elseif ($position == 1 && $digit == 2) {
                    $text .= 'ยี่';
                } elseif ($position == 0 && $digit == 1 && $length > 1) {
                    $text .= 'เอ็ด';
                } else {
                    $text .= $read[$digit];
                }
                
                $text .= $unit[$position];
            }
        }
        
        return $text;
    }
}
