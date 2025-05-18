[available=demo]
{include file="/engine/modules/demo.php"}
[/available]<!DOCTYPE html>
<html lang="zxx">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    {headers}

    <link rel="stylesheet" href="/templates/Full/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/templates/Full/assets/css/animate.min.css">
    <link rel="stylesheet" href="/templates/Full/assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="/templates/Full/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/templates/Full/assets/css/nice-select.min.css">
    <link rel="stylesheet" href="/templates/Full/assets/css/magnific-popup.min.css">
    <link rel="stylesheet" href="/templates/Full/assets/css/meanmenu.css">
    <link rel="stylesheet" href="/templates/Full/assets/css/ion.rangeSlider.min.css">
    <link rel="stylesheet" href="/templates/Full/assets/css/slick.min.css">
    <link rel="stylesheet" href="/templates/Full/assets/css/style.css">
    <link rel="stylesheet" href="/templates/Full/assets/css/responsive.css">
    <link rel="icon" type="image/png" href="/templates/Full/assets/img/favicon.png">
    <link rel="stylesheet" href="/templates/Full/assets/css/sm.css">
    <link rel="stylesheet" href="/templates/Full/assets/css/smshop/front.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</head>
<body>


{include file="/modules/top_panel.tpl"}
{include file="/modules/navbar_area.tpl"}
{include file="/modules/bts_popup.tpl"}


[group=1]
[available=admin]
{include file="/admin.tpl"}
[/available]
[/group]

[available=smshop|static]
{content}
[/available]

[available=main]
{include file="/pages/main.tpl"}
[/available]


{include file="/modules/footer.tpl"}

<div class="go-top"><i class="fas fa-arrow-up"></i><i class="fas fa-arrow-up"></i></div>

<!-- JQuery Min Js -->
<script src="/templates/Full/assets/js/jquery.min.js"></script>
<!-- Bootstrap Min Js -->
<script src="/templates/Full/assets/js/bootstrap.bundle.min.js"></script>
<!-- Parallax Min JS -->
<script src="/templates/Full/assets/js/parallax.min.js"></script>
<!-- Slick Min JS -->
<script src="/templates/Full/assets/js/slick.min.js"></script>
<!-- Owl Carousel Min JS -->
<script src="/templates/Full/assets/js/owl.carousel.min.js"></script>
<!-- Magnific Popup Min JS -->
<script src="/templates/Full/assets/js/jquery.magnific-popup.min.js"></script>
<!-- niceSelect Min JS -->
<script src="/templates/Full/assets/js/jquery.nice-select.min.js"></script>
<!-- MeanMenu JS -->
<script src="/templates/Full/assets/js/jquery.meanmenu.js"></script>
<!-- ION rangeSlider Min JS  -->
<script src="/templates/Full/assets/js/ion.rangeSlider.min.js"></script>
<!-- Form Validator Min JS -->
<script src="/templates/Full/assets/js/form-validator.min.js"></script>
<!-- Contact Form Min JS -->
<script src="/templates/Full/assets/js/contact-form-script.js"></script>
<!-- ajaxChimp Min JS -->
<script src="/templates/Full/assets/js/jquery.ajaxchimp.min.js"></script>
<!-- Main JS -->
<script src="/templates/Full/assets/js/main.js"></script>

<script src="/templates/Full/assets/js/smshop/front.js"></script>
</body>
</html>