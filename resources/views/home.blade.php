@extends('layouts.app')

@section('content')
    @include('components.notifications')

    <main class="py-8 grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($posts as $post)
            @include('components.post-card', ['post' => $post])
        @endforeach

        @include('components.create-card')
    </main>

    @include('components.create-modal')

    @foreach($posts as $post)
        @include('components.detail-modal', ['post' => $post])
    @endforeach
@endsection

@section('scripts')
<script>
    const audio = document.getElementById('like-sound');

    document.querySelectorAll('.like-button').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            const postId = this.dataset.postId;
            const heart = document.getElementById(`heart-${postId}`);

            audio.currentTime = 0;
            audio.play();

            heart.classList.remove('text-gray-500');
            heart.classList.add('text-red-500', 'transform', 'scale-125');
            setTimeout(() => {
                heart.classList.remove('scale-125');
            }, 200);

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

    const createCard = document.getElementById('create-post-card');
    const createModal = document.getElementById('create-modal');
    const closeBtn = document.getElementById('close-modal');
    createCard.addEventListener('click', () => createModal.classList.remove('hidden'));
    closeBtn.addEventListener('click', () => createModal.classList.add('hidden'));

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
@endsection
