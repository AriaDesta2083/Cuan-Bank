<?php

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\Storage;
use Melihovv\Base64ImageDecoder\Base64ImageDecoder;

function getUser($param)
{
    $user = User::where('id', $param)
        ->orWhere('email', $param)
        ->orWhere('username', $param)
        ->first();

    $wallet = Wallet::where('user_id', $user->id)->first();
    $user->profile_picture = $user->profile_picture ?
        url('storage/proile/' . $user->profile_picture) : "";
    $user->ktp = $user->ktp ?
        url('storage/ktp/' . $user->ktp) : "";
    $user->balance = $wallet->balance;
    $user->card_number = $wallet->card_number;
    $user->pin = $wallet->pin;

    return $user;
}

function uploadImgBase64($img64, $nameImg, $folder)
{
    $decoder = new Base64ImageDecoder($img64, ['jpeg', 'png', 'jpg']);
    $content = $decoder->getDecodedContent();
    $format = $decoder->getFormat();
    $img =  $folder . '_' . $nameImg . '.' . $format;
    Storage::disk('public')->put($folder . '/' . $img, $content);

    return $img;
}

function pinChecker($pin)
{
    $userId = auth()->user()->id;
    $wallet =    Wallet::where('user_id', $userId)->first();
    if ($wallet == null) return false;
    if ($wallet->pin == $pin) return true;
    return false;
}
