// preloader
window.addEventListener("load", () => {
  const loader = document.querySelector(".loader");

  loader.classList.add("loader--hidden");

  loader.addEventListener("transitionend", () => {
    // document.body.removeChild(loader);
    loader.remove();
  });
});

// nav bar dropdown

$(document).ready(function () {
  $(".toggle").click(function () {
    $(".toggle").toggleClass("active");
    $(".navigation").toggleClass("active");
  });
});

// light Gallery plugin
$(document).ready(function () {
  $(".pic").lightGallery();
});
$(document).ready(function () {
  $(".ved").lightGallery();
});

// select new data content
let allTabs = document.querySelectorAll(".allTabs .tab");
let allTabsArray = Array.from(allTabs);
let newData = document.querySelectorAll(".newDataContent > div");
let allNewDataArray = Array.from(newData);

allTabsArray.forEach((ele) => {
  ele.addEventListener("click", function (e) {
    allTabsArray.forEach((ele) => {
      ele.classList.remove("activeTab");
    });
    e.currentTarget.classList.add("activeTab");
    allNewDataArray.forEach((element) => {
      element.style.display = "none";
    });
    document.querySelector(
      e.currentTarget.dataset.content
    ).style.display = `flex`;
  });
});
// add to wish list

let addToWish = document.querySelectorAll(".addToWish");

addToWish.forEach((e) => {
  // console.log(e);
  e.addEventListener("click", function (ele) {
    // console.log(ele.currentTarget);
    if (ele.currentTarget.classList.contains("like")) {
      ele.currentTarget.innerHTML = `<i class="far fa-heart"></i>`;
      ele.currentTarget.classList.toggle("like");
    } else {
      ele.currentTarget.innerHTML = `<i class="fas fa-heart"></i>`;
      ele.currentTarget.classList.toggle("like");
    }
  });
});

// statistics for all content
let counterNum = document.querySelectorAll(".counter-num");
let statistics = document.querySelector(".statistics");
let started = false;

// Scroll to Top
const scrollToTop = document.getElementById("scrollToTop"); //get btn Id

// counter
window.onscroll = () => {
  // this for counter
  if (window.scrollY >= statistics.offsetTop - statistics.offsetHeight - 200) {
    if (!started) {
      counterNum.forEach((e) => startCount(e));
    }
    started = true;
  }

  // this for scroll to top
  if (window.scrollY >= 600) {
    scrollToTop.style.display = "block"; // check scroll > 600 show btn
  } else {
    scrollToTop.style.display = "none"; // check scroll < 600 hide btn
  }
};
// counter
function startCount(el) {
  let goal = el.dataset.goal;
  let count = setInterval(() => {
    if(goal > 0){
        el.textContent++;
      }
    if (el.textContent == goal) {
      clearInterval(count);
    }
  }, 3000 / goal);
}
// to top click
scrollToTop.onclick = () => {
  window.scrollTo({
    top: 0,
    behavior: "smooth",
  });
};

// start api pray times

let urlAr = "https://hamadalhajri.net/";


let dayInWeek = document.querySelector(".dayInWeek");
let hajriDate = document.querySelector(".day-hajri");
let dayM = document.querySelector(".day-m");
let fajr = document.querySelector(".fajr");
let shrouk = document.querySelector(".shrouk");
let zuhr = document.querySelector(".zuhr");
let aser = document.querySelector(".aser");
let maqhreb = document.querySelector(".maqhreb");
let easha = document.querySelector(".easha");
let prayApi = document.querySelector(".pray-api-box");
let prayEmbbed = document.querySelector(".pray-embbed");
let embbedLink = `
  <div>
    <iframe
      src="https://timesprayer.com/widgets.php?frame=2&amp;
      lang=en&amp;name=kuwait&amp;avachang=true&amp;time=0&amp;fcolor=000000&amp;
      tcolor=FFC265&amp;frcolor=000000"
      style= overflow: hidden; height: 275px;">
    </iframe>
  </div>`;

// fetch api
fetch(
  "https://api.aladhan.com/v1/timingsByCity?city=Kuwait&country=Kuwait&method=8"
)
  .then((res) => res.json())
  .then(
    (data) =>
      `${(
        (fajr.innerHTML = data.data.timings.Fajr),
        (shrouk.innerHTML = data.data.timings.Sunrise),
        (zuhr.innerHTML = data.data.timings.Dhuhr),
        (aser.innerHTML = data.data.timings.Asr),
        (maqhreb.innerHTML = data.data.timings.Maghrib),
        (easha.innerHTML = data.data.timings.Isha),
        (window.location.href == urlAr
            ?
            dayInWeek.innerHTML = data.data.date.hijri.weekday.ar
            :
            dayInWeek.innerHTML = data.data.date.gregorian.weekday.en
        ),
        // (dayInWeek.innerHTML = data.data.date.hijri.weekday.ar),
        (window.location.href == urlAr
            ?
            hajriDate.innerHTML = data.data.date.hijri.date + " " + `<span class="time-dd"> هـ</span>`
            :
            hajriDate.innerHTML = data.data.date.hijri.date + " " + `<span class="time-dd"> H </span>`
        ),
        // (hajriDate.innerHTML =
        //   data.data.date.hijri.date + " " + `<span class="time-dd"> هـ</span>`),
        (window.location.href == urlAr
            ?
            dayM.innerHTML = data.data.date.gregorian.date + " " + `<span class="time-dd"> م</span>`
            :
            dayM.innerHTML = data.data.date.gregorian.date + " " + `<span class="time-dd"> M</span>`
        )
        
        // (dayM.innerHTML = data.data.date.gregorian.date + " " + `<span class="time-dd"> م</span>`)
         
         )}`
  )
  .catch((erorr) =>
    erorr
      ? (prayApi.remove(),
        ((prayEmbbed.style.display = "block"),
        (prayEmbbed.innerHTML = embbedLink)))
      : ""
  );

// console.log();

window.addEventListener("scroll", () => {
  let allTabs = document.querySelector(".allTabs");
  let realComeEvent = document.querySelector(".real-come");
  let defultCome = document.querySelector(".defult-come");
  let prayFadeOut = document.querySelector(".prayFadeOut");
  let moreDown = document.querySelector(".moreDown");
  let moreWatch = document.querySelector(".moreWatch");
  let fadeFatwa = document.querySelector(".fadeFatwa");
  let postion = window.scrollY;

//   if (postion >= 350) {
//     allTabs.classList.remove("fade-out");
//     allTabs.classList.add("fade-in");
//   }

  if (postion >= 2500) {
    prayFadeOut.style.cssText = `
    right: 0;
    transition: 1s all ease-out;
  `;
  }
  if (postion >= 3600) {
    (moreDown.style.cssText = `
    right: 0;
    transition: 1s all ease-out;
  `),
      (moreWatch.style.cssText = `
  left: 0;
  transition: 1s all ease-out;
`);
    if (postion >= 4200) {
      fadeFatwa.classList.remove("fade-out");
      fadeFatwa.classList.add("fade-in");
    }
  }
});
