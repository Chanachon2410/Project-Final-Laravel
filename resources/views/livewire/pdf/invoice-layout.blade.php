@php
    $isPdf = $isPdf ?? false;
@endphp
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Invoice</title>

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
            src: url("{{ $isPdf ? public_path('fonts/Sarabun-Thin.ttf') : asset('fonts/Sarabun-Thin.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'Sarabun';
            font-style: italic;
            font-weight: 100;
            src: url("{{ $isPdf ? public_path('fonts/Sarabun-ThinItalic.ttf') : asset('fonts/Sarabun-ThinItalic.ttf') }}") format('truetype');
        }

        /* ExtraLight (200) */
        @font-face {
            font-family: 'Sarabun';
            font-style: normal;
            font-weight: 200;
            src: url("{{ $isPdf ? public_path('fonts/Sarabun-ExtraLight.ttf') : asset('fonts/Sarabun-ExtraLight.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'Sarabun';
            font-style: italic;
            font-weight: 200;
            src: url("{{ $isPdf ? public_path('fonts/Sarabun-ExtraLightItalic.ttf') : asset('fonts/Sarabun-ExtraLightItalic.ttf') }}") format('truetype');
        }

        /* Light (300) */
        @font-face {
            font-family: 'Sarabun';
            font-style: normal;
            font-weight: 300;
            src: url("{{ $isPdf ? public_path('fonts/Sarabun-Light.ttf') : asset('fonts/Sarabun-Light.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'Sarabun';
            font-style: italic;
            font-weight: 300;
            src: url("{{ $isPdf ? public_path('fonts/Sarabun-LightItalic.ttf') : asset('fonts/Sarabun-LightItalic.ttf') }}") format('truetype');
        }

        /* Regular (400) */
        @font-face {
            font-family: 'Sarabun';
            font-style: normal;
            font-weight: 400;
            font-weight: normal;
            src: url("{{ $isPdf ? public_path('fonts/Sarabun-Regular.ttf') : asset('fonts/Sarabun-Regular.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'Sarabun';
            font-style: italic;
            font-weight: 400;
            font-weight: normal;
            src: url("{{ $isPdf ? public_path('fonts/Sarabun-Italic.ttf') : asset('fonts/Sarabun-Italic.ttf') }}") format('truetype');
        }

        /* Medium (500) */
        @font-face {
            font-family: 'Sarabun';
            font-style: normal;
            font-weight: 500;
            src: url("{{ $isPdf ? public_path('fonts/Sarabun-Medium.ttf') : asset('fonts/Sarabun-Medium.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'Sarabun';
            font-style: italic;
            font-weight: 500;
            src: url("{{ $isPdf ? public_path('fonts/Sarabun-MediumItalic.ttf') : asset('fonts/Sarabun-MediumItalic.ttf') }}") format('truetype');
        }

        /* SemiBold (600) */
        @font-face {
            font-family: 'Sarabun';
            font-style: normal;
            font-weight: 600;
            src: url("{{ $isPdf ? public_path('fonts/Sarabun-SemiBold.ttf') : asset('fonts/Sarabun-SemiBold.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'Sarabun';
            font-style: italic;
            font-weight: 600;
            src: url("{{ $isPdf ? public_path('fonts/Sarabun-SemiBoldItalic.ttf') : asset('fonts/Sarabun-SemiBoldItalic.ttf') }}") format('truetype');
        }

        /* Bold (700) */
        @font-face {
            font-family: 'Sarabun';
            font-style: normal;
            font-weight: 700;
            font-weight: bold;
            src: url("{{ $isPdf ? public_path('fonts/Sarabun-Bold.ttf') : asset('fonts/Sarabun-Bold.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'Sarabun';
            font-style: italic;
            font-weight: 700;
            font-weight: bold;
            src: url("{{ $isPdf ? public_path('fonts/Sarabun-BoldItalic.ttf') : asset('fonts/Sarabun-BoldItalic.ttf') }}") format('truetype');
        }

        /* ExtraBold (800) */
        @font-face {
            font-family: 'Sarabun';
            font-style: normal;
            font-weight: 800;
            src: url("{{ $isPdf ? public_path('fonts/Sarabun-ExtraBold.ttf') : asset('fonts/Sarabun-ExtraBold.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'Sarabun';
            font-style: italic;
            font-weight: 800;
            src: url("{{ $isPdf ? public_path('fonts/Sarabun-ExtraBoldItalic.ttf') : asset('fonts/Sarabun-ExtraBoldItalic.ttf') }}") format('truetype');
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
            /* แนะนำให้ปรับเป็น 14pt หรือ 16pt สำหรับ Sarabun เพราะฟอนต์นี้ตัวเล็กกว่าปกติ */
            line-height: 1.1;
            margin: 0;
            padding: 0;
            color: #000000;
        }

        /* Ensure tables inherit font family in PDF */
        table, th, td {
            font-family: "Sarabun", sans-serif;
        }

        /*
         * This is the main container for each page.
         * Page-specific padding should be handled within the page's own container div.
         */
        .pdf-page {
            width: 210mm;
            height: 297mm;
            padding: 0;
            /* Reset padding, will be handled by each page's container */
            box-sizing: border-box;
            position: relative;
            background: white;
            overflow: hidden;
            /* Clipped content is important for PDF */
        }

        /* Ensures each included page starts on a new sheet in the PDF */
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
         * These styles are applied only when viewing in a browser (not generating a PDF).
         */
        @if (!$isPdf)
            body {
                background-color: transparent;
                /* Make body transparent to see wrapper */
                font-family: "Sarabun", sans-serif;
            }


            /* The grey background for preview */
            .preview-wrapper {
                background-color: #52525b;
                padding: 30px;
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 30px;
                height: 100%;
                overflow-y: auto;
                /* Allow scrolling between pages */
            }

            /* Overrides for the page container in preview */
            .pdf-page {
                height: auto !important;
                /* Let content define the height */
                min-height: 297mm;
                /* Keep the A4 aspect ratio */
                margin: 0 auto;
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
                /* Add shadow for depth */
                overflow: visible !important;
                /* Show any overflowing content */
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
    {{-- All variables are passed automatically --}}
    @include('livewire.pdf.pages.page1')
    @include('livewire.pdf.pages.page2')
    @include('livewire.pdf.pages.page3')

    @if (!$isPdf)
        </div>
    @endif

</body>

</html>
