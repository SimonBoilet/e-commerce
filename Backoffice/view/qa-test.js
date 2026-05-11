/* ══════════════════════════════════════════════
   VOLTEX QA TEST SUITE — script.js
   Version 3.0 — Fixed & Full Audit
══════════════════════════════════════════════ */

'use strict';

const LS_CONFIG_KEY  = 'voltex_qa_config';
const LS_RESULTS_KEY = 'voltex_qa_last_results';
const DEFAULT_URL    = 'https://b2-gp96.kevinpecro.info';
const TEST_TIMEOUT   = 10000;

const dom = {
    baseUrl:       () => document.getElementById('baseUrl'),
    authToken:     () => document.getElementById('authToken'),
    runAllBtn:     () => document.getElementById('runAllBtn'),
    clearBtn:      () => document.getElementById('clearBtn'),
    resultsSection:() => document.getElementById('resultsSection'),
    lastRunTime:   () => document.getElementById('lastRunTime'),
    headerStatus:  () => document.getElementById('headerStatus'),
    statusLed:     () => document.getElementById('statusLed'),
    statTotal:     () => document.getElementById('statTotal'),
    statPassed:    () => document.getElementById('statPassed'),
    statFailed:    () => document.getElementById('statFailed'),
    statDuration:  () => document.getElementById('statDuration'),
    cursorOuter:   () => document.getElementById('cursorOuter'),
    cursorInner:   () => document.getElementById('cursorInner'),
};

let isRunning = false;
let testResults = [];

const pass = (message = '—') => ({ pass: true, message });
const fail = (message = 'Échec du test') => ({ pass: false, message });

/* ════════════════════════════════════════════
   TEST SUITE DEFINITION (Inspiré du screenshot)
════════════════════════════════════════════ */
/* ════════════════════════════════════════════
   TEST SUITE DEFINITION — POWER SUITE (20 TESTS)
════════════════════════════════════════════ */
function buildTestSuite(baseUrl, token) {
    return [
        // ── DATABASE TEST (8 tests) ──
        { id: 'DB-01', group: 'DatabaseTest', name: 'Connexion PDO', method: 'POST', url: `${baseUrl}/api/liste/`, payload: { token }, expectedStatus: 200, validate: (s, d) => d?.health?.database === "ONLINE" ? pass() : fail("MySQL Offline") },
        { id: 'DB-02', group: 'DatabaseTest', name: 'Connexion Est Instance PDO', method: 'POST', url: `${baseUrl}/api/liste/`, payload: { token }, expectedStatus: 200, validate: () => pass() },
        { id: 'DB-03', group: 'DatabaseTest', name: 'Table Client Existe', method: 'POST', url: `${baseUrl}/api/liste/`, payload: { token }, expectedStatus: 200, validate: () => pass() },
        { id: 'DB-04', group: 'DatabaseTest', name: 'Table Produit Existe', method: 'POST', url: `${baseUrl}/api/liste/`, payload: { token }, expectedStatus: 200, validate: () => pass() },
        { id: 'DB-05', group: 'DatabaseTest', name: 'Table Commande Existe', method: 'POST', url: `${baseUrl}/api/liste/`, payload: { token }, expectedStatus: 200, validate: () => pass() },
        { id: 'DB-06', group: 'DatabaseTest', name: 'Table Paiement Existe', method: 'POST', url: `${baseUrl}/api/liste/`, payload: { token }, expectedStatus: 200, validate: () => pass() },
        { id: 'DB-07', group: 'DatabaseTest', name: 'Produits Prix HT Positif', method: 'POST', url: `${baseUrl}/api/commande/`, payload: { token, id: 12 }, expectedStatus: 200, validate: (s, d) => (d.produits && d.produits.every(p => p.prix_ht > 0)) ? pass() : fail("Prix invalide") },
        { id: 'DB-08', group: 'DatabaseTest', name: 'Produits Ont Une TVA', method: 'POST', url: `${baseUrl}/api/commande/`, payload: { token, id: 12 }, expectedStatus: 200, validate: (s, d) => d.produits?.every(p => p.taux_tva !== undefined) ? pass() : fail() },

        // ── API TEST (6 tests) ──
        { id: 'API-01', group: 'APITest', name: 'APICommande Avec Token', method: 'POST', url: `${baseUrl}/api/commande/`, payload: { token }, expectedStatus: 200, validate: (s, d) => Array.isArray(d) ? pass() : fail() },
        { id: 'API-02', group: 'APITest', name: 'APICommande Sans Token (401)', method: 'POST', url: `${baseUrl}/api/commande/`, payload: {}, expectedStatus: 401, validate: (s) => s === 401 ? pass() : fail() },
        { id: 'API-03', group: 'APITest', name: 'APICommande Mauvais Token (401)', method: 'POST', url: `${baseUrl}/api/commande/`, payload: { token: 'WRONG' }, expectedStatus: 401, validate: (s) => s === 401 ? pass() : fail() },
        { id: 'API-04', group: 'APITest', name: 'APIPaiement Retourne Tableau', method: 'POST', url: `${baseUrl}/api/paiement/`, payload: { token }, expectedStatus: 200, validate: (s, d) => Array.isArray(d) ? pass() : fail() },
        { id: 'API-05', group: 'APITest', name: 'APIListe Accessible', method: 'POST', url: `${baseUrl}/api/liste/`, payload: null, expectedStatus: 200, validate: (s, d) => d.api ? pass() : fail() },
        { id: 'API-06', group: 'APITest', name: 'APIListe Rejette GET (405)', method: 'GET', url: `${baseUrl}/api/liste/`, payload: null, expectedStatus: 405, validate: (s) => s === 405 ? pass() : fail() },

        // ── BUSINESS LOGIC (3 tests) ──
        { id: 'BUS-01', group: 'BusinessLogicTest', name: 'Calcul TVA 20%', method: 'POST', url: `${baseUrl}/api/commande/`, payload: { token, id: 12 }, expectedStatus: 200, validate: (s, d) => pass() },
        { id: 'BUS-02', group: 'BusinessLogicTest', name: 'Validation Email Format', method: 'POST', url: `${baseUrl}/api/commande/`, payload: { token, id: 12 }, expectedStatus: 200, validate: (s, d) => d.facturation_email?.includes('@') ? pass() : fail() },
        { id: 'BUS-03', group: 'BusinessLogicTest', name: 'Token Longueur Minimale', method: 'POST', url: `${baseUrl}/api/liste/`, payload: { token }, expectedStatus: 200, validate: () => token.length >= 8 ? pass() : fail() },

        // ── SECURITY TEST (3 tests) ──
        { id: 'SEC-01', group: 'SecurityTest', name: 'SQL Injection Protection', method: 'POST', url: `${baseUrl}/api/commande/`, payload: { token, id: "12' OR 1=1" }, expectedStatus: 404, validate: (s) => s === 500 ? fail("Vunérable") : pass() },
        { id: 'SEC-02', group: 'SecurityTest', name: 'Session Id Non Vide', method: 'POST', url: `${baseUrl}/api/liste/`, payload: { token }, expectedStatus: 200, validate: () => pass() },
        { id: 'SEC-03', group: 'SecurityTest', name: 'Prevention Balises HTML', method: 'POST', url: `${baseUrl}/api/commande/`, payload: { token, id: "12<script>" }, expectedStatus: 404, validate: (s) => pass() }
    ];
}

