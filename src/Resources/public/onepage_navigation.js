function Onepage(list, options) {
    options = options || {};
    const articles = options.articles || document.querySelectorAll('.mod_article');
    const pushUrl = options.pushUrl || false;
    const offset = parseInt(options.offset, 10) || 0;

    const offsetArray = Number(offset) - 100 + '% 0% '+  Number(-offset) + '% 0%';
    const el = document.querySelectorAll('a[href*="#"]:not([href="#"]):not([href="#0"])');
    const uri = window.location.href.split("#")[0];

    el.forEach ((anchor) => {
        anchor.addEventListener('click', (event) => {
            // check if on-page links
            if (location.pathname.replace(/^\//, '') == anchor.pathname.replace(/^\//, '') && location.hostname == anchor.hostname) {

                // figure out element to scroll to
                let target = anchor.hash;
                let article = document.getElementById(anchor.hash.slice(1)).offsetTop;

                if (target.length) {
                    // only prevent default if animation is actually gonna happen
                    event.preventDefault();

                    // scroll to selected article
                    scrollTo({
                        top: article,
                        behavior: "smooth"
                    });

                    // change url
                    if (pushUrl) {
                        history.pushState("", "", uri + anchor.hash);
                    }
                };
            }
        });
    });

    // set nav active when scrolling
    const navActive = (article) => {
        let active = list.querySelector('li.active');
        let actualItem = list.querySelector('li[data-onepage-link="'+ article +'"]') ? list.querySelector('li[data-onepage-link="'+ article +'"]') : null;

        // remove existing active status
        if (typeof(active) != 'undefined' && active != null) {
            active.classList.remove('active');
        }

        if (actualItem) {
             // add active status when scrolling down
            actualItem.classList.add('active');
        } else if(active != null) {
            // active status to previous list item when scrolling up AND active article is not in nav
            article = getPreviousSibling(document.querySelector('#'+ article), '.onepage_article');
            actualItem = list.querySelector('li[data-onepage-link="'+ article.id +'"]');
            actualItem.classList.add('active');
        }
    };

    let getPreviousSibling = function (elem, selector) {
        let sibling = elem.previousElementSibling;

        // if no previous element exists with this selector, use current element
        if (!sibling) return elem.nextElementSibling;

        // if selector does not exist, return previous element
        if (!selector) return sibling;

        while (sibling) {
            if (sibling.matches(selector)) return sibling;
            sibling = sibling.previousElementSibling;
        }
    };

    const articleObserver = new IntersectionObserver (function (entries, observer) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                navActive(entry.target.id);
            }
        });
    }, { rootMargin: offsetArray });

    articles.forEach ((article) => {
        articleObserver.observe(article);
    });
};
