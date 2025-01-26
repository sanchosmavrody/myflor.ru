<header>
    <!--Mobile Header-->
    <div class="mobile-header bg-white typo-dark" style="display: none; height: 60px;">
        <div class="mobile-header-inner">
            <div class="sticky-outer" data-height="60" style="height: 60px;">
                <div class="sticky-head">
                    <div class="basic-container clearfix">
                        <ul class="nav mobile-header-items pull-left">
                            <li class="nav-item"><a href="#" class="zmm-toggle img-before"><i class="ti-menu"></i></a></li>
                        </ul>
                        <ul class="nav mobile-header-items pull-center">
                            <div  style="    line-height: 21px; margin-top: 11px; font-size: 13px;">
                                <a href= "tel:+74951799955">+7 (495) 179-99-55</a><br>
                                <a href= "tel:+78003505056">+7 (800) 350-50-56</a>
                            </div>
                        </ul>

                        <ul class="nav mobile-header-items pull-right">
                            <li>
                                <a href="/" class="img-before"><img src="/images/elephant-flowers.jpg" class="img-fluid changeable-dark" width="50" height="35" alt="Logo"></a>
                            </li>
                        </ul>
                    </div>
                    <!-- .basic-container -->
                </div>
                <!-- .sticky-head -->
            </div>
            <!-- .sticky-outer -->
        </div>
        <!-- .mobile-header-inner -->
    </div>
    <!-- .mobile-header -->
    <!--Header-->
    <div class="header-inner header-1" style="display: block;">
        <!--Logobar-->
        <div class="logobar">
            <div class="basic-container clearfix">
                <div class="logobar-inner">
                    <!--Logobar Left Item-->
                    <ul class="nav logobar-items pull-left">
                        <li class="dropdown dropdown-sub pos-static icon-hide-1024">
                            <div  style="line-height: 20px;margin-top: 25px;font-size: 13px; margin-right: 97px;">
                                <a class="text-muted">Город доставки:</a><br>
                                <a>{city_im}</a>&nbsp;<i class="fa-solid fa-location-dot" style="color: #545454;"></i>
                            </div>

                            <ul class="dropdown-menu mega-dropdown-menu basic-container dropdown-col-4 clearfix">
                                {include file="engine/modules/shop/citymenu.php"}
                            </ul>
                        </li>
                        <li class="nav-item">
                            <ul class="nav header-info">
                                <div  style="line-height: 20px;margin-top: 25px;font-size: 13px;">
                                    <a>г. Жуковский, ул. Чкалова 38а</a><br>
                                    <a>График работы: 9:00 - 18:00</a>
                                </div>


                            </ul>


                        </li>

                    </ul>
                    <!--Logobar Center Item-->
                    <ul class="nav logobar-items pull-left center-brand">
                        <li class="nav-item">
                            <a href="{city_alt}/" class="logo-general">
                                <img src="/images/elephant-flowers.jpg" class="img-fluid changeable-dark" width="80" height="35" alt="Logo"></a>
                        </li>
                    </ul>
                    <!--Logobar Right Item-->
                    <ul class="nav logobar-items pull-right">
                        <li class="nav-item">
                            <ul class="nav header-info">
                                <div class="header-address typo-dark">
                                    <span class="ti-email ms-3"></span>
                                    <a href="mailto:elephanflowers@gmail.com">elephanflowers@gmail.com</a>
                                    <span class="ti-headphone-alt ms-3"></span>

                                </div>
                                <div  style="line-height: 20px;margin-top: 25px;font-size: 13px;">
                                    <a href= "tel:+74951799955">+7 (495) 179-99-55</a><br>
                                    <a href= "tel:+78003505056">+7 (800) 350-50-56</a>
                                </div>


                            </ul>


                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--Sticky part-->
       {* <div class="sticky-outer full-dark" style="height: 72px;" data-height="72">
            <div class="sticky-head">
                <!--Navbar-->
                <nav class="navbar">
                    <div class="basic-container clearfix">
                        <div class="navbar-inner">
                            <!--Overlay Menu Switch-->
                            <!-- Menu -->
                            <ul class="nav navbar-items justify-content-between">
                                <!--List Item-->
                                <li class="list-item">
                                    <ul class="active nav navbar-main theme-main-menu">
                                        <li class="dropdown dropdown-sub pos-static icon-hide-1024">
                                             <a>{city_im}</a>
                                            <ul class="dropdown-menu mega-dropdown-menu basic-container dropdown-col-4 clearfix">
                                                {include file="engine/modules/shop/citymenu.php"}
                                            </ul>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{city_alt}/">Главная</a>
                                        </li>
                                        <li class="dropdown dropdown-sub pos-static icon-hide-1024">
                                            <a href="{city_alt}/katalog/">Цветы</a>
                                            <ul class="dropdown-menu mega-dropdown-menu basic-container dropdown-col-4 clearfix">
                                                {include file="engine/modules/shop/catmenu.php?catid=1&big=1"}
                                            </ul>
                                        </li>
                                        <li class="dropdown dropdown-sub pos-static icon-hide-1024">
                                            <a href="{city_alt}/katalog-dekora/">Декор</a>
                                            <ul class="dropdown-menu mega-dropdown-menu basic-container dropdown-col-4 clearfix">
                                                {include file="engine/modules/shop/catmenu.php?catid=441&big=1"}
                                            </ul>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link page-scroll" href="{city_alt}/kontakty.html">Контакты</a>
                                        </li>


                                        <div class="modal fade" id="requestModal" tabindex="-1" aria-labelledby="requestModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <li>
                                                        <a href="/" class="img-before"><img src="/images/elephant-flowers.jpg" class="img-fluid changeable-dark" width="80" height="35" alt="Logo"></a>
                                                    </li>
                                                    <div class="modal-header">

                                                        <h5 class="modal-title" id="requestModalLabel">Форма заявки на доступ в кабинет</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- Форма -->
                                                        <form id="leadForm">
                                                            <div class="mb-3">
                                                                <label for="name" class="form-label">Имя</label>
                                                                <input type="text" class="form-control" id="name" name="name" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="phone" class="form-label">Телефон</label>
                                                                <input type="tel" class="form-control" id="phone" name="phone" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="email" class="form-label">Электронная почта</label>
                                                                <input type="email" class="form-control" id="email" name="email" required>
                                                            </div>
                                                            <div id="message" class="text-success"></div>
                                                            <button type="submit" class="btn btn-primary">Отправить заявку</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <script>
                                            $(document).ready(function() {
                                                $('#leadForm').on('submit', function(e) {
                                                    e.preventDefault();

                                                    var formData = $(this).serialize();
                                                    $.ajax({
                                                        type: 'POST',
                                                        url: '/engine/modules/shop/submit_lead.php',
                                                        data: formData,
                                                        success: function(response) {
                                                            $('#message').html(response);
                                                            $('#leadForm')[0].reset();
                                                        },
                                                        error: function() {
                                                            $('#message').html('Произошла ошибка при отправке данных.');
                                                        }
                                                    });
                                                });
                                            });
                                        </script>

                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#requestModal">
                                        Заявка на доступ в кабинет
                                    </button>
                                </li>
                                <!--List Item-->
                                *}{*<li class="list-item">
                                    {speedbar}
                                </li>*}{*
                                <!--List Item End-->
                                <nav class="navbar navbar-light">
                                    <div class="container-fluid">
                                        <div class="navbar-nav">
                                            <li class="nav-item">
                                                <a class="nav-link" href="{city_alt}/index.php?do=register">Регистрация</a>
                                            </li>
                                            <li class="nav-item">
                                                <span class="navbar-text">|</span>
                                            </li>
                                            <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle" href="#" id="loginDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Вход
                                                </a>
                                                <ul class="dropdown-menu" aria-labelledby="loginDropdown">
                                                    <form class="dropdown-form dot" method="post">

                                                        {login}
                                                    </form>
                                                </ul>
                                            </li>
                                        </div>
                                    </div>
                                </nav>

                                <style>
                                    .navbar-nav {
                                        flex-direction: row;
                                    }
                                    .navbar-nav .nav-link {
                                        color: #666;
                                        font-size: 14px;
                                        margin-right: 10px;
                                        position: relative;
                                    }
                                    .navbar-nav .nav-link:not(:last-child)::after {
                                        content: '|';
                                        position: absolute;
                                        right: -11px;
                                        color: #666;
                                    }
                                    .navbar-nav .nav-link:nth-child(2) {
                                        margin-left: 10px;
                                    }
                                </style>
                            </ul>
                            <!-- Menu -->
                        </div>
                    </div>
                </nav>
            </div>
            <!--sticky-head-->
        </div>*}
        <div class="sticky-outer full-dark" style="height: 72px;" data-height="72">
            <div class="sticky-head">
                <!--Navbar-->
                <nav class="navbar">
                    <div class="basic-container clearfix">
                        <div class="navbar-inner">
                            <!--Overlay Menu Switch-->
                            <!-- Menu -->
                            <ul class="nav navbar-items justify-content-between">
                                <!--List Item-->
                                <li class="list-item">
                                    <ul class="active nav navbar-main theme-main-menu">

                                        <li class="nav-item">
                                            <a href="{city_alt}/">Главная</a>
                                        </li>
                                        <li class="dropdown dropdown-sub pos-static icon-hide-1024">
                                            <a href="{city_alt}/katalog/">Цветы</a>
                                            <ul class="dropdown-menu mega-dropdown-menu basic-container dropdown-col-4 clearfix">
                                                {include file="engine/modules/shop/catmenu.php?catid=1&big=1"}
                                            </ul>
                                        </li>
                                        <li class="dropdown dropdown-sub pos-static icon-hide-1024">
                                            <a href="{city_alt}/katalog-dekora/">Декор</a>
                                            <ul class="dropdown-menu mega-dropdown-menu basic-container dropdown-col-4 clearfix">
                                                {include file="engine/modules/shop/catmenu.php?catid=441&big=1"}
                                            </ul>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link page-scroll" href="{city_alt}/kontakty.html">Контакты</a>
                                        </li>

                                        <!-- Compact Menu -->

                                        <div class="modal fade" id="requestModal" tabindex="-1" aria-labelledby="requestModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <li>
                                                        <a href="/" class="img-before">
                                                            <img src="/images/elephant-flowers.jpg" class="img-fluid changeable-dark" width="80" height="35" alt="Logo">
                                                        </a>
                                                    </li>
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="requestModalLabel">Форма заявки на доступ в кабинет</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- Форма -->
                                                        <form id="leadForm">
                                                            <div class="mb-3">
                                                                <label for="name" class="form-label">Имя</label>
                                                                <input type="text" class="form-control" id="name" name="name" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="phone" class="form-label">Телефон</label>
                                                                <input type="tel" class="form-control" id="phone" name="phone" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="email" class="form-label">Электронная почта</label>
                                                                <input type="email" class="form-control" id="email" name="email" required>
                                                            </div>
                                                            <div id="message" class="text-success"></div>
                                                            <button type="submit" class="btn btn-primary">Отправить заявку</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <script>
                                            $(document).ready(function() {
                                                $('#leadForm').on('submit', function(e) {
                                                    e.preventDefault();

                                                    var formData = $(this).serialize();
                                                    $.ajax({
                                                        type: 'POST',
                                                        url: '/engine/modules/shop/submit_lead.php',
                                                        data: formData,
                                                        success: function(response) {
                                                            if (response.includes("Заявка с таким телефоном уже существует") || response.includes("Заявка с таким email уже существует")) {
                                                                // Показываем ошибку
                                                                $('#message')
                                                                    .html(response)
                                                                    .removeClass('text-success')
                                                                    .addClass('text-danger')
                                                                    .show();
                                                            } else if (response.includes("Заявка принята")) {
                                                                $('#message')
                                                                    .html(response)
                                                                    .removeClass('text-danger')
                                                                    .addClass('text-success')
                                                                    .show();
                                                                $('#leadForm .form-control, #leadForm label, #leadForm button').hide();
                                                            }
                                                        },
                                                        error: function() {
                                                            $('#message')
                                                                .html('Произошла ошибка при отправке данных.')
                                                                .addClass('text-danger')
                                                                .show();
                                                        }
                                                    });
                                                });
                                            });
                                        </script>
                                    </ul>
                                </li>
                                {*<li class="nav-item">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#requestModal">
                                        Заявка на доступ в кабинет
                                    </button>
                                </li>*}

                                <li class=" navbar-expand-lg ">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#requestModal">
                                        Заявка на доступ в кабинет
                                    </button>
                                    <a>
                                        {login}
                                    </a> 

                                </li>

                            </ul>
                            <!-- Menu -->
                        </div>
                    </div>
                </nav>
            </div>
            <!--sticky-head-->
        </div>

        <!--sticky-outer-->
    </div>
</header>
