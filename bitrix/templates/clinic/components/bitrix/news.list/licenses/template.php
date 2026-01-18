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
<section class="licenses">
    <div class="licenses__container">
        <p class="licenses__title">Лицензии</p>

        <div class="licenses__grid">
            <?php foreach ($arResult['ITEMS'] as $arItem): ?>
                <?php
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
                <div class="license-card" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
                    <div class="license-card__image">
                        <img src="<?= $arItem['PREVIEW_PICTURE']['SRC']; ?>" alt="<?= $arItem['PREVIEW_PICTURE']['ALT']; ?>">
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="licenses__slider splide">
            <div class="splide__track">
                <div class="splide__list">
                    <?php foreach ($arResult['ITEMS'] as $arItem): ?>
                        <div class="license-card splide__slide">
                            <div class="license-card__image">
                                <img src="<?= $arItem['PREVIEW_PICTURE']['SRC']; ?>" alt="<?= $arItem['PREVIEW_PICTURE']['ALT']; ?>">
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="my-carousel-progress">
                <div class="my-carousel-progress-bar"></div>
            </div>
        </div>
    </div>
</section>
<style>
    .licenses__grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, 273px);
        justify-content: center;
        gap: 24px;
    }
</style>