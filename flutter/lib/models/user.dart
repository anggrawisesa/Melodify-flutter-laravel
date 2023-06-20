class Lagu {
  final int id;
  final String nama;
  final String email;

  Lagu({
    required this.id,
    required this.nama,
    required this.email,
  });

  factory Lagu.fromJson(Map<String, dynamic> json) {
    return Lagu(
      id: json['id'],
      nama: json['nama'],
      email: json['email'],
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'nama': nama,
      'email': email,
    };
  }
}
