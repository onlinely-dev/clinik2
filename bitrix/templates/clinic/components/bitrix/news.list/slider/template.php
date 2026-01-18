<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<section class="hero">
    <div class="hero__container">
        <div class="hero__content">
            <div class="hero__text">
                <div class="hero__slides-container">
                    <?php foreach ($arResult['ITEMS'] as $index => $arItem): ?>

                        <?php /* код, который позволяет редактировать и удалять статьи */
                        $this->AddEditAction(
                            $arItem['ID'],
                            $arItem['EDIT_LINK'],
                            CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT")
                        );
                        $this->AddDeleteAction(
                            $arItem['ID'],
                            $arItem['DELETE_LINK'],
                            CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"),
                            array(
                                "CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')
                            )
                        );
                        ?>

                        <div class="hero__slide <?= $index === 0 ? 'hero__slide--active' : '' ?>"
                             data-slide="<?= $index ?>"
                             id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
                            <p class="hero__title"><?= $arItem['NAME']; ?></p>
                            <p class="hero__subtitle"><?= $arItem['PREVIEW_TEXT']; ?></p>
                        </div>

                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Блок с кнопками вынесен из hero__text -->
            <div class="hero__buttons">
                <button class="hero__button">Записаться на приём</button>

                <div class="hero__carousel">
                    <button class="hero__carousel-arrow hero__carousel-arrow--left">
                        <img src="<?php echo SITE_TEMPLATE_PATH ?>/img/icon/arrow.left-card.svg" alt="Предыдущий слайд">
                    </button>
                    <div class="hero__carousel-dots">
                        <?php foreach ($arResult['ITEMS'] as $index => $arItem): ?>
                            <button class="hero__carousel-dot <?= $index === 0 ? 'hero__carousel-dot--active' : '' ?>"
                                    data-slide="<?= $index ?>"></button>
                        <?php endforeach; ?>
                    </div>
                    <button class="hero__carousel-arrow hero__carousel-arrow--right">
                        <img src="<?php echo SITE_TEMPLATE_PATH ?>/img/icon/arrow.right-card.svg" alt="Следующий слайд">
                    </button>
                </div>
            </div>

            <?php foreach ($arResult['ITEMS'] as $index => $arItem): ?>
                <img src="<?= $arItem['PREVIEW_PICTURE']['SRC']; ?>"
                     alt="<?= $arItem['PREVIEW_PICTURE']['ALT']; ?>"
                     class="hero__slide-img <?= $index === 0 ? 'hero__slide-img--active' : '' ?>"
                     data-slide="<?= $index ?>">
            <?php endforeach; ?>

        </div>
    </div>
</section>