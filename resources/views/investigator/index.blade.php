@extends('layouts.default')

@section('content')

    <div class="row margin-bottom">
        <div class="col-md-7">
            <h2 class="no-margin">Liste des enquêteurs</h2>
        </div>

        <div class="col-md-5 btn-group" style="display: flex; justify-content: flex-end">
            <a href="{{ route('investigators.create') }}" class="btn btn-default"><i class="entypo-print"></i> Imprimer
                la liste</a>
            <a href="javascript:;" onclick="jQuery('#add_modal').modal('show', {backdrop: 'static'});"
               id="add_investigator" class="btn btn-primary"><i class="entypo-user-add"></i> Ajouter un enquêteur</a>
        </div>
    </div>
    <br>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>Noms & prénoms</th>
            <th>Date de naissance</th>
            <th>Lieu de naissance</th>
            <th>Numéro de téléphone</th>
            <th>Genre</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($investigators as $investigator)
            <tr>
                <td>{{ $investigator->id }}</td>
                <td>{{ $investigator->first_name . ' ' .$investigator->last_name }}</td>
                <td>{{ $investigator->date_of_birth }}</td>
                <td>{{ $investigator->birthplace }}</td>
                <td>{{ $investigator->phone }}</td>
                <td>{{ $investigator->gender == 'M' ? 'Homme' : 'Femme' }}</td>
                <td>
                    <div class="btn-group">
                        @if($investigator->active)
                            <button type="button" title="Désactiver l'enquêteur"
                                    data-investigator="{{ $investigator->id }}"
                                    class="btn btn-primary btn-sm toggle-investigator"><i class="entypo-lock-open"></i>
                            </button>
                        @else
                            <button type="button" title="Activer l'enquêteur"
                                    data-investigator="{{ $investigator->id }}"
                                    class="btn btn-primary btn-sm toggle-investigator"><i class="entypo-lock"></i>
                            </button>
                        @endif
                        <button type="button" data-investigator="{{ $investigator->id }}"
                                class="btn btn-primary btn-sm edit-investigator"><i class="entypo-pencil"></i></button>
                        <button type="button"
                                data-url="{{ route('investigators.destroy', ['investigator' => $investigator]) }}"
                                class="btn btn-red btn-sm delete-investigator"><i class="entypo-trash"></i></button>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <!-- Add investigator modal -->
    <div class="modal fade" id="add_modal" style="display: none">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Ajouter un enquêteur</h4>
                </div>
                <form role="form" id="create_form" method="POST">
                    @csrf
                    <input type="hidden" name="type" value="1">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first_name" class="control-label">Noms</label>
                                    <input type="text" class="form-control" name="first_name" id="first_name"
                                           placeholder="ex: John" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name" class="control-label">Prénoms</label>
                                    <input type="text" class="form-control" name="last_name" id="last_name"
                                           placeholder="ex: Doe">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date_of_birth" class="control-label">Date de naissance</label>
                                    <input type="date" name="date_of_birth" id="date_of_birth"
                                           class="form-control datepicker"
                                           max="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="birthplace" class="control-label">Lieu de naissance</label>
                                    <input type="text" name="birthplace" id="birthplace" class="form-control"
                                           placeholder="ex: Douala" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="gender" class="control-label">Sexe</label>
                                    <select name="gender" id="gender" class="form-control" required>
                                        <option value="M">Homme</option>
                                        <option value="F">Femme</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone" class="control-label">Téléphone</label>
                                    <input type="text" name="phone" id="phone" class="form-control"
                                           data-mask="999999999"
                                           data-numeric="true" placeholder="699999999" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="password" class="control-label">Mot de passe</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="unity" class="control-label">Unité</label>
                                    <select name="unity" id="unity" class="form-control">
                                        @if($unities->count() <= 0)
                                            <option value="">Aucune unité disponible</option>
                                        @endif

                                        @foreach ($unities as $unity)
                                            <option value="{{ $unity->id }}">{{ $unity->name }}</option>
                                        @endforeach
                                    </select>
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

    <!-- Edit investigator modal -->
    <div class="modal fade" id="edit_modal" style="display: none">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Modifier un enquêteur</h4>
                </div>
                <form role="form" id="update_form" method="PUT">
                    @csrf
                    <input type="hidden" name="type" value="1">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first_name" class="control-label">Noms</label>
                                    <input type="text" class="form-control" name="first_name" id="first_name_2"
                                           placeholder="ex: John" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name" class="control-label">Prénoms</label>
                                    <input type="text" class="form-control" name="last_name" id="last_name_2"
                                           placeholder="ex: Doe">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date_of_birth" class="control-label">Date de naissance</label>
                                    <input type="date" name="date_of_birth" id="date_of_birth_2"
                                           class="form-control datepicker"
                                           max="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="birthplace" class="control-label">Lieu de naissance</label>
                                    <input type="text" name="birthplace" id="birthplace_2" class="form-control"
                                           placeholder="ex: Douala" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="gender" class="control-label">Sexe</label>
                                    <select name="gender" id="gender_2" class="form-control" required>
                                        <option value="M">Homme</option>
                                        <option value="F">Femme</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone" class="control-label">Téléphone</label>
                                    <input type="text" name="phone" id="phone_2" class="form-control"
                                           data-mask="999999999"
                                           data-numeric="true" placeholder="699999999" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="unity" class="control-label">Unité</label>
                                    <select name="unity" id="unity_2" class="form-control">
                                        @if($unities->count() <= 0)
                                            <option value="">Aucune unité disponible</option>
                                        @endif

                                        @foreach ($unities as $unity)
                                            <option value="{{ $unity->id }}">{{ $unity->name }}</option>
                                        @endforeach
                                    </select>
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

            const data = new FormData($(this)[0]);

            $.ajax({
                url: "{{ route('investigators.store') }}",
                method: "POST",
                data: data,
                processData: false,
                contentType: false,
                success: function (data) {
                    toastr.success(data.message, 'Enquêteur ajouté');
                    initialize();
                },
                error: function (data) {
                    toastr.error(data.responseJSON.message, 'Erreur');
                    console.log(data);
                }
            });
        });

        $('.edit-investigator').click(function () {
            const investigator = $(this)[0].dataset['investigator'];
            $('#update_form')[0].dataset['investigator'] = investigator;

            $.ajax({
                url: "/investigators/" + investigator,
                method: "GET",
                success: function (data) {
                    const user = data.investigator;

                    $('#first_name_2').val(user.first_name);
                    $('#last_name_2').val(user.last_name);
                    $('#date_of_birth_2').val(user.date_of_birth);
                    $('#birthplace_2').val(user.birthplace);
                    $('#gender_2').val(user.gender);
                    $('#phone_2').val(user.phone);
                    $('#unity_2').val(user.unity);

                    $('#edit_modal').modal('show', {backdrop: 'static'});
                },
                error: function (data) {
                    console.log(data);
                    toastr.error("Impossible de modifier cet enquêteur. Contactez l'administrateur.", 'Une erreur est survenue');
                }
            });
        });

        $('#update_form').submit(function (e) {
            e.preventDefault();
            e.stopPropagation();

            const investigator = $(this)[0].dataset['investigator'];
            const data = {
                first_name: $('#first_name_2').val(),
                last_name: $('#last_name_2').val(),
                date_of_birth: $('#date_of_birth_2').val(),
                birthplace: $('#birthplace_2').val(),
                gender: $('#gender_2').val(),
                phone: $('#phone_2').val(),
                unity: $('#unity_2').val(),
                _token: "{{ csrf_token() }}"
            };

            console.log(data);

            $.ajax({
                url: '/investigators/' + investigator,
                method: "PUT",
                data: data,
                processData: false,
                contentType: false,
                success: function (data) {
                    console.log(data);
                    toastr.success(data.message, 'Enquêteur modifié');
                    initialize();
                },
                error: function (data) {
                    toastr.error(data.responseJSON.message, 'Erreur');
                    console.log(data);
                }
            });
        });

        $('.delete-investigator').click(function () {
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