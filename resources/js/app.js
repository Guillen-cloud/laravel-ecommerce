import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
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
