(function () {
    const tabs = document.querySelectorAll('.tabs-menu__tabs');
    if (typeof tabs !== 'undefined' && tabs !== null) {
        Tabs(tabs);
    }
})();

/**
 * Default tab functionality
 *
 * @param {Node} tabs Node list of all tabs
 */
 function Tabs(tabs) {
    // Init tab pagination
    TabPagination(tabs);

    // Default tab functionality
    function openTab(el) {
        const current = el.target;
        const grandparent = current.closest('.tabs__wrapper').parentNode;
        const tab_id = current.getAttribute('data-tab');

        const tabLinks = {
            items: grandparent.querySelectorAll('[role="tab"]'),
            attribute: 'data-tab',
            aria: 'aria-selected',
            bool: true,
        };

        const tabPanels = {
            items: grandparent.querySelectorAll('[role="tabpanel"]'),
            attribute: 'id',
            aria: 'aria-hidden',
            bool: false,
        };

        // Handle toggling of active tab link & panels
        return (
            toggleActiveSelection(tab_id, tabLinks),
            toggleActiveSelection(tab_id, tabPanels)
        );

        // get current position, focus, then maintain position so focus doesn't move screen
        // var x = window.scrollX, y = window.scrollY;
        // tabContent.setAttribute("tabindex", -1); //.focus();
        // window.scrollTo(x,y);
    }

    objForEachPolyfill(tabs).forEach(function (el) {
        const buttons = el.querySelectorAll('.tabs-menu__link');

        objForEachPolyfill(buttons).forEach(function (button) {
            button.addEventListener('click', openTab);
        });
    });

    // Helper class - Simple polyfill to fix a stupid IE issue w/ forEach
    function objForEachPolyfill(node) {
        return Array.prototype.slice.call(node, 0);
    }

    // Helper - Pass current tab id & object containing data to handle attribute checking
    function toggleActiveSelection(id, { items, attribute, aria, bool }) {
        objForEachPolyfill(items).forEach(function (item) {
            const itemAttr = item.getAttribute(attribute);

            return itemAttr === id
                ? toggleActiveVisibility(item, bool)
                : toggleActiveVisibility(item, !bool);
        });

        function toggleActiveVisibility(el, selection) {
            return el.setAttribute(aria, selection);
        }
    }

    /**
     * Tab pagination
     */
    function TabPagination(tabs) {
        let scrollCount = 0; // Global iterator

        // Tab pagination toggle
        function paginationToggle(link, parentScroll, parentWidth) {
            let updateAttr =
                parentScroll > parentWidth
                    ? link.setAttribute('aria-hidden', 'false')
                    : link.setAttribute('aria-hidden', 'true');

            return updateAttr;
        }

        // Pagination click handling
        function paginationClick(el) {
            const current = el.target, // Grabs inner span instead of button, hence grabbing the parent
                tabs = current.parentNode.querySelector('.tabs-menu__tabs'),
                tabNav = current.parentNode.querySelector('.tabs-menu__navigation'),
                tabMenu = current.parentNode.querySelector('.tabs-menu__list'),
                tabNavWidth = tabs.clientWidth, // Width integer for the .tabs-menu-navigation inter wrapper
                tabMenuWidth = tabMenu.clientWidth; // Width integer for the .tabs outer wrapper

            /**
             * Toggle pagination button usability
             */
            function toggleButtonUsability() {
                const offset = tabMenuWidth - tabNavWidth;
                const prevButton = document.querySelector(
                    '.tabs-menu__pagination--prev'
                );
                const nextButton = document.querySelector(
                    '.tabs-menu__pagination--next'
                );
                const regex = /\bdisabled\b/g;

                const isPrevButtonDisabled = hasClass(prevButton, 'disabled')
                    ? prevButton.className.replace(regex, '')
                    : prevButton.className;

                const isNextButtonDisabled = hasClass(nextButton, 'disabled')
                    ? nextButton.className.replace(regex, '')
                    : nextButton.className;

                if (scrollCount === offset) {
                    nextButton.className += ' disabled';
                    prevButton.className = isPrevButtonDisabled;
                } else if (scrollCount === 0) {
                    prevButton.className += ' disabled';
                    nextButton.className = isNextButtonDisabled;
                } else {
                    prevButton.className = isPrevButtonDisabled;
                    nextButton.className = isNextButtonDisabled;
                }
            }

            // Scroll pagination logic
            function scrollPagination() {
                let scrollVal = hasClass(current, 'tabs-menu__pagination--next')
                    ? scrollPaginationRight()
                    : scrollPaginationLeft(); // Calculate scroll value

                // Apply transform to middle tab wrapper
                tabNav.style.transform = `translateX( -${scrollVal}px )`;
            }

            // Scroll through next list of tabs
            function scrollPaginationRight() {
                const scrollAmt = Math.round(tabNavWidth / 3);
                const offset = tabMenuWidth - tabNavWidth;

                if (scrollCount + scrollAmt < offset) {
                    scrollCount += scrollAmt;
                } else {
                    scrollCount = offset;
                }

                return scrollCount;
            }

            // Scroll through previous list of tabs
            function scrollPaginationLeft() {
                const scrollAmt = Math.round(tabNavWidth / 3);

                if (scrollCount > 0 && scrollCount - scrollAmt > 0) {
                    scrollCount -= scrollAmt;
                } else {
                    scrollCount = 0;
                }

                return scrollCount;
            }

            scrollPagination();
            toggleButtonUsability();
        }

        // Load pagination
        function paginationLoad() {
            objForEachPolyfill(tabs).forEach(function (el) {
                const containerWidth = el.clientWidth;
                const menuWidth = el.querySelector('.tabs-menu__list').clientWidth;
                const paginationLinks = el.parentNode.querySelectorAll(
                    '.tabs-menu__pagination'
                );

                objForEachPolyfill(paginationLinks).forEach(function (link) {
                    paginationToggle(link, menuWidth, containerWidth);
                    link.addEventListener('click', paginationClick);
                });
            });
        }

        window.addEventListener('load', paginationLoad);
        window.addEventListener('resize', paginationLoad);

        // Helper class - Avoid using Node.classlist since Babel doesn't polyfill classlist
        function hasClass(element, className) {
            return (
                (' ' + element.className + ' ').indexOf(' ' + className + ' ') > -1
            );
        }
    }
}