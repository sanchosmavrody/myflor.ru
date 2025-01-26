<div id="shop-section" class="shop-section">
    <div class="container shop">
        <div class="row">
            <div class="sidebar col-sm-12 col-md-3">


                <div class="widget category-widget">
                    <div class="widget-title d-flex">
                        <h3 class="title">По Категориям</h3>
                        <a class="ti-back-right" style="margin-left: auto" title="Назад" onclick="window.history.back()"></a>
                    </div>

                    {include file="engine/modules/shop/catmenu.php?sidebar=1"}

                </div>


                {*<div class="widget tag-cloud">
                    <div class="widget-title">
                        <h3 class="title">Облако тегов</h3>
                    </div>
                    <div class="tagcloud">
                        <a href="#" class="tag-cloud-link">All</a>
                        <a href="#" class="tag-cloud-link">Design</a>
                        <a href="#" class="tag-cloud-link">Development</a>
                        <a href="#" class="tag-cloud-link">Settings</a>
                        <a href="#" class="tag-cloud-link">Branding</a>
                        <a href="#" class="tag-cloud-link">Video</a>
                        <a href="#" class="tag-cloud-link">Photography</a>
                        <a href="#" class="tag-cloud-link">Customize</a>
                    </div>
                </div>*}
            </div>
            <div class="col-md-12 col-lg-9 text-center">
                <div class="row">
                    <h1 class="" style="text-align: left;font-size: 2rem">{category-h1}</h1>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="input-group  input-group-lg"  id="catalog_search_control">
                            <input type="search" class="form-control mb-0" placeholder="Поиск по названию или артикулу"/>
                            <span class="input-group-text" style="cursor: pointer;">
                                <span class="spinner-border text-muted" aria-hidden="true" style="display: none"></span>
                                <i class="ti-search typo-dark"></i>
                            </span>
                        </div>
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered w-100" id="catalog_search" style="display:none;">
                                <thead>
                                <tr>
                                    <th scope="col">Артикул</th>
                                    <th scope="col" style="text-align: center">Фото</th>
                                    <th scope="col">Название цветка</th>
                                    <th scope="col">Остаток</th>
                                    <th scope="col" style="width: 70px;">Наличие</th>
                                    <th scope="col" style="width: 70px;">Цена</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <div id="catalog_page">
                    {navigation}
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered w-100">
                            <thead>
                            <tr>
                                <th scope="col">Артикул</th>
                                <th scope="col" style="text-align: center">Фото</th>
                                <th scope="col">Название цветка</th>
                                <th scope="col">Остаток</th>
                                <th scope="col" style="width: 70px;">Наличие</th>
                                <th scope="col" style="width: 70px;">Цена</th>
                            </tr>
                            </thead>
                            <tbody>
                            {content}
                            </tbody>
                        </table>
                    </div>
                    {navigation}
                </div>

            </div>
            <style>
                @media (max-width: 767px) {
                    .shop .row {
                        display: flex;
                        flex-direction: column-reverse;
                    }
                }

            </style>

        </div>
    </div>
</div>
