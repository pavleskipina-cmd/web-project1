(function () {
  "use strict";

  function toggleSidebar() {
    document.body.classList.toggle("sidebar-toggled");
    var sidebar = document.querySelector(".sidebar");

    if (sidebar) {
      sidebar.classList.toggle("toggled");
    }
  }

  document.addEventListener("click", function (event) {
    if (event.target.closest("#sidebarToggle, #sidebarToggleTop")) {
      toggleSidebar();
    }

    if (window.innerWidth < 768 && event.target.closest(".sidebar .nav-link")) {
      document.body.classList.remove("sidebar-toggled");
      var sidebar = document.querySelector(".sidebar");

      if (sidebar) {
        sidebar.classList.remove("toggled");
      }
    }
  });
}());
