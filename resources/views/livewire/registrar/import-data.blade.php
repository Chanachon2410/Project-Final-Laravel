<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <h2 class="text-2xl font-bold mb-4">Import Class Data</h2>

                @if (session()->has('message'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        <p>{{ session('message') }}</p>
                    </div>
                @endif
                
                @if (session()->has('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                        <p class="font-bold">Error</p>
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                <form wire:submit.prevent="import">
                    <div class="mb-4">
                        <label for="file" class="block text-gray-700 text-sm font-bold mb-2">Excel File:</label>
                        <input type="file" wire:model="file" id="file" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('file') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center">
                        <button type="submit" 
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline disabled:opacity-50 disabled:cursor-not-allowed"
                                {{ !$file ? 'disabled' : '' }} 
                                wire:loading.attr="disabled" 
                                wire:target="file, import">
                            Import
                        </button>
                        <div wire:loading wire:target="import" class="ml-4">
                            <div class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span>Processing...</span>
                            </div>
                        </div>
                    </div>
                </form>
                
                <div class="mt-8 border-t pt-4">
                    <h3 class="text-lg font-semibold">Instructions</h3>
                    <ul class="list-disc list-inside mt-2 text-sm text-gray-600 space-y-1">
                        <li>Please upload an Excel file (.xlsx) with the correct format.</li>
                        <li>The system will import data from the <strong>first sheet</strong> of the Excel file only.</li>
                        <li>The system will find or create teachers, students, and a class group based on the data in that sheet.</li>
                        <li>Ensure the following cells and columns are correctly populated in the first sheet:
                            <ul class="list-disc list-inside ml-6 mt-1">
                                <li>Cell <strong>C7</strong>: Class Group Code (รหัสกลุ่มเรียน)</li>
                                <li>Cell <strong>E7</strong>: Major Name (ชื่อกลุ่มเรียน)</li>
                                <li>Cell <strong>E8</strong>: Teacher's Full Name (ครูที่ปรึกษา)</li>
                                <li>Cell <strong>C8</strong>: Class Level/Room (ชั้นปี)</li>
                                <li>Column <strong>B</strong> (from row 11): Student's Citizen ID (รหัสประชาชน)</li>
                                <li>Column <strong>C</strong> (from row 11): Student ID (รหัสประจำตัว)</li>
                                <li>Column <strong>D</strong> (from row 11): Student's Full Name (ชื่อ - สกุล)</li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>