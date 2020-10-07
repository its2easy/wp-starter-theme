<!-- Callback Modal -->
<div class="modal fade modal-callback simple-modal" id="modal-callback" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h3 class="modal-title simple-modal__title">Заказать обратный звонок</h3>
                <button type="button" class="close simple-modal__close" data-dismiss="modal" aria-label="Close">
	                <?php get_inline_svg('close'); ?>
                </button>

                <form action="" class="simple-modal__form js__simple-form">
                    <div class="form-group">
                        <label>Имя:</label>
                        <input type="text" class="form-control" placeholder="Ваше имя" name="name"
                               required minlength="3" maxlength="30" >
                    </div>
                    <div class="form-group">
                        <label>Телефон:</label>
                        <input type="text" class="form-control" placeholder="Ваш телефон" name="phone"
                               required>
                    </div>
                    <div class="simple-modal__btn-block">
                        <button class="button-primary simple-modal__submit js__submit" type="submit">
                            <span>Отправить</span>
                        </button>
                    </div>
                    <div class="js__form-messages"></div>
                    <div class="simple-modal__note">Нажимая на кнопку “Отправить”, Вы соглашаетесь
                        на обработку персональных данных</div>
                    <?php the_form_common_info(); ?>
                    <input type="hidden" name="type" value="Форма обратного звонка">
                </form>


            </div><!-- /.modal-body -->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
