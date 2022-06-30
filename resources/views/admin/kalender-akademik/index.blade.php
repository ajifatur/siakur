@extends('faturhelper::layouts/admin/main')

@section('title', 'Kelola Kalender Akademik')

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-2 mb-sm-0">Kelola Kalender Akademik</h1>
    <div class="btn-group">
        <a href="{{ route('admin.kalender-akademik.create') }}" class="btn btn-sm btn-primary"><i class="bi-plus me-1"></i> Tambah Tahun Akademik</a>
    </div>
</div>
<div class="py-5" id="page-container">
    <div class="row">
        <div class="col-md-9">
            <div id="calendar"></div>
        </div>
        <div class="col-md-3">
            <div class="card shadow">
                <div class="card-header pb-0">
                    <h5 class="card-title">Schedule Form</h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('admin.kalender-akademik.create') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-2">
                            <label for="title" class="control-label">Title</label>
                            <input type="text" class="form-control" name="title" id="title" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="description" class="control-label">Description</label>
                            <textarea rows="3" class="form-control" name="description" id="description" required></textarea>
                        </div>
                        <div class="form-group mb-2">
                            <label for="start_datetime" class="control-label">Start</label>
                            <input type="datetime-local" class="form-control" name="start_datetime" id="start_datetime" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="end_datetime" class="control-label">End</label>
                            <input type="datetime-local" class="form-control" name="end_datetime" id="end_datetime" required>
                        </div>

                        <div class="text-center mt-3">
                            <button class="btn btn-primary" type="submit"><i class="bi bi-save"></i> Save</button>
                            <button class="btn btn-default border" type="reset"><i class="bi bi-x-square"></i> Cancel</button>
                        </div>
                    </form>
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
    $sched_res = [];
    $row['sdate'] = date("F d, Y h:i A",strtotime($row['start_datetime']));
    $row['edate'] = date("F d, Y h:i A",strtotime($row['end_datetime']));
    $sched_res[$row['id']] = $row;
?>
@endforeach
@section('js')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
<script>
var scheds = $.parseJSON('<?= json_encode($sched_res) ?>')

var calendar;
var Calendar = FullCalendar.Calendar;
var events = [];

$(function() {

    if (!!scheds) {
        Object.keys(scheds).map(k => {
            var row = scheds[k]
            events.push({ id: row.id, title: row.title, start: row.start_datetime, end: row.end_datetime });
        });
    }
    
    var date = new Date()
    var d = date.getDate(),
        m = date.getMonth(),
        y = date.getFullYear(),

    calendar = new Calendar(document.getElementById('calendar'), {
        headerToolbar: {
            left: 'prev,next today',
            right: 'dayGridMonth,dayGridWeek,list',
            center: 'title',
        },
        themeSystem: 'bootstrap5',
        editable: true,
        selectable: true,
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

        if (!!scheds[id]) {
            var form = $('#schedule-form');

            console.log(String(scheds[id].start_datetime), String(scheds[id].start_datetime).replace(" ", "\\t"));
            form.find('[name="id"]').val(id);
            form.find('[name="title"]').val(scheds[id].title);
            form.find('[name="description"]').val(scheds[id].description);
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
                location.href = "./delete_schedule.php?id=" + id;
            }
        } else {
            alert("Event is undefined");
        }
    });
});
</script>
@endsection