<!doctype html>
<html class="no-js" lang="zxx">
<html[available=lostpassword|register] class="page_form_style"[/available] lang="ru">
<head>
    {headers}
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/images/favicon-el.ico" rel="icon">


    {include file="/{THEME}/css/bootstrap.min.css"}
    {include file="/{THEME}/css/font-awesome.min.css"}
    {include file="/{THEME}/css/bootstrap-icons.css"}
    {include file="/{THEME}/css/simple-line-icons.min.css"}
    {include file="/{THEME}/css/themify-icons.css"}
    {include file="/{THEME}/css/rs-plugin/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css"}
    {include file="/{THEME}/css/rs-plugin/css/settings.css"}
    {include file="/{THEME}/css/rs-plugin/css/owl-slider-fadeup/rs6.css"}
    {include file="/{THEME}/css/owl.carousel.min.css"}
    {include file="/{THEME}/css/owl.theme.default.min.css"}
    {include file="/{THEME}/css/magnific-popup.css"}
    {include file="/{THEME}/css/klim.css"}

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{THEME}/css/color_panel.css" type="text/css"/>
    <link rel="stylesheet" href="{THEME}/css/color-schemes/blue.css" id="changeable-colors">
    <link rel="stylesheet" href="{THEME}/css/style.css" class="main-style">
    <script src="{THEME}/js/catalog.js"></script>
    <link rel="stylesheet" href="{THEME}/css/klim.css">
    <style>#rev_slider_6_1_wrapper .hesperiden.tparrows{cursor:pointer;background:rgba(0,0,0,0.5);width:40px;height:40px;position:absolute;display:block;z-index:1000; border-radius:50%}#rev_slider_6_1_wrapper .hesperiden.tparrows.rs-touchhover{background:#000000}#rev_slider_6_1_wrapper .hesperiden.tparrows:before{font-family:'revicons';font-size:20px;color:#ffffff;display:block;line-height:40px;text-align:center}#rev_slider_6_1_wrapper .hesperiden.tparrows.tp-leftarrow:before{content:'\e82c'; margin-left:-3px}#rev_slider_6_1_wrapper .hesperiden.tparrows.tp-rightarrow:before{content:'\e82d'; margin-right:-3px}#rev_slider_6_1_wrapper .hesperiden.tp-bullets{}#rev_slider_6_1_wrapper .hesperiden.tp-bullets:before{content:' ';position:absolute;width:100%;height:100%;background:transparent;padding:10px;margin-left:-10px;margin-top:-10px;box-sizing:content-box; border-radius:8px}#rev_slider_6_1_wrapper .hesperiden .tp-bullet{width:12px;height:12px;position:absolute;background:#000000;  background:-moz-linear-gradient(top,#000000 0%,#000000 100%);  background:-webkit-linear-gradient(top,#000000 0%,#000000 100%);  background:-o-linear-gradient(top,#000000 0%,#000000 100%);  background:-ms-linear-gradient(top,#000000 0%,#000000 100%);  background:linear-gradient(to bottom,#000000 0%,#000000 100%);  filter:progid:dximagetransform.microsoft.gradient(  startcolorstr='#000000',endcolorstr='#000000',gradienttype=0 ); border:3px solid #e5e5e5;border-radius:50%;cursor:pointer;box-sizing:content-box}#rev_slider_6_1_wrapper .hesperiden .tp-bullet.rs-touchhover, #rev_slider_6_1_wrapper .hesperiden .tp-bullet.selected{background:#666666}#rev_slider_6_1_wrapper .hesperiden .tp-bullet-image{}#rev_slider_6_1_wrapper .hesperiden .tp-bullet-title{}</style>