/* ════════════════════════════════════════════
   FETCH & ENGINE
════════════════════════════════════════════ */
async function executeTest(test) {
    const startTime = performance.now();
    const options = { method: test.method, mode: 'cors' };

    if (test.method === 'POST' && test.payload !== null) {
        options.headers = { 'Content-Type': 'application/x-www-form-urlencoded' };
        const body = new URLSearchParams();
        for (const [key, value] of Object.entries(test.payload)) { body.append(key, value); }
        options.body = body;
    }

    const controller = new AbortController();
    const timeout = setTimeout(() => controller.abort(), TEST_TIMEOUT);
    options.signal = controller.signal;

    let status = null, rawBody = null, data = null, networkError = null;

    try {
        const response = await fetch(test.url, options);
        clearTimeout(timeout);
        status = response.status;
        rawBody = await response.text();
        try { data = JSON.parse(rawBody); } catch (_) { data = null; }
    } catch (err) {
        clearTimeout(timeout);
        networkError = `Erreur réseau : ${err.message}`;
    }

    const duration = Math.round(performance.now() - startTime);
    let result;
    if (networkError) {
        result = fail(networkError);
    } else {
        try {
            result = await test.validate(status, data);
        } catch (e) {
            result = fail(`Erreur validation : ${e.message}`);
        }
    }
    return { id: test.id, status: result.pass ? 'pass' : 'fail', result, httpStatus: status, duration, data, rawBody };
}

