<?php
global $now_city;

$city_alt = '';
if ($now_city['alt_name'] != 'moskva')
    $city_alt = '/city-' . $now_city['alt_name'];

$rows_html = [];
$rows = $db->super_query("SELECT * FROM store_price LIMIT 15", true);
foreach ($rows as $row) {
    $rows_html[] = <<<HTML
<tr>
    <th class="text-muted" scope="row">{$row['code']}</th>
    <th>
        <a href="/uploads/uploads/fotos/bouquet-142876_640.jpg" data-bs-toggle="modal" data-bs-target="#imageModal" class="image-preview">
            <img src="/uploads/uploads/fotos/bouquet-142876_640.jpg" alt="Превью" style="width: 50px; height: auto; border: 1px solid #ccc; border-radius: 4px;">
        </a>
        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content"> 
                    <div class="modal-header">
                        <h5 class="modal-title" id="imageModalLabel">Просмотр изображения</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="" alt="Увеличенное изображение" id="modalImage" style="width: 100%; height: auto;">
                    </div>
                </div>
            </div>

        </div>
        <style>
            .modal-backdrop {
                z-index: 9999;
            }
            .modal.fade.show {
                z-index: 99999;
            }
        </style>

        <script>
            document.querySelectorAll('.image-preview').forEach(anchor => {
                anchor.addEventListener('click', function (event) {
                    event.preventDefault(); 
                    const imageSrc = this.getAttribute('href');
                    document.getElementById('modalImage').setAttribute('src', imageSrc);
                });
            });
        </script>

    </th>
    <th class="text-muted" scope="row">{$row['name']}</th>
    <th class="text-muted" scope="row">{$row['amount']}</th>
    <th class="text-muted" scope="row">{$row['availability']}</th>
    <th class="text-muted" scope="row">{$row['price']} &#8381;</th>
  
</tr>
HTML;

}

$rows_html = implode('', $rows_html);
echo <<<HTML
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">Артикул</th>
                <th scope="col" style="text-align: center">Фото</th>
                <th scope="col">Название цветка</th>
                <th scope="col">Остаток</th>
                <th scope="col">Наличие</th>
                <th scope="col">Цена</th>
            </tr>
        </thead>
        <tbody>
            {$rows_html}
        </tbody>
    </table>
</div>
<div class="offset-md-2 col-md-8">
    <div class="title-wrap text-center">
        <div class="section-title margin-bottom-40">
            <a class="btn btn-border ms-3 bg-dark typo-white" href="{$city_alt}/katalog/">
                Запросить оптовые цены
            </a>
        </div>
    </div>
</div>
HTML;

