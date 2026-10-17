(function () {
  "use strict";

  var routes = {
    dashboard: "dashboard.html",
    workouts: "workouts.html",
    exercises: "exercises.html",
    nutrition: "nutrition.html",
    profile: "profile.html"
  };
  var routeAliases = {
    view_dashboard: "dashboard"
  };
  var contentWrapper = document.getElementById("content-wrapper");
  var outlet = document.getElementById("router-view");
  var defaultRoute = "dashboard";

  if (!contentWrapper || !outlet) {
    return;
  }

  function getRouteName() {
    var requestedRoute = window.location.hash.substring(1);
    return routeAliases[requestedRoute] || requestedRoute || defaultRoute;
  }

  function setActiveLink(routeName) {
    var links = document.querySelectorAll("[data-route]");

    links.forEach(function (link) {
      var isActive = link.getAttribute("data-route") === routeName;
      link.classList.toggle("active", isActive);

      if (link.closest(".nav-item")) {
        link.closest(".nav-item").classList.toggle("active", isActive);
      }
    });
  }

  function showMessage(message, className) {
    outlet.innerHTML = "<div class=\"alert " + className + "\" role=\"alert\">" + message + "</div>";
  }

  function loadRoute() {
    var routeName = getRouteName();
    var template = routes[routeName];

    if (!template) {
      window.location.hash = defaultRoute;
      return;
    }

    setActiveLink(routeName);
    showMessage("Loading...", "alert-info");

    fetch("views/" + template)
      .then(function (response) {
        if (!response.ok) {
          throw new Error("View request failed with status " + response.status);
        }
        return response.text();
      })
      .then(function (html) {
        outlet.innerHTML = html;
      })
      .catch(function () {
        showMessage("The requested view could not be loaded.", "alert-danger");
      });
  }

  document.addEventListener("click", function (event) {
    var link = event.target.closest("[data-route]");

    if (!link) {
      return;
    }

    event.preventDefault();
    window.location.hash = link.getAttribute("data-route");
  });

  window.addEventListener("hashchange", loadRoute);
  loadRoute();
}());
