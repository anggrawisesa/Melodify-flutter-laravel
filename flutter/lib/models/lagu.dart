class Lagu {
  final int id;
  final String judul;
  final String penyanyi;
  final String album;
  final String cover;
  final String file;

  Lagu({
    required this.id,
    required this.judul,
    required this.penyanyi,
    required this.album,
    required this.cover,
    required this.file,
  });

  factory Lagu.fromJson(Map<String, dynamic> json) {
    return Lagu(
      id: json['id'],
      judul: json['judul'],
      penyanyi: json['penyanyi'],
      album: json['album'],
      cover: json['cover'],
      file: json['file'],
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'judul': judul,
      'penyanyi': penyanyi,
      'album': album,
      'cover': cover,
      'file': file,
    };
  }
}
