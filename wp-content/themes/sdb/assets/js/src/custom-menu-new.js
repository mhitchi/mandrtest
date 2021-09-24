(function(){
    const mobileNavigation = document.getElementById('mobile-navigation');
    const mobileTrigger = document.getElementById('mobile-trigger');
    const mobileSubmenuToggles = document.querySelectorAll('.mobile-menu-primary__toggle, .mobile-sub-menu__toggle');
    const mobileSubmenuTogglesRedux = document.querySelectorAll('.has-submenu > a[href="#"]');
    const navigationOverlay = document.getElementById('navigation-overlay');
    const closeMenuButton = document.getElementById('close-nav-menu');
    const navClasses = mobileNavigation.classList;
    const bodyClasses = document.body.classList;

    const parentMenuClass = '.mobile-menu__panel';
    const subMenuClass = 'ul.mobile-sub-menu';

    // Handle all scroll functionality
    function scrollEffectsHandler() {
        const header = document.getElementById('header');
        let scrollTop = window.pageYOffset;
        let isLoaded = false;

        // On first load, initialize header
        if( isPastHeader() ){
            toggleScrollClass(false);
        }

        function toggleActiveClass(direction){
            if( direction === 'up' ) {
                if( header.classList.contains('header--show') ) return;

                return header.classList.add('header--show'), header.classList.remove('header--hide');
            } else {
                return header.classList.add('header--hide'), header.classList.remove('header--show');
            }
        }

        function determineScrollDirection(scroll){
            let scrollDirection = scroll > scrollTop ? 'down' : 'up';
            return scrollDirection;
        }

        function toggleScrollClass(hasClass){
            let isLoaded;
            
            if( hasClass === true ) {
                if( !header.classList.contains('header--init') ) return;

                header.classList.remove('header--init');
                isLoaded = false;
            } else {
                header.classList.add('header--init');
                isLoaded = true;
            }

            return isLoaded;
        }

        function isPastHeader(){
            return document.documentElement.scrollTop >= header.getBoundingClientRect().height ? true : false;
        }

        function isTop() {
            return document.documentElement.scrollTop === 0 ? true : false;
        }

        function menuScrollVisibility(){
            let scroll = window.pageYOffset || document.documentElement.scrollTop;
            const direction = determineScrollDirection(scroll);

            // Add class to header on first scroll
            if( isLoaded === false ){
                toggleScrollClass(false);
            }

            // Determine if at top of page
            if( isTop() ) {
                toggleScrollClass(true);
            }

            // Determine which class to attach to menu
            if( isPastHeader() ) {
                toggleActiveClass(direction);
            }

            // Update scroll position standard
            return scrollTop = scroll;
        }

        window.addEventListener('scroll', menuScrollVisibility);
    }

    // Toggle navigation classes
    function toggleNavigation(){
        return bodyClasses.contains('nav-active') ? closeNavigation() : openNavigation();
    }
    // Open menu & remove classes
    function openNavigation(){
        return ( navClasses.add('mobile-menu--active'), bodyClasses.add('nav-active') );
    }
    // Close menu & remove classes
    function closeNavigation(){
        return ( navClasses.remove('mobile-menu--active'), bodyClasses.remove('nav-active'), bodyClasses.remove('search-active') );
    }

    // Create the focus menu for the active sub menu
    function createFocusMenu(e){

        // Determine if we're dealing with a submenu or parent menu
        const isSubmenu = e.target.closest(subMenuClass);
        const menu = isSubmenu !== null ? isSubmenu : document.querySelector(parentMenuClass);

        // Grab focusable elements
        const focusableEls = menu.querySelectorAll('a, button');
        const firstFocusableEl = focusableEls[0];
        const lastFocusableEl = focusableEls[focusableEls.length - 1];
        
        // Tab key & active element
        const isTabKey = e.key === 'Tab';
        const isShiftPressed = e.shiftKey;
        const currentFocusedElement = document.activeElement;

        // Determine whether going forward or back in menu focus
        if( isShiftPressed && isTabKey ) {
            if( currentFocusedElement === firstFocusableEl ){
                e.preventDefault();
                lastFocusableEl.focus();
            }
        } else if( isTabKey ) {
            if( currentFocusedElement === lastFocusableEl ){
                e.preventDefault();
                firstFocusableEl.focus();
            }
        }
    }

    // Trap focus inside sub menu
    function trapFocus(menu, focusableEls, activeStatus){
        const initialFocus = focusableEls[0];

        // Set initial focus on first anchor
        initialFocus.focus();

        // If the sub menu has been closed, bring focus back to parent
        if( activeStatus === false ) {
            mobileTrigger.focus();
        }

        // Toggle between adding/removing event listener
        return activeStatus !== false ? menu.addEventListener('keydown', createFocusMenu) : menu.removeEventListener('keydown', createFocusMenu);
    }

    // Open or close parent and/or sub menu panels
    function switchActiveMenuList(e){
        const targetSubmenu = e.target.dataset.open;
        const targetParent = e.target.dataset.close;

        if( typeof targetSubmenu !== 'undefined' ) {
            const associatedMenu = document.getElementById(targetSubmenu);
            const isHidden = associatedMenu.getAttribute('aria-hidden');
            const focusableEls = associatedMenu.querySelectorAll('li > a, li > button');

            trapFocus(associatedMenu, focusableEls, true);
    
            return associatedMenu.setAttribute('aria-hidden', !isHidden);
        } else {            
            const parentMenu = document.getElementById(targetParent);
            const currentActiveMenu = parentMenu.querySelector('[aria-hidden="false"]');
            const focusableEls = parentMenu.querySelectorAll('li > a, li > button');

            trapFocus(currentActiveMenu, focusableEls, false);

            return currentActiveMenu.setAttribute('aria-hidden', 'true');
        }
    }

    function switchActiveMenuListNearby(e){
        console.log(e.target)
        const targetSubmenu = e.target.nextElementSibling.dataset.open;
        const targetParent = e.target.nextElementSibling.dataset.close;

        if( typeof targetSubmenu !== 'undefined' ) {
            const associatedMenu = document.getElementById(targetSubmenu);
            const isHidden = associatedMenu.getAttribute('aria-hidden');
            const focusableEls = associatedMenu.querySelectorAll('li > a, li > button');

            trapFocus(associatedMenu, focusableEls, true);
    
            return associatedMenu.setAttribute('aria-hidden', !isHidden);
        } else {            
            const parentMenu = document.getElementById(targetParent);
            const currentActiveMenu = parentMenu.querySelector('[aria-hidden="false"]');
            const focusableEls = parentMenu.querySelectorAll('li > a, li > button');

            trapFocus(currentActiveMenu, focusableEls, false);

            return currentActiveMenu.setAttribute('aria-hidden', 'true');
        } 
    }

    // Set initial focus when menu loaded
    function setInitialFocus(){
        if( !bodyClasses.contains('nav-active') ) return;
        const primaryNavigation = document.getElementById('mobile-menu-primary');
        const focusableEls = primaryNavigation.querySelectorAll('ul > li > a, ul > li > button');

        // Set overall focus for menu navigation
        trapFocus(primaryNavigation, focusableEls, true);
    }

    Array.prototype.slice.call(mobileSubmenuToggles, 0).forEach( toggle => {
        toggle.addEventListener('click', switchActiveMenuList);
    });

    Array.prototype.slice.call(mobileSubmenuTogglesRedux, 0).forEach( toggle => {
        toggle.addEventListener('click', switchActiveMenuListNearby);
    });

    mobileTrigger.addEventListener('click', toggleNavigation);
    mobileTrigger.addEventListener('click', setInitialFocus);
    navigationOverlay.addEventListener('click', closeNavigation);
    //closeMenuButton.addEventListener('click', closeNavigation);

    window.addEventListener('DOMContentLoaded', scrollEffectsHandler);
})();
