<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Upload</title>
    <!-- Plyr CSS -->
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css">
</head>
<body>
    <h1>Upload e Visualização de Vídeos</h1>

    <!-- Formulário de upload -->
    <form action="{{ route('video.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="video" accept="video/*" required>
        <button type="submit">Upload</button>
    </form>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <!-- Player Plyr -->
    @if ($video)
        <h2>Último Vídeo</h2>
        <video id="player" controls>
            <source src="{{ asset('storage/' . $video) }}" type="video/mp4">
            Seu navegador não suporta o vídeo.
        </video>
    @else
        <p>Nenhum vídeo disponível.</p>
    @endif

    <!-- Plyr JS -->
    <script src="https://cdn.plyr.io/3.7.8/plyr.js"></script>
    <script>
        const player = new Plyr('#player');
    </script>
</body>
</html>
