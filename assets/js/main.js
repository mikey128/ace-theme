document.addEventListener('DOMContentLoaded', () => {
  // Custom Custom Video Interaction
  const videoOverlays = document.querySelectorAll('.js-video-overlay');

  videoOverlays.forEach(overlay => {
    overlay.addEventListener('click', function(e) {
      e.preventDefault();
      
      const wrapper = this.closest('.ace-video-module');
      if (!wrapper) return;

      const videoElement = wrapper.querySelector('video');
      if (videoElement) {
        // Hide overlay
        this.style.display = 'none';
        
        // Play video
        videoElement.play();
        
        // Ensure controls are enabled
        videoElement.controls = true;
      }
    });
  });
});

