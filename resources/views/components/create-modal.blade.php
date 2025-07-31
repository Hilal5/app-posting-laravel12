<div id="create-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-2xl shadow-lg p-6 w-96">
        <h2 class="text-xl font-semibold mb-4">Buat Postingan Baru</h2>
        <form action="/posts" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Gambar</label>
                <input type="file" name="image" required class="w-full" />
                @error('image')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Caption</label>
                <textarea name="caption" rows="3" required class="w-full border rounded px-3 py-2"></textarea>
                @error('caption')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="flex justify-end space-x-2">
                <button type="button" id="close-modal" class="px-4 py-2">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>
