(function ($) {
  "use strict";

  $(function () {
    var standaloneRoutes = ["login", "register", "forgot-password", "admin"];

    function updateRouteState() {
      var routeName = window.location.hash.substring(1) || "dashboard";
      var isStandalone = standaloneRoutes.indexOf(routeName) !== -1;

      document.body.classList.toggle("standalone-route", isStandalone);

      document.querySelectorAll(".sidebar .nav-link").forEach(function (link) {
        var isActive = link.getAttribute("href") === "#" + routeName;
        link.classList.toggle("active", isActive);

        var navItem = link.closest(".nav-item");

        if (navItem) {
          navItem.classList.toggle("active", isActive);
        }
      });
    }

    var app = $.spapp({
      templateDir: "views/",
      defaultView: "#dashboard"
    });

    window.addEventListener("hashchange", updateRouteState);
    updateRouteState();
    app.run();
  });
}(jQuery));
