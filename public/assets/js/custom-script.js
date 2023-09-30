$(".banner-carousel").slick({
    dots: true,
    autoplay: true,
    autoplaySpeed: 1000,
    // centerMode: true,
    centerPadding: "60px",
});
$(".event-terbaru").slick({
    dots: false,
    slidesToShow: 4,
    slidesToScroll: 1,
    responsive: [
        {
            breakpoint: 1150,
            settings: {
                arrows: false,
                centerPadding: "40px",
                slidesToShow: 3,
                slidesToScroll: 1,
            },
        },
        {
            breakpoint: 950,
            settings: {
                dots: false,
                arrows: false,
                centerPadding: "40px",
                slidesToShow: 2,
                slidesToScroll: 1,
            },
        },
        {
            breakpoint: 700,
            settings: {
                arrows: true,
                centerMode: false,
                centerPadding: "40px",
                slidesToShow: 2,
                slidesToScroll: 1,
            },
        },
        {
            breakpoint: 500,
            settings: {
                dots: false,
                centerMode: false,
                slidesToShow: 1,
                slidesToScroll: 1,
            },
        },
    ],
});
