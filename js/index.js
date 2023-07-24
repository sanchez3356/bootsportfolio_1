window.onload = () => {
  let currentPage = document.location.pathname.split("/").pop().split(".")[0];
  fetchData(currentPage, function (data) {
    setData(data);
  });
};

function limitText() {
  var elements = document.getElementsByClassName("limitedText");

  for (var i = 0; i < elements.length; i++) {
    var element = elements[i];
    var limit = element.getAttribute("data-limit");
    var id = element.getAttribute("data-id");
    var words = element.textContent.split(" ");

    if (words.length > limit) {
      var limitedText = words.slice(0, limit).join(" ");
      var hiddenText = words.slice(limit).join(" ");
      element.textContent = limitedText;

      var link = document.createElement("a");
      link.href = id;
      // link.textContent = "... Read More";
      link.innerHTML = "<button class=\"btn btn-primary btn-sm mx-2\">... Read More <i class=\"fas fa-right-long\"></i></button>";

      link.addEventListener("click", function (event) {
        event.preventDefault();
        element.textContent = limitedText + " " + hiddenText;
      });

      element.appendChild(link);
    }
  }
}
const portContainer = document.querySelector("#portfolio .port_container");
function filter(category) {
  const cards = portContainer.getElementsByClassName('project');

  for (let i = 0; i < cards.length; i++) {
    const card = cards[i];

    if (category === 'all' || card.classList.contains(category)) {
      card.classList.remove('hide');
    } else {
      card.classList.add('hide');
    }
  }
}
function setContactLink(containerName, data) {
  var container = document.querySelector(containerName);
  var link = container.querySelector("a");

  if (containerName === '.phone_cont') {
    link.href = 'tel:' + data;
  } else if (containerName === '.email_cont') {
    link.href = 'mailto:' + data;
  } else {
    link.href = 'https://goo.gl/maps/4g4AnAaHpCwgtvjD6'; // Unclickable link for address
  }
  link.textContent = data;
}

function navToggle() {
  navToggler.classList.toggle("active");
  const nav = document.querySelector(".nav");
  nav.classList.toggle("open");
  if (nav.classList.contains("open")) {
    console.log(nav);
    console.log(nav.scrollHeight);
    nav.style.height = nav.scrollHeight + "px";
  } else {
    nav.style.height = "";
  }
}

