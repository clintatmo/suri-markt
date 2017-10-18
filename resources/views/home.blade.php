@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading">Banner</div>
                    <div class="panel-body">
                        <img src="{{asset('assets/images/banner-ad-1.png')}}">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Opties</div>
                    <div class="panel-body">
                        <div class="sidebar">
                            <ul class="nav sidebar-nav">
                                <li>
                                    <a href="#"><i class="fa fa-fw fa-home"></i> Mijn karretje </a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-fw fa-home"></i> Mijn webshop </a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-fw fa-folder"></i> Mijn advertenties </a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-fw fa-folder"></i> Mijn account </a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-fw fa-folder"></i> Category </a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-fw fa-folder"></i> Districten </a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-fw fa-folder"></i> Status </a>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Categorie</div>
                    <div class="panel-body">
                        <div class="sidebar">
                            <ul class="nav sidebar-nav">
                                <li>
                                    <a href="#"><i class="fa fa-fw fa-home"></i> Automarkt</a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-fw fa-folder"></i> Eten</a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-fw fa-file-o"></i> Klussen</a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-fw fa-cog"></i> Percelen</a>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-md-offset-0">
                <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}

                    <div class="input-group">
                        <input id="email" type="email" placeholder="Zoeken..." class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="button">Zoeken!</button>
                        </span>
                    </div>
                </form>
                <br/>
                <div class="row">
                    <category></category>
                </div>
                <div class="row">
                    <condition></condition>
                </div>
                <div class="row">
                    <district></district>
                </div>
                <div class="row">
                    <currency></currency>
                </div>
                <div class="row">
                    <task></task>
                </div>
            </div>
            <div class="col-md-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Ad</div>
                    <div class="panel-body">
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Ad</div>
                    <div class="panel-body">
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Ad</div>
                    <div class="panel-body">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer-component></footer-component>
@endsection
