<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="description" content="Neon Admin Panel"/>
    <meta name="author" content=""/>

    <link rel="icon" href="/assets/images/favicon.ico">

    <title>Porter plainte</title>

    <link rel="stylesheet" href="/assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
    <link rel="stylesheet" href="/assets/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
    <link rel="stylesheet" href="/assets/css/bootstrap.css">
    <link rel="stylesheet" href="/assets/css/neon-core.css">
    <link rel="stylesheet" href="/assets/css/neon-theme.css">
    <link rel="stylesheet" href="/assets/css/neon-forms.css">
    <link rel="stylesheet" href="/assets/css/custom.css">

    <script src="/assets/js/jquery-1.11.3.min.js"></script>

    <!--[if lt IE 9]>
    <script src="/assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>

<div class="container">

    <h2 style="margin: 10% 0">Remplissez le formulaire ci-dessous pour poster une plainte<hr></h2>

    <form id="create-complaint" method="post" action="" class="form-wizard validate" novalidate="novalidate">
        <input type="hidden" name="logged" value="{{ $logged }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="steps-progress" style="margin-left: 10%; margin-right: 10%;">
            <div class="progress-indicator" style="width: 0px;"></div>
        </div>

        <ul id="progress">
            @if(!$logged)
                <li class="active">
                    <a href="#tab2-1" data-toggle="tab"><span>1</span>Informations personnelle</a>
                </li>
            @endif
            <li @if($logged)class="active"@endif>
                <a href="#tab2-2" data-toggle="tab"><span>2</span>Plainte</a>
            </li>
            <li>
                <a href="#tab2-3" data-toggle="tab"><span>3</span>Terminé</a>
            </li>
        </ul>

        <div class="tab-content">
            @if(!$logged)
                <div class="tab-pane active" id="tab2-1">

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="first_name">Quel est votre nom?</label>
                                <input class="form-control" name="first_name" id="first_name" data-validate="required" placeholder="Votre nom" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="last_name">Quel est votre prénom?</label>
                                <input class="form-control" name="last_name" id="last_name" placeholder="Votre prénom">
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="date_of_birth">Quand êtes vous né?</label>
                                <input class="form-control" name="date_of_birth" id="date_of_birth" data-validate="required" data-mask="date" placeholder="Date de naissance" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="birthplace">Où êtes vous né?</label>
                                <input class="form-control" name="birthplace" id="birthplace" data-validate="required" placeholder="ex: Douala" required>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="gender">Vous êtes?</label>
                                <select name="gender" id="gender" class="form-control" data-validate="required" required>
                                    <option value="M">Un homme</option>
                                    <option value="F">Une femme</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="phone">Quel est votre numéro de téléphone?</label>
                                <input type="tel" name="phone" id="phone" class="form-control" minlength="9" data-validate="required" placeholder="699999999" required>
                            </div>
                        </div>

                    </div>

                </div>
            @endif

            <div class="tab-pane @if($logged) active @endif" id="tab2-2">

                <div class="row">

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label" for="street">Vous portez plainte contre?</label>
                            <input class="form-control" name="suspect" id="suspect" data-validate="required" placeholder="Veuillez renseigner son nom">
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label" for="address_line_2">Décrivez votre plainte avec le plus de détails possible</label>
                            <textarea name="description" id="description" cols="30" rows="10" class="form-control" data-validate="required" required></textarea>
                        </div>
                    </div>

                </div>

            </div>

            <div class="tab-pane" id="tab2-3">

                <div class="text-center" style="margin: 10% 0">
                    <h3>Vos informations ont bien étés enregistrées. Cliquez sur le bouton ci-dessous pour porter plainte.</h3>
                    <hr>
                    <button type="submit" class="btn btn-primary btn-lg"><i class="entypo-upload"></i> Poster votre plainte</button>
                </div>

            </div>

            <ul class="pager wizard">
                <li class="previous disabled">
                    <a href="#"><i class="entypo-left-open"></i> Précédent</a>
                </li>

                <li class="next">
                    <a href="#">Suivant <i class="entypo-right-open"></i></a>
                </li>
            </ul>
        </div>

    </form>

</div>

<!-- Result Modal -->
<div class="modal fade" id="result-modal" data-backdrop="static" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content" style="transform: matrix(1, 0, 0, 1, 0, 0);">
            <div class="modal-header">
                <h4 class="modal-title">Plainte déposée.</h4>
            </div>

            <div class="modal-body">
                Plainte déposée avec succès. Cliquez sur le bouton continuer pour ouvrir votre tableau de bord.
            </div>

            <div class="modal-footer">
                <a href="{{ route('dashboard') }}" class="btn btn-info">Continuer</a>
            </div>
        </div>
    </div>
</div>

<!-- Bottom scripts (common) -->
<script src="/assets/js/gsap/TweenMax.min.js"></script>
<script src="/assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
<script src="/assets/js/bootstrap.js"></script>
<script src="/assets/js/joinable.js"></script>
<script src="/assets/js/resizeable.js"></script>
<script src="/assets/js/neon-api.js"></script>
<script src="/assets/js/jquery.bootstrap.wizard.min.js"></script>
<script src="/assets/js/jquery.validate.min.js"></script>
<script src="/assets/js/jquery.inputmask.bundle.js"></script>
<script src="/assets/js/selectboxit/jquery.selectBoxIt.min.js"></script>
<script src="/assets/js/bootstrap-datepicker.js"></script>
<script src="/assets/js/bootstrap-switch.min.js"></script>
<script src="/assets/js/jquery.multi-select.js"></script>
<script src="/assets/js/neon-login.js"></script>
<script src="/assets/js/toastr.js"></script>


<!-- JavaScripts initializations and stuff -->
<script src="/assets/js/neon-custom.js"></script>


<!-- Demo Settings -->
<script src="/assets/js/neon-demo.js"></script>

<script>
    $('#create-complaint').submit(function (e) {
        e.preventDefault();
        e.stopPropagation();

        const data = new FormData($(this)[0]);

        $.ajax({
            url: "{{ route('complaints.store') }}",
            method: "POST",
            data: data,
            processData: false,
            contentType: false,
            success: function (data) {
                $('.modal-body').empty().append(data.message);

                if (typeof data.password != 'undefined')
                    $('.modal-body').append("<br>Veuillez noter votre mot de passe, vous en aurez besoin pour accéder à votre tableau de bord plus tard. <br><br><b>Mot de passe: </b>" + data.password);

                $('#result-modal').modal('show');
            },
            error: function (data) {
                console.log(data);
                toastr.error(data.responseJSON.message, 'Erreur');
            }
        });
    });
</script>
</body>
</html>