function addElement(element, className, callback) {
  const doc = document.createElement(element);
  doc.classList.add(className);
  callback(doc);
}
function setData(data) {
  //add class to nav list
  var navList = document.querySelector(".desktop-nav .menu");
  var list = navList.querySelectorAll("li");
  list.forEach(function (li) {
    li.classList.add("hover-2");
  });

  console.log(data);
  //services cards
  async function loadServices() {
    const loader = document.querySelector("#services .service .loader-cont");
    try {
      const services = data.filter(function (data) {
        return data.service;
      });

      services.forEach((service) => {
        const serveElement = service.service;
        document.querySelector("#services .service").insertAdjacentHTML("afterbegin", serveElement);
      });
    } catch (error) {
      // Handle any errors that occur during portfolio loading
      const errorCard = "<div class=\"alert alert-danger\" role=\"alert\">Error loading my services!</div>";
      document.querySelector("#services .service").insertAdjacentHTML("afterbegin", errorCard);
      loader.classList.replace("d-flex", "hide");
      console.error("Error loading services:", error);
    } finally {
      loader.classList.replace("d-flex", "hide");
    }
  }
  loadServices();
  //portfolio cards
  async function loadPortfolios() {
    const loader = portContainer.querySelector(".loader-cont");
    try {
      const portfolios = data.filter(function (data) {
        return data.project;
      });

      for (let i = 0; i < portfolios.length; i++) {
        const port = portfolios[i];
        const portElement = port.project;
        portContainer.insertAdjacentHTML("afterbegin", portElement);
      }
    } catch (error) {
      // Handle any errors that occur during portfolio loading
      const errorCard = "<div class=\"alert alert-danger\" role=\"alert\">Error loading my portfolios!</div>";
      portContainer.insertAdjacentHTML("afterbegin", errorCard);
      loader.classList.replace("d-flex", "hide");
      console.error("Error loading portfolios:", error);
    } finally {
      loader.classList.replace("d-flex", "hide");
    }
  }
  loadPortfolios();
  //review cards
  async function loadReviews() {
    const loader = document.querySelector("#slider .my-slider .loader-cont");
    try {
      const reviews = data.filter(function (data) {
        return data.review;
      });
      reviews.forEach((review) => {
        const reviewElement = review.review;
        document.querySelector("#slider .my-slider").insertAdjacentHTML("afterbegin", reviewElement);
      });
    } catch (error) {
      // Handle any errors that occur during portfolio loading
      const errorCard = "<div class=\"alert alert-danger\" role=\"alert\">Error loading my reviews!</div>";
      document.querySelector("#slider .my-slider").insertAdjacentHTML("afterbegin", errorCard);
      loader.classList.replace("d-flex", "hide");
      console.error("Error loading reviews:", error);
    } finally {
      loader.classList.replace("d-flex", "hide");
    }
  }
  loadReviews();
  limitText();
  // button slider 1
  let slider = tns({
    container: ".my-slider",
    slideBy: 1,
    speed: 400,
    nav: false,
    controlsContainer: "#controls",
    prevButton: ".previous",
    nextButton: ".next",
    responsive: {
      1600: {
        items: 3,
        gutter: 40,
      },
      1024: {
        items: 2,
        gutter: 30,
      },
      768: {
        items: 2,
        gutter: 20,
      },
      480: {
        items: 1,
        gutter: 10,
      },
    },
  });

  // slider effects

  var portList = document.querySelector(".controls");
  var portLists = portList.querySelectorAll("button");
  portLists.forEach(function (list) {
    list.addEventListener("click", function (event) {
      portLists.forEach(function (lis) {
        lis.classList.remove("shown");
      });
      event.target.classList.toggle("shown");
      filter(event.target.getAttribute("data-filter"));
    });
  });
}
///////////////////////////////////////////////////////////////
///resume setup
function setResume(data) {
  //skills lists
  const skills = data.filter(function (data) {
    return data.skill;
  });
  for (var i = 0; i < skills.length; i++) {
    var html = skills[i]["skill"]; // Get the HTML content from the object's "interest" property
    document.querySelector(".skills .list-unstyled").innerHTML += html; // Append the HTML content to the .interest element
  }

  //interests icons
  const interests = data.filter(function (data) {
    return data.interest;
  });
  for (var i = 0; i < interests.length; i++) {
    var html = interests[i]["interest"]; // Get the HTML content from the object's "interest" property
    document.querySelector(".interests .d-flex").innerHTML += html; // Append the HTML content to the .interest element
  }

  //reference cards
  const references = data.filter(function (data) {
    return data.reference;
  });
  for (var i = 0; i < references.length; i++) {
    var html = references[i]["reference"]; // Get the HTML content from the object's "reference" property
    document.querySelector(".reference .row").innerHTML += html; // Append the HTML content to the .references element
  }
  //experience cards
  const experience = data.filter(function (data) {
    return data.experience;
  });

  const experienceSection = document.querySelector(".experience");
  experience.forEach((exp) => {
    const expElement = exp.experience;
    experienceSection.insertAdjacentHTML("afterend", expElement);
  });

  //education cards
  const education = data.filter(function (data) {
    return data.education;
  });

  const educationSection = document.querySelector(".education");
  education.forEach((edu) => {
    const eduElement = edu.education;
    educationSection.insertAdjacentHTML("afterend", eduElement);
  });

  timeoutTimer = setTimeout(() => {
    //Text animation
    function animateText(textElements) {
      textElements.forEach((element) => {
        const textSplit = element.textContent.split("");
        element.textContent = "";
        textSplit.forEach((letter) => {
          element.innerHTML += '<span class="letter">' + letter + "</span>";
        });
        let currentLetter = 0;
        const letterSpans = element.querySelectorAll(".letter");
        const animationTimer = setInterval(() => {
          letterSpans[currentLetter].classList.add("fade-in");
          currentLetter++;
          if (currentLetter === letterSpans.length) {
            clearInterval(animationTimer);
          }
        }, 60);
      });
    }

    const textElements = document.querySelectorAll(".animated-text");
    animateText(textElements);

    //progressBars animation
    const progressBars = document.querySelectorAll(".progress-bar");

    function animateProgress(bar) {
      const maxProgress = parseInt(bar.dataset["progress"]);
      let currProgress = parseInt(bar.getAttribute("value"));
      const progressAnimationTimer = setInterval(() => {
        if (currProgress >= maxProgress) {
          clearInterval(progressAnimationTimer);
        }
        bar.value = currProgress;
        currProgress += 0.5;
      }, 5);
    }
    progressBars.forEach((bar) => {
      bar.value = 0;
      animateProgress(bar);
    });
  }, 800);
}

