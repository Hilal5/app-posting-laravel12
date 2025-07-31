<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <audio id="like-sound" src="/sounds/pop.mp3" preload="auto"></audio>

    @include('components.navbar')

    <div class="container mx-auto">
        @yield('content')
    </div>

    @yield('scripts')
</body>
</html>
