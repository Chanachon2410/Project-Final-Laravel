@php
    $isPdf = $isPdf ?? false;
@endphp
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice</title>
    <style>
        /* 
         * BASE PDF STYLES
         * These styles are applied to all pages and are optimized for PDF generation.
         */
        @page {
            size: A4;
            margin: 0;
        }
        @font-face {
            font-family: 'Sarabun';
            font-style: normal;
            font-weight: normal;
            /* For PDF, use local font file. The path needs to be absolute. */
            src: url("{{ "file://" . str_replace('\\', '/', public_path('fonts/Sarabun-Regular.ttf')) }}") format('truetype');
        }
        @font-face {
            font-family: 'Sarabun';
            font-style: normal;
            font-weight: bold;
            src: url("{{ "file://" . str_replace('\\', '/', public_path('fonts/Sarabun-Bold.ttf')) }}") format('truetype');
        }

        body {
            font-family: 'Sarabun', sans-serif;
            font-size: 11pt;
            line-height: 1.2; /* A bit more readable */
            margin: 0;
            padding: 0;
            color: #000000;
        }

        /*
         * This is the main container for each page.
         * Page-specific padding should be handled within the page's own container div.
         */
        .pdf-page {
            width: 210mm;
            height: 297mm; 
            padding: 0; /* Reset padding, will be handled by each page's container */
            box-sizing: border-box;
            position: relative;
            background: white;
            overflow: hidden; /* Clipped content is important for PDF */
        }
        
        /* Ensures each included page starts on a new sheet in the PDF */
        .page-break { 
            page-break-after: always; 
        }

        /* Generic Helper Classes */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .font-bold { font-weight: bold; }
        .w-full { width: 100%; }

        /* 
         * PREVIEW MODE OVERRIDES
         * These styles are applied only when viewing in a browser (not generating a PDF).
         */
        @if(!$isPdf)
            /* For browser preview, load font from Google Fonts */
            @import url('https://fonts.googleapis.com/css2?family=Sarabun:wght@400;700&display=swap');

            body {
                background-color: transparent; /* Make body transparent to see wrapper */
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
                overflow-y: auto; /* Allow scrolling between pages */
            }
            /* Overrides for the page container in preview */
            .pdf-page {
                height: auto !important; /* Let content define the height */
                min-height: 297mm; /* Keep the A4 aspect ratio */
                margin: 0 auto;
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); /* Add shadow for depth */
                overflow: visible !important; /* Show any overflowing content */
            }
        @endif
    </style>
</head>
<body>

{{-- This wrapper is only used for browser preview --}}
@if(!$isPdf) <div class="preview-wrapper"> @endif

    {{-- Include the three separate page templates --}}
    {{-- All variables are passed automatically --}}
    @include('livewire.pdf.pages.page1')
    @include('livewire.pdf.pages.page2')
    @include('livewire.pdf.pages.page3')

@if(!$isPdf) </div> @endif

</body>
</html>