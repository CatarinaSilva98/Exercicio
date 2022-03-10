@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Faça uma publicação') }}</div>
                    <div class="card-body">
                        <form action="{{route('mensagem.store')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="mensagem">
                                    <textarea rows="4" cols="80" name="mensagem" id="mensagem"> </textarea>
                                </label>
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Publicar') }}
                                </button>
                                @if (session('erro'))
                                    <div class="alert alert-danger">
                                        {{ session('erro') }}
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>
                    <div class="card">
                        <div class="card-header">{{ __('Publicações') }}</div>
                        <div class="card-body">
                            <ul class="list-group">
                                @forelse($notifications as $notification)
                                    <li class="list-group-item my-2">
                                        @foreach($users as $user)
                                            @if($notification->id_user == $user->id)
                                                <h5>{{$user->name}}: {{$notification->content}}</h5>
                                            @endif
                                        @endforeach
                                        <h7> Publicado a: {{$notification->created_at}}</h7>
                                        @if($notification->id_user == Auth::User()->getAuthIdentifier())
                                            <div class="row justify-content-center">
                                                <form method="POST"
                                                      action="{{route('mensagem.destroy',$notification->id)}}">
                                                    <input type="submit" class="btn btn-danger" value="Apagar" />
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                @php $i=0;
                                                $j=0; @endphp
                                                @foreach($notifications as $not)
                                                    @if($not->id_user == $notification->id_user && $not->id < $notification->id)
                                                        @php $i++; @endphp
                                                    @endif
                                                    @if($not->id_user == $notification->id_user && $not->id > $notification->id)
                                                        @php $j++; @endphp
                                                    @endif
                                                @endforeach
                                                @if($i>0)
                                                    <form id="up"
                                                          action="{{route('mensagem.up',$notification->id)}}">
                                                        <button class="btn btn-primary">
                                                            <i class="icon-user icon-white"></i>/\
                                                        </button>
                                                    </form>
                                                @endif
                                                @if($j>0)
                                                    <form id="down"
                                                          action="{{route('mensagem.down',$notification->id)}}">
                                                        <button class="btn btn-primary">
                                                            <i class="icon-user icon-white"></i>\/
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                                <form method="POST" id="delete-form"
                                                      action="{{route('mensagem.destroy',$notification->id)}}">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                        @endif
                                    </li>
                                @empty
                                    <div class="alert alert-danger" role="alert">
                                        Nenhuma notificação encontrada!
                                    </div>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
