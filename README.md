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

### Accessibility

* The module renders a "Skip navigation" link before the list, just like the core navigation module. It is visually hidden until it receives keyboard focus, so your theme should style `a.invisible:focus-visible`.
* Use the field *ARIA label* to name the navigation landmark (e.g. "Main navigation"), especially if the page contains more than one `<nav>`.
* After a jump, the target article receives the focus (`tabindex="-1"` is added if necessary), so keyboard and screen reader users continue reading there.
* The active item gets `aria-current="location"` in addition to the `active` class.
* Smooth scrolling is disabled when the visitor prefers reduced motion.
