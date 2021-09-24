(function(){
    const teams = document.querySelector('.team-module');
    if ( teams && typeof teams !== 'undefined') {
        teamPopup(teams);
    }
})();

/**
 * Handle team popup modal
 *
 * @param {Node} parent Parent section for services
 */
 function teamPopup(parent){
    const DATA = mandr_team_data;

    function modalInit(){
        const modals = parent.querySelectorAll('.team__member__popup');

        [...modals].forEach( modal => {
            modal.addEventListener('click', modalSelected);
        });
    }

    function modalSelected(e) {
        const selected = e.target;
        const jsonNode = selected.dataset.id;
        const jsonArray = DATA[jsonNode];

        // Do not run if modal is already active
        if (document.body.classList.contains('modal-active')) {
            return;
        }

        // Build modal modal
        modalBuild(jsonArray);
    }

    // Build modal HTML & append to body
    function modalBuild(array) {
        const modalID = array.ID;
        const modalName = array.name;
        const modalTitle = array.title;
        const modalExcerpt = array.excerpt;
        const modalImageURL = array.image;
        const modalImageAlt = array.image_alt;

        let excerpt = modalExcerpt && typeof modalExcerpt !== 'undefined' ? `<div class="modal__content__excerpt">${modalExcerpt}</div>` : '';
        let image = modalImageURL && modalImageURL !== 'undefined' ? `<picture class="modal__picture"><img class="modal__image" src="${modalImageURL}" alt="${modalImageAlt}" /></picture>` : '';

        /**
         * Build modal HTML
         * -- Edit this to include as many parameters as you need
         **/
        const modal = `
            <aside id="modal-${modalID}" class="modal">
                <div class="modal__container">
                    ${image}
                    <div class="modal__content">
                        <div class="modal__content__inner">
                            <button id="modal-close" type="button" class="modal__close close-button" data-cid="${modalID}" title="Close this modal">
                                <span class="modal__close__text sr-only">Close the modal by clicking the button or pressing the ESC key.</span>
                                <span class="ikes-cross no-touch" aria-hidden="true"></span>
                            </button>
                            <div class="modal__content__heading">
                                <h2 class="modal__content__heading__name h1--styled">${modalName}</h2>
                                <h3 class="modal__content__heading__title">${modalTitle}</h3>
                            </div>
                            ${excerpt}
                        </div>
                    </div>
                </div>
            </aside>
        `;

        // Append modal to end of body
        document.body.insertAdjacentHTML('beforeend', modal);

        // Add body class
        document.body.classList.add('modal-active');

        // Add modal class in order to create animation effect
        setTimeout(function() {
            document
                .getElementById(`modal-${modalID}`)
                .classList.add('modal-open');
        }, 15);

        // Set focus inside modal
        document.getElementById('modal-close').focus();
    }

    // Close modal
    function closemodal() {
        const modal = document.querySelector('[id^="modal-"]');

        if (modal === null || modal === undefined) {
            return;
        }

        document.body.classList.remove('modal-active');
        modal.classList.add('modal-close');

        // Apply animation effect on close
        setTimeout(function() {
            document.body.removeChild(modal);
        }, 300);
    }

    // Close modals on ESC keypress
    function tabCheckClosemodals(e) {
        if (e != null && e.keyCode === 27) {
            const boolmodal = document.querySelector('[id^="modal-"]');

            if (boolmodal !== null) {
                closemodal();
            }
        }
    }

    modalInit();

    document.addEventListener('keydown', tabCheckClosemodals);
    document.body.addEventListener('click', (e) => {
        if( e.target.id === 'modal-close' || e.target.id === 'navigation-overlay' ){
            closemodal();
        }
    });
}