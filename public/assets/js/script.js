window.onload = function () {
    fixButtonRight();
};

/**Fix button right */
function fixButtonRight() {
    if (
        Math.max(
            document.body.scrollWidth,
            document.documentElement.scrollWidth,
            document.body.offsetWidth,
            document.documentElement.offsetWidth,
            document.documentElement.clientWidth
        ) < 900
    ) {
        document
            .getElementsByClassName("right-area")[0]
            .setAttribute("hidden", true);
    } else {
        document
            .getElementsByClassName("right-area")[0]
            .removeAttribute("hidden");
    }
}
/*end fix button right */

/* Start Scroll */
const mainArea = document.getElementsByClassName("main-area")[0];
mainArea.addEventListener("scroll", function () {
    if (mainArea.scrollTop >= 113) {
        document
            .getElementsByClassName("main-area-header")[0]
            .classList.add("fixed");
    } else {
        document
            .getElementsByClassName("main-area-header")[0]
            .classList.remove("fixed");
    }
});
/* End Scroll */
/* Start Area Link */
const aPageLink = document.querySelectorAll("a#pageLink");
aPageLink.forEach((pageLink) => {
    pageLink.addEventListener("click", () => {
        deleteAllActive();
        pageLink.classList.add("active");
    });
    function deleteAllActive() {
        aPageLink.forEach((pageLink1) => pageLink1.classList.remove("active"));
    }
});
/* End Area Link */
/* Start Area Right */
document
    .getElementsByClassName("btn-show-right-area")[0]
    .addEventListener("click", function () {
        document
            .getElementsByClassName("right-area")[0]
            .removeAttribute("hidden");
        document
            .getElementsByClassName("right-area")[0]
            .classList.remove("show");
        document.getElementsByClassName("right-area")[0].classList.add("show");
    });
document
    .getElementsByClassName("btn-close-right")[0]
    .addEventListener("click", function () {
        fixButtonRight();
        document
            .getElementsByClassName("right-area")[0]
            .classList.remove("show");
    });
/* End Area Right */
/* Start Area Left */
document
    .getElementsByClassName("btn-show-left-area")[0]
    .addEventListener("click", function () {
        document
            .getElementsByClassName("left-area")[0]
            .classList.remove("show");
        document.getElementsByClassName("left-area")[0].classList.add("show");
    });
document
    .getElementsByClassName("btn-close-left")[0]
    .addEventListener("click", function () {
        document
            .getElementsByClassName("left-area")[0]
            .classList.remove("show");
    });
/* End Area Left */