</head>
<!--Body Start-->
<body data-res-from="1025">
<div id="page">
    <!--Page Loader-->
    {* <div class="page-loader"></div>*}
    <!--Zmm Wrapper-->
    <div class="zmm-wrapper">
        <a href="#" class="zmm-close close"></a>
        <div class="zmm-inner bg-white typo-dark">
            <div class="text-center mobile-logo-part margin-bottom-30">
                <a href="index.html" class="img-before"><img src="/images/elephant-flowers.jpg" class="img-fluid changeable-dark" width="80" height="35" alt="Logo"></a>
            </div>
            <div class="zmm-main-nav">
            </div>
           {* <div class="search-form-wrapper margin-top-30">
                <form class="search-form" role="search">
                    <div class="input-group add-on">
                        <input class="form-control" placeholder="Search for..+" name="srch-term" type="text">
                        <div class="input-group-btn">
                            <button class="btn btn-default search-btn" type="submit"><i class="ti-arrow-right"></i></button>
                        </div>
                    </div>
                </form>
            </div>*}
        </div>
    </div>
    <!-- Overlay Search -->
    <div class="overlay-search text-center hide">
        <a href="#" class="close close-light overlay-search-close"></a>
        <div class="search-form-wrapper">
            <form class="navbar-form search-form sliding-search-form" role="search">
                <div class="input-group add-on">
                    <input class="form-control" placeholder="Search for.." name="srch-term" type="text">
                    <div class="input-group-btn">
                        <button class="btn btn-default search-btn" type="submit"><i class="ti-arrow-right"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Main wrapper-->
    <div class="page-wrapper">

        <div class="page-wrapper-inner">
            <!-- Page Content -->
            <div class="content-wrapper pad-none">
                <div class="content-inner">
                    [available=main]
                    {include file="/modules/content_main.tpl"}
                    [/available]

                    [available=city]
                    {include file="/modules/content_main_city.tpl"}
                    [/available]

                    [available=contact]
                    {include file="/modules/header.tpl"}
                    {include file="/Full/contact.tpl"}
                    {include file="/modules/footer.tpl"}
                    [/available]

                    [available=cat]
                    {include file="/modules/header.tpl"}
                    {include file="/pages/price.tpl"}
                    {include file="/modules/footer.tpl"}
                    [/available]

                    [available=showfull|static|lostpassword|register]
                    {include file="/modules/header.tpl"}
                    {info}
                    {content}
                    {navigation}
                    {include file="/modules/footer.tpl"}
                    [/available]
                </div>
            </div>
        </div>

        <!-- .page-wrapper-inner -->
    </div>
    <!--page-wrapper-->


</div>


<!-- jQuery Lib -->
<script src="{THEME}/js/jquery.min.js"></script>
<!-- Bootstrap Js -->
<script src="{THEME}/js/bootstrap.bundle.min.js"></script>
<!-- Popper Js Support for Bootstrap -->
<script src="{THEME}/js/popper.min.js"></script>
<!-- Easing Js -->
<script src="{THEME}/js/jquery.easing.min.js"></script>
<!-- Carousel Js Code -->
<script src="{THEME}/js/owl.carousel.min.js"></script>
<!-- Isotope Js -->
<script src="{THEME}/js/isotope.pkgd.min.js"></script>
<!-- Circle Progress Js -->
<script src="{THEME}/js/jquery.circle.progress.min.js"></script>
<!-- Magnific Popup Js -->
<script src="{THEME}/js/jquery.magnific-popup.min.js"></script>
<!-- Validator Js -->
<script src="{THEME}/js/validator.min.js"></script>
<!-- Smart Resize Js -->
<script src="{THEME}/js/smartresize.min.js"></script>
<!-- Appear Js -->
<script src="{THEME}/js/jquery.appear.min.js"></script>

<script src="{THEME}/js/price-filter.js"></script>

<!-- Theme Custom Js -->
<script src="{THEME}/js/custom.js"></script>
<!-- Color -->
<script src="{THEME}/js/color-panel.js"></script>
<!-- REVOLUTION JS FILES -->
<script src="{THEME}/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
<script src="{THEME}/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
<!-- SLIDER REVOLUTION 5.0 EXTENSIONS  (Load Extensions only on Local File Systems !  The following part can be removed on Server for On Demand Loading) -->
<script src="{THEME}/rs-plugin/js/owl-slider-fadeup/owl-slider-fadeup.js"></script>
<script src="{THEME}/rs-plugin/js/owl-slider-fadeup/rbtools.min.js"></script>
<script src="{THEME}/rs-plugin/js/owl-slider-fadeup/rs6.min.js"></script>
<!-- Google Map Js -->
<script async="" defer="" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBtkY02zM_XV3XtSzJbNwJdiA2iuNmP_bI"></script>
</body>
<!-- Body End -->
</html>
