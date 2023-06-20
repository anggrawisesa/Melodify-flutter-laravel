import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:music_player/const/colors.dart';
import 'package:music_player/const/text_style.dart';
import 'package:music_player/controller/player_controller.dart';
import 'package:music_player/models/lagu.dart';

import '../const/util.dart';

class Player extends StatelessWidget {
  final List<Lagu> data;
  final int initialIndex;

  const Player({Key? key, required this.data, this.initialIndex = 0});

  @override
  Widget build(BuildContext context) {
    var controller = Get.find<PlayerController>();
    controller.playIndex.value = initialIndex;

    return Scaffold(
      backgroundColor: bgColor,
      appBar: AppBar(),
      body: Padding(
        padding: const EdgeInsets.all(8.0),
        child: Column(
          children: [
            Obx(
              () => Expanded(
                child: Container(
                  height: 350,
                  width: 350,
                  child: ClipRRect(
                    borderRadius: BorderRadius.circular(175),
                    child: Image.network(
                      'http://$ip:8000/storage/cover${data[controller.playIndex.value].cover}',
                      errorBuilder: (context, error, stackTrace) => const Icon(
                        Icons.music_note,
                        size: 48,
                        color: whiteColor,
                      ),
                      fit: BoxFit.cover,
                    ),
                  ),
                ),
              ),
            ),
            const SizedBox(
              height: 12,
            ),
            Expanded(
              child: Container(
                padding: const EdgeInsets.all(8),
                alignment: Alignment.center,
                decoration: const BoxDecoration(
                  borderRadius: BorderRadius.vertical(top: Radius.circular(16)),
                ),
                child: Obx(
                  () => Column(
                    children: [
                      const SizedBox(
                        height: 12,
                      ),
                      Text(
                        data[controller.playIndex.value].judul,
                        textAlign: TextAlign.center,
                        overflow: TextOverflow.ellipsis,
                        maxLines: 2,
                        style: ourStyle(
                          color: bgDarkColor,
                          family: bold,
                          size: 24,
                        ),
                      ),
                      const SizedBox(
                        height: 6,
                      ),
                      Text(
                        data[controller.playIndex.value].penyanyi,
                        textAlign: TextAlign.center,
                        overflow: TextOverflow.ellipsis,
                        maxLines: 2,
                        style: ourStyle(
                          color: bgDarkColor,
                          family: regular,
                          size: 20,
                        ),
                      ),
                      const SizedBox(
                        height: 12,
                      ),
                      Obx(
                        () => Row(
                          children: [
                            Text(
                              controller.position.value,
                              style: ourStyle(color: bgDarkColor),
                            ),
                            Expanded(
                              child: Slider(
                                thumbColor: sliderColor,
                                inactiveColor: whiteColor,
                                activeColor: sliderColor,
                                min: const Duration(seconds: 0)
                                    .inSeconds
                                    .toDouble(),
                                max: controller.max.value,
                                value: controller.value.value,
                                onChanged: (newValue) {
                                  controller.changeDurationToSeconds(
                                      newValue.toInt());
                                  newValue = newValue;
                                },
                              ),
                            ),
                            Text(
                              controller.duration.value,
                              style: ourStyle(color: bgDarkColor),
                            ),
                          ],
                        ),
                      ),
                      const SizedBox(
                        height: 12,
                      ),
                      Column(
                        children: [
                          Row(
                            mainAxisAlignment: MainAxisAlignment.spaceAround,
                            children: [
                              IconButton(
                                onPressed: () {
                                  int prevIndex =
                                      controller.playIndex.value - 1;
                                  if (prevIndex < 0) {
                                    prevIndex = data.length - 1;
                                  }
                                  controller.playSong(
                                    data[prevIndex].file,
                                    prevIndex,
                                  );
                                },
                                icon: const Icon(
                                  Icons.skip_previous_rounded,
                                  color: whiteColor,
                                  size: 40,
                                ),
                              ),
                              Obx(
                                () => CircleAvatar(
                                  radius: 35,
                                  backgroundColor: whiteColor,
                                  child: Transform.scale(
                                    scale: 2.5,
                                    child: IconButton(
                                      onPressed: () {
                                        if (controller.isPlaying.value) {
                                          controller.audioPlayer.pause();
                                          controller.isPlaying(false);
                                        } else {
                                          controller.audioPlayer.play();
                                          controller.isPlaying(true);
                                        }
                                      },
                                      icon: controller.isPlaying.value
                                          ? const Icon(
                                              Icons.pause,
                                              color: bgDarkColor,
                                            )
                                          : const Icon(
                                              Icons.play_arrow_rounded,
                                              color: bgDarkColor,
                                            ),
                                    ),
                                  ),
                                ),
                              ),
                              IconButton(
                                onPressed: () {
                                  int nextIndex =
                                      controller.playIndex.value + 1;
                                  if (nextIndex >= data.length) {
                                    nextIndex = 0;
                                  }
                                  controller.playSong(
                                    data[nextIndex].file,
                                    nextIndex,
                                  );
                                },
                                icon: const Icon(
                                  Icons.skip_next_rounded,
                                  color: whiteColor,
                                  size: 40,
                                ),
                              ),
                              IconButton(
                                onPressed: () {
                                  controller.toggleAutoplay();
                                },
                                icon: Obx(() {
                                  return Icon(
                                    Icons.autorenew_outlined,
                                    color: controller.autoplay.value
                                        ? Colors.white
                                        : Colors.green,
                                    size: 40,
                                  );
                                }),
                              ),
                            ],
                          ),
                        ],
                      ),
                    ],
                  ),
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }
}
