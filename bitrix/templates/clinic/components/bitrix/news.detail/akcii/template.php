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
<main>
    <nav class="container">
        <nav class="breadcrumb">
            <ul class="breadcrumb__items">
                <li class="breadcrumb__item"><a href="/">Главная</a></li>
                <span class="breadcrumb__item">/</span>
                <li class="breadcrumb__item"><a href="/aktsii">Программы и акции</a></li>
                <span class="breadcrumb__item">/</span>
                <li class="breadcrumb__item"><?=$arResult["NAME"]?></li>
            </ul>
        </nav>
    </nav>
    <section class="doctors container">
        <h1 class="doctors__title"><?=$arResult["NAME"]?>
        </h1>

        <div class="promotion__expiry">Акция действует <?= mb_strtolower(mb_substr($arResult['PROPERTIES']['end_akcii']['VALUE'], 0, 1)) . mb_substr($arResult['PROPERTIES']['end_akcii']['VALUE'], 1) ?></div>
        <div class="blogs__grid">
            <div class="news__content">
                <div class="news__content-img">
                    <img src="<?= $arResult["DETAIL_PICTURE"]["SRC"] ?>"
                         alt="<?= $arResult["DETAIL_PICTURE"]["ALT"] ?>"
                         title="<?= $arResult["DETAIL_PICTURE"]["TITLE"] ?>" >
                </div>
                <div class="news__content-text">
                    <?=$arResult["DETAIL_TEXT"]?>
                </div>
                <?
                $APPLICATION->IncludeFile(
                    SITE_TEMPLATE_PATH . "/include/cocial-banner.php",
                    [],
                    ['MODE' => 'php']
                );
                ?>

            </div>
            <div class="blogs__grid-promotion">
                <div class="promotions__card promotions__card--all">
                    <div class="promotions__card-content">
                        <p class="promotions__card-title">Смотреть все акции нашей <br> клиники</p>
                        <button class="promotions__button" onclick="window.location.href='<?=SITE_DIR?>aktsii/'">
                            <span>Смотреть все</span>
                            <img class="promotions__button-icon" src="<?php echo SITE_TEMPLATE_PATH ?>/img/icon/arrow.right.circle-green.svg" alt="Стрелка">
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="promotions container">
        <div class="promotions__container">
            <p class="promotions__title">Другие акции</p>
            <div class="promotions__cards">
                <div class="promotions__card promotions__card--discount">
                    <div class="promotions__card-bg--percent">
                        <div class="promotions__card-content">
                            <a href="<?= $arResult['DETAIL_PAGE_URL']; ?>" class="promotions__card-title"><?= $arResult['NAME']; ?></a>
                            <p class="promotions__card-description"><?= $arResult['PREVIEW_TEXT']; ?></p>
                            <div class="promotions__arrow-icon">
                                <img src="<?= SITE_TEMPLATE_PATH ?>/img/icon/arrow.down-card.svg" alt="Подробнее">
                            </div>
                        </div>
                        <div class="promotions__card-badge">
                            <span><?= $arResult['PROPERTIES']['end_akcii']['VALUE']; ?></span>
                        </div>
                        <img class="promotions__card-percent" src="<?= $arResult['PREVIEW_PICTURE']['SRC']; ?>" alt="<?= $arResult['PREVIEW_PICTURE']['ALT']; ?>">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
    $APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"licenses", 
	array(
		"IBLOCK_ID" => "3",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_ORDER1" => "DESC",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"COMPONENT_TEMPLATE" => "licenses",
		"IBLOCK_TYPE" => "content",
		"NEWS_COUNT" => "20",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"FILTER_NAME" => "",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"PREVIEW_TRUNCATE_LEN" => "",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"SET_TITLE" => "Y",
		"SET_BROWSER_TITLE" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_META_DESCRIPTION" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "Y",
		"STRICT_SECTION_CHECK" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Новости",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SET_STATUS_404" => "N",
		"SHOW_404" => "N",
		"MESSAGE_404" => ""
	),
	false
);
    ?>


</main>
