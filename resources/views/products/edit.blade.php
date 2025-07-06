<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Edit Product - Laravel CRUD</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body.dark-mode {
      background-color: #121212;
      color: #e4e4e4;
    }

    .card.dark-mode,
    .table.dark-mode,
    .alert.dark-mode {
      background-color: #1e1e1e;
      color: #ffffff;
      border-color: #333;
    }
  </style>
</head>
<body>

  <!-- Header -->
  <div class="bg-dark text-center text-white py-3 shadow-sm d-flex justify-content-between align-items-center px-4">
    <h2 class="m-0">✏️ Edit Product</h2>
    <!-- Theme toggle -->
    <div class="form-check form-switch">
      <input class="form-check-input" type="checkbox" id="themeToggle">
      {{-- <label class="form-check-label text-white" for="themeToggle">Dark Mode</label> --}}
    </div>
  </div>

  <div class="container py-4">
    <div class="d-flex justify-content-end">
      <a href="{{ route('products.index') }}" class="btn btn-secondary mb-3">← Back</a>
    </div>

    <!-- Validation Errors -->
    @if ($errors->any())
    <div class="alert alert-danger">
      <strong>Whoops!</strong> Please fix the following:
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <!-- Edit Form -->
    <div class="card shadow">
      <div class="card-header bg-dark text-white">Edit Details for: <strong>{{ $product->name }}</strong></div>
      <div class="card-body">
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
              value="{{ old('name', $product->name) }}" placeholder="Enter product name">
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="mb-3">
            <label for="sku" class="form-label">SKU</label>
            <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror"
              value="{{ old('sku', $product->sku) }}" placeholder="Enter SKU">
            @error('sku') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="mb-3">
            <label for="price" class="form-label">Price (₹)</label>
            <input type="number" step="0.01" name="price" class="form-control @error('price') is-invalid @enderror"
              value="{{ old('price', $product->price) }}" placeholder="Enter price">
            @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="mb-3">
            <label for="image" class="form-label">Product Image</label><br>
            @if ($product->image)
              <img src="{{ asset('uploads/' . $product->image) }}" width="70" class="rounded mb-2" alt="Product Image">
            @endif
            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
            @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-select @error('status') is-invalid @enderror">
              <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Active</option>
              <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="text-end">
            <button type="submit" class="btn btn-primary">💾 Update Product</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Bootstrap & Theme Toggle -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const toggle = document.getElementById('themeToggle');
      const body = document.body;

      if (localStorage.getItem('dark-mode') === 'enabled') {
        toggle.checked = true;
        enableDark();
      }

      toggle.addEventListener('change', function () {
        if (this.checked) {
          enableDark();
          localStorage.setItem('dark-mode', 'enabled');
        } else {
          disableDark();
          localStorage.setItem('dark-mode', 'disabled');
        }
      });

      function enableDark() {
        body.classList.add('dark-mode');
        document.querySelectorAll('.card, .table, .alert').forEach(el => el.classList.add('dark-mode'));
      }

      function disableDark() {
        body.classList.remove('dark-mode');
        document.querySelectorAll('.card, .table, .alert').forEach(el => el.classList.remove('dark-mode'));
      }
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
