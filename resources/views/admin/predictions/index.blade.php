@extends('admin.layouts.app')

@section('title', 'Prediction Results')
@section('header_title', 'Prediction Results')

@section('content')
    <section class="card page-card">
        <div class="toolbar">
            <h2 class="page-title" style="margin:0;">Prediction Results</h2>
            <span class="muted">Create dinonaktifkan untuk prediction</span>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Skin Type</th>
                        <th>Confidence</th>
                        <th>Image Path</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($predictions as $prediction)
                        <tr>
                            <td>{{ optional($prediction->predicted_at ?? $prediction->created_at)->format('d M Y H:i') }}</td>
                            <td><span class="badge">{{ $prediction->skinType->name ?? '-' }}</span></td>
                            <td>{{ $prediction->confidence !== null ? number_format((float) $prediction->confidence * 100, 2) . '%' : '-' }}</td>
                            <td>{{ $prediction->image_path ?? '-' }}</td>
                            <td>
                                <div class="actions">
                                    <button class="btn btn-info" onclick="viewImage('{{ asset('storage/' . $prediction->image_path) }}', '{{ $prediction->skinType->name ?? '-' }}', '{{ $prediction->confidence !== null ? number_format((float) $prediction->confidence * 100, 2) : 0 }}%', '{{ optional($prediction->predicted_at ?? $prediction->created_at)->format('d M Y H:i') }}')">Lihat Gambar</button>
                                    <a class="btn btn-secondary" href="{{ route('admin.predictions.edit', $prediction) }}">Edit</a>
                                    <form class="js-delete-form" data-delete-label="Prediction ini akan dihapus permanen." action="{{ route('admin.predictions.destroy', $prediction) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="muted">Belum ada data prediction.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrap">{{ $predictions->links() }}</div>
    </section>

    <!-- Image Modal -->
    <div id="imageModal" class="modal-overlay">
        <div class="modal-content-admin">
            <div class="modal-header-admin">
                <h3>Gambar Prediction</h3>
                <button class="modal-close-btn" onclick="closeImageModal()">&times;</button>
            </div>
            <div class="modal-body-admin">
                <img id="modalImage" src="" alt="Prediction Image" class="modal-image-admin">
                <div class="modal-info-admin">
                    <p><strong>Skin Type:</strong> <span id="modalSkinType">-</span></p>
                    <p><strong>Confidence:</strong> <span id="modalConfidence">-</span></p>
                    <p><strong>Tanggal:</strong> <span id="modalDate">-</span></p>
                </div>
            </div>
        </div>
    </div>

    <style>
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-content-admin {
            background: white;
            border-radius: 8px;
            padding: 24px;
            max-width: 500px;
            width: 100%;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.3s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-header-admin {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid #e0e0e0;
        }

        .modal-header-admin h3 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }

        .modal-close-btn {
            background: none;
            border: none;
            font-size: 28px;
            cursor: pointer;
            color: #999;
            padding: 0;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.2s;
        }

        .modal-close-btn:hover {
            color: #333;
        }

        .modal-body-admin {
            text-align: center;
        }

        .modal-image-admin {
            width: 100%;
            max-height: 400px;
            border-radius: 8px;
            margin-bottom: 16px;
            object-fit: contain;
            background: #f5f5f5;
        }

        .modal-info-admin {
            background: #f9f9f9;
            border-radius: 8px;
            padding: 16px;
            text-align: left;
        }

        .modal-info-admin p {
            margin: 8px 0;
            font-size: 14px;
            color: #666;
        }

        .modal-info-admin strong {
            color: #333;
        }

        .btn-info {
            background: #2196F3;
            border-color: #2196F3;
            color: white;
            cursor: pointer;
            text-decoration: none;
            padding: 8px 16px;
            display: inline-block;
            border-radius: 4px;
            font-size: 13px;
            transition: background 0.2s;
        }

        .btn-info:hover {
            background: #1976D2;
        }

        .actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
    </style>

    <script>
        function viewImage(imagePath, skinType, confidence, date) {
            document.getElementById('modalImage').src = imagePath;
            document.getElementById('modalSkinType').textContent = skinType;
            document.getElementById('modalConfidence').textContent = confidence;
            document.getElementById('modalDate').textContent = date;
            document.getElementById('imageModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking backdrop
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeImageModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImageModal();
            }
        });
    </script>
@endsection
