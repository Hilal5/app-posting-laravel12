<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Audio for like sound -->
    <audio id="like-sound" src="/sounds/pop.mp3" preload="auto"></audio>

    <!-- Navbar -->
    <nav class="bg-white shadow">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="/" class="text-2xl font-bold text-gray-800">Aplikasi Postingan</a>
        </div>
    </nav>

    <!-- Notifications -->
    @if(session('success'))
        <div class="container mx-auto mt-6">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        </div>
    @endif
    @if(session('success_comment'))
        <div class="container mx-auto mt-6">
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded">
                {{ session('success_comment') }}
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="container mx-auto py-8 grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($posts as $post)
            <div id="post-card-{{ $post->id }}" class="post-card bg-white rounded-2xl shadow p-6 cursor-pointer">
                <img src="{{ asset('storage/' . $post->image) }}" alt="Post image" class="w-full h-64 object-cover rounded-lg">
                <p class="mt-4 text-gray-800">{{ $post->caption }}</p>
                <div class="mt-3 flex items-center space-x-3">
                    <button class="like-button" data-post-id="{{ $post->id }}">
                        <svg id="heart-{{ $post->id }}" xmlns="http://www.w3.org/2000/svg"
                            class="w-7 h-7 transition-colors duration-300 text-gray-400 hover:text-red-500"
                            viewBox="0 0 24 24" fill="currentColor" >
                            <path id="heart-path-{{ $post->id }}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 21C12 21 4 13.5 4 8.5C4 5.5 6.5 3 9.5 3C11.28 3 12 4.5 12 4.5C12 4.5 12.72 3 14.5 3C17.5 3 20 5.5 20 8.5C20 13.5 12 21 12 21Z"/>
                        </svg>
                    </button>
                    <span id="like-count-{{ $post->id }}" class="like-count font-medium text-gray-700">{{ $post->likes }}</span>
                </div>
            </div>
        @endforeach

        <!-- Create Post Card -->
        <div id="create-post-card" class="bg-gray-50 rounded-2xl shadow p-6 flex items-center justify-center cursor-pointer hover:bg-gray-100">
            <div class="text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <p class="mt-2 text-gray-600 font-medium">Buat Postingan</p>
            </div>
        </div>
    </main>

    <!-- Create Modal -->
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

    <!-- Detail Modals -->
    @foreach($posts as $post)
        <div id="detail-modal-{{ $post->id }}" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-2xl shadow-lg p-6 w-[90%] max-w-2xl sm:p-8 overflow-y-auto max-h-[90vh]">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold">Detail Postingan</h2>
                    <button class="close-detail-modal text-2xl leading-none">&times;</button>
                </div>
                <img src="{{ asset('storage/' . $post->image) }}" alt="Detail image"
            class="w-full max-h-[60vh] object-contain rounded-lg mx-auto">

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
                    <textarea name="content" rows="2" required placeholder="Tulis komentar..."
                            class="w-full border rounded px-3 py-2 mb-2"></textarea>
                    <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-green-500 text-white rounded">Kirim Komentar</button>
                </form>
            </div>
        </div>
    @endforeach

    <!-- Scripts -->
    <script>
        const audio = document.getElementById('like-sound');

        document.querySelectorAll('.like-button').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.stopPropagation();
                const postId = this.dataset.postId;
                const heart = document.getElementById(`heart-${postId}`);

                // Sound
                audio.currentTime = 0;
                audio.play();

                // Animasi & warna love merah
                heart.classList.remove('text-gray-500');
                heart.classList.add('text-red-500', 'transform', 'scale-125');
                setTimeout(() => {
                    heart.classList.remove('scale-125');
                }, 200);

                // Hit ke server
                fetch(`/posts/${postId}/like`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    document.getElementById(`like-count-${postId}`).innerText = data.likes;
                });
            });
        });

        // Create modal
        const createCard = document.getElementById('create-post-card');
        const createModal = document.getElementById('create-modal');
        const closeBtn = document.getElementById('close-modal');
        createCard.addEventListener('click', () => createModal.classList.remove('hidden'));
        closeBtn.addEventListener('click', () => createModal.classList.add('hidden'));

        // Detail modals
        @foreach($posts as $post)
        (function() {
            const card = document.getElementById('post-card-{{ $post->id }}');
            const modal = document.getElementById('detail-modal-{{ $post->id }}');
            const closeBtn = modal.querySelector('.close-detail-modal');
            card.addEventListener('click', () => modal.classList.remove('hidden'));
            closeBtn.addEventListener('click', () => modal.classList.add('hidden'));
        })();
        @endforeach
    </script>
</body>
</html>