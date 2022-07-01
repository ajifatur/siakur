@extends('faturhelper::layouts/admin/main')

@section('title', 'Kelola Kalender Akademik')

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-2 mb-sm-0">Kelola Kalender Akademik</h1>
</div>

<div class="row">
    <div class="col-md-9">
        <div class="card">
            <div class="card-body">
                @if(Session::get('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <div class="alert-message">{{ Session::get('message') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <div id="calendar"></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-header border-bottom text-center">
                <h5 class="mb-0">Tambah Agenda</h5>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('admin.kalender-akademik.store') }}" enctype="multipart/form-data" id="schedule-form">
                    @csrf
                    <input type="hidden" name="id" value="">
                    <div class="form-group mb-2">
                        <label for="title" class="control-label">Judul</label>
                        <input type="text" class="form-control" name="title" id="title" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="description" class="control-label">Deskripsi</label>
                        <textarea rows="3" class="form-control" name="description" id="description" required></textarea>
                    </div>
                    <div class="form-group mb-2">
                        <label for="start_datetime" class="control-label">Warna</label>
                        <input type="color" class="form-control" name="color" id="color" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="start_datetime" class="control-label">Mulai</label>
                        <input type="datetime-local" class="form-control" name="start_datetime" id="start_datetime" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="end_datetime" class="control-label">Selesai</label>
                        <input type="datetime-local" class="form-control" name="end_datetime" id="end_datetime" required>
                    </div>

                    <div class="text-center mt-3">
                        <button class="btn btn-primary" type="submit"><i class="bi bi-save"></i> Simpan</button>
                        <button class="btn btn-default border" type="reset"><i class="bi bi-x-square"></i> Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Event Details Modal -->
<div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="event-details-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Schedule Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <dl>
                        <dt class="text-muted">Judul</dt>
                        <dd id="title" class="fw-bold fs-4"></dd>
                        <dt class="text-muted">Deskripsi</dt>
                        <dd id="description" class=""></dd>
                        <dt class="text-muted">Mulai</dt>
                        <dd id="start" class=""></dd>
                        <dt class="text-muted">Selesai</dt>
                        <dd id="end" class=""></dd>
                    </dl>
                </div>
            </div>
            <div class="modal-footer">
                <div class="text-end">
                    <button type="button" class="btn btn-primary" id="edit" data-id="">Edit</button>
                    <button type="button" class="btn btn-danger" id="delete" data-id="">Delete</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css">
@endsection

@foreach($kalender_akademik as $row)
<?php
    $row['sdate'] = date("F d, Y h:i A",strtotime($row['start_datetime']));
    $row['edate'] = date("F d, Y h:i A",strtotime($row['end_datetime']));
    $sched_res[$row['id']] = $row;
?>
@endforeach
@section('js')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/locales-all.min.js"></script>
<script>
var scheds = $.parseJSON('<?= json_encode($sched_res) ?>')

var calendar;
var Calendar = FullCalendar.Calendar;
var events = [];

$(function() {

    if (!!scheds) {
        Object.keys(scheds).map(k => {
            var row = scheds[k]
            events.push({ id: row.id, title: row.title, color: row.color, start: row.start_datetime, end: row.end_datetime });
        });
    }
    
    var date = new Date()
    var d = date.getDate(),
        m = date.getMonth(),
        y = date.getFullYear(),

    // full calendar
    calendar = new Calendar(document.getElementById('calendar'), {
        headerToolbar: {
            left: 'prev,next today',
            right: 'dayGridMonth,dayGridWeek,list',
            center: 'title',
        },
        businessHours: {
            daysOfWeek: [ 1, 2, 3, 4, 5, 6 ], // Monday - Saturday
        },
        selectable: true,
        themeSystem: 'bootstrap5',
        eventMinHeight: '100',
        events: events,
        locale: 'id',
        eventClick: function(info) {
            var details = $('#event-details-modal');
            var id = info.event.id;

            if (!!scheds[id]) {
                details.find('#title').text(scheds[id].title);
                details.find('#description').text(scheds[id].description);
                details.find('#start').text(scheds[id].sdate);
                details.find('#end').text(scheds[id].edate);
                details.find('#edit,#delete').attr('data-id', id);
                details.modal('show');
            } else {
                alert("Event is undefined");
            }
        },
        eventDidMount: function(info) {
            // Do Something after events mounted
        },
        editable: true
    });

    calendar.render();

    // Form reset listener
    $('#schedule-form').on('reset', function() {
        $(this).find('input:hidden').val('');
        $(this).find('input:visible').first().focus();
    });

    // Edit Button
    $('#edit').click(function() {
        var id = $(this).attr('data-id');
        $('#schedule-form').attr('action', '{{ route("admin.kalender-akademik.update") }}');

        if (!!scheds[id]) {
            var form = $('#schedule-form');

            console.log(String(scheds[id].start_datetime), String(scheds[id].start_datetime).replace(" ", "\\t"));
            form.find('[name="id"]').val(id);
            form.find('[name="title"]').val(scheds[id].title);
            form.find('[name="description"]').val(scheds[id].description);
            form.find('[name="color"]').val(scheds[id].color);
            form.find('[name="start_datetime"]').val(String(scheds[id].start_datetime).replace(" ", "T"));
            form.find('[name="end_datetime"]').val(String(scheds[id].end_datetime).replace(" ", "T"));
            $('#event-details-modal').modal('hide');
            form.find('[name="title"]').focus();
        } else {
            alert("Event is undefined");
        }
    });

    // Delete Button / Deleting an Event
    $('#delete').click(function() {
        var id = $(this).attr('data-id');

        if (!!scheds[id]) {
            var _conf = confirm("Are you sure to delete this scheduled event?");
            if (_conf === true) {
                location.href = "{{ route('admin.kalender-akademik.delete') }}?id=" + id;
            }
        } else {
            alert("Event is undefined");
        }
    });
});

</script>
@endsection