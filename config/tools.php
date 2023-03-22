<?php

// use spicyweb\oddsandends\fields\Ancestors;
// use spicyweb\oddsandends\fields\AuthorInstructions;
// use spicyweb\oddsandends\fields\CategoriesMultipleGroups;
// use spicyweb\oddsandends\fields\CategoriesSearch;
// use spicyweb\oddsandends\fields\DisabledCategories;
// use spicyweb\oddsandends\fields\DisabledDropdown;
// use spicyweb\oddsandends\fields\DisabledEntries;
// use spicyweb\oddsandends\fields\DisabledLightswitch;
// use spicyweb\oddsandends\fields\DisabledNumber;
// use spicyweb\oddsandends\fields\DisabledPlainText;
// use spicyweb\oddsandends\fields\DisabledProducts;
// use spicyweb\oddsandends\fields\DisabledVariants;
// use spicyweb\oddsandends\fields\EntriesSearch;
// use spicyweb\oddsandends\fields\Grid;
// use spicyweb\oddsandends\fields\ProductsSearch;
// use spicyweb\oddsandends\fields\VariantsSearch;
// use spicyweb\oddsandends\fields\Width;
// use spicyweb\oddsandends\widgets\RollYourOwn;

/*
 * This is an example of project specific configuration for Odds & Ends.
 * You can disable any of the Odds & Ends fields and widgets by adding them below if you don't use them.
 * Copy this file to your project's config directory and uncomment the fields and widgets you want to disable.
 * Remember to also uncomment the corresponding use statements above.
 *
 * Multi environment config is possible, see:
 * https://craftcms.com/docs/4.x/extend/plugin-settings.html#overriding-setting-values
 * */
return [
    'disableNormalFields' => [
        // Ancestors::class,
        // AuthorInstructions::class,
        // CategoriesMultipleGroups::class,
        // CategoriesSearch::class,
        // DisabledCategories::class,
        // DisabledDropdown::class,
        // DisabledEntries::class,
        // DisabledLightswitch::class,
        // DisabledNumber::class,
        // DisabledPlainText::class,
        // EntriesSearch::class,
        // Grid::class,
        // Width::class,
    ],
    'disableCommerceFields' => [
        // DisabledProducts::class,
        // DisabledVariants::class,
        // ProductsSearch::class,
        // VariantsSearch::class,
    ],
    'disableWidgets' => [
        // RollYourOwn::class,
    ],
];