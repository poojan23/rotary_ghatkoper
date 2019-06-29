// date and time-----------------------------------------------------------------------------------------------
    document.getElementById("date").innerHTML = formatAMPM();

    function formatAMPM() {
        var d = new Date(),
            months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        return months[d.getMonth()] + ' ' + d.getDate() + ', ' + d.getFullYear();
        // return days[d.getDay()] + ' ' + months[d.getMonth()] + ' ' + d.getDate() + ' ' + d.getFullYear() + ' ' + hours + ':' + minutes + ampm;
    }
    function startTime() {
        var today = new Date();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        var ampm = today.getHours() >= 12 ? 'pm' : 'am';
        m = checkTime(m);
        s = checkTime(s);
        document.getElementById('time').innerHTML = h + ":" + m + ":" + s + " " + ampm;
        var t = setTimeout(startTime, 500);
    }
    function checkTime(i) {
        if (i < 10) { i = "0" + i };  // add zero in front of numbers < 10
        return i;
    }
//end code date and time-----------------------------------------------------------------------------------------------
// slider-----------------------------------------------------------------------------------------------
    $(function () {

        $(".fullscreen-carousel").owlCarousel({
            items: 1,
            center: true,
            dots: false,
            autoplay: true,
            autoplayTimeout: 5000,
            smartSpeed: 900,
            nav: true, //comment for sbi logo
            navText: ['<i class="fa fa-angle-left fa-2x"></i>', '<i class="fa fa-angle-right fa-2x"></i>'],
            loop: true,
            mouseDrag: true,
            touchDrag: true,
            navigation: true,
            singleItem: true,
            animateIn: 'fadeIn', // add this
            animateOut: 'fadeOut', // and this
            transitionStyle: "fade"
        });

        $(".project-carousel").owlCarousel({
            items: 3,
            center: true,
            margin: 20,
            dots: false,
            autoplay: true,
            autoplayTimeout: 5000,
            smartSpeed: 900,
            nav: true,
            navText: ['<i class="fa fa-angle-left fa-2x"></i>', '<i class="fa fa-angle-right fa-2x"></i>'],
            loop: true,
            mouseDrag: true,
            touchDrag: true
        });
    });
//end slider-----------------------------------------------------------------------------------------------