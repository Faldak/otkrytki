/* ═══════════════════════════════════════════
   TOIGAKEL — result.js v2
   Envelope animation, music, RSVP,
   countdown timer, text fitting
   ═══════════════════════════════════════════ */

/* ── Element references ─────────────────── */
const openInvite = document.querySelector("#openInvite");
const closedCover = document.querySelector("#closedCover");
const musicToggle = document.querySelector("#musicToggle");
const inviteAudio = document.querySelector("#inviteAudio");
const rsvpName = document.querySelector("#rsvpName");
const rsvpWhatsapp = document.querySelector("#rsvpWhatsapp");
const rsvpButtons = document.querySelectorAll("[data-rsvp]");
const countdownEl = document.querySelector("#countdown");

const fitTextTargets = document.querySelectorAll([
  ".opening-card h1",
  ".split-letter h1",
  ".floral-frame h1",
  ".banquet-card h1",
  ".arch-copy h1",
  ".night-invite h1",
  ".child-note h1",
  ".baby-card h1",
  ".jubilee-invite h1",
  ".calm-letter h1",
  ".poster-copy h1",
].join(","));
const vipNameGroups = document.querySelectorAll(".vip-names");

/* ── Text fitting ────────────────────────── */
function fitVipNameGroups() {
  vipNameGroups.forEach((group) => {
    const names = Array.from(group.querySelectorAll("span"));
    if (!names.length) return;
    group.style.fontSize = "";
    names.forEach((n) => { n.style.whiteSpace = ""; });
    let size = parseFloat(window.getComputedStyle(group).fontSize);
    const minSize = 32;
    names.forEach((n) => { n.style.whiteSpace = "nowrap"; });
    while (names.some((n) => n.scrollWidth > n.clientWidth) && size > minSize) {
      size -= 2;
      group.style.fontSize = `${size}px`;
    }
    if (names.some((n) => n.scrollWidth > n.clientWidth)) {
      names.forEach((n) => { n.style.whiteSpace = "normal"; });
    }
  });
}

function fitLongText() {
  fitVipNameGroups();
  fitTextTargets.forEach((el) => {
    el.style.fontSize = "";
    el.style.whiteSpace = "";
    el.style.maxHeight = "";
    const computed = window.getComputedStyle(el);
    const maxSize = parseFloat(computed.fontSize);
    const isOpeningName = el.matches(".opening-card h1");
    const minSize = isOpeningName ? 24 : 34;
    const maxLines = isOpeningName ? 3 : 2;
    let size = maxSize;
    el.style.whiteSpace = "normal";
    el.style.overflowWrap = "anywhere";
    const overflows = () => {
      const s = window.getComputedStyle(el);
      const lh = parseFloat(s.lineHeight) || size * 1.08;
      const mh = lh * maxLines + 2;
      return el.scrollWidth > el.clientWidth + 1 || el.scrollHeight > mh;
    };
    while (overflows() && size > minSize) { size -= 2; el.style.fontSize = `${size}px`; }
    if (isOpeningName) {
      const s = window.getComputedStyle(el);
      const lh = parseFloat(s.lineHeight) || size * 1.08;
      el.style.maxHeight = `${lh * maxLines + 2}px`;
    }
  });
}

function scheduleFitLongText() {
  window.requestAnimationFrame(() => { fitLongText(); window.setTimeout(fitLongText, 80); });
}

/* ── Music ────────────────────────────────── */
function setMusicState(isPlaying) {
  if (!musicToggle) return;
  musicToggle.classList.toggle("playing", isPlaying);
  const label = isPlaying ? musicToggle.dataset.stop : musicToggle.dataset.play;
  musicToggle.setAttribute("aria-label", label);
  musicToggle.title = label;
}

async function playInviteAudio() {
  if (!inviteAudio) return false;
  try { await inviteAudio.play(); setMusicState(true); return true; }
  catch { setMusicState(false); return false; }
}

/* ── Opening cover ───────────────────────── */
if (openInvite && closedCover) {
  openInvite.addEventListener("click", async () => {
    closedCover.classList.add("opening");
    await playInviteAudio();
    window.setTimeout(() => { closedCover.classList.add("opened"); }, 1250);
  });
}

/* ── Music toggle ────────────────────────── */
if (musicToggle && inviteAudio) {
  setMusicState(false);
  musicToggle.addEventListener("click", async () => {
    if (inviteAudio.paused) { await playInviteAudio(); }
    else { inviteAudio.pause(); setMusicState(false); }
  });
}

/* ── RSVP ─────────────────────────────────── */
function updateRsvpLink(answer) {
  if (!rsvpWhatsapp) return;
  const name = rsvpName?.value?.trim() || "";
  const order = window.inviteOrderId || "";
  const phone = window.inviteWhatsapp || "77024667526";
  const text = [order, name, answer].filter(Boolean).join(" - ");
  rsvpWhatsapp.href = `https://wa.me/${phone}?text=${encodeURIComponent(text)}`;
}

rsvpButtons.forEach((btn) => {
  btn.addEventListener("click", () => {
    rsvpButtons.forEach((b) => b.classList.remove("selected"));
    btn.classList.add("selected");
    updateRsvpLink(btn.dataset.rsvp);
  });
});

if (rsvpName) {
  rsvpName.addEventListener("input", () => {
    const sel = document.querySelector("[data-rsvp].selected");
    if (sel) updateRsvpLink(sel.dataset.rsvp);
  });
}

/* ═══════════════════════════════════════════
   NEW: COUNTDOWN TIMER
   ═══════════════════════════════════════════ */
function initCountdown() {
  if (!countdownEl) return;
  const targetDate = countdownEl.dataset.date;
  if (!targetDate) return;
  const target = new Date(targetDate + "T00:00:00").getTime();

  const daysEl = countdownEl.querySelector("[data-unit='days']");
  const hoursEl = countdownEl.querySelector("[data-unit='hours']");
  const minsEl = countdownEl.querySelector("[data-unit='minutes']");
  const secsEl = countdownEl.querySelector("[data-unit='seconds']");

  function pad(n) { return String(n).padStart(2, "0"); }

  function tick() {
    const now = Date.now();
    const diff = Math.max(0, target - now);
    const d = Math.floor(diff / 86400000);
    const h = Math.floor((diff % 86400000) / 3600000);
    const m = Math.floor((diff % 3600000) / 60000);
    const s = Math.floor((diff % 60000) / 1000);

    if (daysEl) daysEl.textContent = d;
    if (hoursEl) hoursEl.textContent = pad(h);
    if (minsEl) minsEl.textContent = pad(m);
    if (secsEl) secsEl.textContent = pad(s);

    if (diff > 0) requestAnimationFrame(() => setTimeout(tick, 1000));
  }
  tick();
}

initCountdown();

/* ── Init ─────────────────────────────────── */
scheduleFitLongText();
window.addEventListener("resize", scheduleFitLongText);
if (document.fonts?.ready) document.fonts.ready.then(scheduleFitLongText);
