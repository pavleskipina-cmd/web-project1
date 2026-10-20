(function ($) {
  "use strict";

  $(function () {
    var app = $.spapp({
      templateDir: "views/",
      defaultView: "#dashboard"
    });

    app.run();
  });
}(jQuery));
