(function () {
    MandrCookies();
    MandrHeaderSpacing();

    // blog hover states
    const clickables = document.getElementsByClassName('news-item__link-wrapper');
    const linkAddClass = function() {
        console.log(this);
        this.parentNode.classList.add('hovered');
    }
    const linkRemoveClass = function() {
        console.log(this);
        this.parentNode.classList.remove('hovered');
    }
    Array.from(clickables).forEach(function(clickable){
        clickable.addEventListener('mouseenter', linkAddClass);
        clickable.addEventListener('mouseleave', linkRemoveClass);
    });

    // registered trademark symbol wrapper
    function replacer(node, parent) { 
        var r = /®/g;
        var result = r.exec(node.nodeValue);
        if(!result) { return; }
        
        var newNode = this.createElement('span');
        
        newNode.innerHTML = node
          .nodeValue
          .replace(r, '<span class="registered-trademark">$&</span>')
        ;
        
        parent.replaceChild(newNode, node);
    }
      
    document.addEventListener('DOMContentLoaded', () => {
        function textNodesIterator(e, cb) {
          if (e.childNodes.length) {
            return Array
              .prototype
              .forEach
              .call(e.childNodes, i => textNodesIterator(i, cb))
            ;
          } 
      
          if (e.nodeType == Node.TEXT_NODE && e.nodeValue) {
            cb.call(document, e, e.parentNode);
          }
        }
      
        textNodesIterator(document.body, replacer);
    });
})();

/**
 * Set cookies for website Gravity Forms
 */
function MandrCookies(){
    /**
         * User referrer tracking
         */
     if (!docCookies.hasItem('mrsrc')) {
        if (
            typeof document.referrer === 'undefined' ||
            document.referrer === '' ||
            document.referrer === null
        ) {
            docCookies.setItem('mrsrc', 'direct', 3600, '/');
        } else {
            docCookies.setItem('mrsrc', document.referrer, 432000, '/');
        }
    }

    /* change this to reflect the ID of the hidden form input */
    var myForm = document.getElementById('input_1_6');
    if (myForm) {
        /* change this to reflect the ID of the hidden form input, again */
        document.getElementById('input_1_6').value = docCookies.getItem(
            'mrsrc'
        );
    }
}

/**
 * Handles heading scroll sticky toggle & margin offset
 */
function MandrHeaderSpacing(){

    // header - help give visibility:hidden on scroll down, but only after transition, and then remove on scroll up
    // this class is removed in the scroll functions below
    document
    .getElementById('header')
    .addEventListener('transitionend', function () {
        this.classList.add('transition-done');
    });

    function headerSetMargin(){
        var headerEl = document.getElementById('header');
        var primaryWrap = document.getElementById('primary-wrap');
        var adminBarHeight = ( document.getElementById('wpadminbar') ? document.getElementById('wpadminbar').clientHeight : 0 );

        primaryWrap.style.marginTop = headerEl.clientHeight + 'px';
        document.documentElement.style.setProperty('--header-height', headerEl.clientHeight+'px');
        document.documentElement.style.setProperty('--header-height-with-adminbar', headerEl.clientHeight + adminBarHeight+'px');
    }
    
    window.addEventListener( 'resize', headerSetMargin );
    window.addEventListener( 'load', headerSetMargin );

    var scrollTopVal = $(window).scrollTop();

    function scrollAddClass() {

        // classes used to hide/display the navigation
        // hide when scrolling down, show when scrolling up
        // keep showing when overlay is active (determined in css)
        // throttled so it will wait 33ms between each check
        if ($(window).scrollTop() > 100) {
            var scrollTopNow = $(window).scrollTop();

            if (scrollTopNow > scrollTopVal) {
                // scrolling down
                $(document.body).addClass('scrolling-down');
                $(document.body).removeClass('scrolling-up');
            } else if (scrollTopNow < scrollTopVal) {
                document
                    .getElementById('header')
                    .classList.remove('transition-done');
                // scrolling up
                document
                    .getElementById('header')
                    .classList.remove('transition-done');
                $(document.body).addClass('scrolling-up');
                $(document.body).removeClass('scrolling-down');
            }

            scrollTopVal = scrollTopNow;
        } else {
            $(document.body).addClass('scrolling-up');
            $(document.body).removeClass('scrolling-down');
        }
    }
    $(window).on('scroll', $.throttle(33, scrollAddClass));
}

/**
 * Simple parallax effect for elements w/ .parallax classname
 */
function MandrSimpleParallax(){

    // If items are in viewport, apply parallax effects
    function setupParallaxItem(item){
        var offset = 0.2;
        var scrolled = window.pageYOffset;

        if( isInViewport(item) && leavingViewport(item) ) {
            item.style.top = - (scrolled * offset) + 'px';
        }
    }
    // Initialize parallax 
    function initParallax() {
        var item = document.querySelector('.parallax');

        return (item) ? setupParallaxItem(item) : false;
    }
    window.addEventListener('scroll', initParallax);
      
    /* Helper - Determine if element is in viewport */
    var isInViewport = function(e) {
        var bounding = e.getBoundingClientRect();

        return (
            bounding.top >= 0 &&
            bounding.left >= 0 &&
            bounding.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            bounding.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }

    /* Helper - Determine if element is leaving viewport */
    var leavingViewport = function(e) {
        var scrolled = window.pageYOffset;
        var top = e.getBoundingClientRect().top;

        return(
            scrolled < top + window.innerHeight
        );
    }
}