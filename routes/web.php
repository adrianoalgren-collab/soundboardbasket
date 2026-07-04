<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $sounds = [
        ['file' => 'buzzer.mp3',        'label' => 'Buzzer',          'desc' => 'Akhir kuarter / pertandingan'],
        ['file' => 'whistle.mp3',       'label' => 'Whistle',         'desc' => 'Peluit wasit, ada pelanggaran'],
        ['file' => 'swish.mp3',         'label' => 'Swish',           'desc' => 'Bola masuk mulus tanpa nyentuh ring'],
        ['file' => 'dunk.mp3',          'label' => 'Slam Dunk',       'desc' => 'Dunk keras, penuh power'],
        ['file' => 'crowd-cheer.mp3',   'label' => 'Crowd Cheer',     'desc' => 'Penonton sorak-sorai senang'],
        ['file' => 'crowd-boo.mp3',     'label' => 'Crowd Boo',       'desc' => 'Penonton kecewa / boo'],
        ['file' => 'ball-bounce.mp3',   'label' => 'Ball Bounce',     'desc' => 'Suara dribble bola di lantai'],
        ['file' => 'air-ball.mp3',      'label' => 'Air Ball',        'desc' => 'Tembakan meleset total'],
        ['file' => 'buzzer-beater.mp3', 'label' => 'Buzzer Beater',   'desc' => 'Tembakan dramatis penutup game'],
        ['file' => 'and-one.mp3',       'label' => 'And One',         'desc' => 'Foul + bola tetap masuk, bonus 1 free throw'],
    ];

    return view('soundboard', compact('sounds'));
});
