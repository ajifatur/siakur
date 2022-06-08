<div class="d-sm-flex justify-content-center align-items-center mb-3">
    <div class="row g-3 align-items-center">
        <div class="col-auto">
            <label class="col-form-label fw-bold">Tahun Akademik:</label>
        </div>
        <div class="col-auto">
            <form method="post" action="{{ route('admin.update-session') }}" id="form-taa">
                @csrf
                <select name="taa" class="form-select form-select-sm" onchange="document.getElementById('form-taa').submit();">
                    <option value="" disabled selected>--Pilih--</option>
                    @foreach(tahun_akademik_all() as $ta)
                    <option value="{{ $ta->id }}" {{ session()->get('taa') == $ta->id ? 'selected' : '' }}>
                        {{ $ta->tahun.'/'.($ta->tahun + 1) }} - {{ $ta->semester == 1 ? 'Ganjil' : 'Genap' }}
                    </option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>
</div>
<hr>