function getCV() {
  const CVData = new FormData();
  CVData.append("generate_pdf", getFormattedDateTime());

  const xhr = new XMLHttpRequest();
  xhr.open("POST", "../src/cv.php", true);
  xhr.responseType = "blob";

  xhr.onload = function () {
    if (xhr.status === 200) {
      // Create a temporary link element
      const link = document.createElement("a");
      link.href = window.URL.createObjectURL(xhr.response);
      link.download = "curriculum vitae.pdf";

      // Append the link to the document body and click it to trigger the download
      document.body.appendChild(link);
      link.click();

      // Clean up the temporary link
      document.body.removeChild(link);
    }
  };

  xhr.send(CVData);
}

//////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////
function fetchData(currentPage, callback) {
  let loader = document.getElementById("loader");
  // let loaderProgress = document.getElementById("loader-progress");
  // loader.style.display = "block";
  // loaderProgress.setAttribute("aria-valuenow", "2%");

  let phpFile;
  switch (currentPage) {
    case "index":
      phpFile = "../src/index.php";
      break;
    case "about":
      phpFile = "../src/about.php";
      break;
    case "portfolio":
      phpFile = "../src/portfolio.php";
      break;
    default:
      phpFile = "../src/index.php";
  }

  fetch(phpFile)
    .then((response) => {
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }
      const contentLength = response.headers.get("Content-Length");
      const total = parseInt(contentLength, 10);
      let loaded = 0;
      const reader = response.body.getReader();
      return new ReadableStream({
        start(controller) {
          function push() {
            reader
              .read()
              .then(({ done, value }) => {
                if (done) {
                  controller.close();
                  return;
                }
                loaded += value.byteLength;
                const percentComplete = (loaded / total) * 100;
                //   loaderProgress.style.width = percentComplete + "%";
                //   loaderProgress.innerText = percentComplete.toFixed(2) + "%";
                //   loaderProgress.setAttribute(
                //     "aria-valuenow",
                //     percentComplete + "%"
                //   );
                controller.enqueue(value);
                push();
              })
              .catch((error) => {
                console.log("Error reading response body:", error);
                alert("Error reading response body:", error);
              });
          }
          push();
        },
      });
    })
    .then((stream) => {
      const response = new Response(stream);
      return response.text();
    })
    .then((content) => {
      // console.log(content);
      var data = JSON.parse(content);
      if (data) {
        loader.style.display = "none";
      }
      // Call other functions based on current page
      switch (currentPage) {
        case "index":
          var profile = data["0"];
          console.log(profile);
          // Insert the website content into the web page
          document.getElementById("main").style.display = "block";
          document.querySelector("#home .banner-name").innerText = profile.first;
          document.querySelector("#home .home-banner-text-col p span").innerText =
            profile.title;
          const logos = document.querySelectorAll(".logo img");
          logos.forEach(function (logo) {
            logo.setAttribute("src", profile.logo);
          });
          document
            .querySelector("#home .profile-image")
            .setAttribute("src", profile.avatar);
          document
            .querySelector("#about .profile-photo")
            .setAttribute("src", profile.photo);
          document.querySelector("#about .abt-image .content").innerHTML =
            "<h2>" +
            profile.first +
            " " +
            profile.last +
            "</br><span>" +
            profile.title +
            "</span></h2>";
          document.querySelector(".full_name span").innerText =
            profile.first + " " + profile.last;
          document.querySelector("#about .abt-text p").innerHTML =
            profile.about;
          setContactLink(".phone_cont", profile.phone);
          setContactLink(".email_cont", profile.email);
          setContactLink(".address_cont", profile.address);
          const footer = document.querySelector("footer .d-flex .wrapper");
          footer.innerHTML = profile.social;
          callback(data);
          break;
        case "about":
          // Call other function for about page
          console.log(data);
          var profile = data["0"];
          document.getElementById("resume").style.display = "block";
          document
            .querySelector(".image #profile_photo")
            .setAttribute("src", profile.photo);
          document.querySelector(".banner_name").innerText = profile.names;
          document.querySelector(".banner_title").innerText = profile.title;
          document.querySelector(".banner_about p").innerText = profile.about;
          setContactLink(".phone_cont", profile.phone);
          setContactLink(".email_cont", profile.email);
          setContactLink(".address_cont", profile.address);
          setResume(data);
          break;
        case "portfolio":
          document.getElementById("main").style.display = "block";
          break;
        default:
          window.location.href = "../public/index.html";
          alert("Couldn't find page url, redirected to default page.");
          callback(data);
      }
    })
    .catch((error) => {
      console.log("Error fetching website content:", error);
    });
}
//form validation
function getFormattedDateTime() {
  const now = new Date();

  const year = now.getFullYear();
  const month = ("0" + (now.getMonth() + 1)).slice(-2);
  const day = ("0" + now.getDate()).slice(-2);
  const hours = ("0" + now.getHours()).slice(-2);
  const minutes = ("0" + now.getMinutes()).slice(-2);
  const seconds = ("0" + now.getSeconds()).slice(-2);

  const formattedDateTime =
    year +
    "-" +
    month +
    "-" +
    day +
    " " +
    hours +
    ":" +
    minutes +
    ":" +
    seconds;

  return formattedDateTime;
}

