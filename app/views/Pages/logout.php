a = document.getElementById("ember180");


a.player.on("ratechange", function () {
  if (a.player.playbackRate() !== 4.0) {
    a.player.playbackRate(4);
  }
});

a.player.on("timeupdate", function () {
  if (Math.floor(player.currentTime()) === 300) {
    player.playbackRate(2);
  }
});
