$(document).ready(function () {
  let href;

  $("#btnTrikDelete").click(function (e) {
    e.preventDefault();
    href = $(this).attr("href");
  });

  $("#confirmModalBtn").click(function (e) {
    window.location.href = href;
  });
});
