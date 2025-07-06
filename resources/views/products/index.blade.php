<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Project - Product List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
      img.rounded {
        object-fit: cover;
        border: 1px solid #dee2e6;
      }
      /* Toggle Switch (Custom from Uiverse.io by WhiteNervosa) */
.slider { 
  background-color: #ffffff2b;
  border-radius: 100px;
  padding: 1px;
  margin: 10px;
  cursor: pointer;
  transition: box-shadow 0.2s cubic-bezier(0.4, 0, 0.2, 1) 0s;
  align-items: center;
  position: relative;
  display: block;
  width: 51px;
  height: 29px;
  box-shadow: rgba(0, 0, 0, 0.62) 0px 0px 5px inset, rgba(0, 0, 0, 0.21) 0px 0px 0px 24px inset,
        #22cc3f 0px 0px 0px 0px inset, rgba(224, 224, 224, 0.45) 0px 1px 0px 0px;
}

.slider::after {
  content: "";
  display: flex;
  top: 2.3px;
  left: 2px;
  width: 26px;
  height: 26px;
  background-color: #e3e3e3;
  border-radius: 200px;
  position: absolute;
  box-shadow: transparent 0px 0px 0px 2px, rgba(0, 0, 0, 0.3) 0px 6px 6px;
  transition: left 300ms cubic-bezier(0.4, 0, 0.2, 1) 0s, background-color 300ms cubic-bezier(0.4, 0, 0.2, 1) 0s;
  will-change: left, background-color;
}

.switch input[type="checkbox"]:checked + .slider {
  box-shadow: rgba(0, 0, 0, 0.62) 0px 0px 5px inset, #22cc3f 0px 0px 0px 2px inset, #22cc3f 0px 0px 0px 24px inset,
        rgba(224, 224, 224, 0.45) 0px 1px 0px 0px;
}

.switch input[type="checkbox"]:checked + .slider::after {
  left: 24px;
}

.switch input[type="checkbox"] {
  display: none;
}
  
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

  .table-dark-mode thead {
    background-color: #2c2c2c;
    color: #fff;
  }

  .btn-dark-mode {
    background-color: #333;
    color: #fff;
    border-color: #444;
  }

  .btn-dark-mode:hover {
    background-color: #444;
  }


    </style>
  </head>
  <body>

    <!-- Header -->
    <div class="bg-dark text-center text-white py-3 shadow-sm d-flex justify-content-between align-items-center px-4">
    <h2 class="m-0">✏️ Listed Product</h2>
    <!-- Theme toggle -->
    <div class="form-check form-switch">
      <input class="form-check-input" type="checkbox" id="themeToggle">
      {{-- <label class="form-check-label text-white" for="themeToggle">Dark Mode</label> --}}
    </div>
    </div>
  


    <!-- Main Container -->
    <div class="container py-4">
      <div class="row">
        <div class="d-flex justify-content-end mb-3">
          <a href="{{ route('products.create') }}" class="btn btn-success">+ Create</a>
        </div>

        <!-- Success Message -->
        @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ Session::get('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <!-- Error Message -->
        @if (Session::has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          {{ Session::get('error') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <!-- Product Table Card -->
        <div class="card shadow">
          <div class="card-header bg-dark text-white">
            <h4 class="mb-0">📦 Product List</h4>
          </div>

          <div class="card-body table-responsive">
            <table class="table table-bordered align-middle text-center">
              <thead class="table-dark">
                <tr>
                  <th>ID</th>
                  <th>Image</th>
                  <th>Name</th>
                  <th>SKU</th>
                  <th>Price</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @if ($products->isNotEmpty())
                  @foreach ($products as $product)
                  <tr>
                    <td>{{ $product->id }}</td>
                    <td>
                      @if (!empty($product->image))
                        <img class="rounded" src="{{ asset('uploads/' . $product->image) }}" width="50" height="50" alt="Product Image">
                      @else
                        <img class="rounded" src="https://via.placeholder.com/50?text=No+Image" width="50" height="50" alt="No Image">
                      @endif
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->sku }}</td>
                    <td>₹{{ number_format($product->price, 2) }}</td>
                    <td>
                      <label class="switch">
                          <input type="checkbox" class="status-toggle" data-id="{{ $product->id }}"
                          {{ $product->status == 1 ? 'checked' : '' }}>
                          <span class="slider"></span>
                      </label>
                    </td>
                <td>
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-primary">Edit</a>
                  <form id="delete-form-{{ $product->id }}"
                    action="{{ route('products.destroy', $product->id) }}"
                    method="POST" style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="button"
                    class="btn btn-danger btn-sm delete-confirm"
                    data-id="{{ $product->id }}">
                    Delete
                    </button>
                  </form>
                </td>

                </tr>
                  @endforeach
                    @else
                  <tr>
                    <td colspan="7" class="text-muted">No products found. Click "Create" to add one.</td>
                </tr>
                @endif
              </tbody>
            </table>
            <div class="d-flex justify-content-center mt-3">
                {{ $products->links() }}
            </div>  

          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap JS -->
    <!-- SweetAlert2 -->
    <!-- Status Toggle AJAX Script -->

<script>
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.status-toggle').forEach((checkbox) => {
      checkbox.addEventListener('change', function () {
        const productId = this.dataset.id;
        const status = this.checked ? 1 : 0;

        fetch(`/products/toggle-status/${productId}`, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}', // ✅ important for Laravel
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({ status: status }) // ✅ sending status as JSON
        })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            Swal.fire('Status Updated', data.message, 'success');
          } else {
            Swal.fire('Error', 'Something went wrong!', 'error');
          }
        })
        .catch(() => {
          Swal.fire('Oops!', 'Could not update status.', 'error');
        });
      });
    });
  });
</script>


    <script>
  document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.delete-confirm');

    deleteButtons.forEach(button => {
      button.addEventListener('click', function () {
        const id = this.getAttribute('data-id');
        Swal.fire({
          title: 'Are you sure?',
          text: "This product will be deleted!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#6c757d',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            document.getElementById(`delete-form-${id}`).submit();
          }
        });
      });
    });
  });
</script>
      {{-- dark and light mode --}}
<script>
  // Check localStorage on page load
  document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.getElementById('themeToggle');
    const body = document.body;

    if (localStorage.getItem('dark-mode') === 'enabled') {
      toggle.checked = true;
      enableDarkMode();
    }

    toggle.addEventListener('change', function () {
      if (this.checked) {
        enableDarkMode();
        localStorage.setItem('dark-mode', 'enabled');
      } else {
        disableDarkMode();
        localStorage.setItem('dark-mode', 'disabled');
      }
    });

    function enableDarkMode() {
      body.classList.add('dark-mode');
      document.querySelectorAll('.card, .table, .alert').forEach(el => el.classList.add('dark-mode'));
    }

    function disableDarkMode() {
      body.classList.remove('dark-mode');
      document.querySelectorAll('.card, .table, .alert').forEach(el => el.classList.remove('dark-mode'));
    }
  });
</script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
