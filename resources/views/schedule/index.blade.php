@extends('layouts.web')
@push('css')
    <style>
        .text-danger {
            font-size: 13px;
            margin-left: 5px;
            font-weight: 500;
        }

        .close-event {
            position: absolute;
            top: -8px;
            right: -5px;
            color: #fff;
            cursor: pointer;
            background: #d40101;
            padding: 0px 6px;
            border-radius: 25px;
            transition: 0.1s ease-in-out;
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
        }

        .close-event:hover {
            background: #9d1c1c;
            color: #ffffff;
        }
    </style>
@endpush
@section('content')
    <div class="container mt-5">
        <div class="row">
            <h1>Program Schedule Calendar</h1>
        </div>

        <div class="card">
            <div class="card-body">
                <div id="calendar"></div>
            </div>

            <!-- Add Program Modal -->
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
                                    <input type="hidden" name="id">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label>Start Date</label>
                                            <input type="text" name="start_date" id="start_date" class="form-control"
                                                placeholder="Start Date" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label>End Date</label>
                                            <input type="text" name="end_date" id="end_date" class="form-control"
                                                placeholder="End Date" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label>Title</label>
                                            <input type="text" name="title" class="form-control"
                                                placeholder="Enter title">
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
                                <button type="submit" id="eventCreateUpdateModalBtn" class="btn btn-success"></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Delete Program Modal -->
            <div class="modal fade" id="programDeleteModal" data-bs-backdrop="static" data-bs-keyboard="false"
                tabindex="-1" aria-labelledby="programDeleteModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md">
                    <form id="programDeleteForm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="programDeleteModalLabel">Delete Program</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row text-center">
                                    <i class="ri-delete-bin-5-line text-danger" style="font-size: 60px;"></i>
                                    <h4 class="mt-3">Are you sure you want to delete this program?</h4>
                                    <p class="text-muted" id="deleteProgramName"></p>

                                    <input type="hidden" name="program_id" id="deleteProgramId">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-info" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Add Program Modal -->
            {{-- <div class="modal fade" id="programModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
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
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label>Start Date</label>
                                            <input type="text" name="start_date" id="start_date" class="form-control"
                                                placeholder="Start Date" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label>End Date</label>
                                            <input type="text" name="end_date" id="end_date" class="form-control"
                                                placeholder="End Date" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label>Title</label>
                                            <input type="text" name="title" class="form-control"
                                                placeholder="Enter title">
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
            </div> --}}
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/index.global.min.js"></script>

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                selectable: true,
                editable: true,
                headerToolbar: {
                    left: 'dayGridMonth',
                    center: 'title',
                    right: 'prev,next today'
                },

                events: '/calendar/events',
                eventDataTransform: function(event) {
                    if (event.quantity >= 100) {
                        event.backgroundColor = '#b31818';
                        event.borderColor = '#b31818';
                    } else if (event.quantity >= 50) {
                        event.backgroundColor = '#d88c00';
                        event.borderColor = '#d88c00';
                    } else {
                        event.backgroundColor = 'green';
                        event.borderColor = 'green';
                    }
                    return event;
                },

                eventContent: function(arg) {
                    let deleteBtn =
                        `<span class="close-event">&times;</span>`;
                    return {
                        html: arg.event.title + deleteBtn
                    };
                },

                eventDidMount: function(arg) {
                    arg.el.querySelector('.close-event')?.addEventListener('click', function(e) {
                        e.stopPropagation();
                        $('#deleteProgramName').text(arg.event.title);
                        $('#deleteProgramId').val(arg.event.id);
                        $('#programDeleteModal').modal('show');
                    });
                },

                select: function(info) {
                    $('#start_date').val(info.startStr);
                    $('#end_date').val(info.endStr);
                    $('#programModal').modal('show');
                    $('#eventCreateUpdateModalBtn').text('Create');
                },

                eventDrop: function(info) {
                    $.ajax({
                        url: "/calendar/update",
                        type: "POST",
                        data: {
                            id: info.event.id,
                            start_date: info.event.start.toLocaleString("sv-SE").replace("T",
                                " "),
                            end_date: info.event.end ? info.event.end.toLocaleString("sv-SE")
                                .replace("T", " ") : null,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function() {
                            toastr.success("Successfully Updated Program!!!");
                        }
                    });
                },

                eventClick: function(info) {
                    $('#programModal').modal('show');
                    $('#eventCreateUpdateModalBtn').text('Update');
                    $('#programForm input[name="id"]').val(info.event.id);
                    $('#programForm  input[name="title"]').val(info.event.title);
                    $('#programForm  input[name="title_ne"]').val(info.event.extendedProps.title_ne ||
                        '');
                    $('#programForm  textarea[name="description"]').val(info.event.extendedProps
                        .description || '');
                    $('#programForm  textarea[name="description_ne"]').val(info.event.extendedProps
                        .description_ne || '');
                    $('#programForm  input[name="quantity"]').val(info.event.extendedProps.quantity ||
                        '');
                    $('#programForm  input[name="start_date"]').val(info.event.startStr);
                    $('#programForm  input[name="end_date"]').val(info.event.endStr);
                    $('#programForm  input[name="icon"]').val(info.event.extendedProps.icon || '');
                    $('#programForm  input[name="mobile_visible"]').val(info.event.extendedProps
                        .mobile_visible || '');
                }
            });

            calendar.render();

            //Close modal
            $('#programModal').on('hidden.bs.modal', function() {
                $('#programForm')[0].reset();
                $('.error').remove();
            });

            //Submit modal form
            $('#programForm').submit(function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                var id = formData.get('id');
                var url = id ? '/calendar/update' : '/calendar/store';

                $.ajax({
                    url: url,
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('.error').remove();
                    },
                    success: function(response) {
                        $('#programForm')[0].reset();
                        $('#programModal').modal('hide');

                        toastr.success(id ? "Program updated successfully!!!" :
                            "Program saved successfully!!!");
                        calendar.refetchEvents();
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;

                            $.each(errors, function(key, value) {
                                let input = $(`[name="${key}"]`);

                                input.siblings('.error').remove();
                                input.after(
                                    `<span class="text-danger error">${value[0]}</span>`
                                );
                            });
                        }
                    }
                });
            });

            //Delete Program
            $('#programDeleteModal').submit(function(e) {
                e.preventDefault();
                let programId = $('#deleteProgramId').val();

                $.ajax({
                    url: '/calendar/delete',
                    type: 'POST',
                    data: {
                        id: programId
                    },
                    success: function() {
                        $('#programDeleteModal').modal('hide');
                        toastr.success("Successfully deleted program!!!");
                        calendar.refetchEvents();
                    }
                })

            });
        });
    </script>
@endpush
