<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Popup Modal Box</title>
    <!-- CSS -->
    <link rel="stylesheet" href="css/modal.css" />
    <!-- Fontawesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"/>
  </head>
  <body>
    <section>
      <button class="show-modal">Show Modal</button>
      <span class="overlay"></span>

      <!-- <div class="modal-box">
        <i class="fa-regular fa-circle-check"></i>
        <h2>Completed</h2>
        <h3>You have sucessfully downloaded all the source code files.</h3>

        <div class="buttons">
          <button class="close-btn">Ok, Close</button>
          <button>Open File</button>
        </div>
      </div> -->

      <?php include 'modal_addDep.php'; ?>
    </section>

    <!-- <script>
      const section = document.querySelector("section"),
        overlay = document.querySelector(".overlay"),
        showBtn = document.querySelector(".show-modal"),
        closeBtn = document.querySelector(".close-btn");

      showBtn.addEventListener("click", () => section.classList.add("active"));

      overlay.addEventListener("click", () =>
        section.classList.remove("active")
      );

      closeBtn.addEventListener("click", () =>
        section.classList.remove("active")
      );
    </script> -->

    <script src="js/showmodal.js"></script>
  </body>
</html>