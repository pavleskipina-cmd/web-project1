(function ($) {
  "use strict";

  var authRoutes = {
    "view_forgot-password": "forgot-password.html",
    "view_login": "login.html",
    "view_register": "register.html"
  };

  var appShell = $("#app-shell");
  var authWrapper = $("#auth-wrapper");
  var authContent = $("#auth-content");

  function showAuthView(viewId) {
    var template = authRoutes[viewId];

    if (!template) {
      return false;
    }

    appShell.addClass("d-none");
    authWrapper.removeClass("d-none");
    authContent
      .empty()
      .load("views/" + template)
      .fail(function () {
        authContent.html("<div class=\"container py-5\"><div class=\"alert alert-danger\" role=\"alert\">The requested view could not be loaded.</div></div>");
      });
    return true;
  }

  function showAppShell() {
    authWrapper.addClass("d-none");
    appShell.removeClass("d-none");
  }

  function handleRoute() {
    var viewId = window.location.hash.substring(1) || "view_dashboard";

    if (!showAuthView(viewId)) {
      showAppShell();
    }
  }

  $(window).on("hashchange", handleRoute);
  handleRoute();

  $(document).on("click", "a[href]", function (event) {
    var route = {
      "forgot-password.html": "view_forgot-password",
      "login.html": "view_login",
      "register.html": "view_register"
    }[$(this).attr("href")];

    if (!route) {
      return;
    }

    event.preventDefault();
    window.location.hash = route;
  });
}(jQuery));
