import 'package:get/get.dart';
import 'package:just_audio/just_audio.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';
import 'package:permission_handler/permission_handler.dart';

import '../const/util.dart';
import '../models/lagu.dart';

class PlayerController extends GetxController {
  final audioPlayer = AudioPlayer();
  var playIndex = 0.obs;
  var isPlaying = false.obs;
  var duration = ''.obs;
  var position = ''.obs;
  var max = 0.0.obs;
  var value = 0.0.obs;
  var autoplay = false.obs;
  var dataList = <Lagu>[].obs;

  @override
  void onInit() {
    super.onInit();
    checkPermission();
    fetchLagu();
    repeat();
  }

  updatePosition() {
    audioPlayer.durationStream.listen((d) {
      duration.value = d.toString().split(".")[0];
      max.value = d!.inSeconds.toDouble();
    });
    audioPlayer.positionStream.listen((p) {
      position.value = p.toString().split(".")[0];
      value.value = p.inSeconds.toDouble();
    });
  }

  changeDurationToSeconds(seconds) {
    var duration = Duration(seconds: seconds);
    audioPlayer.seek(duration);
  }

  playSong(String? uri, index) {
    playIndex.value = index;
    try {
      if (index >= 0 && index < dataList.length) {
        var lagu = dataList[index];
        var url = 'http://$ip:8000/storage/lagu/${lagu.file}';
        audioPlayer.setAudioSource(AudioSource.uri(Uri.parse(url)));
        audioPlayer.play();
        isPlaying(true);
        updatePosition();
      }
    } catch (e) {
      print(e.toString());
    }
  }

  checkPermission() async {
    var perm = await Permission.storage.request();
    if (perm.isGranted) {
    } else {
      checkPermission();
    }
  }

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

  void toggleAutoplay() {
    autoplay.value = !autoplay.value;
    if (autoplay.value) {
      audioPlayer.playerStateStream.listen((playerState) {
        if (playerState.processingState == ProcessingState.completed) {
          if (playIndex.value == dataList.length - 1) {
            playSong(dataList[0].file, 0);
          } else {
            playSong(dataList[playIndex.value + 1].file, playIndex.value + 1);
          }
        }
      });
    }
  }

  void repeat() {
    if (!autoplay.value) {
      audioPlayer.playerStateStream.listen((playerState) {
        if (playerState.processingState == ProcessingState.completed) {
          playSong(dataList[playIndex.value].file, playIndex.value);
        }
      });
    }
  }
}
