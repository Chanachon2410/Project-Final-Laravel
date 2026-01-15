<?php

namespace App\Imports;

use App\Models\ClassGroup;
use App\Models\Level;
use App\Models\Major;
use App\Models\Teacher;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Log;

class ClassGroupsImport implements ToCollection
{
    private $levels;
    private $majors;
    private $teachers;
    private $errors = [];
    private $lastPotentialCode = null;

    public function __construct()
    {
        $this->levels = Level::all();
        $this->majors = Major::all();
        $this->teachers = Teacher::all();
    }

    public function collection(Collection $rows)
    {
        Log::info('Start Importing Class Groups (Aggressive Debug Mode)', ['count' => $rows->count()]);
        
        $this->lastPotentialCode = null;

        foreach ($rows as $index => $row) {
            try {
                // Read row by row from index 0
                $this->processComplexRow($row, $index + 1);
            } catch (\Exception $e) {
                $this->errors[] = "Row " . ($index + 1) . ": " . $e->getMessage();
            }
        }
    }
    
    public function getErrors()
    {
        return $this->errors;
    }

    private function processComplexRow($row, $rowNumber)
    {
        // Debug: Log raw row data
        // Log::info("Row {$rowNumber} Raw:", $row->toArray());

        $val0 = trim($row[0] ?? '');
        $val1 = trim($row[1] ?? '');
        $val2 = trim($row[2] ?? ''); // Sometimes data shifts to C

        // 1. Find Group Code (9-11 digits)
        // Check ALL columns because sometimes it shifts
        if (preg_match('/^\d{9,11}$/', $val0)) {
            $this->lastPotentialCode = $val0;
            // Log::info("Row {$rowNumber}: Found potential code {$val0}");
            return;
        }
        if (preg_match('/^\d{9,11}$/', $val1)) {
            $this->lastPotentialCode = $val1;
            return;
        }
        if (preg_match('/^\d{9,11}$/', $val2)) {
            $this->lastPotentialCode = $val2;
            return;
        }

        // 2. Find Group Name (Matches ปวช.X/Y or ปวส.X/Y)
        // Regex: (ปวช|ปวส)\.(\d)(\/(\d+))?
        // Covers: ปวช.1, ปวช.1/1, ปวส.2/3
        $foundName = null;
        $colsToCheck = [$val0, $val1, $val2];
        
        foreach ($colsToCheck as $val) {
            if (preg_match('/(ปวช|ปวส)\.(\d+)/', $val)) {
                $foundName = $val;
                break;
            }
        }

        if ($foundName && $this->lastPotentialCode) {
            // Found a pair!
            $this->saveClassGroup($this->lastPotentialCode, $foundName, $rowNumber);
            $this->lastPotentialCode = null; // Reset to avoid reusing same code
        } else if ($foundName && !$this->lastPotentialCode) {
            // Found Name but NO Code? (Maybe Code was on same line?)
            // Try to find code in same line
             foreach ($colsToCheck as $val) {
                if (preg_match('/^\d{9,11}$/', $val)) {
                    $this->lastPotentialCode = $val;
                    $this->saveClassGroup($val, $foundName, $rowNumber);
                    $this->lastPotentialCode = null;
                    return;
                }
            }
            // Warning: Found name without code
            // Log::warning("Row {$rowNumber}: Found Name '{$foundName}' but no Code yet.");
        }
    }

    private function saveClassGroup($code, $name, $rowNumber)
    {
        // Extract Level and Room
        $levelName = '';
        $levelYear = 1;
        $classRoom = null;

        if (preg_match('/(ปวช|ปวส)\.(\d+)(\/(\d+))?/', $name, $matches)) {
            // Group 1: Prefix (ปวช)
            // Group 2: Year (1)
            // Group 4: Room (1) - Optional
            
            $prefix = $matches[1];
            $year = $matches[2];
            $room = $matches[4] ?? null;

            $levelName = "{$prefix}.{$year}"; // "ปวช.1"
            $levelYear = (int)$year;
            $classRoom = $room;
        }

        $level = $this->levels->firstWhere('name', $levelName);
        if (!$level) {
            // Try fallback? Or just log error?
            // Often "ปวช.1" exists in DB.
            $this->errors[] = "Row {$rowNumber}: Group '{$name}' -> Level '{$levelName}' not found in DB.";
            return;
        }

        // Major: Fallback to first
        $major = $this->majors->first();

        ClassGroup::updateOrCreate(
            ['course_group_code' => $code],
            [
                'course_group_name' => $name,
                'class_room'        => $classRoom,
                'level_id'          => $level->id,
                'level_year'        => $levelYear,
                'major_id'          => $major->id,
                'teacher_advisor_id'=> null, 
            ]
        );
        Log::info("Imported: {$code} - {$name} (Room: {$classRoom})");
    }

    private function extractYear($levelName)
    {
        if (preg_match('/(\d+)/', $levelName, $matches)) {
            return (int)$matches[1];
        }
        return 1;
    }
}