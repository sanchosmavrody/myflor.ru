<!-- Top Bar -->
{include file="modules/header.tpl"}


<style>
    #mainLand > .section-title h2 {
        margin: 30px 0 12px;
    }

    .thumb-wrap {
        position: relative;
        padding-bottom: 56.25%; /* задаёт высоту контейнера для 16:9 (если 4:3 — поставьте 75%) */
        height: 0;
        overflow: hidden;
    }

    .thumb-wrap iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-width: 0;
        outline-width: 0;
    }

</style>


<section id="main-slider" class="carousel">
    <div class="slider carousel">
        <div id="carousel-example-generic1" class="carousel slide carousel-fade" data-ride="carousel">
            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                <div id="item1" class="item active">
                    <img src="/uploads/fotos/slider_2.jpg" alt="" title="" width="2000" height="1080"/>
                    <div class="carousel-caption text-left ">
                        <h1 style="text-shadow: 1px 2px 2px #000;}"
                            class="upper animation animated-item-1 no-text-shadow">
                            <span class="text-color">Ремонт турбин в Москве от 2500 руб.</span>
                        </h1>
                        <br>
                        <p class="description animation animated-item-2 no-text-shadow">
                            Наш завод специализируется на ремонте турбин всех видов техники.<br>
                            Современное оборудование, прямые поставки запчастей и турбин от производителей.<br>
                            Многие автосервисы привозят турбины своих клиентов именно к нам, так как доверяют качеству
                            нашего ремонта.
                            <br/>Гарантия на год, без учета пробега!</p>

                        <script data-b24-form="click/14/7y76vz" data-skip-moving="true">
                            (function (w, d, u) {
                                var s = d.createElement('script');
                                s.async = true;
                                s.src = u + '?' + (Date.now() / 180000 | 0);
                                var h = d.getElementsByTagName('script')[0];
                                h.parentNode.insertBefore(s, h);
                            })(window, document, 'https://cdn-ru.bitrix24.ru/b9731463/crm/form/loader_14.js');
                        </script>
                        <a class="tp-caption lfb btn btn-default hidden-xs b24-web-form-popup-btn-14"
                           data-x="502" data-y="432" data-speed="1000" data-start="1700"
                           data-easing="Power4.easeOut" data-endspeed="500" data-endeasing="Power1.easeIn">
                            Получить консультацию
                        </a>

                    </div>
                </div>

            </div>
            <!-- Controls -->
            <a class="left carousel-control" href="#carousel-example-generic1" role="button" data-slide="prev">
                <span class="fa fa-angle-left fa-2x" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic1" role="button" data-slide="next">
                <span class="fa fa-angle-right fa-2x" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a></div>
    </div>
    <style>

        #item1 {
            background-color: #000;
        }

        #item1 > img {
            opacity: 0.78;
        }

        #item2 > img {
            opacity: 0.5;
        }

        #item3 > img {
            opacity: 0.6;
        }
    </style>
</section>


<!-- page-header -->
<section class="page-section">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-9 pull-right product-page" id="mainLand">


                {include file="modules/content_main_block_1.tpl"}

                {include file="modules/content_main_block_3.tpl"}
                {include file="modules/content_main_block_4.tpl"}
                {include file="modules/content_main_block_5.tpl"}
                {include file="modules/content_main_block_6.tpl"}
                {include file="modules/content_main_block_7.tpl"}
                {include file="modules/content_main_block_8.tpl"}
                {include file="modules/content_main_block_slider.tpl"}
                {include file="modules/content_main_block_10.tpl"}
                {include file="modules/content_main_block_11.tpl"}
                {include file="modules/content_main_block_12.tpl"}
                {include file="modules/content_main_block_13.tpl"}
                {include file="modules/content_main_block_14.tpl"}
                {include file="modules/content_main_block_15.tpl"}


            </div>
            <div id="sidebarCars" style="float: left" class="sidebar col-sm-12 col-md-3">

                <div class="widget">
                    <div class="widget-title" style="border-bottom: 2px solid #faac3d;">
                        <h3 class="title" style="font-size: 28px;">Марка и модель авто</h3>
                    </div>
                    <div id="MainMenu2">
                        <div class="list-group panel">
                            <div class="collapse in" id="demo3">


                                {include file="/engine/modules/center/autoTree.php"}


                            </div>
                        </div>
                    </div>
                    <style>
                        .list-group-item span {
                            width: 100%;
                            display: inline-block;
                        }

                        .list-group-item {
                            line-height: 1;
                        }
                    </style>
                    <!-- category-list -->
                </div>

            </div>
        </div>

    </div>
</section>

<!-- request -->
{include file="modules/footer.tpl"}

<!-- page -->
<!-- Scripts -->
<script type="text/javascript" src="/js/jquery.min.js"></script>
<script type="text/javascript" src="/js/bootstrap.min.js"></script>
<!-- Menu jQuery plugin -->

<script type="text/javascript" src="/js/hover-dropdown-menu.js"></script>
<!-- Menu jQuery Bootstrap Addon -->
<script type="text/javascript" src="/js/jquery.hover-dropdown-menu-addon.js"></script>
<!-- Scroll Top Menu -->

<script type="text/javascript" src="/js/jquery.easing.1.3.js"></script>
<!-- Sticky Menu -->
<script type="text/javascript" src="/js/jquery.sticky.js"></script>
<!-- Bootstrap Validation -->

<script type="text/javascript" src="/js/bootstrapValidator.min.js"></script>
<!-- Animations -->

<script type="text/javascript" src="/js/jquery.appear.js"></script>
<script type="text/javascript" src="/js/effect.js"></script>
<!-- Owl Carousel Slider -->

<script type="text/javascript" src="/js/owl.carousel.min.js"></script>
<!-- Price Filter -->

<script type="text/javascript" src="/js/price-filter.js"></script>
<!-- Pretty Photo Popup -->

<script type="text/javascript" src="/js/jquery.prettyPhoto.js"></script>
<!-- Parallax BG -->

<script type="text/javascript" src="/js/jquery.parallax-1.1.3.js"></script>
<!-- Fun Factor / Counter -->

<script type="text/javascript" src="/js/jquery.countTo.js"></script>
<!-- Custom Js Code -->

<script type="text/javascript" src="/js/jquery.mb.YTPlayer.js"></script>
<!-- Ticker Slider -->

<script type="text/javascript" src="/js/jquery.easy-ticker.min.js"></script>

<script type="text/javascript" src="/js/custom.js"></script>
<!-- Scripts -->