<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arParams
 * @var array $arResult
 */

// Отладочная информация
// echo '<pre>'; print_r($arResult); echo '</pre>';

// Проверяем, есть ли сообщение об успешной отправке
$isSuccess = ($arResult["isFormNote"] == "Y");
$hasErrors = ($arResult["isFormErrors"] == "Y");
?>

<div class="review-form-wrapper">
    <?php if ($isSuccess): ?>
        <!-- Сообщение об успешной отправке -->
        <div class="review-form-success">
            <h3>Спасибо!</h3>
            <p>Ваша заявка успешно отправлена.</p>
            <?php if (!empty($arResult["RESULT_ID"])): ?>
                <p>Номер заявки: <?= $arResult["RESULT_ID"] ?></p>
            <?php endif; ?>
            <?php if (!empty($arResult["FORM_NOTE"])): ?>
                <p><?= $arResult["FORM_NOTE"] ?></p>
            <?php endif; ?>
        </div>
    <?php else: ?>

        <?php if ($hasErrors): ?>
            <div class="review-form-errors">
                <strong>Ошибки при заполнении формы:</strong><br>
                <?= $arResult["FORM_ERRORS"] ?>
            </div>
        <?php endif; ?>

        <?php
        // Важно: выводим FORM_HEADER перед формой
        echo $arResult["FORM_HEADER"];
        ?>

        <form class="review-form__content"
              name="<?= $arResult["FORM_NAME"] ?>"
              method="POST"
              enctype="multipart/form-data"
              onsubmit="return validateForm(this)">

            <?= bitrix_sessid_post() ?>

            <!-- Скрытое поле с ID формы (ОЧЕНЬ ВАЖНО!) -->
            <input type="hidden" name="WEB_FORM_ID" value="<?= $arResult["WEB_FORM_ID"] ?>">

            <!-- Выводим скрытые поля формы -->
            <?php if (!empty($arResult["HIDDEN"])): ?>
                <?php foreach ($arResult["HIDDEN"] as $hiddenField): ?>
                    <?= $hiddenField ?>
                <?php endforeach; ?>
            <?php endif; ?>

            <!-- Поле: Ваше имя -->
            <div class="review-form__field">
                <label class="review-form__label">Ваше имя<span>*</span></label>
                <?php
                // Ищем поле NAME в вопросах
                $nameFieldId = null;
                if (!empty($arResult['QUESTIONS'])) {
                    foreach ($arResult['QUESTIONS'] as $sid => $question) {
                        if (in_array(strtoupper($sid), ['NAME', 'FIO', 'FULL_NAME'])) {
                            $nameFieldId = $question['STRUCTURE'][0]['ID'] ?? null;
                            break;
                        }
                    }
                }

                // Если не нашли в QUESTIONS, ищем в arQuestions
                if (!$nameFieldId && !empty($arResult['arQuestions'])) {
                    foreach ($arResult['arQuestions'] as $sid => $question) {
                        if (in_array(strtoupper($sid), ['NAME', 'FIO', 'FULL_NAME'])) {
                            $nameFieldId = $question['ID'] ?? null;
                            break;
                        }
                    }
                }
                ?>
                <input type="text"
                       class="review-form__input"
                       name="form_text_<?= $nameFieldId ?: '' ?>"
                       placeholder="Введите ваше имя"
                       required
                       value="<?= htmlspecialcharsbx($_POST['form_text_' . $nameFieldId] ?? '') ?>">
            </div>

            <!-- Поле: Телефон -->
            <div class="review-form__field">
                <label class="review-form__label">Телефон<span>*</span></label>
                <?php
                $phoneFieldId = null;
                if (!empty($arResult['QUESTIONS'])) {
                    foreach ($arResult['QUESTIONS'] as $sid => $question) {
                        if (in_array(strtoupper($sid), ['PHONE', 'TEL', 'TELEPHONE'])) {
                            $phoneFieldId = $question['STRUCTURE'][0]['ID'] ?? null;
                            break;
                        }
                    }
                }
                ?>
                <input type="tel"
                       class="review-form__input"
                       name="form_text_<?= $phoneFieldId ?: '' ?>"
                       placeholder="+7 (___) ___-__-__"
                       required
                       value="<?= htmlspecialcharsbx($_POST['form_text_' . $phoneFieldId] ?? '') ?>">
            </div>

            <!-- Поле: Email -->
            <div class="review-form__field">
                <label class="review-form__label">Email</label>
                <?php
                $emailFieldId = null;
                if (!empty($arResult['QUESTIONS'])) {
                    foreach ($arResult['QUESTIONS'] as $sid => $question) {
                        if (in_array(strtoupper($sid), ['EMAIL', 'MAIL'])) {
                            $emailFieldId = $question['STRUCTURE'][0]['ID'] ?? null;
                            break;
                        }
                    }
                }
                ?>
                <input type="email"
                       class="review-form__input"
                       name="form_text_<?= $emailFieldId ?: '' ?>"
                       placeholder="inbox@example.com"
                       value="<?= htmlspecialcharsbx($_POST['form_text_' . $emailFieldId] ?? '') ?>">
            </div>

            <!-- Поле: Файл -->
            <div class="review-form__field">
                <label class="review-form__label">Прикрепить файл</label>
                <div class="file-attachment">
                    <?php
                    $fileFieldId = null;
                    if (!empty($arResult['QUESTIONS'])) {
                        foreach ($arResult['QUESTIONS'] as $sid => $question) {
                            if (in_array(strtoupper($sid), ['FILE', 'ATTACHMENT'])) {
                                $fileFieldId = $question['STRUCTURE'][0]['ID'] ?? null;
                                break;
                            }
                        }
                    }
                    ?>
                    <input type="file"
                           class="file-attachment__input"
                           id="fileInput"
                           name="form_file_<?= $fileFieldId ?: '' ?>">
                    <label for="fileInput" class="file-attachment__label">
                        <img src="<?= SITE_TEMPLATE_PATH ?>/img/icon/attach.svg" alt="Прикрепить файл"
                             class="file-attachment__icon">
                        <span class="file-attachment__text">Прикрепить файл</span>
                    </label>
                    <div class="file-attachment__hint">Максимальный размер: 10МБ</div>
                </div>
            </div>

            <!-- Капча -->
            <?php if ($arResult["isUseCaptcha"] == "Y"): ?>
                <div class="review-form__field">
                    <label class="review-form__label">Введите код с картинки<span>*</span></label>
                    <input type="hidden" name="captcha_sid" value="<?= htmlspecialcharsbx($arResult["CAPTCHACode"] ?? $arResult["captcha_sid"] ?? '') ?>">
                    <div style="margin-bottom: 10px;">
                        <img src="/bitrix/tools/captcha.php?captcha_sid=<?= htmlspecialcharsbx($arResult["CAPTCHACode"] ?? $arResult["captcha_sid"] ?? '') ?>"
                             alt="CAPTCHA" style="border: 1px solid #ddd; max-width: 200px;">
                    </div>
                    <input type="text"
                           class="review-form__input"
                           name="captcha_word"
                           required
                           placeholder="Введите код"
                           value="<?= htmlspecialcharsbx($_POST['captcha_word'] ?? '') ?>">
                </div>
            <?php endif; ?>

            <!-- Согласие -->
            <div class="review-form__checkbox">
                <?php
                $consentFieldId = null;
                if (!empty($arResult['QUESTIONS'])) {
                    foreach ($arResult['QUESTIONS'] as $sid => $question) {
                        if (in_array(strtoupper($sid), ['CONSENT', 'AGREEMENT', 'POLICY'])) {
                            $consentFieldId = $question['STRUCTURE'][0]['ID'] ?? null;
                            break;
                        }
                    }
                }
                ?>
                <input class="review-form__checkbox-input"
                       type="checkbox"
                       name="form_checkbox_<?= $consentFieldId ?: '' ?>[]"
                       id="consent"
                       value="Y"
                       required
                    <?= (isset($_POST['form_checkbox_' . $consentFieldId]) && $_POST['form_checkbox_' . $consentFieldId][0] == 'Y') ? 'checked' : '' ?>>
                <label for="consent" class="review-form__checkbox-label">
                    <span class="review-form__checkbox-custom"></span>
                    <span>Ознакомился и соглашаюсь с <a href="<?= $arParams['AGREEMENT_LINK'] ?? '/policy/' ?>"
                                                        class="review-form__link" target="_blank">Политикой обработки персональных данных</a></span>
                </label>
            </div>

            <!-- Кнопка отправки -->
            <button type="submit"
                    name="web_form_submit"
                    value="Y"
                    class="review-form__submit">
                <?= $arResult["arForm"]["BUTTON"] ?? "Отправить заявку" ?>
            </button>

            <!-- Дисклеймер -->
            <div class="review-form__disclaimer">
                *Администрация сайта оставляет за собой право производить предварительную модерацию отзывов и принимать решение по размещению отзывов по своему усмотрению.
            </div>

        </form>

        <?php
        // Важно: выводим FORM_FOOTER после формы
        echo $arResult["FORM_FOOTER"];
        ?>

    <?php endif; ?>
</div>

<script>
    function validateForm(form) {
        // Простая валидация
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.style.borderColor = 'red';
                isValid = false;
            } else {
                field.style.borderColor = '';
            }
        });

        // Проверка согласия
        const consent = form.querySelector('#consent');
        if (consent && !consent.checked) {
            alert('Необходимо согласие с политикой обработки данных');
            return false;
        }

        return isValid;
    }

    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('fileInput');
        const fileLabel = document.querySelector('.file-attachment__label');
        const fileText = document.querySelector('.file-attachment__text');

        if (fileInput && fileText) {
            fileInput.addEventListener('change', function(e) {
                const fileName = e.target.files[0]?.name;
                if (fileName) {
                    fileText.textContent = fileName;
                } else {
                    fileText.textContent = 'Прикрепить файл';
                }
            });
        }
    });
</script>

