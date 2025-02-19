<?php
$sliders = \App\Models\Slider::whereStatus(1)
    ->orderBy('order_position', 'asc')
    ->paginate(5);

?>
@if ($sliders->count() > 0)
    <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach ($sliders as $slider)
                <div class="carousel-item {{ $loop->index == 0 ? 'active' : '' }}">
                    <img src="{{ asset('Files/slider/' . $slider->image) }}" class="d-block"  alt="{{ $slider->title }}"
                        title="{{ $slider->title }}" />
                    <div class="carousel-caption d-none d-md-block">
                        <a href="{{ $slider->link ? $slider->link : "https://hamadalhajri.net" }}" class="titleCaption" target="_blank" title="{{ $slider->title }}">
                            {{ $slider->title }}
                        </a>
                    </div>

                </div>
            @endforeach
        </div>
        @if ($sliders->count() > 1)
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        @endif

    </div>
    @else
    <div class="sliderImgDefult">
        <img src="{{ asset('Files/settings/'. setting()->slider_image) }}" class="d-block"
        alt="{{ setting()->site_name }}" title="{{ setting()->site_name }}" />
    </div>
@endif

