let splideInstances = {};

function handleTabsSplides() {
  const splideElements = document.querySelectorAll(".tabs.splide");
  
  if (!splideElements.length) return;

  splideElements.forEach((element, index) => {
    const instanceKey = `tabs_splide_${index}`;
    
    if (window.innerWidth >= 1024) {
      if (splideInstances[instanceKey]) {
        splideInstances[instanceKey].destroy();
        splideInstances[instanceKey] = null;
        delete splideInstances[instanceKey];
      }

      if (!splideInstances[instanceKey]) {
        splideInstances[instanceKey] = new Splide(element, {
          type: 'slide',
          autoWidth: true,
          perMove: 1,
          gap: '20px',
          drag: true,
          pagination: false,
          arrows: false,
        }).mount();
      }
    }
  });
}

handleTabsSplides();
window.addEventListener('resize', () => handleTabsSplides());


// console.log(document.querySelector('.splide-gggggg'));

// new Splide('.splide-gggggg', {
//   type: 'slide',
//   autoWidth: true,
//   focus: 0,
//   perMove: 1,
//   gap: 20,
//   pagination: false,
//   arrows: false,
//   drag: true,
// }).mount();
// document.addEventListener('DOMContentLoaded', function() {
// });