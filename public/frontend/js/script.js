$(document).ready(function () {
  // Bắt sự kiện khi nhấp vào tab Sign In
  $("#signin-tab").click(function (e) {
    e.preventDefault();
    $("#signin-form").addClass("show active");
    $("#signup-form").removeClass("show active");
  });

  // Bắt sự kiện khi nhấp vào tab Sign Up
  $("#signup-tab").click(function (e) {
    e.preventDefault();
    $("#signup-form").addClass("show active");
    $("#signin-form").removeClass("show active");
  });
});

$(document).ready(function() {
  $("a.nav-link").click(function(e) {
    e.preventDefault();

    if ($(this).text() === "Logout") {
      window.location.href = "https://www.youtube.com/";
    } else {
      var targetSection = $(this).attr("href");

      // Ẩn tất cả các mục điều hướng
      $("a.nav-link").removeClass("show active");
      $(".tab-pane").removeClass("show active");

      // Hiển thị mục điều hướng và phần tương ứng được nhấp
      $(this).addClass("show active");
      $(targetSection).addClass("show active");
    }
  });
});
