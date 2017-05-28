@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Rate update</div>

                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('rates.update', ['rate' => $rate->id]) }}">
                        <input type="hidden" name="_method" value="PUT">
                        {{ csrf_field() }}
                        
                        <div class="form-group{{ $errors->has('province') ? ' has-error' : '' }}">
                            <label for="province" class="col-md-4 control-label">For what province</label>

                            <div class="col-md-6">
                                <select name="province" class="form-control">
                                    <option value="ab" @if($rate->province == "ab") SELECTED @endif>Alberta</option>
                                    <option value="bc" @if($rate->province == "bc") SELECTED @endif>British-Coloumbia</option>
                                    <option value="mb" @if($rate->province == "mb") SELECTED @endif>Manitoba</option>
                                    <option value="nb" @if($rate->province == "nb") SELECTED @endif>New-Brunswick</option>
                                    <option value="nl" @if($rate->province == "nl") SELECTED @endif>Newfoundland and Labrador</option>
                                    <option value="nt" @if($rate->province == "nt") SELECTED @endif>Northwest Territories</option>
                                    <option value="ns" @if($rate->province == "ns") SELECTED @endif>Nova-Scotia</option>
                                    <option value="nu" @if($rate->province == "nu") SELECTED @endif>Nunavut</option>
                                    <option value="on" @if($rate->province == "on") SELECTED @endif>Ontario</option>
                                    <option value="pe" @if($rate->province == "pe") SELECTED @endif>Prince-Edward Island</option>
                                    <option value="qc" @if($rate->province == "qc") SELECTED @endif>Quebec</option>
                                    <option value="sk" @if($rate->province == "sk") SELECTED @endif>Saskatchewan</option>
                                    <option value="yt" @if($rate->province == "yt") SELECTED @endif>Yukon</option>
                                </select>

                                @if ($errors->has('province'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('province') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('start') ? ' has-error' : '' }}">
                            <label for="start" class="col-md-4 control-label">When does it start to apply?</label>

                            <div class="col-md-6">
                                <input id="start" type="start" class="form-control" name="start" value="{{ $rate->start }}" required autofocus>

                                @if ($errors->has('start'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('start') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('pst') ? ' has-error' : '' }}">
                            <label for="pst" class="col-md-4 control-label">PST rate</label>

                            <div class="col-md-6">
                                <input id="pst" type="pst" class="form-control" name="pst" value="{{ $rate->pst }}" autofocus>

                                @if ($errors->has('pst'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('pst') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('hst') ? ' has-error' : '' }}">
                            <label for="hst" class="col-md-4 control-label">HST rate</label>

                            <div class="col-md-6">
                                <input id="hst" type="hst" class="form-control" name="hst" value="{{ $rate->hst }}" autofocus>

                                @if ($errors->has('hst'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('hst') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('gst') ? ' has-error' : '' }}">
                            <label for="gst" class="col-md-4 control-label">GST rate</label>

                            <div class="col-md-6">
                                <input id="gst" type="gst" class="form-control" name="gst" value="{{ $rate->gst }}" autofocus>

                                @if ($errors->has('gst'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('gst') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('applicable') ? ' has-error' : '' }}">
                            <label for="applicable" class="col-md-4 control-label">What is the total applicable tax rate</label>

                            <div class="col-md-6">
                                <input id="applicable" type="applicable" class="form-control" name="applicable" value="{{ $rate->applicable }}" required autofocus>

                                @if ($errors->has('applicable'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('applicable') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                            <label for="type" class="col-md-4 control-label">What type is it?</label>

                            <div class="col-md-6">
                                <input id="type" type="type" class="form-control" name="type" value="{{ $rate->type }}" required autofocus>

                                @if ($errors->has('type'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('type') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('source') ? ' has-error' : '' }}">
                            <label for="source" class="col-md-4 control-label">What is the source of the information?</label>

                            <div class="col-md-6">
                                <input id="source" type="source" class="form-control" name="source" value="{{ $rate->source }}" required autofocus>

                                @if ($errors->has('source'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('source') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Update
                                </button>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
