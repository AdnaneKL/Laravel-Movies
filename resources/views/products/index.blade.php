<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Produits</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1 class="mb-4">Gestion des Produits</h1>

        <!-- Filtres et Bouton Ajouter -->
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="btn-group">
                    <button class="btn btn-outline-primary" onclick="filterProducts('all')">Tous</button>
                    <button class="btn btn-outline-primary" onclick="filterProducts('price-asc')">Prix ↑</button>
                    <button class="btn btn-outline-primary" onclick="filterProducts('price-desc')">Prix ↓</button>
                </div>
            </div>
            <div class="col-md-4 text-end">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addProductModal">
                    <i class="fas fa-plus"></i> Ajouter un produit
                </button>
            </div>
        </div>

        <!-- Liste des Produits -->
        <div class="row" id="products-container">
            @foreach($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="{{ $product->path }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ $product->description }}</p>
                        <h6 class="card-subtitle mb-2 text-muted">Prix: {{ number_format($product->price, 2) }} €</h6>
                        <div class="mt-3">
                            <button class="btn btn-primary btn-sm" onclick="editProduct({{ $product->id }})">
                                <i class="fas fa-edit"></i> Modifier
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="deleteProduct({{ $product->id }})">
                                <i class="fas fa-trash"></i> Supprimer
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Prix Moyen -->
        <div class="card mt-4 mb-4">
            <div class="card-body">
                <h5 class="card-title">Statistiques</h5>
                <p class="card-text">Prix moyen des produits: <strong>{{ number_format($averagePrice, 2) }} €</strong></p>
            </div>
        </div>
    </div>

    <!-- Modal Ajout Produit -->
    <div class="modal fade" id="addProductModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un produit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addProductForm" action="{{ route('product.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nom du produit</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Prix</label>
                            <input type="number" step="0.01" class="form-control" name="price" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">URL de l'image</label>
                            <input type="url" class="form-control" name="path" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function filterProducts(filter) {
            window.location.href = `{{ route('product.index') }}?filter=${filter}`;
        }

        function editProduct(id) {
            // Récupérer les données du produit via AJAX
            fetch(`/product/${id}/edit`)
                .then(response => response.json())
                .then(product => {
                    // Créer un formulaire modal pour l'édition
                    const modal = `
                        <div class="modal fade" id="editProductModal" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Modifier le produit</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="editProductForm" action="/product/${id}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-3">
                                                <label class="form-label">Nom du produit</label>
                                                <input type="text" class="form-control" name="name" value="${product.name}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Description</label>
                                                <textarea class="form-control" name="description" required>${product.description}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Prix</label>
                                                <input type="number" step="0.01" class="form-control" name="price" value="${product.price}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">URL de l'image</label>
                                                <input type="url" class="form-control" name="path" value="${product.path}" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

                    // Supprimer l'ancien modal s'il existe
                    const oldModal = document.getElementById('editProductModal');
                    if (oldModal) {
                        oldModal.remove();
                    }

                    // Ajouter le nouveau modal au document
                    document.body.insertAdjacentHTML('beforeend', modal);

                    // Afficher le modal
                    const editModal = new bootstrap.Modal(document.getElementById('editProductModal'));
                    editModal.show();
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Une erreur est survenue lors de la récupération des données du produit');
                });
        }

        function deleteProduct(id) {
            if (confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')) {
                // Créer un formulaire pour la suppression
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/product/${id}`;
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';
                
                form.appendChild(csrfToken);
                form.appendChild(methodField);
                document.body.appendChild(form);
                
                form.submit();
            }
        }

        // Ajouter des messages flash
        @if(session('success'))
            alert('{{ session('success') }}');
        @endif
    </script>
</body>
</html>