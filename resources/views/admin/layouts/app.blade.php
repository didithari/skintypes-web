<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fb;
            color: #1f2937;
        }
        .admin-wrapper {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 230px 1fr;
        }
        .admin-main {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .admin-content {
            padding: 22px 28px;
        }
        .card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
        }
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        .stat-card {
            padding: 22px;
            min-height: 132px;
        }
        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            margin-bottom: 14px;
        }
        .stat-label {
            color: #6b7280;
            font-size: 16px;
            margin-bottom: 4px;
        }
        .stat-value {
            font-size: 42px;
            font-weight: 700;
            line-height: 1;
        }
        .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }
        .panel-title {
            margin: 0;
            font-size: 32px;
            font-weight: 700;
        }
        .panel-select {
            border: 1px solid #d1d5db;
            background: #fff;
            border-radius: 10px;
            color: #6b7280;
            padding: 10px 14px;
            font-size: 15px;
        }
        .analytics-body {
            height: 250px;
            border-radius: 12px;
            border: 1px dashed #e5e7eb;
            display: grid;
            place-items: center;
            color: #9ca3af;
            margin-bottom: 18px;
        }
        .table-wrap {
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            text-align: left;
            padding: 12px 14px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 14px;
        }
        th {
            color: #6b7280;
            font-weight: 600;
            background: #f9fafb;
        }
        .page-card {
            padding: 20px;
        }
        .page-title {
            margin: 0 0 14px;
            font-size: 24px;
            font-weight: 700;
        }
        .muted {
            color: #6b7280;
            font-size: 14px;
        }
        .badge {
            display: inline-flex;
            align-items: center;
            border-radius: 9999px;
            padding: 4px 10px;
            font-size: 12px;
            background: #e8f5ee;
            color: #059669;
            font-weight: 600;
        }
        .pagination-wrap {
            margin-top: 14px;
        }
        .actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }
        .btn {
            border: none;
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .btn-primary { background: #059669; color: #fff; }
        .btn-secondary { background: #e5e7eb; color: #1f2937; }
        .btn-danger { background: #ef4444; color: #fff; }
        .btn + .btn { margin-left: 6px; }
        .toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 14px;
        }
        .form-grid {
            display: grid;
            gap: 14px;
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
        .form-full { grid-column: span 2; }
        .field label {
            display: block;
            margin-bottom: 6px;
            font-size: 13px;
            color: #374151;
            font-weight: 600;
        }
        .field input,
        .field select,
        .field textarea {
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 9px 10px;
            font-size: 14px;
            background: #fff;
        }
        .field textarea { min-height: 110px; resize: vertical; }
        .alert {
            border-radius: 10px;
            padding: 10px 12px;
            margin-bottom: 14px;
            font-size: 14px;
        }
        .alert-success {
            background: #e8f5ee;
            color: #047857;
            border: 1px solid #a7f3d0;
        }
        .alert-danger {
            background: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(17, 24, 39, 0.45);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            padding: 16px;
        }
        .modal-overlay.show {
            display: flex;
        }
        .modal-box {
            width: 100%;
            max-width: 420px;
            background: #fff;
            border-radius: 14px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.18);
            padding: 18px;
        }
        .modal-title {
            margin: 0 0 8px;
            font-size: 18px;
            font-weight: 700;
            color: #111827;
        }
        .modal-text {
            margin: 0;
            color: #4b5563;
            font-size: 14px;
            line-height: 1.5;
        }
        .modal-actions {
            margin-top: 16px;
            display: flex;
            justify-content: flex-end;
            gap: 8px;
        }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        @include('admin.partials.sidebar')

        <main class="admin-main">
            @include('admin.partials.header')

            <section class="admin-content">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul style="margin:0; padding-left:18px;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </section>
        </main>
    </div>

    <div class="modal-overlay" id="confirmDeleteModal" aria-hidden="true">
        <div class="modal-box" role="dialog" aria-modal="true" aria-labelledby="confirmDeleteTitle">
            <h3 class="modal-title" id="confirmDeleteTitle">Konfirmasi Hapus</h3>
            <p class="modal-text" id="confirmDeleteText">Data ini akan dihapus permanen.</p>

            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" id="confirmDeleteCancel">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteSubmit">Ya, Hapus</button>
            </div>
        </div>
    </div>

    <script>
        (function () {
            const modal = document.getElementById('confirmDeleteModal');
            const message = document.getElementById('confirmDeleteText');
            const cancelButton = document.getElementById('confirmDeleteCancel');
            const submitButton = document.getElementById('confirmDeleteSubmit');
            let pendingForm = null;

            function closeModal() {
                modal.classList.remove('show');
                modal.setAttribute('aria-hidden', 'true');
                pendingForm = null;
            }

            document.querySelectorAll('.js-delete-form').forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    event.preventDefault();
                    pendingForm = form;

                    const label = form.dataset.deleteLabel || 'Data ini akan dihapus permanen.';
                    message.textContent = label;

                    modal.classList.add('show');
                    modal.setAttribute('aria-hidden', 'false');
                });
            });

            cancelButton.addEventListener('click', closeModal);

            submitButton.addEventListener('click', function () {
                if (pendingForm) {
                    pendingForm.submit();
                }
            });

            modal.addEventListener('click', function (event) {
                if (event.target === modal) {
                    closeModal();
                }
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    closeModal();
                }
            });
        })();
    </script>
</body>
</html>
