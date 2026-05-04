<body>

<!-- Custom cursor -->
<div id="cursor" aria-hidden="true"></div>
<div id="cursor-trail" aria-hidden="true"></div>

<!-- ══ HEADER ══════════════════════════════════════════════════════ -->
<header id="site-header" role="banner">
    <nav class="navbar navbar-expand-lg" aria-label="Navigation principale">
        <div class="container">

            <!-- Brand → Accueil -->
            <a class="navbar-brand" href="/" aria-label="VOLTEX — Accueil">
                <img src="assets/img/logo.png"
                     alt="VOLTEX"
                     class="navbar-logo" />
            </a>

            <!-- Toggler -->
            <button class="navbar-toggler border-0" type="button"
                    data-bs-toggle="collapse" data-bs-target="#mainNav"
                    aria-controls="mainNav" aria-expanded="false" aria-label="Ouvrir le menu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Nav links -->
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav mx-auto gap-1">
                    <li class="nav-item">
                        <a class="nav-link" href="/produit/">Produits</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/#ingredients">Formule</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/#features">Avantages</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/#testimonials">Avis</a>
                    </li>
                </ul>

                <!-- Actions -->
                <div class="d-flex align-items-center gap-2">
                    <button class="nav-icon-btn" aria-label="Rechercher">
                        <i class="bi bi-search"></i>
                    </button>
                    <button class="nav-icon-btn position-relative" aria-label="Compte">
                        <i class="bi bi-person"></i>
                    </button>
                    <a href="/panier/" class="nav-icon-btn position-relative" aria-label="Panier">
                        <i class="bi bi-bag"></i>
                        <?php if (isset($_SESSION['id_panier'])) : ?>
                            <span class="cart-badge" aria-hidden="true">!</span>
                        <?php endif; ?>
                    </a>
                    <!-- Bouton backoffice -->
                    <a href="/backoffice/" class="nav-icon-btn" aria-label="Backoffice" title="Backoffice">
                        <i class="bi bi-grid-3x3-gap-fill"></i>
                    </a>
                    <a href="/produit/" class="btn btn-nav-cta ms-2">Commander</a>
                </div>  
            </div>

        </div>
    </nav>
</header>

<!-- ══ MAIN ════════════════════════════════════════════════════════ -->
<main id="main-content">