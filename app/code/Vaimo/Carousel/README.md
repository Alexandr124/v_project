# README #

Carousel module for Magento 2, works good together with **vaimo/module-cms**.


## Installation ##

1. Use: `aja project add-module vaimo/module-carousel:semantic.version.number`
2. Run this (in project root): `php bin/magento setup:upgrade`

- - - -

## What does the module do? ##

This module is a carousel/slideshow/banner slider (whatever you wanna call it) that you can use to first create a carousel and then attach carousel items to it. 

By default each item have support for:

 * Three image variations used for different devices (min-width: 320/768/992px)
 * Content theming (light/medium/dark)
 * Content positioning (left/center/right)
 * Heading
 * Text
 * Two buttons
 * And/or attaching widgets (via WYSIWYG editor)

The module uses Owl Carousel 2 jQuery plugin for the slide and swipe functionality: http://owlcarousel2.github.io/OwlCarousel2/

More information can be found on Confluence: [Vaimo Carousel](https://confluence.vaimo.com/pages/viewpage.action?pageId=28923015)