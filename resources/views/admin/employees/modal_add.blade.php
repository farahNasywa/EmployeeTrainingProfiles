<div class="modal fade" id="addEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content shadow border-0" style="border-radius: 15px;">

            <form action="{{ route('admin.employees.store') }}" method="POST">
                @csrf

               <style>
    .custom-modal-header {
        background: #0F3387;
        color: white;
        border-radius: 15px 15px 0 0;
        padding: 18px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .custom-close {
        background: rgba(255,255,255,0.15);
        border: none;
        color: white;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        font-size: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 1;
        transition: all 0.3s ease;
        margin: 0;
        padding: 0;
    }

    .custom-close:hover {
        background: rgba(255,255,255,0.25);
        transform: rotate(90deg);
        color: white;
    }

    .custom-close:focus {
        outline: none;
        box-shadow: none;
    }
</style>

<div class="modal-header custom-modal-header border-0">
    <h5 class="modal-title font-weight-bold mb-0" id="addEmployeeModalLabel">
        <i class="fas fa-user-plus mr-2"></i>
        Add Employee
    </h5>

    <button type="button"
            class="custom-close"
            data-bs-dismiss="modal"
            aria-label="Close">
        &times;
    </button>
</div>
                <div class="modal-body px-4 py-4">

                    <div class="form-group">
                        <label>Employee ID</label>
                        <input type="number" class="form-control" name="id_pegawai" required>
                    </div>

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="nama" required>
                    </div>

                    <div class="form-group">
                        <label>Field</label>
                        <input type="text" class="form-control" name="bidang" required>
                    </div>

                    <div class="form-group">
                        <label>Level</label>
                        <select class="form-control" name="level" required>
                            <option value="">SELECT LEVEL</option>
                            <option value="JUNIOR">JUNIOR</option>
                            <option value="PRACTICIONER">PRACTICIONER</option>
                            <option value="PROFESIONAL">PROFESIONAL</option>
                            <option value="EXPERT">EXPERT</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Join Date</label>
                        <input type="date" class="form-control" name="tanggal_bergabung" required>
                    </div>

                    <div class="form-group">
                        <label>Division</label>
                        <select class="form-control" name="id_divisi">
                            <option value="">SELECT DIVISION</option>
                            @foreach($divisions as $division)
                                <option value="{{ $division->id_divisi }}">
                                    {{ $division->nama_divisi }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Deputy</label>
                        <select class="form-control" name="id_deputi">
                            <option value="">SELECT DEPUTY</option>
                            @foreach($deputies as $deputy)
                                <option value="{{ $deputy->id_deputi }}">
                                    {{ $deputy->nama_deputi }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Roles</label>
                        <input type="text" class="form-control" name="Roles">
                    </div>

                </div>

                <div class="modal-footer border-0">
                    <button type="button"
                            class="btn btn-light px-4"
                            data-bs-dismiss="modal"
                            style="border-radius:10px;">
                        Cancel
                    </button>

                    <button type="submit"
                            class="btn px-4"
                            style="background:#0F3387;color:white;border-radius:10px;">
                        <i class="fas fa-save mr-1"></i> Save
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>