const username = document.querySelector("#username");
const email = document.querySelector("#email");
const message = document.querySelector("#message");
const subject = document.querySelector("#subject");
const phone = document.querySelector("#phone");
const date = document.querySelector("#date");

const form = document.querySelector("#form");

const checkUsername = () => {
  let valid = false;

  const min = 3,
    max = 25;

  const usernameVal = username.value.trim();

  if (!isRequired(usernameVal)) {
    showError(username, "Username cannot be blank.");
  } else if (!isBetween(usernameVal.length, min, max)) {
    showError(
      username,
      `Username must be between ${min} and ${max} characters.`
    );
  } else {
    showSuccess(username);
    valid = true;
  }
  return valid;
};

const checkEmail = () => {
  let valid = false;
  const emailVal = email.value.trim();
  if (!isRequired(emailVal)) {
    showError(email, "Email cannot be blank.");
  } else if (!isEmailValid(emailVal)) {
    showError(email, "Email is not valid.");
  } else {
    showSuccess(email);
    valid = true;
  }
  return valid;
};

const checkMessage = () => {
  let valid = false;

  const min = 10,
    max = 25;

  const messageVal = message.value.trim();

  if (!isRequired(messageVal)) {
    showError(message, "The message cannot be blank.");
  } else if (!isBetween(messageVal.split(" ").length, min, max)) {
    showError(message, `The message must be between ${min} and ${max} words.`);
  } else {
    showSuccess(message);
    valid = true;
  }
  return valid;
};

