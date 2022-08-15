# Onepage Navigation

## Function

This extension for Contao Open Source CMS allows you to create a article navigation that can be used to build onepage navigations. It can be used just like a normal navigation but scrolls smoothly between the links within a page automatically rather than redirecting to another page.

## Usage

* Each article has a new area where the onepage navigation settings can be edited
* Each article can be activated to be a navigation item
* a new frontend module needs to be created (type: '*Article navigation (Onepage)*')
* place the module on the page (layout or as content element)
* activate `js_onepage_navigation.html5` in your site layout

### InsertTags

* {{scroll::[article-id]::[myCustomLinkTitle]}}
  * [article-id] = article id this link should scroll to
  * [myCustomLinkTitle] = text to be displayed as the link
  * Example: `{{scroll::contact::Email us}}`
