<div id="detail-modal-{{ $post->id }}" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl shadow-lg p-6 w-[90%] max-w-2xl sm:p-8 overflow-y-auto max-h-[90vh]">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Detail Postingan</h2>
            <button class="close-detail-modal text-2xl leading-none">&times;</button>
        </div>
        <img src="{{ asset('storage/' . $post->image) }}" alt="Detail image" class="w-full max-h-[60vh] object-contain rounded-lg mx-auto">
        <p class="mt-4 text-gray-800">{{ $post->caption }}</p>
        <hr class="my-4">
        <h3 class="font-semibold mb-2">Komentar</h3>
        <div class="space-y-2 max-h-48 overflow-y-auto mb-4">
            @forelse($post->comments as $comment)
                <div class="bg-gray-100 rounded p-2">
                    <p class="text-sm font-medium">{{ $comment->name }}</p>
                    <p class="text-sm">{{ $comment->content }}</p>
                </div>
            @empty
                <p class="text-gray-500">Belum ada komentar.</p>
            @endforelse
        </div>
        <form action="/posts/{{ $post->id }}/comments" method="POST">
            @csrf
            <textarea name="content" rows="2" required placeholder="Tulis komentar..." class="w-full border rounded px-3 py-2 mb-2"></textarea>
            <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-green-500 text-white rounded">Kirim Komentar</button>
        </form>
    </div>
</div>
