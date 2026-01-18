<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
<div class="content">
    <div class="cap-in mb-0">
        <div class="container">
            <ul class="bread">
                <li><a href="/">Главная</a></li>
                <li><?=$arResult["NAME"]?></li>
            </ul>

            <h1><?=$arResult["NAME"]?>
                <span><?= $arResult['PROPERTIES']['DOPH']['VALUE'] ?></span>
            </h1>

            <?php if (!empty($arResult["DETAIL_PICTURE"])): ?>
                <div class="img">
                    <img src="<?= $arResult["DETAIL_PICTURE"]["SRC"] ?>"
                         width="<?= $arResult["DETAIL_PICTURE"]["WIDTH"] ?>"
                         height="<?= $arResult["DETAIL_PICTURE"]["HEIGHT"] ?>"
                         alt="<?= $arResult["DETAIL_PICTURE"]["ALT"] ?>"
                         title="<?= $arResult["DETAIL_PICTURE"]["TITLE"] ?>" >
                </div>
            <?php endif; ?>

        </div>
    </div>
    <div class="article section" style="margin-bottom: 0 !important;">
        <?=$arResult["DETAIL_TEXT"]?>
    </div>

</div>