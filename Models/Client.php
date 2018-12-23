<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Client extends Authenticatable
{
    use Notifiable;
    protected $guard = 'client';

    protected $fillable = ['mailClient','nomClient','prenomClient','telClient',
                         'mdpClient','sexeClient','dateNaissanceClient',
                         'adresseClient','codePostalClient','villeClient','idClient'];

    public $timestamps = false; // pour ne pas avoir de colonne supplementaire (updated_at)
    protected $primaryKey ='mailClient';
    protected $keyType = 'string';
    protected $table ='clients';
    public $incrementing = false;


    /**
     * Get the password for the seller.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->mdpClient;
    }


    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return $this->mailClient;
    }

    public static function getMailClient(){
        return "r@g.com";
    }

    public static function getIdClient(){
        return "2";
    }

    public static function validateFormClient(){
        request()->validate([
            'mail' => ['bail','required','email'],
            'password' => ['bail','required','confirmed','min:6'],
            'password_confirmation' => ['required'],
            'name' => ['bail','required','string'],
            'firstName' => ['bail','required','string'],
            'address' => ['bail','required','string'],
            'city' => ['bail','required','string'],
            'postalCode' => ['bail','required','numeric'],
            'phone' => ['bail','required','numeric'],
            'gender' => ['bail','required','string'],
            'birthday' => ['bail','required','before:now'],
        ]);
    }

    public static function validateUpdate(){
        request()->validate([
            'name' => ['bail','required','string'],
            'firstName' => ['bail','required','string'],
            'phone' => ['bail','required','numeric'],
            'address' => ['bail','required','string'],
            'city' => ['bail','required','string'],
            'zipCode' => ['bail','required','numeric'],
        ]);
    }

    public static function createClient(){
        return self::create([
            'mailClient' => request('mail'),
            'mdpClient' => bcrypt(request('password')),
            'nomClient' => request('name'),
            'prenomClient' => request('firstName'),
            'adresseClient' => request('address'),
            'villeClient' => request('city'),
            'telClient' => request('phone'),
            'codePostalClient' => request('postalCode'),
            'sexeClient' => request('gender'),
            'dateNaissanceClient' => request('birthday'),
        ]);
    }

    public static function updateClient(){
        self::where('mailClient',request('mail'))
            ->update(['nomClient'=> request('name') ,
                'prenomClient'=> request('firstName'),
                'telClient' => request('phone'),
                'adresseClient' => request('address') ,
                'villeClient' => request('city'),
                'codePostalClient' => request('zipCode')
            ]);
    }

    public static function getMyAddress(){
        $client = self::where('mailClient',self::getMailClient())->firstOrFail();
        return "$client->adresseClient , $client->villeClient ";
    }

    public static function getClientWithMail($mail){
        return self::where('mailClient',$mail)->firstOrFail();
    }

    public static function getClientWithId($id){
        return self::where('idClient',$id)->firstOrFail();
    }

}