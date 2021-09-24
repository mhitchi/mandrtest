Number.isInteger =
    Number.isInteger ||
    function(value) {
        return (
            typeof value === 'number' &&
            isFinite(value) &&
            Math.floor(value) === value
        );
    };
(function($) {
    'use strict';

    if ('object' !== typeof window.MRNav) {
        window.MRNav = {};
    }

    MRNav.init = function(options, callback) {
        /**
         * Options
         */
        var defaults = {
            'nav-id': 'primary-nav',
            'nav-button-id': 'primary-nav-button',
            'menu-wrap-id': 'primary-menu-wrap',
            'menu-id': 'primary-menu',
            'overlay-class': 'navigation-overlay',
        };
        var actual = $.extend({}, defaults, options || {});

        /**
         * Variables
         */
        var $thisSubMenu;
        var $body = $('body');
        var $navWrap = $('#' + actual['nav-id']); // nav wrap
        var $navButton = $('#' + actual['nav-button-id']); // button inside nav wrap, before ul
        var $menuWrap = $('#' + actual['menu-wrap-id']); // wrap outside menu ul
        var $menu = $('#' + actual['menu-id']); // menu ul
        var $overlay = $('.' + actual['overlay-class']);

        var $focusableElements = $menuWrap.find('a, button'); // any button or link
        //var firstFocusable = $focusableElements.first()[0]; // the first focusable element
        var lastFocusable = $focusableElements.last()[0]; // the last focusable elemnt
        //var firstLink = $menuWrap.find('a').first()[0]; // first actual link
        var $subMenu = $menu.find('.sub-menu'); // all sub menu <ul> elements
        var $liWithChildren = $menu.find('.menu-item-has-children'); // support multiple menu depths
        //var $immediateSubMenu = $liWithChildren.children('.sub-menu'); // all tier 1 sub menus
        var $currentMenuItem = $menu.find('.current-menu-item > a');
        var $currentMenuAncestors = $menu.find('.current-menu-ancestor');

        /**
         * Functions
         */

        // function adjustMenuWrapHeight(newHeight) { // OPTIONAL - menu/submenu height adjustments
        //     var currentHeight = $menuWrap.height();
        //     if (
        //         newHeight === 'auto' ||
        //         (Number.isInteger(newHeight) && newHeight > currentHeight)
        //     ) {
        //         $menuWrap.height(newHeight);
        //     }
        // }

        function closeAllSubMenus() {
            // hide all menus
            // $menu.find('.menu-item-has-children > .sub-menu').hide(400); // OPTIONAL - hide()/show() jquery animation on opening of submenu

            // remove open class on any toggle
            $menu
                .find('.menu-item-has-children > .toggle-dropdown')
                .parent('li')
                .removeClass('opened');

            // change aria-expanded on any toggle
            $menu
                .find('.menu-item-has-children > .toggle-dropdown')
                .attr('aria-expanded', 'false');

            // change aria-hidden on submenu
            $subMenu.attr('aria-hidden', 'true');

            //adjustMenuWrapHeight('auto'); // OPTIONAL - menu/submenu height adjustments
        }

        function closeSiblingSubMenus($target) {
            // grab closest submenu
            $thisSubMenu = $target.closest('.sub-menu');

            // Hide
            // $thisSubMenu.find('.sub-menu').hide(400); // OPTIONAL - hide()/show() jquery animation on opening of submenu

            // change aria-hidden on the submenu
            $thisSubMenu.find('.sub-menu').attr('aria-hidden', 'true');

            // change aria-expanded on the toggle
            $thisSubMenu
                .find('.dropdown-toggle')
                .attr('aria-expanded', 'false');

            // remove open class on the toggle
            $thisSubMenu.find('.dropdown-toggle').removeClass('opened');

            //adjustMenuWrapHeight('auto'); // OPTIONAL - menu/submenu height adjustments
        }

        function closeNav() {
            // Hook Off - close on overlay click
            $overlay.off('click.mrnav', closeNav);

            // Hook Off - close the menu if esc is pressed
            $navWrap.off('keydown.mrnav', escLeaveMenu);

            // Hook Off - tabbing from last item takes you to the close button
            $(lastFocusable).off('keydown.mrnav', tabLast);

            // Hook Off - shift-tabbing from toggle item takes you to the last item
            $navButton.off('keydown.mrnav', shiftTabLast);

            // Hook Off - sub menu toggling
            $liWithChildren.off(
                'click.mrnav',
                '.toggle-dropdown',
                toggleSubMenu
            );

            // Hook Off - close submenu and go back to toggle if esc is pressed
            $subMenu.off('keydown.mrnav', escLeaveSub);

            // Adjust body class
            $body.removeClass('nav-active');
            $navWrap.removeClass('is-active');

            // Adjust ARIA
            $navButton.attr('aria-expanded', 'false');
            $menu.attr('aria-hidden', 'true');

            // Close all subs
            closeAllSubMenus();

            // Focus menu button again
            $navButton.focus();
        }

        function openNav() {
            // Hook On - close on overlay click
            $overlay.on('click.mrnav', closeNav);

            // Hook On - close the menu if esc is pressed
            $navWrap.on('keydown.mrnav', escLeaveMenu);

            // Hook On - tabbing from last item takes you to the close button
            $(lastFocusable).on('keydown.mrnav', tabLast);

            // Hook On - shift-tabbing from toggle item takes you to the last item
            $navButton.on('keydown.mrnav', shiftTabLast);

            // Hook On - sub menu toggling
            $liWithChildren.on(
                'click.mrnav',
                '.toggle-dropdown',
                toggleSubMenu
            );

            // Hook On - close submenu and go back to toggle if esc is pressed
            $subMenu.on('keydown.mrnav', escLeaveSub);

            // Add classes
            $body.addClass('nav-active');
            $navWrap.addClass('is-active');

            // Adjust ARIA
            $navButton.attr('aria-expanded', 'true');
            $menu.attr('aria-hidden', 'false');

            // Current Page Shown, and click toggles with waits between clicking each toggle - also see waitClick()
            if ($currentMenuAncestors.length > 0) {
                var $parents = $currentMenuItem.parents('.sub-menu-toggleable');
                $.fn.reverse = [].reverse;
                $parents.reverse();
                $parents.each(function(i, el) {
                    i++;
                    waitClick($(el), 250 + 150 * i);
                });
            }
        }

        function waitClick(item, wait, i) {
            setTimeout(function() {
                item.prev('.toggle-dropdown').trigger('click');
                console.log('clicked' + i);
            }, wait);
        }

        function toggleNav() {
            if ($navWrap.hasClass('is-active')) {
                closeNav();
            } else {
                openNav();
            }
        }

        /**
         * Init
         */

        // Add dropdown links to all mobile list items with a sub-menu
        // menus will need to hide extra buttons with css
        $liWithChildren.each(function() {
            var thisTitle = $(this)
                .find(' > a')
                .text();
            $(this)
                .addClass('dropdown-toggle')
                .find(' > a')
                .after(
                    '<button type="button" class="toggle-dropdown" aria-expanded="false" aria-haspopup="true"><span class="screen-reader-text">' +
                        thisTitle +
                        ' submenu toggle</span></button>'
                );
        });

        // Add aria-hidden to menu and sub-menus
        $menu.attr('aria-hidden', 'true');
        $subMenu.attr('aria-hidden', 'true');

        // Add class for .sub-menu's that are toggleable
        $subMenu.addClass('sub-menu-toggleable');

        /**
         * Hooks
         */

        // Menu opens and closes via CSS via this toggled class, aria toggled after
        $navButton.on('click.mrnav', toggleNav);

        // Close the menu if esc is pressed
        function escLeaveMenu(e) {
            if (e.which === 27) {
                closeNav();
            }
        }

        // tabbing from last item takes you to the close button
        function tabLast(e) {
            if (
                e.which === 9 &&
                !e.shiftKey &&
                $navButton.attr('aria-expanded') === 'true'
            ) {
                e.preventDefault();
                $navButton.focus();
            }
        }

        // shift-tabbing from toggle item takes you to the last item
        function shiftTabLast(e) {
            if (
                e.which === 9 &&
                e.shiftKey &&
                $navButton.attr('aria-expanded') === 'true'
            ) {
                e.preventDefault();
                $(lastFocusable).focus();
            }
        }

        // Close submenu and go back to toggle if esc is pressed
        function escLeaveSub(e) {
            if (e.which === 27) {
                var $this = $(e.currentTarget);
                if ($this.attr('aria-hidden') === 'false') {
                    e.stopPropagation();
                    $this.prev('.toggle-dropdown').trigger('click');
                }
            }
        }

        // Sub menu toggling
        function toggleSubMenu(e) {
            e.preventDefault();
            var $this = $(e.currentTarget);
            var testIfSub = $this.parent('li').parent('.sub-menu');
            var $thisFocusables, thisLastFocusable;

            // if below the first tier of the menu
            if (testIfSub.length > 0) {
                if ($this.parent('li').hasClass('opened')) {
                    // close all sibling menus
                    closeSiblingSubMenus($this);
                } else {
                    // close all sibling menus
                    closeSiblingSubMenus($this);

                    // open this menu
                    // $this.next('.sub-menu').show(400); // OPTIONAL - hide()/show() jquery animation on opening of submenu
                    $this.parent('li').addClass('opened');
                    // apply aria
                    $this
                        .attr('aria-expanded', 'true')
                        .next('.sub-menu')
                        .attr('aria-hidden', 'false');

                    // keep tabbing within the submenu context until user leaves with esc
                    // or hits the submenu button
                    // $thisFocusables = $this.next('.sub-menu').find('a');
                    // thisLastFocusable = $thisFocusables.last()[0];
                    // $this.on('keydown.mrnav', function(e) {
                    //     if (
                    //         e.which === 9 &&
                    //         e.shiftKey &&
                    //         $this.attr('aria-expanded') === 'true'
                    //     ) {
                    //         e.preventDefault();
                    //         $(thisLastFocusable).focus();
                    //     }
                    // });
                    // $(thisLastFocusable).on('keydown.mrnav', function(e) {
                    //     if (
                    //         e.which === 9 &&
                    //         !e.shiftKey &&
                    //         $this.attr('aria-expanded') === 'true'
                    //     ) {
                    //         e.preventDefault();
                    //         $this.focus();
                    //     }
                    // });
                }

                // or if at the top tier of the menu
            } else {
                if ($this.parent('li').hasClass('opened')) {
                    // close all menus
                    closeAllSubMenus();
                } else {
                    // close all menus
                    closeAllSubMenus();

                    // open this menu
                    // $this.next('.sub-menu').show(400); // OPTIONAL - hide()/show() jquery animation on opening of submenu
                    $this.parent('li').addClass('opened');

                    // apply aria
                    $this
                        .attr('aria-expanded', 'true')
                        .next('.sub-menu')
                        .attr('aria-hidden', 'false');

                    // keep tabbing within the submenu context until user leaves with esc
                    // or hits the submenu button
                    // $thisFocusables = $this.next('.sub-menu').find('a');
                    // thisLastFocusable = $thisFocusables.last()[0];
                    // $this.on('keydown.mrnav', function(e) {
                    //     if (
                    //         e.which === 9 &&
                    //         e.shiftKey &&
                    //         $this.attr('aria-expanded') === 'true'
                    //     ) {
                    //         e.preventDefault();
                    //         $(thisLastFocusable).focus();
                    //     }
                    // });
                    // $(thisLastFocusable).on('keydown.mrnav', function(e) {
                    //     if (
                    //         e.which === 9 &&
                    //         !e.shiftKey &&
                    //         $this.attr('aria-expanded') === 'true'
                    //     ) {
                    //         e.preventDefault();
                    //         $this.focus();
                    //     }
                    // });
                }
            }
            // adjustMenuWrapHeight($this.next('.sub-menu').outerHeight()); // OPTIONAL - menu/submenu height adjustments
            return false;
        }

        /**
         * Optional callback processing
         */
        if (typeof callback === 'function') {
            callback.call();
        }
    };
})(jQuery);
jQuery(document).ready(function() {
    MRNav.init({
        'nav-id': 'primary-nav',
        'nav-button-id': 'primary-nav-button',
        'menu-wrap-id': 'primary-menu-wrap',
        'menu-id': 'primary-menu',
        'overlay-class': 'navigation-overlay',
    });
});
