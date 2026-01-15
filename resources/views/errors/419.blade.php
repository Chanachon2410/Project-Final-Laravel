<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Expired</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Sarabun', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="text-center p-8 bg-white shadow-lg rounded-lg max-w-md w-full mx-4">
        <div class="mb-6">
            <svg class="mx-auto h-24 w-24 text-indigo-500 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <h1 class="text-4xl font-bold text-gray-800 mb-2">419</h1>
        <h2 class="text-xl font-semibold text-gray-600 mb-4">Page Expired</h2>
        <p class="text-gray-500 mb-8">
            หน้าเว็บหมดอายุเนื่องจากไม่ได้ใช้งานเป็นเวลานาน<br>
            กรุณารีโหลดหน้าเว็บหรือเข้าสู่ระบบใหม่อีกครั้ง
        </p>
        
        <div class="flex flex-col space-y-3">
            <button onclick="window.history.back()" class="w-full px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 transition duration-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                ย้อนกลับไปหน้าเดิม (Go Back)
            </button>

            <button onclick="window.location.reload()" class="w-full px-4 py-2 bg-white border border-gray-300 text-gray-700 font-semibold rounded-md hover:bg-gray-50 transition duration-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                รีโหลดหน้าเว็บ (Refresh)
            </button>
            
            <a href="{{ route('login') }}" class="w-full px-4 py-2 text-sm text-gray-500 hover:text-indigo-600 transition duration-300">
                เข้าสู่ระบบใหม่ (Login)
            </a>
        </div>
    </div>
</body>
</html>
