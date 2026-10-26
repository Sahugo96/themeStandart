export default function modal() {
  const modal = document.querySelector(".modal");

  if (modal) {
    document.addEventListener("click", function (e) {
      if (e.target == document.querySelector(".modal")) {
        modal.classList.remove("active");
        document.querySelector("body").classList.remove("lock");
        modal.classList.remove("success");
      }
    });

    document
      .querySelector(".modal__close")
      .addEventListener("click", function (e) {
        e.preventDefault();

        modal.classList.remove("active");
        document.querySelector("body").classList.remove("lock");
        modal.classList.remove("success");
      });

    document
      .querySelectorAll("[href='#'], [href='#modal'], [href='#modalUp']")
      .forEach((element) => {
        element.addEventListener("click", function (e) {
          e.preventDefault();

          modal.classList.add("active");
          console.log('lock');
          
          document.querySelector("body").classList.add("lock");
        });
      });

    // Закрытие по Esc.
    document.addEventListener("keydown", function (e) {
      if (e.key === "Escape" && modal.classList.contains("active")) {
        modal.classList.remove("active");
        document.querySelector("body").classList.remove("lock");
        modal.classList.remove("success");
      }
    });

    document.addEventListener(
      "wpcf7mailsent",
      function (e) {
        modal.classList.add("success");
        modal.classList.add("active");
      },
      false,
    );
  }
}
