</main>

<!-- ══ FOOTER ══════════════════════════════════════════════════════ -->
<footer role="contentinfo">
    <div class="container">
        <div class="row g-5">

            <!-- Brand col -->
            <div class="col-lg-4">
                <div class="footer-brand">VOLT<span>EX</span></div>
                <div class="footer-tagline">Premium Energy · Formulé en France</div>
                <p style="color:var(--muted);font-size:.82rem;line-height:1.8;margin-top:1.2rem;max-width:280px;">
                    Boissons énergisantes haut de gamme pour ceux qui refusent la médiocrité. Chaque canette, une déclaration d'intention.
                </p>
                <div class="d-flex gap-2 mt-3">
                    <a href="#" class="social-btn" aria-label="Instagram VOLTEX"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="social-btn" aria-label="TikTok VOLTEX"><i class="bi bi-tiktok"></i></a>
                    <a href="#" class="social-btn" aria-label="YouTube VOLTEX"><i class="bi bi-youtube"></i></a>
                    <a href="#" class="social-btn" aria-label="Twitter / X VOLTEX"><i class="bi bi-twitter-x"></i></a>
                </div>
            </div>

            <!-- Nav cols -->
            <div class="col-6 col-md-3 col-lg-2">
                <h3 class="footer-col-title">Boutique</h3>
                <a href="#" class="footer-link">Tous les produits</a>
                <a href="#" class="footer-link">Packs & offres</a>
                <a href="#" class="footer-link">Nouveautés</a>
                <a href="#" class="footer-link">Best-sellers</a>
                <a href="#" class="footer-link">Abonnements</a>
            </div>

            <div class="col-6 col-md-3 col-lg-2">
                <h3 class="footer-col-title">Marque</h3>
                <a href="#" class="footer-link">Notre histoire</a>
                <a href="#" class="footer-link">La formule</a>
                <a href="#" class="footer-link">Partenaires</a>
                <a href="#" class="footer-link">Magazine</a>
                <a href="#" class="footer-link">Ambassadeurs</a>
            </div>

            <div class="col-6 col-md-3 col-lg-2">
                <h3 class="footer-col-title">Support</h3>
                <a href="#" class="footer-link">FAQ</a>
                <a href="#" class="footer-link">Mon compte</a>
                <a href="#" class="footer-link">Suivi commande</a>
                <a href="#" class="footer-link">Retours</a>
                <a href="#" class="footer-link">Contact</a>
            </div>

            <div class="col-6 col-md-3 col-lg-2">
                <h3 class="footer-col-title">Légal</h3>
                <a href="#" class="footer-link">CGV</a>
                <a href="#" class="footer-link">Mentions légales</a>
                <a href="#" class="footer-link">Confidentialité</a>
                <a href="#" class="footer-link">Cookies</a>
                <a href="#" class="footer-link">Accessibilité</a>
            </div>

        </div>

        <!-- Bottom bar -->
        <div class="footer-bottom d-flex flex-wrap gap-3 justify-content-between align-items-center">
            <span>© 2025 VOLTEX SAS — Tous droits réservés. SIRET 000 000 000 00000</span>
            <div class="d-flex align-items-center gap-3">
                <span>Paiement sécurisé</span>
                <i class="bi bi-credit-card" style="color:var(--volt);"></i>
                <i class="bi bi-lock-fill" style="color:var(--volt);"></i>
                <span>SSL 256-bit</span>
            </div>
        </div>

    </div>
</footer>

<!-- Back to top -->
<button id="back-top" aria-label="Retour en haut de page">
    <i class="bi bi-arrow-up"></i>
</button>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    /* ── Custom cursor ── */
    const cursor = document.getElementById('cursor');
    const trail  = document.getElementById('cursor-trail');
    let mx = 0, my = 0, tx = 0, ty = 0;

    document.addEventListener('mousemove', e => {
        mx = e.clientX; my = e.clientY;
        cursor.style.transform = `translate(${mx - 6}px, ${my - 6}px)`;
    });

    (function animTrail() {
        tx += (mx - tx) * .12;
        ty += (my - ty) * .12;
        trail.style.transform = `translate(${tx - 18}px, ${ty - 18}px)`;
        requestAnimationFrame(animTrail);
    })();

    document.querySelectorAll('a, button, [role=button]').forEach(el => {
        el.addEventListener('mouseenter', () => { cursor.style.transform += ' scale(1.8)'; trail.style.opacity = '.15'; });
        el.addEventListener('mouseleave', () => { trail.style.opacity = '.4'; });
    });

    /* ── Sticky header ── */
    const header = document.getElementById('site-header');
    window.addEventListener('scroll', () => {
        header.classList.toggle('scrolled', window.scrollY > 60);
        document.getElementById('back-top').classList.toggle('show', window.scrollY > 400);
    }, { passive: true });

    document.getElementById('back-top').addEventListener('click', () =>
        window.scrollTo({ top: 0, behavior: 'smooth' })
    );

    /* ── Ticker band populate ── */
    (function() {
        const tpl   = document.getElementById('ticker-tpl');
        const track = document.querySelector('.ticker-track');
        if (!tpl || !track) return;
        const clone1 = tpl.content.cloneNode(true);
        const clone2 = tpl.content.cloneNode(true);
        track.appendChild(clone1);
        track.appendChild(clone2);
    })();

    /* ── Marquee populate ── */
    (function() {
        const tpl   = document.getElementById('marquee-tpl');
        const track = document.getElementById('marquee-track');
        if (!tpl || !track) return;
        const clone1 = tpl.content.cloneNode(true);
        const clone2 = tpl.content.cloneNode(true);
        track.appendChild(clone1);
        track.appendChild(clone2);
    })();

    /* ── Add to cart feedback ── */
    document.querySelectorAll('.product-add-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const original = this.innerHTML;
            this.innerHTML = '<i class="bi bi-check2 me-1"></i> Ajouté !';
            this.style.background = 'var(--volt-dim)';
            setTimeout(() => {
                this.innerHTML = original;
                this.style.background = '';
            }, 1600);
        });
    });

    /* ── Newsletter submit ── */
    document.querySelector('#newsletter form').addEventListener('submit', function(e) {
        e.preventDefault();
        const input = this.querySelector('input');
        const btn   = this.querySelector('button');
        if (!input.value) return;
        btn.innerHTML = '<i class="bi bi-check2 me-1"></i> Inscrit !';
        btn.disabled  = true;
        input.value   = '';
        setTimeout(() => { btn.innerHTML = 'S\'inscrire <i class="bi bi-arrow-right ms-1"></i>'; btn.disabled = false; }, 3000);
    });

    /* ── Scroll-reveal for cards ── */
    if ('IntersectionObserver' in window) {
        const obs = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity   = '1';
                    entry.target.style.transform = 'translateY(0)';
                    obs.unobserve(entry.target);
                }
            });
        }, { threshold: .12 });

        document.querySelectorAll('.product-card, .ingr-card, .feature-item, .testi-card').forEach((el, i) => {
            el.style.opacity   = '0';
            el.style.transform = 'translateY(28px)';
            el.style.transition= `opacity .6s ease ${i * .08}s, transform .6s ease ${i * .08}s, border-color .35s, box-shadow .35s`;
            obs.observe(el);
        });
    }
</script>

</body>
</html>
