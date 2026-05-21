const videoContainer = document.querySelector(".video-angklung");
const video = videoContainer.querySelector("video");

video.addEventListener("loadeddata", () => {
  const poster = video.getAttribute("poster") || "video/Angklung.mp4";
  videoContainer.style.setProperty("--poster", `url('${poster}')`);
  videoContainer.style.backgroundImage = `url('${poster}')`;
});

video.addEventListener("play", () => {
  videoContainer.classList.add("playing");
  video.classList.add("expand");
});

video.addEventListener("pause", () => {
  if (!video.ended) {
    videoContainer.classList.remove("playing");
    video.classList.remove("expand");
  }
});

video.addEventListener("ended", () => {
  videoContainer.classList.remove("playing");
  video.classList.remove("expand");
});
