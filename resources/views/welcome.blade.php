@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <el-carousel :interval="8000" arrow="always" height="250px">
                            <el-carousel-item>
                                <img src="{{asset('images/banner_ad_1.png')}}">
                            </el-carousel-item>
                            <el-carousel-item>
                                <img src="{{asset('images/banner_ad_2.jpg')}}">
                            </el-carousel-item>
                        </el-carousel>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
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
                    <div class="col-md-3 col-md-offset-0">
                        <div class="panel panel-default">
                            <div class="panel-heading">Product</div>
                            <div class="panel-body">
                                <el-button type="primary">Hello</el-button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-md-offset-0">
                        <div class="panel panel-default">
                            <div class="panel-heading">Product</div>
                            <div class="panel-body">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-md-offset-0">
                        <div class="panel panel-default">
                            <div class="panel-heading">Product</div>
                            <div class="panel-body">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-md-offset-0">
                        <div class="panel panel-default">
                            <div class="panel-heading">Product</div>
                            <div class="panel-body">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-md-offset-0">
                        <div class="panel panel-default">
                            <div class="panel-heading">Product</div>

                            <div class="panel-body">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-md-offset-0">
                        <div class="panel panel-default">
                            <div class="panel-heading">Product</div>

                            <div class="panel-body">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-md-offset-0">
                        <div class="panel panel-default">
                            <div class="panel-heading">Product</div>

                            <div class="panel-body">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-md-offset-0">
                        <div class="panel panel-default">
                            <div class="panel-heading">Product</div>

                            <div class="panel-body">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-md-offset-0">
                        <div class="panel panel-default">
                            <div class="panel-heading">Product</div>

                            <div class="panel-body">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-md-offset-0">
                        <div class="panel panel-default">
                            <div class="panel-heading">Product</div>

                            <div class="panel-body">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-md-offset-0">
                        <div class="panel panel-default">
                            <div class="panel-heading">Product</div>

                            <div class="panel-body">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-md-offset-0">
                        <div class="panel panel-default">
                            <div class="panel-heading">Product</div>

                            <div class="panel-body">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-md-offset-0">
                        <div class="panel panel-default">
                            <div class="panel-heading">Product</div>

                            <div class="panel-body">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-md-offset-0">
                        <div class="panel panel-default">
                            <div class="panel-heading">Product</div>

                            <div class="panel-body">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-md-offset-0">
                        <div class="panel panel-default">
                            <div class="panel-heading">Product</div>

                            <div class="panel-body">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-md-offset-0">
                        <div class="panel panel-default">
                            <div class="panel-heading">Product</div>

                            <div class="panel-body">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <img src="{{asset('images/ad_small_1.png')}}" class="ad_small_1">
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <img src="{{asset('images/ad_small_2.jpg')}}" class="ad_small_2">
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <img src="{{asset('images/ad_small_3.jpg')}}" class="ad_small_3">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer-component></footer-component>
@endsection
