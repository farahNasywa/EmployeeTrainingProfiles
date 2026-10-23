<div class="modal fade" id="editEmployeeModal{{ $employee->id_pegawai }}" tabindex="-1" role="dialog"
     aria-labelledby="editEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content shadow border-0" style="border-radius: 15px;">

            <form action="{{ route('admin.employees.update', $employee->id_pegawai) }}" method="POST">
                @csrf
              @method('PUT')

                <!-- Header -->
                <div class="modal-header border-0"
                     style="background:#0F3387; color:white; border-radius:15px 15px 0 0; padding:18px 24px;">

                    <h5 class="modal-title font-weight-bold mb-0">
                        <i class="fas fa-user-edit mr-2"></i>
                        Edit Pegawai
                    </h5>

                    <button type="button"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                            style="
                                background:rgba(255,255,255,0.15);
                                border:none;
                                color:white;
                                width:34px;
                                height:34px;
                                border-radius:50%;
                                font-size:22px;
                                cursor:pointer;
                            ">
                        &times;
                    </button>
                </div>

                <!-- Body -->
                <div class="modal-body px-4 py-4">

                    <div class="form-group">
                        <label>Id Pegawai</label>
                        <input type="number"
                               class="form-control"
                               name="id_pegawai"
                               value="{{ old('id_pegawai', $employee->id_pegawai) }}"
                               readonly>
                    </div>

                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text"
                               class="form-control"
                               name="nama"
                               value="{{ old('nama', $employee->nama) }}"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Bidang</label>
                        <input type="text"
                               class="form-control"
                               name="bidang"
                               value="{{ old('bidang', $employee->bidang) }}"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Level</label>
                        <select class="form-control" name="level" required>
                            <option value="JUNIOR" {{ $employee->level == 'JUNIOR' ? 'selected' : '' }}>JUNIOR</option>
                            <option value="PRACTICIONER" {{ $employee->level == 'PRACTICIONER' ? 'selected' : '' }}>PRACTICIONER</option>
                            <option value="PROFESIONAL" {{ $employee->level == 'PROFESIONAL' ? 'selected' : '' }}>PROFESIONAL</option>
                            <option value="EXPERT" {{ $employee->level == 'EXPERT' ? 'selected' : '' }}>EXPERT</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tanggal Bergabung</label>
                        <input type="date"
                               class="form-control"
                               name="tanggal_bergabung"
                               value="{{ old('tanggal_bergabung', $employee->tanggal_bergabung) }}"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Divisi</label>
                        <select class="form-control" name="id_divisi" required>
                            <option value="">PILIH DIVISI</option>
                            @foreach($divisions as $division)
                                <option value="{{ $division->id_divisi }}"
                                    {{ $employee->id_divisi == $division->id_divisi ? 'selected' : '' }}>
                                    {{ $division->nama_divisi }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Deputi</label>
                        <select class="form-control" name="id_deputi" required>
                            <option value="">PILIH DEPUTI</option>
                            @foreach($deputies as $deputy)
                                <option value="{{ $deputy->id_deputi }}"
                                    {{ $employee->id_deputi == $deputy->id_deputi ? 'selected' : '' }}>
                                    {{ $deputy->nama_deputi }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Roles</label>
                        <input type="text"
                               class="form-control"
                               name="Roles"
                               value="{{ old('Roles', $employee->Roles) }}">
                    </div>

                </div>

                <!-- Footer -->
                <div class="modal-footer border-0">

                    <button type="button"
                            class="btn btn-light px-4"
                            data-bs-dismiss="modal"
                            style="border-radius:10px;">
                        Batal
                    </button>

                    <button type="submit"
                            class="btn px-4"
                            style="background:#0F3387; color:white; border-radius:10px;">
                        <i class="fas fa-save mr-1"></i>
                        Simpan Perubahan
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>

@once
<script>
    // ============================================================
    // FORCE-FIX modal edit: memaksa mekanisme flex+scroll internal
    // lewat JS + !important, dijamin menang lawan CSS apa pun.
    // TIDAK bergantung pada deteksi lebar layar (window.innerWidth),
    // dan TIDAK memaksa height:100vh / border-radius:0, supaya
    // tampilan desktop (modal card di tengah) tetap sama seperti biasa.
    // @once supaya script ini cuma dipasang SEKALI walau file ini
    // di-include berkali-kali (satu per pegawai).
    // ============================================================
    (function () {
        function fixEditModalLayout(modalEl) {
            var dialog = modalEl.querySelector('.modal-dialog');
            var content = modalEl.querySelector('.modal-content');
            var formEl = modalEl.querySelector('.modal-content > form');
            var body = modalEl.querySelector('.modal-body');
            var header = modalEl.querySelector('.modal-header');
            var footer = modalEl.querySelector('.modal-footer');

            if (dialog) {
                dialog.style.setProperty('display', 'flex', 'important');
                dialog.style.setProperty('flex-direction', 'column', 'important');
            }
            if (content) {
                content.style.setProperty('max-height', '100%', 'important');
                content.style.setProperty('display', 'flex', 'important');
                content.style.setProperty('flex-direction', 'column', 'important');
                content.style.setProperty('overflow', 'hidden', 'important');
            }
            // PENTING: <form> membungkus header+body+footer, jadi DIA yang
            // harus jadi flex container juga - bukan cuma modal-content saja.
            if (formEl) {
                formEl.style.setProperty('display', 'flex', 'important');
                formEl.style.setProperty('flex-direction', 'column', 'important');
                formEl.style.setProperty('overflow', 'hidden', 'important');
                formEl.style.setProperty('max-height', '100%', 'important');
                formEl.style.setProperty('min-height', '0', 'important');
            }
            if (body) {
                body.style.setProperty('overflow-y', 'auto', 'important');
                body.style.setProperty('flex', '1 1 auto', 'important');
                body.style.setProperty('min-height', '0', 'important');
            }
            if (header) header.style.setProperty('flex-shrink', '0', 'important');
            if (footer) footer.style.setProperty('flex-shrink', '0', 'important');
        }

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('[id^="editEmployeeModal"]').forEach(function (modalEl) {
                fixEditModalLayout(modalEl);
                modalEl.addEventListener('shown.bs.modal', function () {
                    fixEditModalLayout(modalEl);
                });
                modalEl.addEventListener('show.bs.modal', function () {
                    fixEditModalLayout(modalEl);
                });
            });
        });
    })();
</script>
@endonce