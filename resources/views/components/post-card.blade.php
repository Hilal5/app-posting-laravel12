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
