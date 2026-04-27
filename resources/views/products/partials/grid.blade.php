<div class="row g-3">
    @forelse($products as $product)
        <div class="col-md-6 col-xl-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="badge text-bg-light border">{{ $product->brand->name ?? 'Marca' }}</span>
                        <span class="small text-muted">{{ $product->category->name ?? 'Categoría' }}</span>
                    </div>
                    <h3 class="h6 fw-semibold">{{ $product->name }}</h3>
                    <p class="small text-muted flex-grow-1">{{ \Illuminate\Support\Str::limit($product->description, 95) }}</p>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <span class="fw-bold">Bs {{ number_format($product->price, 2) }}</span>
                        <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-outline-primary">Ver detalle</a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-warning mb-0">No encontramos productos con esos filtros.</div>
        </div>
    @endforelse
</div>

@if(!$products->isEmpty())
    <div class="mt-3">
        {{ $products->links() }}
    </div>
@endif
