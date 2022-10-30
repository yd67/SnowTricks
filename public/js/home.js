let btnToTop = document.getElementById("btn-back-to-top");
let btnToDown = document.getElementById("btn-go-down");

window.onscroll = function () {
  scrollFunction();
};

function scrollFunction() {
  if (
    document.body.scrollTop > 700 ||
    document.documentElement.scrollTop > 700
  ) {
    btnToTop.style.display = "block";
    btnToDown.style.display = "none"
  } else {
    btnToTop.style.display = "none";
    btnToDown.style.display = "block"
  }
}

btnToTop.addEventListener("click", backToTop);
btnToDown.addEventListener("click",goDown) ;

function goDown() {
  document.documentElement.scrollTo({
      top: 800,
      left: 0,
      behavior: "smooth"
  })
}
function backToTop() {
  document.documentElement.scrollTo({
      top: 0,
      left: 0,
      behavior: "smooth"
  })
}

//  partie load more 
$(document).ready(function() {
  $(".block").slice(0, 6).show();
  if ($(".block:hidden").length != 0) {
      $("#load").show();
  }
  $("#load").on("click", function(e) {
      e.preventDefault();
      $(".block:hidden").slice(0, 3).slideDown();
      if ($(".block:hidden").length == 0) {
          $("#load").hide();
      }
  });
}) 