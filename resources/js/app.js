import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
	const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
	const cartCount = document.getElementById('cart-count');
	const cartAlertContainer = document.getElementById('cart-alerts');

	const updateCartCount = (count) => {
		if (cartCount) {
			cartCount.textContent = count ?? 0;
		}
	};

	const showCartAlert = (message, type = 'success') => {
		if (!cartAlertContainer) {
			return;
		}
		cartAlertContainer.innerHTML = `
			<div class="alert alert-${type} alert-dismissible fade show" role="alert">
				${message}
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
		`;
	};

	const sendCartRequest = async (url, method, payload) => {
		const response = await fetch(url, {
			method,
			headers: {
				'Content-Type': 'application/json',
				'X-Requested-With': 'XMLHttpRequest',
				'X-CSRF-TOKEN': csrfToken ?? '',
				Accept: 'application/json',
			},
			body: payload ? JSON.stringify(payload) : null,
		});

		if (!response.ok) {
			throw new Error('No se pudo actualizar el carrito.');
		}

		return response.json();
	};

	const handleAddToCart = async (productId) => {
		try {
			const data = await sendCartRequest('/carrito/agregar', 'POST', {
				product_id: productId,
				quantity: 1,
			});
			updateCartCount(data.cart?.count ?? 0);
			showCartAlert(data.message ?? 'Producto agregado.');
		} catch (error) {
			console.error(error);
			showCartAlert('No se pudo agregar el producto.', 'danger');
		}
	};

	document.querySelectorAll('.add-to-cart').forEach((button) => {
		button.addEventListener('click', () => {
			const productId = Number(button.dataset.productId);
			if (productId) {
				handleAddToCart(productId);
			}
		});
	});

	const cartTable = document.getElementById('cart-items');
	const cartTotal = document.getElementById('cart-total');

	const refreshCartRow = (row, item) => {
		const subtotalCell = row.querySelector('.cart-subtotal');
		if (subtotalCell) {
			subtotalCell.textContent = `Bs ${item.subtotal.toFixed(2)}`;
		}
	};

	const refreshCartTotals = (cart) => {
		if (cartTotal) {
			cartTotal.textContent = `Bs ${cart.total.toFixed(2)}`;
		}
		updateCartCount(cart.count ?? 0);
	};

	if (cartTable) {
		cartTable.addEventListener('change', async (event) => {
			const input = event.target;
			if (!input.classList.contains('cart-qty')) {
				return;
			}
			const row = input.closest('tr');
			const productId = Number(row?.dataset.productId);
			const quantity = Number(input.value);

			if (!productId || quantity < 1) {
				return;
			}

			try {
				const data = await sendCartRequest('/carrito/actualizar', 'PATCH', {
					product_id: productId,
					quantity,
				});
				const item = data.cart?.items?.[productId];
				if (item) {
					refreshCartRow(row, item);
				}
				refreshCartTotals(data.cart);
				showCartAlert('Cantidad actualizada.');
			} catch (error) {
				console.error(error);
				showCartAlert('No se pudo actualizar la cantidad.', 'danger');
			}
		});

		cartTable.addEventListener('click', async (event) => {
			const button = event.target;
			if (!button.classList.contains('cart-remove')) {
				return;
			}
			const row = button.closest('tr');
			const productId = Number(row?.dataset.productId);
			if (!productId) {
				return;
			}
			try {
				const data = await sendCartRequest(`/carrito/eliminar/${productId}`, 'DELETE');
				row?.remove();
				refreshCartTotals(data.cart);
				showCartAlert('Producto eliminado.');
				if (data.cart?.count === 0) {
					window.location.reload();
				}
			} catch (error) {
				console.error(error);
				showCartAlert('No se pudo eliminar el producto.', 'danger');
			}
		});
	}

	const filterForm = document.getElementById('catalog-filters');
	const gridContainer = document.getElementById('catalog-grid');
	const totalBadge = document.getElementById('catalog-total');

	if (!filterForm || !gridContainer) {
		return;
	}

	const endpoint = gridContainer.dataset.endpoint;

	const fetchFilteredProducts = async () => {
		const formData = new FormData(filterForm);
		const query = new URLSearchParams(formData);
		query.set('ajax', '1');

		try {
			const response = await fetch(`${endpoint}?${query.toString()}`, {
				headers: {
					'X-Requested-With': 'XMLHttpRequest',
					Accept: 'application/json',
				},
			});

			if (!response.ok) {
				throw new Error('No se pudo cargar el catálogo filtrado.');
			}

			const data = await response.json();
			gridContainer.innerHTML = data.html;

			if (totalBadge) {
				totalBadge.textContent = `${data.total} resultados`;
			}

			const browserUrl = `${endpoint}?${new URLSearchParams(formData).toString()}`;
			window.history.replaceState({}, '', browserUrl);
		} catch (error) {
			console.error(error);
		}
	};

	filterForm.addEventListener('submit', async (event) => {
		event.preventDefault();
		await fetchFilteredProducts();
	});

	filterForm.querySelectorAll('select, input').forEach((input) => {
		input.addEventListener('change', () => {
			fetchFilteredProducts();
		});
	});
});
