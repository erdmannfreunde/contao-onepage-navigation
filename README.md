# Onepage Navigation

## Function

This extension for Contao Open Source CMS allows you to create a article navigation that can be used to build onepage navigations. It can be used just like a normal navigation but scrolls smoothly between the links within a page automatically rather than redirecting to another page.

## Usage

* Each article has a new area where the onepage navigation settings can be edited
* Each article can be activated to be a navigation item
* a new frontend module needs to be created (type: '*Article navigation (Onepage)*')
* place the module on the page (layout or as content element)
* activate jQuery in your layout

### InsertTags

* {{scroll::[article-id]::[myCustomLinkTitle]}}
  * [article-id] = article id this link should scroll to
  * [myCustomLinkTitle] = text to be displayed as the link
  * Example: `{{scroll::contact::Email us}}`

## Acknowledgement

This extension is inspired and based on [onepage-navigation](https://github.com/Sascha-Brandhoff/onepage-navigation) by Sascha Brandhoff. It's been adapted and rewritten for Contao 4.x as a symfony bundle.