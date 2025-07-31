@if(session('success'))
    <div class="mt-6">
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    </div>
@endif
@if(session('success_comment'))
    <div class="mt-6">
        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded">
            {{ session('success_comment') }}
        </div>
    </div>
@endif
