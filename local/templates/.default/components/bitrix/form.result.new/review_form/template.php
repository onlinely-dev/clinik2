<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>

<div class="direction-form">
    <p class="direction-form__title">Записаться на прием</p>

    <?php if ($arResult["isFormErrors"] == "Y"): ?>
        <div style="color: red; margin-bottom: 15px;">
            <?= $arResult["FORM_ERRORS_TEXT"] ?>
        </div>
    <?php endif; ?>

    <?php if ($arResult["isFormNote"] == "Y"): ?>
        <div style="color: green; margin-bottom: 15px;">
            <?= $arResult["FORM_NOTE"] ?>
        </div>
    <?php endif; ?>

    <?= $arResult["FORM_HEADER"] ?>

    <div class="direction-form__content">
        <?php foreach ($arResult["QUESTIONS"] as $FIELD_SID => $question): ?>

            <?php if ($FIELD_SID == 'NAME'): ?>
                <!-- Поле Имя - стандартное поле Битрикс с нашим классом -->
                <div class="direction-form__field">
                    <label class="direction-form__label">Имя</label>
                    <?php
                    // Заменяем классы у стандартного поля
                    $htmlCode = str_replace(
                        'class="inputtext"',
                        'class="direction-form__input" placeholder="Введите текст"',
                        $question["HTML_CODE"]
                    );
                    echo $htmlCode;
                    ?>
                </div>

            <?php elseif ($FIELD_SID == 'PHONE'): ?>
                <!-- Поле Телефон - стандартное поле Битрикс с нашим классом -->
                <div class="direction-form__field">
                    <label class="direction-form__label">Телефон</label>
                    <?php
                    // Заменяем классы у стандартного поля
                    $htmlCode = str_replace(
                        'class="inputtext"',
                        'class="direction-form__input" placeholder="+7 (_ _ _)- _ _ _-_ _-_ _"',
                        $question["HTML_CODE"]
                    );
                    echo $htmlCode;
                    ?>
                </div>

            <?php elseif ($FIELD_SID == 'AGREEMENT'): ?>
                <!-- Чекбокс согласия - стандартный чекбокс Битрикс, но стилизованный -->
                <div class="direction-form__checkbox">
                    <?php
                    // Получаем HTML код чекбокса
                    $checkboxHtml = $question["HTML_CODE"];

                    // Извлекаем ID из чекбокса для связи с label
                    preg_match('/id="([^"]+)"/', $checkboxHtml, $matches);
                    $checkboxId = $matches[1] ?? 'consent_default';
                    ?>

                    <!-- Скрываем стандартный чекбокс -->
                    <div style="display: none;">
                        <?= $checkboxHtml ?>
                    </div>

                    <!-- Наш кастомный чекбокс, который управляет скрытым -->
                    <input type="checkbox"
                           id="custom_<?= $checkboxId ?>"
                           class="direction-form__checkbox-input"
                           onchange="document.getElementById('<?= $checkboxId ?>').checked = this.checked;">

                    <label for="custom_<?= $checkboxId ?>" class="direction-form__checkbox-label">
                        <span class="direction-form__checkbox-custom"></span>
                        <span> Ознакомился и соглашаюсь с <br>
                            <a href="/policy/" class="direction-form__link">
                                Политикой обработки персональных данных
                            </a>
                        </span>
                    </label>
                </div>
            <?php endif; ?>

        <?php endforeach; ?>

        <!-- Стандартная кнопка отправки, но стилизованная -->
        <input type="submit"
               name="web_form_submit"
               value="Отправить заявку"
               class="direction-form__submit"
               style="display: none;"
               id="main_submit">

        <button type="button"
                class="direction-form__submit"
                onclick="document.getElementById('main_submit').click()">
            Отправить заявку
        </button>
    </div>

    <?= $arResult["FORM_FOOTER"] ?>
</div>