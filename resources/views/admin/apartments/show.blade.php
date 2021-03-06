@extends('layouts.app')

@section('content')
<div class="container">
    @forelse ($apartment->sponsor_plans as $plan)
        @if ($plan->sponsorships->deadline > $now)
            <div class="card bg-success text-white mt-4">
                <div class="mt-3 mb-3 sponsor-plan text-center">
                    <h4 class="mb-3">Piano sponsorizzazione</h4>
                    <span class="p-2 pr-4 pl-4 rounded bg-light text-dark">{{$plan->name}}</span>
                    <p class="mt-4">Durata sponsorizzazione: {{$plan->hours}} ore</p>
                    <p class="text-warning">Termine della sponsorizzazione: {{$plan->sponsorships->deadline}}</p>
                </div>
            </div>
        @break
        @elseif ($loop->last)
            <div class="card bg-dark text-white mt-4">
                <div class="mt-3 mb-3 sponsor-plan text-center">
                    <h4 class="mb-3">Piano sponsorizzazione</h4>                
                    <p>Quest{{(substr($apartment->category->name, -1, 1) == 'o') ? 'o' : 'a'}} {{$apartment->category->name}} non è sponsorizzat{{(substr($apartment->category->name, -1, 1) == 'o') ? 'o' : 'a'}}!</p>
                    <a class="btn btn-sm btn-light" href="{{route('admin.apartments.sponsorship.pay', ['apartment' => $apartment])}}">Nuovo Sponsor</a>
                </div>
            </div>
        @endif
    @empty
        <div class="card bg-dark text-white mt-4">
            <div class="mt-3 mb-3 sponsor-plan text-center">
                <h4 class="mb-3">Piano sponsorizzazione</h4>
                <p>Quest{{(substr($apartment->category->name, -1, 1) == 'o') ? 'o' : 'a'}} {{$apartment->category->name}} non è sponsorizzat{{(substr($apartment->category->name, -1, 1) == 'o') ? 'o' : 'a'}}!</p>
                <a class="btn btn-sm btn-light" href="{{route('admin.apartments.sponsorship.pay', ['apartment' => $apartment])}}">Nuovo Sponsor</a>
            </div>
        </div>
    @endforelse
    {{-- MAIN DETAILS APPARTMENT --}}
    <div class="mt-4 details-apartment row">
        <div class="featured-img col-12 col-lg-6">
            <span class="badge badge-success position-absolute p-2 m-2">Immagine in primo piano</span>
            <img class="w-100 rounded-lg" style="height: 400px; object-fit: cover;" src="{{strpos($apartment->featured_img, '://') ? $apartment->featured_img : asset("/storage/" . $apartment->featured_img)}}" alt="{{$apartment->title}}">
        </div>
        <div class="col-12 col-lg-6">
            <h2 class="card-title">
                <strong>{{$apartment->title}}</strong>
            </h2>
            <p>{{$apartment->address}} ({{$apartment->city . ', ' . $apartment->province . ', ' . $apartment->region}})</p>
            <div class="d-flex align-items-center mb-4">
                <h5 class="mr-2"> {{$apartment->rooms_number}} <i class="fas fa-person-booth text-secondary"></i></h5>
                <h5 class="mr-2">{{$apartment->beds_number}} <i class="fas fa-bed text-secondary"></i></h5>
                <h5 class="mr-2">{{$apartment->bathrooms_number}} <i class="fas fa-bath text-secondary"></i></h5>
                <h5 class="mr-2">{{$apartment->square_meters}} m²</h5>
            </div>    
            <p class="card-text">{{$apartment->description}}</p>
            <div class="mt-4 services-apartment">
                <div class="mb-2">
                    <strong>Servizi disponibili</strong>
                </div>
                <div class="services-badge">
                    @forelse ($apartment->services as $service)
                        <span class="badge badge-pill badge-primary mb-2">{{$service->name}}</span>
                    @empty
                        <p>Non ci sono servizi aggiuntivi!</p>
                    @endforelse
                </div>
            </div>  
            {{-- BUTTONS EDIT, STATS, DELETE --}}
            <div class="mt-3 button-options">
                <a class="btn btn-sm btn-primary" href="{{route('admin.apartments.edit', $apartment->id)}}">Modifica</a>
                <a class="btn btn-sm btn-dark" href="{{ route('admin.apartments.stats.index', ['apartment' => $apartment ]) }}">Statistiche</a>
                <form class="d-inline" action="{{route('admin.apartments.destroy', $apartment->id)}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="submit" class="btn btn-sm btn-danger" value="Elimina">
                </form>
            </div>
        </div>
    </div>
    {{-- CAROUSEL MEDIA CONTENTS --}}
    <div class="media-apartment row align-items-baseline mt-4">
        <div class="col-12 col-lg-6">
                <div id="carousel" class="carousel carousel-fade" data-ride="carousel">
                    <ol class="carousel-indicators">
                        @foreach($apartment->media as $item)
                            <li data-target="#carousel" data-slide-to="{{$loop->index}}" class="{{$loop->first ? 'active' : ''}}"></li>
                        @endforeach
                    </ol>
                    <div class="carousel-inner rounded-lg bg-secondary" role="listbox" style="height: 300px;">
                        @foreach ($apartment->media as $item)
                            <div class="carousel-item {{$loop->first ? 'active' : ''}}">
                                <img src="{{strpos($item->path, '://') ? $item->path : asset("/storage/" . $item->path)}}" class="w-100" style="height: 300px; object-fit: cover;" alt="{{$item->caption}}">
                            </div>
                        @endforeach
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon bg-secondary rounded-circle" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon bg-secondary rounded-circle" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
        </div>
        {{-- MAP --}}
        <div class="mt-4 col-12 col-lg-6">
            <div id="show-map" class="rounded-lg" style="height: 300px"></div>
        </div> 
    </div>
    {{-- INFO REQUESTS --}}
    <div class="mt-4 info-requests">
        <h4>Richieste di informazioni:</h4>
        <div class="row">
            @forelse ($apartment->messages as $message)
                <div class="mb-4 col-12 col-lg-6 mb-4">
                    <h5>Ricevuta da: <a href="mailto:{{$message->email}}">{{$message->email}}</a></h5>
                    <small class="d-block mb-2">{{$message->created_at}}</small>
                    <h6><strong>{{$message->title}}</strong></h6>
                    <p>{{$message->body}}</p>
                    <a href="#" class="btn btn-sm btn-primary">Rispondi</a>
                </div>
            @empty
                <div class="mb-4 col-12 col-lg-6 mb-4">
                    <p>Non ci sono commenti!</p>
                </div>
            @endforelse
        </div>
    </div>
    {{-- REVIEWS --}}
    <div class="reviews">
        @if ($numvotes == 0)
            <div class="row">
                <div class="col-12 col-lg-6 mb-4">
                    <h4>({{$numvotes}} recensioni)</h4>
                    <p>Nessun ha ancora lasciato una recensione su questo alloggio</p>
                </div>
            </div>
        @else    
            <h4><i class="fas fa-star"></i>{{$average}}/5 ({{$numvotes}} {{$numvotes == 1 ? 'recensione' : 'recensioni'}})</h4>
        @endif
        <div class="row">
            @foreach ($apartment->reviews as $review)
                <div class="col-12 col-lg-6 mb-4">
                    <h5><strong>{{$review->first_name}} {{$review->last_name}}</strong></h5>
                    <small class="d-block mb-2">{{$review->created_at}}</small>    
                    <strong>{{$review->title}}</strong>
                    <p>{{$review->body}}</p>
                    <span class="review-rating">
                        <i class="fas fa-star"></i>
                        <strong>{{$review->rating}}/5</strong>
                    </span>
                </div>
            @endforeach    
        </div>
    </div>
</div>
{{-- MAP LAT AND LONG --}}
<input type="hidden" id="lat" value="{{$apartment->geo_lat}}">
<input type="hidden" id="lng" value="{{$apartment->geo_lng}}">
{{-- JS --}}
<script src="{{asset('js/map/map-show.js')}}"></script>
@endsection