@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">Opties</div>
                    <div class="panel-body">
                        <div class="sidebar">
                            <ul class="nav sidebar-nav">
                                <li class="{{ Request::is('categories') ? 'active' : '' }}">
                                    <a href="{{ route('categories') }}"><i class="fa fa-fw fa-folder"></i> Category </a>
                                </li>
                                <li class="{{ Request::is('conditions') ? 'active' : '' }}">
                                    <a href="{{ route('conditions') }}"><i class="fa fa-fw fa-folder"></i> Condition </a>
                                </li>
                                <li class="{{ Request::is('districts') ? 'active' : '' }}">
                                    <a href="{{ route('districts') }}"><i class="fa fa-fw fa-folder"></i> District </a>
                                </li>
                                <li class="{{ Request::is('currencies') ? 'active' : '' }}">
                                    <a href="{{ route('currencies') }}"><i class="fa fa-fw fa-folder"></i> Currency </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9 col-md-offset-0">
                @yield('subcontent')
            </div>
        </div>
    </div>
    <footer-component></footer-component>
@endsection
