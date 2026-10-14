// Инициализация видео
const videoTriggers = document.querySelectorAll(".video");

function closeAllVideos() {
  videoTriggers.forEach((video) => {
    // console.log(videoTriggers);
    if (video.classList.contains("active")) {
      video.classList.remove("active");
      // const iframe = video.querySelector('.video__iframe');
      let iframe = video.querySelector('.video__iframe');
      if (!iframe) {
          iframe = video.querySelector('iframe');
      }
      if (iframe && !iframe.paused) {
        // console.log('pause');
        
        iframe.pause();
      }
    }
  });
}

function videoPlay(videoElement) {
  let iframe = videoElement.querySelector('.video__iframe');
  if (!iframe) {
      iframe = videoElement.querySelector('iframe');
  }
  // console.log(iframe);
  // console.log(videoElement);
  
  if (!iframe) return;
  
  if (document.fullscreenElement !== iframe) {
    if (iframe.paused) {
      closeAllVideos();
      
      // console.log(videoElement.classList.contains("active"));
      if (!videoElement.classList.contains("active")) {
        videoElement.classList.add("active");
        // console.log(videoElement);
        iframe.play();
      }
    } else {
      videoElement.classList.remove("active");
      // console.log(videoElement);
      // console.log(videoElement.classList.contains("active"));
      iframe.pause();
    }
  }
}

if (videoTriggers.length > 0) {
  videoTriggers.forEach((trigger) => {
    trigger.addEventListener("click", (e) => {
      e.stopPropagation();
      videoPlay(trigger);
    });
  });
  
  // Закрытие видео при клике вне его
  document.addEventListener("click", (e) => {
    if (!e.target.closest('.video')) {
      closeAllVideos();
    }
  });
}