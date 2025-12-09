@extends('layouts.web')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <h1>Laravel 12 Schedule Calendar | Full Calendar</h1>
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search Events">
                    <div class="input-group-append">
                        <button id="searchButton" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div id="calendar"></div>
            </div>

            <!-- Program Modal -->
            <div class="modal fade" id="programModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="programModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <form id="programForm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="programModalLabel">Add Program</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <input type="hidden" id="start_date" name="start_date" />
                                    <input type="hidden" id="end_date" name="end_date" />

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label>Title</label>
                                            <input type="text" name="title" class="form-control"
                                                placeholder="Enter title" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label>Title (Nepali)</label>
                                            <input type="text" name="title_ne" class="form-control"
                                                placeholder="Enter title in Nepali">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label>Description</label>
                                            <textarea name="description" class="form-control" placeholder="Enter description"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label>Description (Nepali)</label>
                                            <textarea name="description_ne" class="form-control" placeholder="Enter description in Nepali"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label>Quantity</label>
                                            <input type="number" name="quantity" class="form-control"
                                                placeholder="Enter quantity">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label>Status</label>
                                            <select name="status" class="form-control">
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label>Icon</label>
                                            <input type="text" name="icon" class="form-control"
                                                placeholder="Enter icon class (e.g., ri-user-line)">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label>Mobile Visible</label>
                                            <select name="mobile_visible" class="form-control">
                                                <option value="1">Visible</option>
                                                <option value="0">Invisible</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label>Image URL</label>
                                            <input type="file" name="image" class="form-control">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Create</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/index.global.min.js"></script>

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                selectable: true,
                editable: true,
                headerToobar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },

                events: '/calendar/events',

                select: function(info) {
                    $('#start_date').val(info.startStr);
                    $('#end_date').val(info.endStr);
                    $('#programModal').modal('show');
                },

                eventDrop: function(info) {
                    $.ajax({
                        url: "/calendar/update",
                        type: "POST",
                        data: {
                            id: info.event.id,
                            start: info.event.start.toLocaleString("sv-SE").replace("T", " "),
                            end: info.event.end ? info.event.end.toLocaleString("sv-SE")
                                .replace("T", " ") : null,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function() {
                            alert("Event Updated!!!");
                        }
                    });
                },

                eventClick: function(info) {
                    if (confirm("Delete this event?")) {
                        $.ajax({
                            url: "/calendar/delete",
                            type: "POST",
                            data: {
                                id: info.event.id,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function() {
                                info.event.remove();
                                alert("Event Deleted!!!");
                            }
                        })
                    }
                }
            });

            calendar.render();

            //Submit modal form
            $('#programForm').submit(function(e){
                e.preventDefault();
                var formData = $(this).serialize();
                console.log('formData: ',formData);
            });
        });
    </script>
@endpush
