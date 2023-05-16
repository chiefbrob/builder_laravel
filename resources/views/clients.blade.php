@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Clients') }}</div>

                <div class="card-body">
                    <div>
                        <p>Here are a list of your clients:</p>
                        @foreach($clients as $client)
                            <div class="py-3 text-gray-900">
                                {{ $client}}
                                <h3 class="text-lg text-gray-500">{{ $client->personal_access_client }}</h3>
                                <p><b> ID:</b>{{ $client->id }}</p>
                                <p><b> Personal Access:</b>{{ $client->personal_access_client ? 'true' : 'false' }}</p>
                                <p><b> Redirect: </b>{{ $client->redirect  }}</p>
                                <p><b> Secret: </b>{{ $client->secret }}</p>
                                <p><b> Revoked: </b>{{ $client->revoked ? 'true' : 'false' }}</p>

                                <p><b> Created: </b>{{ $client->created_at->diffForHumans() }}</p>
                                <p><b> Updated: </b>{{ $client->updated_at->diffForHumans() }}</p>

                            </div>
                        @endforeach
                    </div>

                    <div class="mt-3 p-6 bg-white border-b border-gray-200">
                        <form action="/oauth/clients" method="POST">
                            <div>
                                <label for="name">Name</label>
                                <input type="text" name="name" placeholder="Client Name" />
                            </div>
                            <div class="mt-2">
                                <label for="redirect">Redirect</label>
                                <input type="text" name="redirect" placeholder="https://my-url.com/callback" />
                            </div>
                            <div class="mt-3">
                                @csrf
                                <button type="submit">Create Client</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
