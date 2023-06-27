
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