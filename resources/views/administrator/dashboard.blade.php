@extends('layouts.default')

@section('content')

    <div class="row">
        <div class="col-sm-3 col-xs-6">
            <div class="tile-stats tile-red">
                <div class="icon"><i class="entypo-users"></i></div>
                <div class="num" data-start="0" data-end="83" data-postfix="" data-duration="1500" data-delay="0">83</div>

                <h3>Enquêteurs</h3>
                <p>nombre d'enquêteurs inscrits.</p>
            </div>
        </div>

        <div class="col-sm-3 col-xs-6">
            <div class="tile-stats tile-green">
                <div class="icon"><i class="entypo-flag"></i></div>
                <div class="num" data-start="0" data-end="8" data-postfix="" data-duration="1500" data-delay="600">08</div>

                <h3>Unités</h3>
                <p>nombre d'unités disponibles.</p>
            </div>
        </div>

        <div class="col-sm-3 col-xs-6">
            <div class="tile-stats tile-aqua">
                <div class="icon"><i class="entypo-box"></i></div>
                <div class="num" data-start="0" data-end="29" data-postfix="" data-duration="1500" data-delay="600">29</div>

                <h3>Plaintes</h3>
                <p>nombre de plaintes déposées.</p>
            </div>
        </div>

        <div class="col-sm-3 col-xs-6">
            <div class="tile-stats tile-blue">
                <div class="icon"><i class="entypo-folder"></i></div>
                <div class="num" data-start="0" data-end="135" data-postfix="" data-duration="1500" data-delay="600">135</div>

                <h3>Dénonciations</h3>
                <p>nombre de dénonciations anonymes.</p>
            </div>
        </div>
    </div>

@stop