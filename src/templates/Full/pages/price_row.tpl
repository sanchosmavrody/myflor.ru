<tr class="price_row">
    <td class="text-muted td_code" scope="row">{code}</td>
    <td>
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

    </td>
    <td class="text-muted td_name" scope="row">{name}</td>
    <td class="text-muted td_amount" scope="row">{amount}</td>
    <td class="text-muted td_availability" scope="row">{availability}</td>
    <td class="text-muted td_price_1" scope="row">{price} &#8381;</td>
</tr>
