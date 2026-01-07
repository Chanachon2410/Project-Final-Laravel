@php
    $isPdf = $isPdf ?? false;
@endphp
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>ใบแจ้งชำระเงิน_{{ $student_code ?? 'STU' }}</title>
    <style>
        /* =========================================
           GLOBAL STYLES (Styles for All Pages)
           ========================================= */
        @page {
            size: A4;
            margin: 0;
        }
        
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("file://{{ str_replace('\\', '/', public_path('fonts/Sarabun-Regular.ttf')) }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            src: url("file://{{ str_replace('\\', '/', public_path('fonts/Sarabun-Bold.ttf')) }}") format('truetype');
        }

        body {
            font-family: 'THSarabunNew', sans-serif;
            font-size: 14pt;
            line-height: 1.1;
            margin: 0;
            padding: 0;
            color: #333333;
            -webkit-font-smoothing: antialiased;
        }

        .pdf-page {
            width: 100%;
            background: white;
            position: relative;
            page-break-after: always;
            box-sizing: border-box;
            margin: 0;
            /* Default for PDF: No shadow/border */
            box-shadow: none !important;
            border: none !important;
        }

        /* Preview Mode Styles */
        body.preview-mode { 
            background-color: #f3f4f6; 
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }
        
        body.preview-mode .pdf-page {
            max-width: 210mm;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06) !important;
            border: 1px solid #ddd !important;
        }

        /* Safety Net for Print */
        @media print {
            body { background: white !important; padding: 0 !important; }
            .pdf-page {
                box-shadow: none !important;
                border: none !important;
                margin: 0 !important;
                width: 100% !important;
            }
        }

        /* Common Helper Classes (เพื่อความเท่ากันทุกหน้า) */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .w-full { width: 100%; }
    </style>
</head>
<body class="{{ !($isPdf ?? false) ? 'preview-mode' : '' }}">

    @include('livewire.pdf.pages.page1')
    @include('livewire.pdf.pages.page2')
    @include('livewire.pdf.pages.page3')

</body>
</html>