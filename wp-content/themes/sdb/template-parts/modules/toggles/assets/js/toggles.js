(function () {
    const toggles = document.querySelectorAll('.toggle');
    if (typeof toggles !== 'undefined' && toggles !== null) {
        Toggles(toggles);
    }
})();

/**
 * Default toggle functionality
 *
 * @param {Node} toggles Node list of all toggles
 */
 function Toggles(toggles) {
    function toggleBehavior(e) {
        e.preventDefault();

        const $this = e.target;

        // Control ARIA landmarks on open
        if ($this.getAttribute('aria-expanded') === 'false') {
            $this.setAttribute('aria-expanded', 'true');
            $this.nextElementSibling.setAttribute('aria-hidden', 'false');
        }

        // Control ARIA landmarks on close
        if (
            $this.classList.contains('active') &&
            $this.getAttribute('aria-expanded') === 'true'
        ) {
            $this.setAttribute('aria-expanded', 'false');
            $this.nextElementSibling.setAttribute('aria-hidden', 'true');
        }

        // Check if toggle trigger has multiple children
        let triggerText = $this.querySelector('.toggle__trigger-text');
        if ( triggerText !== null ) {
            const revealedText = triggerText.dataset.show;
            const hiddenText = triggerText.dataset.hide;

            // Only run if data attributes found
            if( typeof revealedText !== 'undefined' && typeof hiddenText !== 'undefined' ) {
    
                // Change value based on if toggle is active
                const toggleText = $this.classList.contains('toggle--active')
                ? triggerText.dataset.show
                : triggerText.dataset.hide;

                // Replace the current text value
                triggerText.textContent = toggleText;
            }
        }

        $this.classList.toggle('toggle--active');

        const toggleBoxDisplay = $this.classList.contains('toggle--active')
            ? 'block'
            : 'none';
        $this.nextElementSibling.style.display = toggleBoxDisplay;
    }

    Array.prototype.slice.call(toggles, 0).forEach(function (e) {
        const toggleBox = e.querySelector('.toggle__box');

        // Check to make sure box is intended to be hidden on load
        if (toggleBox.getAttribute('aria-hidden') !== 'false') {
            toggleBox.style.display = 'none';
        }
        
        e.querySelector('.toggle__trigger').addEventListener(
            'click',
            toggleBehavior
        );
    });
}