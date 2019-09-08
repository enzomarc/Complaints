@extends('layouts.default')

@section('content')

    <div class="row margin-bottom">
        <div class="col-md-7">
            <h2 class="no-margin">Vos enquêtes</h2>
        </div>

        <div class="col-md-5" style="display: flex; justify-content: flex-end">
            <a href="{{ route('complaints.create') }}" class="btn btn-default"><i class="entypo-print"></i> Imprimer
                la liste</a>
        </div>
    </div>
    <br>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>Auteur de la plainte</th>
            <th>Enquête ouverte le</th>
            <th>Date de fin prévue</th>
            <th>Statut</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
            @foreach($investigations as $investigation)
                <tr>
                    <td>{{ $investigation->id }}</td>
                    <td>{{ $investigation->author->first_name . ' ' . $investigation->author->last_name }}</td>
                    <td>{{ date('d/m/Y', strtotime($investigation->start_date)) }}</td>
                    <td>{{ date('d/m/Y', strtotime($investigation->end_date)) }}</td>
                    <td>
                        @if($investigation->status == 0)
                            <div class="label label-primary">Enquête en cours</div>
                        @elseif($investigation->status == 1)
                            <div class="label label-danger">Enquête fermée</div>
                        @elseif($investigation->status == 2)
                            <div class="label label-success">Enquête terminée</div>
                        @else
                            <div class="label label-primary">Statut inconnu</div>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group">
                            <button data-complaint="{{ $investigation->complaint }}" class="btn btn-primary btn-sm show-complaint"><i class="entypo-eye"></i> Voir la plainte</button>
                            @if($investigation->status == 0)
                                <button type="button" data-investigation="{{ $investigation->id }}" class="btn btn-red btn-sm close-investigation"><i class="entypo-cancel"></i> Fermer</button>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Add investigation modal -->
    <div class="modal fade" id="edit_modal" style="display: none">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Ouvrir une enquête</h4>
                </div>
                <form role="form" id="create_form" method="POST">
                    <input type="hidden" name="complaint" id="complaint">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="reason" class="control-label">Raison d'ouverture de l'enquête</label>
                                    <input type="text" class="form-control" name="reason" id="reason"
                                           placeholder="ex: Il a raison, un chat sur un toit en tuile face à la lune ... IL A RAISOOOON" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="start_date">Date d'ouverture de la plainte</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="end_date">Date de fermeture de la plainte</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="entypo-cancel"></i>Fermer</button>
                        <button type="submit" class="btn btn-success"><i class="entypo-floppy"></i>Ouvrir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View complaint modal -->
    <div class="modal fade" id="view_modal" style="display: none">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Plainte n°10203</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <b>Plainte déposée par: </b><span id="complaint-author">N/A</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <b>Plainte déposée contre: </b><span id="complaint-suspect">N/A</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <b>Plainte déposée le: </b><span id="complaint-date">N/A</span>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <b>Description de la plainte:</b><br>
                            <p id="complaint-content">N/A</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="entypo-cancel"></i>Fermer</button>
                </div>
            </div>
        </div>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="assets/js/datatables/datatables.css">
    <link rel="stylesheet" href="assets/js/select2/select2-bootstrap.css">
    <link rel="stylesheet" href="assets/js/select2/select2.css">
@stop

