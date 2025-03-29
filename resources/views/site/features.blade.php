@extends("site.app")
@section("title")
    Features - {{ $setting->main_name }}
@endsection

@section("content")
    <section id="features">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="container">

                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h1 class="section-heading" style="color:#000">Features</h1>
                        <hr class="primary">
                    </div>
                </div>


                @foreach($features as $feature)
                    @if($loop->index%2 == 0)
                        <div class="row">

                            <div class="col-md-6">
                                <div class="">
                                    <h2>{{ $feature->title}}</h2>

                                    <p>{{ $feature->description }}</p>
                                </div>
                            </div>

                            <div class="col-md-6 text-center">
                                <div class="img-feature">
                                    <img
                                            src="{{  $feature->image_url   }}"
                                            class="img-responsive" alt="">
                                </div>
                            </div>


                        </div>
                        <span class="separator"></span>
                    @else
                        <div class="row">

                            <div class="col-md-6 text-center">
                                <div class="img-feature">
                                    <img
                                            src="{{  $feature->image_url   }}"
                                            class="img-responsive" alt="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="">
                                    <h2>{{ $feature->title}}</h2>

                                    <p>{{ $feature->description }}</p>
                                </div>
                            </div>


                        </div>
                        <span class="separator"></span>
                    @endif
                @endforeach

            </div>

        </div>

        <div class="clearfix"></div>
    </section>
@endsection

