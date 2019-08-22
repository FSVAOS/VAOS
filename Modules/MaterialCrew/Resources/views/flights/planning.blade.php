@extends('materialcrew::layouts.crewops')
@section('customcss')
    <style>
        .info-block {
            text-align: center;
            color: white;
        }
        .info-block-title {
            font-size: 2.6rem;
        }
        .info-block-item {
            font-size: 3.7rem;
            font-weight: bold;
        }
        .tab>a {
            color: white/* #61c7ff */ !important;
            text-transform: none !important;
            font-size: 1.73rem !important;
        }
        .tabs {
            display: flex;
            justify-content: space-between;

        }
        .tab-panel {
            margin-top: 2rem;
        }
        .status-strip-container {
            display: grid;
            grid-template-columns: 20% auto 20%;
            grid-template-rows: 100%;
            grid-column-gap: 10px;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col s12">
            <div class="card grey darken-3" style="background: url('{!! $flight->arrapt->banner_url !!}'), url('https://i.imgur.com/qOXmrci.png');     background-repeat: no-repeat;
                    background-position: center;
                    background-size: cover;">
                <div style="position: absolute; height: 100%; width: 100%; background-color: rgba(25,25,25,.75);z-index: 0"></div>
                <div class="card-content" style="display: flex;justify-content: space-between;position: relative; z-index: 5;">
                    <div class="info-block">
                        <div class="info-block-title">Callsign</div>
                        <div class="info-block-item">{{ $flight->getCallsign() }}</div>
                    </div>
                    <div class="info-block">
                        <div class="info-block-title">Departure</div>
                        <div class="info-block-item">{{ $flight->depapt->icao }}</div>
                    </div>
                    <div class="info-block">
                        <div class="info-block-title">Arrival</div>
                        <div class="info-block-item">{{ $flight->arrapt->icao }}</div>
                    </div>
                    <div class="info-block">
                        <div class="info-block-title">Aircraft</div>
                        <div class="info-block-item">{{ $flight->aircraft->icao }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col m10 s12 offset-m1" style="display: flex;justify-content: space-between;position: relative; z-index: 5;">
            <a class="waves-effect waves-light btn"><i class="material-icons left">flight_takeoff</i>activate flight</a>
            @if(intval($flight->state) == 1 && Auth::user()->id == intval($flight->user_id))
                <a href="{{route('flightops.flights.manualfile', ['id' => $flight->id])}}" class="waves-effect waves-light btn brand b-red"><i class="material-icons left">save</i>close flight</a>
            @endif
            @if(intval($flight->state) == 0 && Auth::user()->id == intval($flight->user_id))
                <a href="{{route('flightops.flights.manualfile', ['id' => $flight->id])}}" onclick="event.preventDefault();
                        document.getElementById('delete-bid').submit();"
                   class="waves-effect waves-light btn brand b-red"><i class="material-icons left">cancel</i>Cancel Flight</a>
                <form id="delete-bid" method="POST" action="{{ route('flightops.flights.destroy', ['id' => $flight->id]) }}" accept-charset="UTF-8" hidden>
                    {{ csrf_field() }}
                    <input name="_method" type="hidden" value="DELETE">
                </form>
            @endif
            <input type="text" id="shareLink" value="{{ url('/share/'.$flight->id) }}" style="display: none;">
            <a class="waves-effect waves-light btn modal-trigger" href="#shareLinkModal" id="shareLinkButton"><i class="material-icons left">share</i>Generate Invite Link</a>
        </div>
    </div>
    <div id="shareLinkModal" class="modal">
        <div class="modal-content">
            <h4>Generate Share Link</h4>
            <p>{{ url('/share/'.$flight->id) }}</p>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Close</a>
        </div>
    </div>
    <div class="row">
        <div class="col m5 s12 offset-m1">
            <div class="card-offset-title">Flight Crew</div>
            <div class="card grey darken-2">
                <div class="card-content white-text" style="display: flex;justify-content: space-between;position: relative; z-index: 5; text-align: center; align-items: center;">
                    <div class="info-block">
                        <div class="circle" style="border: solid; border-color: white; width: 150px; height: 150px;background: url('{!! $flight->user->avatar_url !!}'), url('/img/VAOS_ICON.png') black no-repeat center; background-size: cover; margin: 0 auto;"></div>
                        <div style="position: relative; margin-top: auto; margin-bottom: auto; margin-right: 0;">
                            <div style="padding-left: 10px; color:white; font-size: 30px;">{{ $flight->user->first_name }} {{ $flight->user->last_name }}</div>
                            <div style="padding-left: 10px; color:#61C7FF;font-size: 28px;">Captain</div>
                        </div>
                    </div>
                    @if(!is_null($flight->fo))
                        <div class="info-block">
                            <div class="circle" style="border: solid; border-color: white; width: 150px; height: 150px;background: url('{!! $flight->fo->avatar_url !!}'), url('/img/VAOS_ICON.png') black no-repeat center; background-size: cover; margin: 0 auto;"></div>
                            <div style="position: relative; margin-top: auto; margin-bottom: auto; margin-right: 0;">
                                <div style="padding-left: 10px; color:white; font-size: 30px;">{{ $flight->fo->first_name }} {{ $flight->fo->last_name }}</div>
                                <div style="padding-left: 10px; color:#61C7FF;font-size: 28px;">First Officer</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col m5 s12">
            <div class="card-offset-title">Weather</div>
            <airport-wx icao="{{ $flight->depapt->icao }}"></airport-wx>
            <airport-wx icao="{{ $flight->arrapt->icao }}" taf></airport-wx>
        </div>
    </div>
    <div class="row">
        <div class="col m5 s12 offset-m1">
            <div class="card-offset-title">Files</div>
            <div class="card grey darken-2">
                <div class="card-content white-text">

                </div>
            </div>
        </div>
        <div class="col m5 s12">
            <div class="card-offset-title">Aircraft</div>
            <div class="card grey darken-2">
                <div class="card-content white-text">
                    <ul class="collection with-header">
                        <li class="collection-item"><div>Equipment Type<div class="secondary-content">{{ $flight->aircraft->icao }}</div></div></li>
                        <li class="collection-item"><div>Registration<div class="secondary-content">{{ $flight->aircraft->registration }}</div></div></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--
    <div class="row">
        <div class="col m10 s12 offset-m1">
            <div class="card-offset-title">Comments</div>
            <div class="card grey darken-2">
                <div class="card-content white-text">

                </div>
            </div>
        </div>
    </div> -->
@endsection
@section('js')
    <script>
        function copyShareLink() {
            let copyText = document.getElementById("shareLink");
            /* Select the text field */
            copyText.select();
            /* Copy the text inside the text field */
            document.execCommand("copy");
            $('#shareLinkButton').text('<i class="material-icons left">share</i>link copied');
        }
    </script>
@endsection