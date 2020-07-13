@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Homepage</h1>

        {{-- Address----------------------------------------------------------------------------- --}}
        <div class="form-group mb-5">
            <label for="search">Indirizzo</label>
            <input type="search" id="search" class="form-control" placeholder="Inserisci l'indirizzo" name="address" value="{{ old('address', 'Piazza di Spagna, 1, Roma, Italia') }}" />
        </div>

        {{-- apartments --}}
        <h2 class="mb-5">Lista appartamenti</h2>
        <div class="apartments-list d-flex flex-wrap justify-content-between" >
            @foreach ( $apartments as $apartment )
                <div class="card mb-5" style="width: 22rem;">
                    <img class="card-img-top" src="{{ $apartment->featured_img }}" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">{{ $apartment->title }}</h5>
                        <h6 class="card-title">{{ $apartment->city . ', ' . $apartment->region . ', ' . $apartment->province }}</h6>
                        <p class="card-text">{{ $apartment->description }}</p>
                        <p>
                            @forelse ($apartment->services as $service)
                                <span class="badge badge-pill badge-secondary">{{ $service->name }}</span>
                            @empty
                                <span class="badge badge-pill badge-warning">No Service</span>
                            @endforelse
                        </p>
                        <a class="btn btn-primary" href="{{ route('apartments.show', $apartment->id)}}">Show</a>
                    </div>
                </div>
            @endforeach

        </div>

        <div class="wrap-pagination mt-5 d-flex justify-content-center">
            {{ $apartments->links() }}
        </div>
    </div>
@endsection