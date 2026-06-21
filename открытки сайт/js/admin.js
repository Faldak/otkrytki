const ordersList = document.querySelector("#ordersList");
const ordersStatus = document.querySelector("#ordersStatus");
const refreshOrders = document.querySelector("#refreshOrders");
const deleteSelectedOrders = document.querySelector("#deleteSelectedOrders");
const clearAllOrders = document.querySelector("#clearAllOrders");
const pricingForm = document.querySelector("#pricingForm");
const pricingStatus = document.querySelector("#pricingStatus");
const webPrice = document.querySelector("#webPrice");
const webOldPrice = document.querySelector("#webOldPrice");
const vipWebPrice = document.querySelector("#vipWebPrice");
const vipWebOldPrice = document.querySelector("#vipWebOldPrice");
const selectedOrderIds = new Set();

function escapeHtml(value) {
  return String(value ?? "")
    .replaceAll("&", "&amp;")
    .replaceAll("<", "&lt;")
    .replaceAll(">", "&gt;")
    .replaceAll('"', "&quot;")
    .replaceAll("'", "&#039;");
}

function formatDate(value) {
  if (!value) return "";
  const date = new Date(value);
  if (Number.isNaN(date.getTime())) return value;
  return date.toLocaleString("ru-RU");
}

function field(label, value) {
  return `
    <div>
      <dt>${label}</dt>
      <dd>${escapeHtml(value || "-")}</dd>
    </div>
  `;
}

function renderOrderActions(order) {
  if (order.cancelled) {
    return `<span class="status">Отменено ${escapeHtml(formatDate(order.cancelledAt))}</span>`;
  }

  if (order.confirmed) {
    const url = order.resultUrl || order.resultPath || "";
    return `
      <span class="status confirmed">Подтверждено ${escapeHtml(formatDate(order.confirmedAt))}</span>
      ${url ? `<a class="admin-link" href="${escapeHtml(url)}" target="_blank" rel="noreferrer">Открыть результат</a>` : ""}
      ${url ? `<button type="button" data-copy="${escapeHtml(url)}">Копировать ссылку</button>` : ""}
    `;
  }

  return `
    <button type="button" data-confirm="${escapeHtml(order.id)}">Подтвердить оплату</button>
    <button class="secondary-action" type="button" data-cancel="${escapeHtml(order.id)}">Отменить заявку</button>
  `;
}

function updateBulkButtons() {
  if (deleteSelectedOrders) {
    deleteSelectedOrders.disabled = selectedOrderIds.size === 0;
    deleteSelectedOrders.textContent = selectedOrderIds.size
      ? `Удалить выбранные (${selectedOrderIds.size})`
      : "Удалить выбранные";
  }
}

function renderOrders(orders) {
  if (!orders.length) {
    ordersList.innerHTML = `<div class="empty-state">Пока заявок нет.</div>`;
    updateBulkButtons();
    return;
  }

  ordersList.innerHTML = orders.map((order) => `
    <article class="order-card">
      <div class="order-top">
        <label class="order-select">
          <input type="checkbox" data-select-order="${escapeHtml(order.id)}" ${selectedOrderIds.has(order.id) ? "checked" : ""}>
          <span>
            <span class="order-id">${escapeHtml(order.id)}</span>
            <span>${escapeHtml(order.category)} / ${escapeHtml(order.template)}</span>
          </span>
        </label>
        <span class="status ${order.confirmed ? "confirmed" : ""}">
          ${escapeHtml(order.status)}
        </span>
      </div>
      <dl class="order-grid">
        ${field("Клиент", order.clientName)}
        ${field("WhatsApp", order.phone)}
        ${field("Формат", order.productType)}
        ${field("Цена", order.price ? `${order.price} тг / было ${order.oldPrice || "-"} тг` : "-")}
        ${field("Музыка", order.music)}
        ${field("Имена", order.mainNames)}
        ${field("Гость", order.guestName)}
        ${field("Дата", `${order.eventDate || ""} ${order.eventTime || ""}`.trim())}
        ${field("Адрес", order.address)}
        ${field("2ГИС", order.gisLink)}
        ${field("Язык", order.inviteLanguage)}
        ${field("Создана", formatDate(order.createdAt))}
        ${field("Текст", order.customText)}
        ${order.resultUrl ? field("Ссылка", order.resultUrl) : ""}
      </dl>
      <div class="order-actions">
        ${renderOrderActions(order)}
      </div>
    </article>
  `).join("");
  updateBulkButtons();
}

async function loadOrders() {
  ordersStatus.textContent = "Загрузка заявок...";
  selectedOrderIds.clear();
  updateBulkButtons();
  const response = await fetch("api/admin-orders.php");
  const data = await response.json();
  if (!data.ok) {
    throw new Error(data.message || "Не удалось загрузить заявки");
  }
  renderOrders(data.orders);
  ordersStatus.textContent = `Заявок: ${data.orders.length}`;
}

async function deleteOrders(payload) {
  const response = await fetch("api/admin-delete-orders.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(payload)
  });
  const data = await response.json();
  if (!data.ok) {
    throw new Error(data.message || "Не удалось удалить заявки");
  }
  selectedOrderIds.clear();
  await loadOrders();
  ordersStatus.textContent = `Удалено: ${data.deleted}. Осталось: ${data.remaining}`;
}

