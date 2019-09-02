@extends('layouts.default')

@section('content')

    <div class="row margin-bottom">
        <div class="col-md-7">
            <h2 class="no-margin">Liste des unités</h2>
        </div>

        <div class="col-md-5 btn-group" style="display: flex; justify-content: flex-end">
            <a href="{{ route('unities.create') }}" class="btn btn-default"><i class="entypo-print"></i> Imprimer
                la liste</a>
            <a href="javascript:;" onclick="jQuery('#add_modal').modal('show', {backdrop: 'static'});"
               id="add_unity" class="btn btn-primary"><i class="entypo-user-add"></i> Ajouter une unité</a>
        </div>
    </div>
    <br>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>Nom de l'unité</th>
            <th>Créée le</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
            @foreach($unities as $unity)
                <tr>
                    <td>{{ $unity->id }}</td>
                    <td>{{ $unity->name }}</td>
                    <td>{{ date('d/m/Y', strtotime($unity->created_at)) }}</td>
                    <td>
                        <div class="btn-group">
                            <button type="button" data-unity="{{ $unity->id }}"
                                    class="btn btn-primary btn-sm edit-unity"><i class="entypo-pencil"></i></button>
                            <button type="button"
                                    data-url="{{ route('unities.destroy', ['unity' => $unity]) }}"
                                    class="btn btn-red btn-sm delete-unity"><i class="entypo-trash"></i></button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Add unity modal -->
    <div class="modal fade" id="add_modal" style="display: none">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Ajouter une unité</h4>
                </div>
                <form role="form" id="create_form" method="POST">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name" class="control-label">Nom de l'unité</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                           placeholder="ex: Unité de Boutsoungoulou" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="entypo-cancel"></i>Fermer
                        </button>
                        <button type="submit" class="btn btn-info"><i class="entypo-floppy"></i>Ajouter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit unity modal -->
    <div class="modal fade" id="edit_modal" style="display: none">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Modifier une unité</h4>
                </div>
                <form role="form" id="update_form" method="PUT">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name_2" class="control-label">Nom de l'unité</label>
                                    <input type="text" class="form-control" name="name" id="name_2"
                                           placeholder="ex: Unité de Boutsoungoulou" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="entypo-cancel"></i>Fermer
                        </button>
                        <button type="submit" class="btn btn-info"><i class="entypo-floppy"></i>Modifier</button>
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

        $('#create_form').submit(function (e) {
            e.preventDefault();
            e.stopPropagation();

            const name = $('#name').val();

            $.ajax({
                url: "{{ route('unities.store') }}",
                method: "POST",
                data: { name: name, _token: "{{ csrf_token() }}" },
                success: function (data) {
                    toastr.success(data.message, 'Unité ajoutée');
                    // initialize();
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
    </script>
@stop