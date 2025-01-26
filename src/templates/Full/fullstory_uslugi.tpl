[group=13]
<div class="page-header">
    <div class="container">
        <h1 class="title">{title}</h1>
    </div>
    <div class="breadcrumb-box">
        <div class="container">
            <ul class="breadcrumb">
                {speedbar}
            </ul>
        </div>
    </div>
</div>
[/group]
<style>

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
                            <span class="text-color">[xfvalue_usligi_baner_h1]</span>
                        </h1>
                        <br>
                        <p class="description animation animated-item-2 no-text-shadow">
                            [xfvalue_usligi_baner_des]
                        </p>

                        <br>
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


<section class="page-section">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-9 pull-right product-page" id="mainLand">

                {include file="modules/content_main_block_1.tpl"}

                {include file="modules/content_main_block_2.tpl"}
                {include file="modules/content_main_block_3.tpl"}
                {include file="modules/content_main_block_4.tpl"}
                {include file="modules/content_main_block_5_uslugi.tpl"}
                {include file="modules/content_main_block_6.tpl"}
                {include file="modules/content_main_block_7.tpl"}


                <img src="[xfvalue_image_url_vakansii_bg]" alt="">

                <p>{full-story}</p>

                [group=13]


                <article class="box story[fixed] fixed_story[/fixed] fullstory" itemscope
                         itemtype="http://schema.org/Article">
                    <div class="box_in">
                        [not-group=5]
                        <ul class="story_icons ignore-select">
                            <li class="fav_btn">
                                [add-favorites]
                                <span title="Добавить в закладки"><svg class="icon icon-fav"><use
                                                xlink:href="#icon-fav"></use></svg></span>
                                [/add-favorites]
                                [del-favorites]
                                <span title="Убрать из закладок"><svg class="icon icon-star"><use
                                                xlink:href="#icon-star"></use></svg></span>
                                [/del-favorites]
                            </li>
                            <li class="edit_btn">
                                [edit]<i title="Редактировать">Редактировать</i>[/edit]
                            </li>
                        </ul>
                        [/not-group]
                        <h2 class="title" itemprop="headline">{title}</h2>
                        <div class="text" itemprop="articleBody">
                            {full-story}
                            [edit-date]<p class="editdate grey">Новость отредактировал: <b>{editor}</b> - {edit-date}
                                <br>
                                                                [edit-reason]Причина: {edit-reason}[/edit-reason]</p>
                            [/edit-date]
                        </div>
                        {pages}
                        <div class="story_tools ignore-select">
                            <div class="category">
                                <svg class="icon icon-cat">
                                    <use xlink:href="#icon-cat"></use>
                                </svg>
                                {link-category}
                            </div>
                            [rating]
                            <div class="rate">
                                [rating-type-1]
                                <div class="rate_stars">{rating}</div>
                                [/rating-type-1]
                                [rating-type-2]
                                <div class="rate_like">
                                    [rating-plus]
                                    <svg class="icon icon-love">
                                        <use xlink:href="#icon-love"></use>
                                    </svg>
                                    {rating}
                                    [/rating-plus]
                                </div>
                                [/rating-type-2]
                                [rating-type-3]
                                <div class="rate_like-dislike">
                                    [rating-plus]
                                    <span title="Нравится"><svg class="icon icon-like"><use
                                                    xlink:href="#icon-like"></use></svg></span>
                                    [/rating-plus]
                                    {rating}
                                    [rating-minus]
                                    <span title="Не нравится"><svg class="icon icon-dislike"><use
                                                    xlink:href="#icon-dislike"></use></svg></span>
                                    [/rating-minus]
                                </div>
                                [/rating-type-3]
                                [rating-type-4]
                                <div class="rate_like-dislike">
                                    <span class="ratingtypeplusminus ignore-select ratingplus">{likes}</span>
                                    [rating-plus]
                                    <span title="Нравится"><svg class="icon icon-like"><use
                                                    xlink:href="#icon-like"></use></svg></span>
                                    [/rating-plus]
                                    <span class="ratingtypeplusminus ratingminus ignore-select">{dislikes}</span>
                                    [rating-minus]
                                    <span title="Не нравится"><svg class="icon icon-dislike"><use
                                                    xlink:href="#icon-dislike"></use></svg></span>
                                    [/rating-minus]
                                </div>
                                [/rating-type-4]
                            </div>
                            [/rating]
                        </div>
                        [fixed]
                        <span class="fixed_label" title="Важная новость"></span>
                        [/fixed]
                    </div>
                    <div class="meta ignore-select">
                        <ul class="right">
                            <li class="complaint" title="Жалоба">[complaint]
                                <svg class="icon icon-bad">
                                    <use xlink:href="#icon-bad"></use>
                                </svg>
                                <span class="title_hide">Жалоба</span>
                                                                 [/complaint]
                            </li>
                            <li class="grey" title="Просмотров: {views}">
                                <svg class="icon icon-views">
                                    <use xlink:href="#icon-views"></use>
                                </svg> {views}</li>
                            <li title="Комментариев: {comments-num}">[com-link]
                                <svg class="icon icon-coms">
                                    <use xlink:href="#icon-coms"></use>
                                </svg> {comments-num}[/com-link]
                            </li>
                        </ul>
                        <ul class="left">
                            <li class="story_date">
                                <svg class="icon icon-info">
                                    <use xlink:href="#icon-info"></use>
                                </svg> {author}
                                <span class="grey"> от </span>
                                <time datetime="{date=Y-m-d}" class="grey" itemprop="datePublished">[day-news]{date}
                                                                                                    [/day-news]
                                </time>
                            </li>
                        </ul>
                    </div>
                    <meta itemprop="author" content="{login}">
                </article>
                <div class="rightside ignore-select">
                    {include file="modules/rightside_fullstory.tpl"}
                </div>
                <div class="box next-prev ignore-select">
                    [prev-url]<a href="{prev-url}" class="btn">Предыдущая публикация</a>[/prev-url]
                    [next-url]<a href="{next-url}" class="btn right">Следующая публикация</a>[/next-url]
                </div>
                [banner_header]
                <div class="box banner ignore-select">
                    {banner_header}
                </div>
                [/banner_header]
                <div class="comments ignore-select">
                    <div class="box">
                        [comments]
                        <h4 class="heading">Комментарии
                            <span class="grey hnum">{comments-num}</span>
                        </h4>
                        [/comments]
                        <div class="com_list">
                            {comments}
                        </div>
                    </div>
                    {navigation}
                    {addcomments}
                </div>

                [/group]


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