async function confirmOrder(id) {
  const response = await fetch("api/admin-confirm.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ id })
  });
  const data = await response.json();
  if (!data.ok) {
    throw new Error(data.message || "Не удалось подтвердить заявку");
  }
  await loadOrders();
}

async function cancelOrder(id) {
  const response = await fetch("api/admin-cancel.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ id })
  });
  const data = await response.json();
  if (!data.ok) {
    throw new Error(data.message || "Не удалось отменить заявку");
  }
  await loadOrders();
}

function fillPricing(pricing) {
  webPrice.value = pricing.web?.current || 590;
  webOldPrice.value = pricing.web?.old || 1990;
  vipWebPrice.value = pricing.vipWeb?.current || 990;
  vipWebOldPrice.value = pricing.vipWeb?.old || 2990;
}

async function loadPricing() {
  pricingStatus.textContent = "Цены загружаются...";
  const response = await fetch("api/admin-pricing.php");
  const data = await response.json();
  if (!data.ok) {
    throw new Error(data.message || "Не удалось загрузить цены");
  }
  fillPricing(data.pricing);
  pricingStatus.textContent = "Цены загружены";
}

async function savePricing() {
  pricingStatus.textContent = "Сохраняем цены...";
  const payload = {
    web: {
      current: webPrice.value,
      old: webOldPrice.value,
    },
    vipWeb: {
      current: vipWebPrice.value,
      old: vipWebOldPrice.value,
    },
  };

  const response = await fetch("api/admin-pricing.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(payload)
  });
  const data = await response.json();
  if (!data.ok) {
    throw new Error(data.message || "Не удалось сохранить цены");
  }
  fillPricing(data.pricing);
  pricingStatus.textContent = "Цены сохранены";
}

async function copyText(text) {
  if (navigator.clipboard) {
    await navigator.clipboard.writeText(text);
    return;
  }

  const input = document.createElement("input");
  input.value = text;
  document.body.append(input);
  input.select();
  document.execCommand("copy");
  input.remove();
}

refreshOrders.addEventListener("click", () => {
  loadOrders().catch((error) => {
    ordersStatus.textContent = error.message;
  });
});

deleteSelectedOrders?.addEventListener("click", () => {
  const ids = [...selectedOrderIds];
  if (!ids.length) return;
  const ok = window.confirm(`Удалить выбранные заявки (${ids.length}) вместе с файлами?`);
  if (!ok) return;

  deleteSelectedOrders.disabled = true;
  deleteSelectedOrders.textContent = "Удаляем...";
  deleteOrders({ ids }).catch((error) => {
    ordersStatus.textContent = error.message;
    updateBulkButtons();
  });
});

clearAllOrders?.addEventListener("click", () => {
  const ok = window.confirm("Точно удалить все заявки и все загруженные файлы заказов? Это действие нельзя отменить.");
  if (!ok) return;

  clearAllOrders.disabled = true;
  clearAllOrders.textContent = "Очищаем...";
  deleteOrders({ all: true }).catch((error) => {
    ordersStatus.textContent = error.message;
  }).finally(() => {
    clearAllOrders.disabled = false;
    clearAllOrders.textContent = "Очистить все";
  });
});

pricingForm?.addEventListener("submit", (event) => {
  event.preventDefault();
  savePricing().catch((error) => {
    pricingStatus.textContent = error.message;
  });
});

ordersList.addEventListener("click", (event) => {
  const confirmButton = event.target.closest("[data-confirm]");
  const cancelButton = event.target.closest("[data-cancel]");
  const copyButton = event.target.closest("[data-copy]");

  if (confirmButton) {
    confirmButton.disabled = true;
    confirmButton.textContent = "Подтверждаем...";
    confirmOrder(confirmButton.dataset.confirm).catch((error) => {
      ordersStatus.textContent = error.message;
      confirmButton.disabled = false;
      confirmButton.textContent = "Подтвердить оплату";
    });
    return;
  }

  if (cancelButton) {
    cancelButton.disabled = true;
    cancelButton.textContent = "Отменяем...";
    cancelOrder(cancelButton.dataset.cancel).catch((error) => {
      ordersStatus.textContent = error.message;
      cancelButton.disabled = false;
      cancelButton.textContent = "Отменить заявку";
    });
    return;
  }

  if (copyButton) {
    copyText(copyButton.dataset.copy).then(() => {
      ordersStatus.textContent = "Ссылка скопирована";
    }).catch((error) => {
      ordersStatus.textContent = error.message;
    });
  }
});

ordersList.addEventListener("change", (event) => {
  const checkbox = event.target.closest("[data-select-order]");
  if (!checkbox) return;

  if (checkbox.checked) {
    selectedOrderIds.add(checkbox.dataset.selectOrder);
  } else {
    selectedOrderIds.delete(checkbox.dataset.selectOrder);
  }

  updateBulkButtons();
});

loadOrders().catch((error) => {
  ordersStatus.textContent = error.message;
});

loadPricing().catch((error) => {
  pricingStatus.textContent = error.message;
});
