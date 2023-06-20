import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:music_player/const/colors.dart';
import 'package:music_player/const/text_style.dart';
import 'package:music_player/controller/player_controller.dart';
import 'package:music_player/views/player.dart';
import 'package:music_player/models/lagu.dart';

import '../const/util.dart';

class Home extends StatelessWidget {
  const Home({Key? key});

  @override
  Widget build(BuildContext context) {
    var controller = Get.put(PlayerController());
    return Scaffold(
      backgroundColor: bgDarkColor,
      appBar: AppBar(
        backgroundColor: bgDarkColor,
        actions: [
          IconButton(
            onPressed: () {
              Scaffold.of(context).openDrawer();
            },
            icon: const Icon(Icons.search, color: whiteColor),
          )
        ],
        leading: Builder(
          builder: (BuildContext context) {
            return IconButton(
              onPressed: () {
                Scaffold.of(context).openDrawer();
              },
              icon: const Icon(Icons.sort_rounded, color: whiteColor),
            );
          },
        ),
        title: Text(
          "Spotifu",
          style: ourStyle(
            family: bold,
          ),
        ),
      ),
      drawer: Drawer(
        child: ListView(
          children: [
            ListTile(
              title: Text("Coba", style: ourStyle()),
            ),
            ListTile(
              title: Text("nama"),
              subtitle: Text("email"),
              leading: Icon(Icons.person),
            )
          ],
        ),

      ),
      body: Obx(
        () => controller.dataList.isEmpty
            ? const Center(
                child: CircularProgressIndicator(
                  valueColor: AlwaysStoppedAnimation<Color>(Colors.blue),
                ),
              )
            : Padding(
                padding: const EdgeInsets.all(8.0),
                child: ListView.builder(
                  physics: const BouncingScrollPhysics(),
                  itemCount: controller.dataList.length,
                  itemBuilder: (BuildContext context, int index) {
                    Lagu lagu = controller.dataList[index];
                    return Container(
                      margin: const EdgeInsets.only(bottom: 4),
                      child: Obx(
                        () => ListTile(
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(12),
                          ),
                          tileColor: bgColor,
                          leading: Container(
                            width: 50,
                            height: 50,
                            decoration: BoxDecoration(
                              shape: BoxShape.circle,
                              image: DecorationImage(
                                image: NetworkImage(
                                  "http://$ip:8000/storage/cover${lagu.cover}",
                                ),
                                fit: BoxFit.cover,
                              ),
                            ),
                          ),
                          title: Text(
                            lagu.judul,
                            style: ourStyle(family: bold, size: 15),
                          ),
                          subtitle: Text(
                            lagu.penyanyi,
                            style: ourStyle(family: regular, size: 12),
                          ),
                          trailing: controller.playIndex.value == index &&
                                  controller.isPlaying.value
                              ? const Icon(
                                  Icons.play_arrow,
                                  color: whiteColor,
                                  size: 26,
                                )
                              : null,
                          onTap: () {
                            controller.playSong(lagu.file, index);
                            Get.to(
                              () => Player(
                                data: controller.dataList,
                                initialIndex: index,
                              ),
                            );
                          },
                        ),
                      ),
                    );
                  },
                ),
              ),
      ),
      
    );
  }
}
