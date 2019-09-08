@extends('layouts.default')

@section('content')

    <div class="row margin-bottom">
        <div class="col-md-7">
            <h2 class="no-margin">Plaintes déposées</h2>
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
            <th>Numéro de téléphone</th>
            <th>Nom du suspect</th>
            <th>Déposée le</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
            @foreach($complaints as $complaint)
                <tr>
                    <td>{{ $complaint->id }}</td>
                    <td>{{ $complaint->author->first_name . ' ' . $complaint->author->last_name }}</td>
                    <td>{{ $complaint->author->phone }}</td>
                    <td>{{ $complaint->suspect }}</td>
                    <td>{{ date('d/m/Y', strtotime($complaint->created_at)) }}</td>
                    <td>
                        @if(!$complaint->investigated)
                            <button class="btn btn-primary btn-sm open-investigation" data-complaint="{{ $complaint->id }}"><i class="entypo-folder"></i> Ouvrir une enquête</button>
                        @else
                            <div class="label label-info">Une enquête est ouverte</div>
                        @endif
                        <button class="btn btn-primary btn-sm send-message" data-user="{{ $complaint->author->id }}"><i class="entypo-paper-plane"></i> Envoyer un message</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Add investigation modal -->
    <div class="modal fade" id="add_modal" style="display: none">
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
                                    <label for="start_date">Date d'ouverture de l'enquête</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="end_date">Date de fermeture de l'enquête</label>
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

    <!-- Send message modal -->
    <div class="modal fade" id="message_modal" style="display: none">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Envoyer un message</h4>
                </div>
                <form role="form" id="message_form" method="POST">
                    <input type="hidden" name="to" id="message_to">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="content" class="control-label">Message: </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <textarea class="form-control" name="content" id="content" cols="30" rows="10" style="height: 300px" placeholder="Contenu du message ici..." required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="entypo-cancel"></i>Fermer</button>
                        <button type="submit" class="btn btn-success"><i class="entypo-paper-plane"></i>Envoyer</button>
                    </div>
                </form>
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

        $('.open-investigation').click(function () {
            const complaint = $(this)[0].dataset['complaint'];
            $('#complaint').val(complaint);

            $('#add_modal').modal('show');
        });

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
                    $('#add_modal').modal('hide');
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

        $('.send-message').click(function () {
            const user = $(this)[0].dataset['user'];

            $.ajax({
                url: '/users/' + user,
                method: 'GET',
                data: { _token: "{{ csrf_token() }}" },
                success: function (data) {
                    $('#message_to').val(data.user.id);
                    $('#message_modal .modal-title').empty().append('Envoyer un message à ' + data.user.first_name + ' ' + data.user.last_name);
                    $('#message_modal').modal('show');
                },
                error: function (data) {
                    console.log(data);
                    toastr.error("Impossible d'envoyer un message à cet utilisateur.", 'Erreur');
                }
            });
        });

        $('#message_form').submit(function (e) {
            e.preventDefault();
            e.stopPropagation();

            const to = $('#message_to').val();
            const content = $('#content').val();

            $.ajax({
                url: "{{ route('messages.store') }}",
                method: "POST",
                data: { to: to, content: content, _token: "{{ csrf_token() }}" },
                success: function (data) {
                    toastr.success(data.message, 'Message envoyé');
                    $('#message_modal').modal('hide');
                },
                error: function (data) {
                    console.log(data);
                    toastr.error(data.responseJSON.message, 'Erreur');
                }
            });
        });
    </script>
@stop