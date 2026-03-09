import gsap from 'gsap';

document.addEventListener('DOMContentLoaded', () => {
    const openBtn = document.querySelector('[data-anim="open-blocks"]');
    const closeBtn = document.querySelector('[data-anim="close-blocks"]');
    const container = document.querySelector('[data-anim="blocks-container"]');
    const box = document.querySelector('[data-anim="blocks-box"]');
    const overlay = document.querySelector('[data-anim="blocks-overlay"]');
    const body = document.body;

    if (!openBtn || !closeBtn || !container || !box || !overlay) {
        return;
    }

    const tl = gsap.timeline({ paused: true });
    gsap.set(container, { autoAlpha: 0, display: 'none' });
    gsap.set(box, { autoAlpha: 0, y: -50 });
    gsap.set(overlay, { autoAlpha: 0 });

    tl.to(overlay, {
        autoAlpha: 1,
        duration: 0.15,
        onStart: () => {
            overlay.classList.remove('pointer-events-none');
            body.classList.add('overflow-hidden');
        },
    })
        .to(container, { display: 'flex', autoAlpha: 1, duration: 0.15 }, '<')
        .to(box, { autoAlpha: 1, y: 0, duration: 0.3 });

    openBtn.addEventListener('click', () => {
        tl.play();
    });

    closeBtn.addEventListener('click', () => {
        tl.reverse();
    });

    overlay.addEventListener('click', () => {
        tl.reverse();
    });

    tl.eventCallback('onReverseComplete', () => {
        overlay.classList.add('pointer-events-none');
        body.classList.remove('overflow-hidden');
    });

    const params = new URLSearchParams(window.location.search);
    const searchValue = params.get('search');
    if (searchValue && searchValue.trim().length > 0) {
        tl.play();
    }

    container.querySelectorAll('li').forEach((item) => {
        const minusBtn = item.querySelector('[data-anim="qty-minus"]');
        const plusBtn = item.querySelector('[data-anim="qty-plus"]');
        const valueEl = item.querySelector('[data-anim="qty-value"]');
        const addBtn = item.querySelector('[data-anim="add-button"]');
        const inputEl = item.querySelector('[data-anim="qty-input"]');

        if (!minusBtn || !plusBtn || !valueEl || !addBtn || !inputEl) {
            return;
        }

        let value = parseInt(valueEl.textContent, 10) || 0;
        const tlAdd = gsap.timeline({ paused: true });
        gsap.set(addBtn, { autoAlpha: 0, x: 8 });
        tlAdd.to(addBtn, {
            autoAlpha: 1,
            x: 0,
            duration: 0.2,
            onStart: () => {
                addBtn.classList.remove('pointer-events-none');
            },
        });

        const render = () => {
            valueEl.textContent = String(value);
            inputEl.value = String(value);
            if (value > 0) {
                tlAdd.play();
            } else {
                tlAdd.reverse();
            }
        };

        render();

        plusBtn.addEventListener('click', () => {
            value += 1;
            render();
        });

        minusBtn.addEventListener('click', () => {
            if (value === 0) return;
            value -= 1;
            render();
        });

        tlAdd.eventCallback('onReverseComplete', () => {
            addBtn.classList.add('pointer-events-none');
        });
    });
});
