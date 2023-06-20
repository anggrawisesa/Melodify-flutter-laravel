Future<List<Lagu>> fetchLagu() async {
    final response = await http.get(Uri.parse('http://$ip:8000/api/lagu'));

    if (response.statusCode == 200) {
      var responseData = jsonDecode(response.body);
      var apa = responseData.cast<Map<String, dynamic>>();
      var laguList = apa.map<Lagu>((json) => Lagu.fromJson(json)).toList();

      dataList.value = laguList;
      return laguList;
    } else {
      throw Exception('Gagal memuat data lagu');
    }
  }