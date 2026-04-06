@php
    $filePath = $pentest->pentest_photo;
    $fileExt = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
@endphp
<div class="modal fade" id="modalFile" tabindex="-1" aria-labelledby="modalFileLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFileLabel">Detail File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="mb-0">
                    
                    @if (in_array($fileExt, ['pdf']))
                        <iframe src="{{ asset('storage/' . $filePath) }}" class="w-100 border rounded"
                            style="height:520px;" frameborder="0">
                        </iframe>
                    @elseif(in_array($fileExt, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                        <img src="{{ asset('storage/' . $filePath) }}" class="img-fluid rounded border">
                    @else
                        <div class="border rounded p-4 bg-light text-center">
                            <i class="feather-download fs-1 d-block mb-3 text-primary"></i>

                            <p class="mb-3 text-muted">
                                Preview tidak tersedia untuk tipe file <strong>.{{ $fileExt }}</strong>
                            </p>

                            <a href="{{ asset('storage/' . $filePath) }}" class="btn btn-primary"
                                download="{{ basename($filePath) }}">
                                Download File
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <a href="{{ asset('storage/' . $pentest->pentest_photo) }}" download="{{ $pentest->pentest_photo }}"
                    class="btn btn-primary btn-sm">
                    <i class="feather-download me-1"></i>Download
                </a>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
