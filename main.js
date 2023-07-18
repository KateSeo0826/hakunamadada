const formEl = document.querySelector('.form');
formEl.addEventListener('submit', (e) => {
    e.preventDefault();

    $("#bookingModal").modal("toggle");
    const formEl2 = document.querySelector('.modalForm')
    formEl2.addEventListener('submit', (e) => {
        e.preventDefault();

        const formData = new FormData(formEl);
        const data = {}

        //Loop through all form elements from the first form
        for (let [key, value] of formData) {
            //Check if the key already exists in the data object
            if (data.hasOwnProperty(key)) {
                //If the key exists, create an array and push the value
                if (!Array.isArray(data[key])) {
                    data[key] = [data[key]];
                }
                data[key].push(value)
            } else {
                //If the key doesn't exist, assign the value directly
                data[key] = value;

            }
        }

        const formData2 = new FormData(formEl2);
        const data2 = Object.fromEntries(formData2)

        //Merge the two form data objects
        const data3 = { ...data, ...data2 };
        console.log(data3)

        $.ajax({
            url: 'send-email.php',
            dataType: 'json',
            type: 'POST',
            data: data3,
            success: function (res) {
                console.log(res['message']);
                $('#bookingModal').html(res['message'])
            }
        })
    })
})

var checkboxes = document.querySelectorAll(".form-check-input");
for (let i = 0; i < checkboxes.length; i++) {
    checkboxes[i].addEventListener("change", function () {
        var checked = document.querySelectorAll(".form-check-input:checked").length;
        for (let j = 0; j < checkboxes.length; j++) {
            if (checked > 0) {
                checkboxes[j].required = false;
            } else {
                checkboxes[j].required = true;
            }
        }
    })
}

//date
let d = new Date();
let c_year = d.getFullYear();
console.log(c_year)
let c_month = d.getMonth() + 1;

if (c_month < 10) {
    c_month = '0' + c_month;
}
let c_date = d.getDate();
if (c_date < 10) {
    c_date = '0' + c_date;
}

let c_day = c_year + "-" + c_month + "-" + c_date;

document.getElementById("date").value = c_day;

/* Toggle Button*/
const navbarMenu = document.querySelector('.header-menu')
const toggleBtn = document.querySelector('.navbar-toggleBtn')

toggleBtn.addEventListener('click', () => {
    navbarMenu.classList.toggle('open')
})

//Navbar menu click 
navbarMenu.addEventListener('click', () => {
    navbarMenu.classList.remove('open')
})
// slide
const slider = document.getElementsByClassName('slider')

for (const s of slider) {
    let isMouseDown = false
    let initialPageX, scrollLeft

    const detectMovement = movement => {
        isMouseDown = movement
        //movement ? s.classList.add('active') : s.classList.remove('active')
    }

    s.addEventListener('mousedown', e => {
        detectMovement(true)
        isMouseDown = true
        initialPageX = e.pageX
        scrollLeft = s.scrollLeft
    })

    s.addEventListener('mouseup', () => detectMovement(false))
    s.addEventListener('mouseleave', () => detectMovement(false))

    s.addEventListener('mousemove', e => {
        if (!isMouseDown) return
        e.preventDefault()
        s.scrollLeft = scrollLeft - (e.pageX - initialPageX)
    })
}


// Carousel
var multipleCardCarousel = document.querySelector(
    "#carouselExampleControls"
);
var carousel = new bootstrap.Carousel(multipleCardCarousel, {
    interval: 2000,
    wrap: false
})
if (window.matchMedia("(min-width: 768px)").matches) {
    var carousel = new bootstrap.Carousel(multipleCardCarousel, {
        interval: false,
    });
    var carouselWidth = $(".carousel-inner")[0].scrollWidth;
    var cardWidth = $(".carousel-item").width();
    var scrollPosition = 0;
    $("#carouselExampleControls .carousel-control-next").on("click", function () {
        if (scrollPosition < carouselWidth - cardWidth * 4) {
            scrollPosition += cardWidth;
            $("#carouselExampleControls .carousel-inner").animate(
                { scrollLeft: scrollPosition },
                600
            );
        }
    });
    $("#carouselExampleControls .carousel-control-prev").on("click", function () {
        if (scrollPosition > 0) {
            scrollPosition -= cardWidth;
            $("#carouselExampleControls .carousel-inner").animate(
                { scrollLeft: scrollPosition },
                600
            );
        }
    });
} else {
    $(multipleCardCarousel).addClass("slide");
}



i