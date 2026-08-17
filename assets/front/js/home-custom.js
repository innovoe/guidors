/* ==========================================================================
   Guidors — homepage behaviour
   Vanilla + jQuery-free. Loaded after custom.js, homepage only.
   Deliberately does NOT depend on AOS: AOS only loads when
   settings()->enable_animation == 1, and anything built on it disappears
   when that switch is off.
   ========================================================================== */

(function () {
    'use strict';

    var root = document.documentElement;
    var reduced = window.matchMedia &&
                  window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* Mark that JS is alive. The reveal styles are scoped to .g-js, so if this
       line never runs the page renders fully visible instead of blank. */
    root.className += ' g-js';

    function ready(fn) {
        if (document.readyState !== 'loading') { fn(); }
        else { document.addEventListener('DOMContentLoaded', fn); }
    }

    /* ----------------------------------------------------------------------
       1. Scroll reveal
       ---------------------------------------------------------------------- */
    function initReveal() {
        var items = document.querySelectorAll('[data-g-reveal]');
        if (!items.length) { return; }

        if (!('IntersectionObserver' in window) || reduced) {
            for (var i = 0; i < items.length; i++) { items[i].classList.add('g-in'); }
            return;
        }

        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) { return; }
                entry.target.classList.add('g-in');
                io.unobserve(entry.target);
            });
        }, { rootMargin: '0px 0px -12% 0px', threshold: 0.12 });

        for (var j = 0; j < items.length; j++) { io.observe(items[j]); }
    }

    /* ----------------------------------------------------------------------
       2. Counters — real numbers from the controller, counted once
       ---------------------------------------------------------------------- */
    function countUp(el) {
        var target = parseInt(el.getAttribute('data-g-count'), 10) || 0;
        var suffix = el.getAttribute('data-g-suffix') || '';

        if (reduced || target === 0) {
            el.textContent = target.toLocaleString() + suffix;
            return;
        }

        var duration = 1100;
        var start = null;

        function step(now) {
            if (start === null) { start = now; }
            var p = Math.min((now - start) / duration, 1);
            /* easeOutCubic — fast then settles, so the number feels weighed */
            var eased = 1 - Math.pow(1 - p, 3);
            el.textContent = Math.round(target * eased).toLocaleString() + suffix;
            if (p < 1) { window.requestAnimationFrame(step); }
        }
        window.requestAnimationFrame(step);
    }

    function initCounters() {
        var nums = document.querySelectorAll('[data-g-count]');
        if (!nums.length) { return; }

        if (!('IntersectionObserver' in window)) {
            for (var i = 0; i < nums.length; i++) { countUp(nums[i]); }
            return;
        }

        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) { return; }
                countUp(entry.target);
                io.unobserve(entry.target);
            });
        }, { threshold: 0.4 });

        for (var j = 0; j < nums.length; j++) { io.observe(nums[j]); }
    }

    /* ----------------------------------------------------------------------
       3. Tab indicator
       Bootstrap 4 fires shown.bs.tab; we position a single bar under the
       active link. Works in RTL because it reads offsetLeft directly.
       ---------------------------------------------------------------------- */
    function initTabs() {
        var tabs = document.querySelector('.g-tabs');
        var wrap = tabs && tabs.parentNode;
        if (!tabs || !wrap) { return; }

        /* the indicator lives on the wrapper — a <span> inside a <ul> is
           invalid markup, and offsetLeft still measures from the wrapper */
        var ink = document.createElement('span');
        ink.className = 'g-tabs__ink';
        wrap.appendChild(ink);

        function move() {
            var active = tabs.querySelector('.nav-link.active');
            if (!active) { return; }
            ink.style.width = active.offsetWidth + 'px';
            ink.style.transform = 'translateX(' + active.offsetLeft + 'px)';
        }

        move();
        window.addEventListener('resize', move);

        var links = tabs.querySelectorAll('[data-toggle="tab"]');
        for (var i = 0; i < links.length; i++) {
            links[i].addEventListener('click', function () {
                /* let Bootstrap swap the active class first */
                window.setTimeout(move, 20);
            });
        }

        /* Fonts landing late can shift widths */
        if (document.fonts && document.fonts.ready) {
            document.fonts.ready.then(move);
        }
    }

    /* ----------------------------------------------------------------------
       4. The booking moment
       One real interaction, played out: pick a day, take a slot, confirm.
       Runs when visible, pauses when not, stops entirely on hover so a
       person who wants to read it can.
       ---------------------------------------------------------------------- */
    function initBooking() {
        var card = document.querySelector('[data-g-booking]');
        if (!card || reduced) { return; }

        var days    = card.querySelectorAll('.g-day');
        var slots   = card.querySelectorAll('.g-slot');
        var confirm = card.querySelector('.g-confirm');
        if (!days.length || !slots.length) { return; }

        var timers = [];
        var running = false;
        var paused = false;

        function clearTimers() {
            for (var i = 0; i < timers.length; i++) { window.clearTimeout(timers[i]); }
            timers = [];
        }

        function at(ms, fn) { timers.push(window.setTimeout(fn, ms)); }

        function reset() {
            for (var i = 0; i < days.length; i++) { days[i].classList.remove('is-on'); }
            for (var j = 0; j < slots.length; j++) { slots[j].classList.remove('is-taken'); }
            if (confirm) { confirm.classList.remove('is-on'); }
        }

        function play() {
            if (paused) { return; }
            clearTimers();
            reset();

            /* default day highlighted immediately so the card never looks dead */
            days[1].classList.add('is-on');

            at(900,  function () { days[1].classList.remove('is-on'); days[3].classList.add('is-on'); });
            at(1700, function () { slots[1].classList.add('is-taken'); });
            at(2400, function () { if (confirm) { confirm.classList.add('is-on'); } });
            at(5200, function () { if (confirm) { confirm.classList.remove('is-on'); } });
            at(5800, play);
        }

        function stop() { clearTimers(); }

        card.addEventListener('mouseenter', function () { paused = true; stop(); });
        card.addEventListener('mouseleave', function () { paused = false; if (running) { play(); } });

        if (!('IntersectionObserver' in window)) { running = true; play(); return; }

        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                running = entry.isIntersecting;
                if (running) { play(); } else { stop(); }
            });
        }, { threshold: 0.35 });

        io.observe(card);
    }

    /* ----------------------------------------------------------------------
       5. Pointer sheen — feeds cursor position to the CSS gradient
       ---------------------------------------------------------------------- */
    function initSheen() {
        if (reduced) { return; }
        if (!window.matchMedia || !window.matchMedia('(hover: hover)').matches) { return; }

        var cards = document.querySelectorAll('.g-sheen');
        for (var i = 0; i < cards.length; i++) {
            (function (card) {
                card.addEventListener('mousemove', function (e) {
                    var r = card.getBoundingClientRect();
                    card.style.setProperty('--g-mx', (e.clientX - r.left) + 'px');
                    card.style.setProperty('--g-my', (e.clientY - r.top) + 'px');
                });
            })(cards[i]);
        }
    }

    ready(function () {
        initReveal();
        initCounters();
        initTabs();
        initBooking();
        initSheen();
    });
})();
