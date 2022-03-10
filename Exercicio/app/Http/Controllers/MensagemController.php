<?php

namespace App\Http\Controllers;

use App\Models\Notifications;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MensagemController extends Controller{

    /**
     * Store a newly created resource in storage
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $mensagem = new Notifications();
        $mensagem->id_user = Auth::User()->getAuthIdentifier();
        $mensagem->content = $request->mensagem;
        if ($request->mensagem == null) {
            return redirect()->route('home')->with('erro', 'Por favor, escreva algo.');
        }
        $mensagem->save(); // save it to the database.
        return redirect()->route('home');
    }

    /**
     * Delete the specified resource from the storage
     *
     * @param int $idNotification
     * @return \Illuminate\Http\Response
     */
    public function destroy($idNotification)
    {
        $mensagem = Notifications::findOrFail($idNotification);
        $mensagem->delete();
        //Redirect to a specified route
        return redirect()->route('home');
    }

    /**
     * Troca a posicão da notificação escolhida para cima
     *
     * @param int $idNotification
     * @return \Illuminate\Http\Response
     */
    public function up($idNotification)
    {
        $mensagem = Notifications::findOrFail($idNotification);
        $notifications = Notifications::all();
        $up = 0;
        foreach ($notifications as $notification){
            if($notification->id_user == $mensagem->id_user && $notification->id < $mensagem->id && $notification->id > $up){
                $up = $notification->id;
            }
        }
        $mensagem_up = Notifications::findOrFail($up);
        $mensagem_up->id = 0;
        $mensagem->id = $up;
        $mensagem_up->save();
        $mensagem->save();
        $mensagem_up->id = $idNotification;
        $mensagem_up->save();
        //Redirect to a specified route
        return redirect()->route('home');
    }

    /**
     * Troca a posicão da notificação escolhida para baixo
     *
     * @param int $idNotification
     * @return \Illuminate\Http\Response
     */
    public function down($idNotification)
    {
        $mensagem = Notifications::findOrFail($idNotification);
        $notifications = Notifications::all();
        $down = 100000;
        foreach ($notifications as $notification){
            if($notification->id_user == $mensagem->id_user && $notification->id > $mensagem->id && $notification->id < $down){
                $down = $notification->id;
            }
        }
        $mensagem_down = Notifications::findOrFail($down);
        $mensagem_down->id = 0;
        $mensagem->id = $down;
        $mensagem_down->save();
        $mensagem->save();
        $mensagem_down->id = $idNotification;
        $mensagem_down->save();
        //Redirect to a specified route
        return redirect()->route('home');
    }
}