@section('script')
    <script src="assets/js/datatables/datatables.js"></script>
    <script src="assets/js/select2/select2.min.js"></script>
    <script src="assets/js/neon-chat.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/jquery.inputmask.bundle.js"></script>
    <script src="assets/js/neon-chat.js"></script>
    <script src="assets/js/toastr.js"></script>

    <script>
        const table = $('table');

        const initialize = function () {
            table.dataTable({
                "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Tout"]],
                "bStateSave": true
            });

            table.closest('.dataTables_wrapper').find('select').select2({
                minimumResultsForSearch: -1
            });
        };

        initialize();

        $('#create_form').submit(function (e) {
            e.preventDefault();
            e.stopPropagation();

            const complaint = $('#complaint').val();
            const reason = $('#reason').val();
            const start_date = $('#start_date').val();
            const end_date = $('#end_date').val();

            $.ajax({
                url: "{{ route('investigations.store') }}",
                method: "POST",
                data: { complaint: complaint, reason: reason, start_date: start_date, end_date: end_date, _token: "{{ csrf_token() }}" },
                success: function (data) {
                    toastr.success(data.message, 'Nouvelle enquête ouverte');
                },
                error: function (data) {
                    toastr.error(data.responseJSON.message, 'Erreur');
                    console.log(data);
                }
            });
        });

        $('.edit-unity').click(function () {
            const unity = $(this)[0].dataset['unity'];
            $('#update_form')[0].dataset['unity'] = unity;

            $.ajax({
                url: "/unities/" + unity,
                method: "GET",
                success: function (data) {
                    $('#name_2').val(data.unity.name);

                    $('#edit_modal').modal('show', {backdrop: 'static'});
                },
                error: function (data) {
                    console.log(data);
                    toastr.error("Impossible de modifier cette unité. Contactez l'administrateur.", 'Une erreur est survenue');
                }
            });
        });

        $('#update_form').submit(function (e) {
            e.preventDefault();
            e.stopPropagation();

            const unity = $(this)[0].dataset['unity'];
            const name = $('#name_2').val();

            $.ajax({
                url: '/unities/' + unity,
                method: "PUT",
                data: { name: name, _token: "{{ csrf_token() }}" },
                success: function (data) {
                    toastr.success(data.message, 'Unité modifiée');
                    initialize();
                },
                error: function (data) {
                    toastr.error(data.responseJSON.message, 'Erreur');
                    console.log(data);
                }
            });
        });

        $('.delete-unity').click(function () {
            const url = $(this)[0].dataset['url'];
            const parent = $(this).parent().parent().parent();

            $.ajax({
                url: url,
                method: "DELETE",
                data: {_token: "{{ csrf_token() }}"},
                success: function (data) {
                    toastr.success(data.message, 'Enquêteur supprimé');
                    parent.fadeOut(300);
                },
                error: function (data) {
                    toastr.error(data.responseJSON.message, 'Erreur');
                    console.log(data);
                }
            });
        });

        $('.show-complaint').click(function () {
            const complaint = $(this)[0].dataset['complaint'];

            $.ajax({
                url: '/complaints/' + complaint,
                method: 'GET',
                success: function (data) {
                    $('#complaint-author').empty().append(data.complaint.author.first_name + ' ' + data.complaint.author.last_name);
                    $('#complaint-suspect').empty().append(data.complaint.suspect);
                    $('#complaint-date').empty().append(data.complaint.date);
                    $('#complaint-content').empty().append(data.complaint.description);
                    $('#view_modal .modal-title').empty().append('Plainte n°' + data.complaint.id);

                    $('#view_modal').modal('show');
                },
                error: function (data) {
                    console.log(data);
                    toastr.error("Une erreur est survenue. Impossible d'afficher la plainte.", 'Erreur');
                }
            });
        });

        $('.close-investigation').click(function () {
            const investigation = $(this)[0].dataset['investigation'];

            $.ajax({
                url: '/investigations/' + investigation,
                method: 'PUT',
                data: { status: 1, _token: "{{ csrf_token() }}" },
                success: function () {
                    toastr.success("L'enquête a été fermée avec succès. Rendez-vous sur la page des plaintes pour ouvrir une nouvelle enquête.", 'Enquête fermeé');
                    setTimeout(() => {
                        window.location.reload();
                    }, 3000);
                },
                error: function (data) {
                    console.log(data);
                    toastr.error(data.responseJSON.message, 'Error');
                }
            })
        });
    </script>
@stop