const isEmailValid = (email) => {
  const re = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
  return re.test(email);
};

const isRequired = (value) => (value === "" ? false : true);
const isBetween = (length, min, max) =>
  length < min || length > max ? false : true;

const showError = (input, message) => {
  // get the form-field element
  const formField = input.parentElement;
  // add the error class
  formField.classList.remove("success");
  formField.classList.add("error");

  // show the error message
  const error = formField.querySelector(".invalid-feedback");
  error.textContent = message;
};

const showSuccess = (input) => {
  // get the form-field element
  const formField = input.parentElement;
  // remove the error class
  formField.classList.remove("error");
  formField.classList.add("success");

  // hide the error message
  const success = formField.querySelector(".invalid-feedback");
  success.textContent = "";
};

form.addEventListener("submit", function (e) {
  // prevent the form from submitting
  e.preventDefault();
  // validate forms
  let isUsernameValid = checkUsername(),
    isEmailValid = checkEmail(),
    isMessageValid = checkMessage();

  let isFormValid = isUsernameValid && isEmailValid && isMessageValid;
  // submit to the server if the form is valid
  if (isFormValid) {
    // Output the formatted date and time string
    date.value = getFormattedDateTime();
    const messageData = new FormData(form);
    post(messageData, "../src/post.php", function (response) {
      console.log(response);
    });
  }
});
const debounce = (fn, delay = 500) => {
  let timeoutId;
  return (...args) => {
    // cancel the previous timer
    if (timeoutId) {
      clearTimeout(timeoutId);
    }
    // setup a new timer
    timeoutId = setTimeout(() => {
      fn.apply(null, args);
    }, delay);
  };
};
//
form.addEventListener(
  "input",
  debounce(function (e) {
    switch (e.target.id) {
      case "username":
        checkUsername();
        break;
      case "email":
        checkEmail();
        break;
      case "message":
        checkMessage();
        break;
    }
  })
);
//newsletter form validation
const newsEmail = document.getElementById("news");

newsEmail.addEventListener(
  "input",
  debounce(function (e) {
    checkNewsEmail();
  })
);

const checkNewsEmail = () => {
  let valid = false;
  const newsVal = newsEmail.value.trim();
  if (!isRequired(newsVal)) {
    showError(newsEmail, "Email cannot be blank.");
  } else if (!isEmailValid(newsVal)) {
    showError(newsEmail, "Email is not valid.");
  } else {
    showSuccess(newsEmail);
    valid = true;
  }
  return valid;
};
const newsForm = document.getElementById("subscribe");
newsForm.addEventListener("submit", function (event) {
  event.preventDefault();
  let isNewsValid = checkNewsEmail();
  let isNewsFormValid = isNewsValid;
  if (isNewsFormValid) {
    const newsData = new FormData();
    newsData.append("newsletter", newsEmail.value.trim());
    newsData.append("newsDate", getFormattedDateTime());
    post(newsData, "../src/post.php", function (response) {
      console.log(response);
    });
  }
});
//end of form validation
// post ajax requests
function post(data, url, callback) {
  const xhr = new XMLHttpRequest();
  xhr.open("POST", url);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      callback(xhr.responseText);
    }
  };
  xhr.send(data);
}
//end of post ajax requests
//get ajax requests
function get(url, callback) {
  // Send the form data to the PHP server using AJAX
  const xhr = new XMLHttpRequest();
  xhr.open("GET", url);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      // Parse the JSON-encoded string into a JavaScript object
      const data = JSON.parse(xhr.responseText);
      // Call the callback function with the data object
      callback(data);
    }
  };
  xhr.send();
}
//end of get ajax requests
