@php
    $isPdf = $isPdf ?? false;
@endphp
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>รายงานผลการลงทะเบียน</title>
    <style>
        /* Define THSarabunNew Font Family */
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ $isPdf ? public_path('fonts/THSarabunNew/THSarabunNew.ttf') : asset('fonts/THSarabunNew/THSarabunNew.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            src: url("{{ $isPdf ? public_path('fonts/THSarabunNew/THSarabunNew-Bold.ttf') : asset('fonts/THSarabunNew/THSarabunNew-Bold.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: normal;
            src: url("{{ $isPdf ? public_path('fonts/THSarabunNew/THSarabunNew-Italic.ttf') : asset('fonts/THSarabunNew/THSarabunNew-Italic.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: bold;
            src: url("{{ $isPdf ? public_path('fonts/THSarabunNew/THSarabunNew-BoldItalic.ttf') : asset('fonts/THSarabunNew/THSarabunNew-BoldItalic.ttf') }}") format('truetype');
        }

        /* Base Global Styles */
        * {
            font-family: 'THSarabunNew', sans-serif;
            box-sizing: border-box;
        }

        body {
            font-size: 16pt;
            line-height: 1.2;
            margin: 0;
            padding: 0;
            color: #000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            /* margin-top เอาออก เพราะจะมีวันที่มาคั่น */
            margin-top: 0px;
        }

        /* Force tables to use font-family */
        table,
        th,
        td {
            font-family: 'THSarabunNew', sans-serif;
            border: 1px solid #000;
        }

        th,
        td {
            /* ปรับลด Padding ให้ตารางกระชับตามที่ขอ */
            padding: 2px 4px;
            vertical-align: middle;
        }

        td {
            font-size: 14pt;
        }

        th {
            font-size: 16pt;
            background-color: #ffffff;
            font-weight: bold;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .header h2 {
            margin: 0;
            font-size: 20pt;
            font-weight: bold;
        }

        .header p {
            margin: 0;
            font-size: 16pt;
        }

        .date-section {
            text-align: right;
            font-size: 14pt;
            margin-bottom: 5px;
            margin-top: 5px;
        }

        .summary {
            margin-top: 15px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>รายงานผลการลงทะเบียนเรียน ภาคเรียนที่ {{ $semester->semester }}/{{ $semester->year }}</h2>

        <p>
            <b>รหัสกลุ่มเรียน</b> {{ $group->course_group_code }} &nbsp;&nbsp;
            <b>ชื่อกลุ่มเรียน</b> {{ $group->course_group_name }} &nbsp;&nbsp;
            <b>ชั้นปี</b> {{ $group->level->name ?? '-' }} &nbsp;&nbsp;
            <b>ห้อง</b> {{ $group->class_room ?? '-' }}
        </p>
    </div>

    <div class="date-section">
        ข้อมูล ณ วันที่ {{ $printDate }}
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">ลำดับ</th>
                <th width="15%">รหัสนักศึกษา</th>
                <th width="40%">ชื่อ-นามสกุล</th>
                <th width="10%">สถานะ</th>
                <th width="10%">วันที่ลงทะเบียน</th>
                <th width="20%">หมายเหตุ</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total = count($students);
                $paid = 0;
                $pending = 0;
                $not_registered = 0;
            @endphp
            @foreach ($students as $index => $student)
                @php
                    $reg = $student->registrations->first();
                    if ($reg) {
                        if ($reg->status == 'approved') {
                            $paid++;
                        } elseif ($reg->status == 'pending') {
                            $pending++;
                        } else {
                            $not_registered++;
                        }
                    } else {
                        $not_registered++;
                    }
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $student->student_code }}</td>
                    <td>{{ $student->title }}{{ $student->firstname }} {{ $student->lastname }}</td>
                    <td class="text-center">
                        @if ($reg)
                            @if ($reg->status == 'approved')
                                สมบูรณ์
                            @elseif($reg->status == 'pending')
                                รอตรวจสอบ
                            @elseif($reg->status == 'rejected')
                                ถูกปฏิเสธ
                            @endif
                        @else
                            ยังไม่ลงทะเบียน
                        @endif
                    </td>
                    <td class="text-center">
                        {{ $reg ? $reg->created_at->addYears(543)->format('d/m/Y') : '-' }}
                    </td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        สรุป: ทั้งหมด {{ $total }} คน | สมบูรณ์ {{ $paid }} คน | รอตรวจสอบ {{ $pending }} คน |
        ยังไม่ลงทะเบียน/อื่นๆ {{ $not_registered }} คน
    </div>
</body>

</html>
