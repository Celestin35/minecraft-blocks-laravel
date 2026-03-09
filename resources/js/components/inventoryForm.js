import gsap from 'gsap';

document.addEventListener('DOMContentLoaded', () => {
    const openBtn = document.querySelector('[data-anim="open-form"]');
    const closeBtn = document.querySelector('[data-anim="close-form"]');
    const formContainer = document.querySelector('[data-anim="form-container"]');
    const form = document.querySelector('[data-anim="form"]');
    const overlay = document.querySelector('[data-anim="overlay"]');
    const body = document.body;

    if (!openBtn || !closeBtn || !formContainer || !form || !overlay) {
        console.warn('Inventory form elements not found', {
            openBtn,
            closeBtn,
            formContainer,
            form,
            overlay,
        });
        return;
    }

    const tlForm = gsap.timeline({ paused: true });
    gsap.set(formContainer, { autoAlpha: 0, display: 'none' });
    gsap.set(form, { autoAlpha: 0, y: -50 });
    gsap.set(overlay, { autoAlpha: 0 });

    tlForm
        .to(overlay, {
            autoAlpha: 1,
            duration: 0.15,
            onStart: () => {
                overlay.classList.remove('pointer-events-none');
                body.classList.add('overflow-hidden');
            },
        })
        .to(formContainer, { display: 'flex', autoAlpha: 1, duration: 0.15 }, '<')
        .to(form, { autoAlpha: 1, y: 0, duration: 0.3 });

    openBtn.addEventListener('click', () => {
        tlForm.play();
    });

    closeBtn.addEventListener('click', () => {
        tlForm.reverse();
    });

    tlForm.eventCallback('onReverseComplete', () => {
        overlay.classList.add('pointer-events-none');
        body.classList.remove('overflow-hidden');
    });
});
