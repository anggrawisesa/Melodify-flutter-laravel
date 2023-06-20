<!DOCTYPE html>
<html>

<head>
    <title>Daftar Playlist</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <style type="text/css">
    .container {
        margin-top: 50px;
    }
    </style>
</head>

<body>
    <div class="container">
        <h2>Daftar Playlist</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nama Playlist</th>
                    <th>Jumlah Lagu</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($playlists as $playlist)
                <tr>
                    <td>{{ $playlist->nama }}</td>
                    <td>{{ $playlist->jumlah_lagu }}</td>
                    <td>
                        <a href="{{ route('playlist.show', $playlist->id) }}" class="btn btn-primary">Lihat</a>
                        <a href="{{ route('playlist.edit', $playlist->id) }}" class="btn btn-warning">Ubah</a>
                        <form action="{{ route('playlist.destroy', $playlist->id) }}" method="POST"
                            style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus playlist ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('playlist.create') }}" class="btn btn-success">Tambah Playlist Baru</a>
    </div>
</body>

</html>