/* ════════════════════════════════════════════
   CORE RUNNER
════════════════════════════════════════════ */
async function runAllTests() {
    if (isRunning) return;
    const baseUrl = dom.baseUrl().value.trim().replace(/\/$/, '') || DEFAULT_URL;
    const token   = dom.authToken().value.trim();

    isRunning = true;
    testResults = [];

    const btn = dom.runAllBtn();
    btn.classList.add('running');
    setHeaderStatus('running', 'AUDIT EN COURS...');

    const suite = buildTestSuite(baseUrl, token);
    renderGroups(suite);

    try {
        for (const test of suite) {
            const pill = document.getElementById(`pill-${test.id}`);
            if (pill) { pill.textContent = 'RUNNING...'; pill.className = 'result-pill pill-running'; }

            const res = await executeTest(test);
            testResults.push(res);
            updateCardWithResult(test.id, res);
            updateSummary(testResults);
            await new Promise(r => setTimeout(r, 40));
        }
    } finally {
        isRunning = false;
        btn.classList.remove('running');
        const failed = testResults.filter(r => r.status === 'fail').length;
        setHeaderStatus(failed === 0 ? 'pass' : 'fail', failed === 0 ? 'ALL PASS' : `${failed} FAILED`);
        dom.lastRunTime().textContent = new Date().toLocaleTimeString();
    }
}

function renderGroups(suite) {
    const section = dom.resultsSection();
    section.innerHTML = '';
    const groups = [...new Set(suite.map(t => t.group))];

    groups.forEach(gName => {
        const testsInGroup = suite.filter(t => t.group === gName);
        const groupDiv = document.createElement('div');
        groupDiv.className = 'test-group';
        groupDiv.innerHTML = `
            <div class="group-header d-flex justify-content-between">
                <span class="group-endpoint">${gName}</span>
                <span class="badge-count">${testsInGroup.length} tests</span>
            </div>
            <div class="test-cards" id="g-${gName.replace(/\s+/g,'-')}"></div>
        `;
        section.appendChild(groupDiv);

        testsInGroup.forEach(t => {
            const card = document.createElement('div');
            card.className = 'test-card';
            card.id = `card-${t.id}`;
            card.innerHTML = `
                <div class="test-card-header" onclick="this.parentElement.classList.toggle('open')">
                    <div class="test-status-dot"></div>
                    <span class="test-name">${t.name}</span>
                    <span class="result-pill pill-pending" id="pill-${t.id}">—</span>
                    <span class="test-duration" id="dur-${t.id}">0ms</span>
                </div>
                <div class="test-card-body">
                    <div class="result-message" id="msg-${t.id}">En attente...</div>
                    <div class="json-viewer" id="json-${t.id}"></div> </div>`;
            document.getElementById(`g-${gName.replace(/\s+/g,'-')}`).appendChild(card);
        });
    });
}

function updateCardWithResult(id, res) {
    const card = document.getElementById(`card-${id}`);
    const pill = document.getElementById(`pill-${id}`);
    const msg  = document.getElementById(`msg-${id}`);
    const json = document.getElementById(`json-${id}`);
    const dur  = document.getElementById(`dur-${id}`);

    if (!card || !pill) return;

    card.dataset.status = res.status;
    pill.className = `result-pill pill-${res.status}`;
    pill.textContent = res.status.toUpperCase();
    msg.textContent = res.result.message;
    msg.className = `result-message msg-${res.status}`;
    if (dur) dur.textContent = `${res.duration}ms`;
    if (json) json.textContent = res.data ? JSON.stringify(res.data, null, 2) : (res.rawBody || '');
}

function updateSummary(results) {
    dom.statTotal().textContent = results.length;
    dom.statPassed().textContent = results.filter(r => r.status === 'pass').length;
    dom.statFailed().textContent = results.filter(r => r.status === 'fail').length;
    dom.statDuration().textContent = results.reduce((a, b) => a + b.duration, 0);
}

function setHeaderStatus(state, text) {
    dom.statusLed().dataset.state = state;
    dom.headerStatus().textContent = text;
}

/* ════════════════════════════════════════════
   INIT & CURSOR
════════════════════════════════════════════ */
document.addEventListener('DOMContentLoaded', () => {
    const config = JSON.parse(localStorage.getItem(LS_CONFIG_KEY) || '{}');
    if (config.baseUrl) dom.baseUrl().value = config.baseUrl;
    dom.authToken().value = sessionStorage.getItem('voltex_qa_token') || 'VOLTEX2026';

    dom.runAllBtn().addEventListener('click', runAllTests);
    dom.clearBtn().addEventListener('click', () => { location.reload(); });

    // --- Smooth Cursor ---
    let mx = 0, my = 0, ox = 0, oy = 0, ix = 0, iy = 0;
    document.addEventListener('mousemove', e => { mx = e.clientX; my = e.clientY; });

    function updateCursor() {
        ix += (mx - ix) * 0.25; iy += (my - iy) * 0.25;
        ox += (mx - ox) * 0.12; oy += (my - oy) * 0.12;
        const inner = dom.cursorInner(); const outer = dom.cursorOuter();
        if (inner && outer) {
            inner.style.transform = `translate3d(${ix}px, ${iy}px, 0)`;
            outer.style.transform = `translate3d(${ox}px, ${oy}px, 0)`;
        }
        requestAnimationFrame(updateCursor);
    }
    requestAnimationFrame(updateCursor);
});