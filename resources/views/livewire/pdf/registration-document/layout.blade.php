@php
    $isPdf = $isPdf ?? false;
@endphp
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    {{-- จุดที่แก้ไข: เปลี่ยนจาก Invoice เป็นตัวแปร pdf_title เพื่อให้ Print to PDF เห็นชื่อไฟล์ --}}
    <title>{{ $pdf_title ?? 'Registration_Document' }}</title>

    <style>
        /*
         * BASE PDF STYLES
         */
        @page {
            size: A4;
            margin: 0;
        }

        /* Define Sarabun Font Family with all weights/styles */
        /* Thin (100) */
        @font-face {
            font-family: 'Sarabun';
            font-style: normal;
            font-weight: 100;
            src: url("{{ $isPdf ? public_path('fonts/Sarabun/Sarabun-Thin.ttf') : asset('fonts/Sarabun/Sarabun-Thin.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'Sarabun';
            font-style: italic;
            font-weight: 100;
            src: url("{{ $isPdf ? public_path('fonts/Sarabun/Sarabun-ThinItalic.ttf') : asset('fonts/Sarabun/Sarabun-ThinItalic.ttf') }}") format('truetype');
        }

        /* ExtraLight (200) */
        @font-face {
            font-family: 'Sarabun';
            font-style: normal;
            font-weight: 200;
            src: url("{{ $isPdf ? public_path('fonts/Sarabun/Sarabun-ExtraLight.ttf') : asset('fonts/Sarabun/Sarabun-ExtraLight.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'Sarabun';
            font-style: italic;
            font-weight: 200;
            src: url("{{ $isPdf ? public_path('fonts/Sarabun/Sarabun-ExtraLightItalic.ttf') : asset('fonts/Sarabun/Sarabun-ExtraLightItalic.ttf') }}") format('truetype');
        }

        /* Light (300) */
        @font-face {
            font-family: 'Sarabun';
            font-style: normal;
            font-weight: 300;
            src: url("{{ $isPdf ? public_path('fonts/Sarabun/Sarabun-Light.ttf') : asset('fonts/Sarabun/Sarabun-Light.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'Sarabun';
            font-style: italic;
            font-weight: 300;
            src: url("{{ $isPdf ? public_path('fonts/Sarabun/Sarabun-LightItalic.ttf') : asset('fonts/Sarabun/Sarabun-LightItalic.ttf') }}") format('truetype');
        }

        /* Regular (400) */
        @font-face {
            font-family: 'Sarabun';
            font-style: normal;
            font-weight: 400;
            font-weight: normal;
            src: url("{{ $isPdf ? public_path('fonts/Sarabun/Sarabun-Regular.ttf') : asset('fonts/Sarabun/Sarabun-Regular.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'Sarabun';
            font-style: italic;
            font-weight: 400;
            font-weight: normal;
            src: url("{{ $isPdf ? public_path('fonts/Sarabun/Sarabun-Italic.ttf') : asset('fonts/Sarabun/Sarabun-Italic.ttf') }}") format('truetype');
        }

        /* Medium (500) */
        @font-face {
            font-family: 'Sarabun';
            font-style: normal;
            font-weight: 500;
            src: url("{{ $isPdf ? public_path('fonts/Sarabun/Sarabun-Medium.ttf') : asset('fonts/Sarabun/Sarabun-Medium.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'Sarabun';
            font-style: italic;
            font-weight: 500;
            src: url("{{ $isPdf ? public_path('fonts/Sarabun/Sarabun-MediumItalic.ttf') : asset('fonts/Sarabun/Sarabun-MediumItalic.ttf') }}") format('truetype');
        }

        /* SemiBold (600) */
        @font-face {
            font-family: 'Sarabun';
            font-style: normal;
            font-weight: 600;
            src: url("{{ $isPdf ? public_path('fonts/Sarabun/Sarabun-SemiBold.ttf') : asset('fonts/Sarabun/Sarabun-SemiBold.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'Sarabun';
            font-style: italic;
            font-weight: 600;
            src: url("{{ $isPdf ? public_path('fonts/Sarabun/Sarabun-SemiBoldItalic.ttf') : asset('fonts/Sarabun/Sarabun-SemiBoldItalic.ttf') }}") format('truetype');
        }

        /* Bold (700) */
        @font-face {
            font-family: 'Sarabun';
            font-style: normal;
            font-weight: 700;
            font-weight: bold;
            src: url("{{ $isPdf ? public_path('fonts/Sarabun/Sarabun-Bold.ttf') : asset('fonts/Sarabun/Sarabun-Bold.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'Sarabun';
            font-style: italic;
            font-weight: 700;
            font-weight: bold;
            src: url("{{ $isPdf ? public_path('fonts/Sarabun/Sarabun-BoldItalic.ttf') : asset('fonts/Sarabun/Sarabun-BoldItalic.ttf') }}") format('truetype');
        }

        /* ExtraBold (800) */
        @font-face {
            font-family: 'Sarabun';
            font-style: normal;
            font-weight: 800;
            src: url("{{ $isPdf ? public_path('fonts/Sarabun/Sarabun-ExtraBold.ttf') : asset('fonts/Sarabun/Sarabun-ExtraBold.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'Sarabun';
            font-style: italic;
            font-weight: 800;
            src: url("{{ $isPdf ? public_path('fonts/Sarabun/Sarabun-ExtraBoldItalic.ttf') : asset('fonts/Sarabun/Sarabun-ExtraBoldItalic.ttf') }}") format('truetype');
        }

        .sarabun-thin {
            font-family: "Sarabun", sans-serif;
            font-weight: 100;
            font-style: normal;
        }

        .sarabun-extralight {
            font-family: "Sarabun", sans-serif;
            font-weight: 200;
            font-style: normal;
        }

        .sarabun-light {
            font-family: "Sarabun", sans-serif;
            font-weight: 300;
            font-style: normal;
        }

        .sarabun-regular {
            font-family: "Sarabun", sans-serif;
            font-weight: 400;
            font-style: normal;
        }

        .sarabun-medium {
            font-family: "Sarabun", sans-serif;
            font-weight: 500;
            font-style: normal;
        }

        .sarabun-semibold {
            font-family: "Sarabun", sans-serif;
            font-weight: 600;
            font-style: normal;
        }

        .sarabun-bold {
            font-family: "Sarabun", sans-serif;
            font-weight: 700;
            font-style: normal;
        }

        .sarabun-extrabold {
            font-family: "Sarabun", sans-serif;
            font-weight: 800;
            font-style: normal;
        }

        .sarabun-thin-italic {
            font-family: "Sarabun", sans-serif;
            font-weight: 100;
            font-style: italic;
        }

        .sarabun-extralight-italic {
            font-family: "Sarabun", sans-serif;
            font-weight: 200;
            font-style: italic;
        }

        .sarabun-light-italic {
            font-family: "Sarabun", sans-serif;
            font-weight: 300;
            font-style: italic;
        }

        .sarabun-regular-italic {
            font-family: "Sarabun", sans-serif;
            font-weight: 400;
            font-style: italic;
        }

        .sarabun-medium-italic {
            font-family: "Sarabun", sans-serif;
            font-weight: 500;
            font-style: italic;
        }

        .sarabun-semibold-italic {
            font-family: "Sarabun", sans-serif;
            font-weight: 600;
            font-style: italic;
        }

        .sarabun-bold-italic {
            font-family: "Sarabun", sans-serif;
            font-weight: 700;
            font-style: italic;
        }

        .sarabun-extrabold-italic {
            font-family: "Sarabun", sans-serif;
            font-weight: 800;
            font-style: italic;
        }

        body {
            font-family: "Sarabun", sans-serif;
            font-size: 14pt;
            line-height: 1.1;
            margin: 0;
            padding: 0;
            color: #000000;
        }

        /* Ensure tables inherit font family in PDF */
        table,
        th,
        td {
            font-family: "Sarabun", sans-serif;
        }

        /*
         * Main Page Container
         */
        .pdf-page {
            width: 210mm;
            height: 297mm;
            padding: 0;
            box-sizing: border-box;
            position: relative;
            background: white;
            overflow: hidden;
        }

        /* Page Break */
        .page-break {
            page-break-after: always;
        }

        /* Generic Helper Classes */
        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        .font-bold {
            font-weight: bold;
        }

        .w-full {
            width: 100%;
        }

        /*
         * PREVIEW MODE OVERRIDES
         */
        @if (!$isPdf)
            body {
                background-color: transparent;
                font-family: "Sarabun", sans-serif;
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
                height: auto !important;
                min-height: 297mm;
                margin: 0 auto;
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
                overflow: visible !important;
            }
        @endif
    </style>
</head>

<body>

    {{-- This wrapper is only used for browser preview --}}
    @if (!$isPdf)
        <div class="preview-wrapper">
    @endif

    {{-- Include the three separate page templates --}}
    @include('livewire.pdf.registration-document.pages.page1')
    @include('livewire.pdf.registration-document.pages.page2')
    @include('livewire.pdf.registration-document.pages.page3')

    @if (!$isPdf)
        </div>
    @endif

</body>

</html>
