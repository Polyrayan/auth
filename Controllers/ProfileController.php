<?php

namespace App\Http\Controllers;

use App\Appartenir;
use App\Avis;
use App\Client;

use App\Panier;
use App\Reduction;
use App\Vendeur;
use Jenssegers\Date\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    public function show()
    {
        //return view('profiles.clientProfile');
        //var_dump(Auth::guard('client')->check());
        var_dump(auth('client')->check());

        $mail = Client::getMailClient();
        $client = Client::getClientWithMail($mail);
        $points = Reduction::getReductionPoints($mail);
        return view('profiles.myClientProfile')->with(['client'=>$client, 'points'=> $points]);
        // var_dump(\Auth::check());

        //return auth('client')->user();


        /*if (auth('client')->check()){
            return 'client';
            //return view('profiles.myClientProfile');
        }
        if(auth('seller')){
            return view('profiles.mySellerProfile');
        }
        else{
            return redirect('/login')->withInput()->withErrors([
                "mailSeller" => "veuilez vous connecter",
            ]);
        }
        */
    }


    public function idClient($id){
        $client = Client::getClientWithId($id);
        return view('profiles.clientProfile', ['client' => $client]);
    }

    public function purchaseClient($id)
    {
        $client = Client::getClientWithId($id);
        $commandes = Panier::getPurchaseOfThisMailClient($client->mailClient);
        return view('myPurchases', ['commandes' => $commandes, 'client' => $client]);
    }
    public function selectForm(Request $request)
    {
        // view myPurchases

        if ($request->has('rate')) {
            Avis::validateReview();
            Avis::createOrUpdateClientReviewOnThisProduct();
            return back();
        }

        // view myClientProfile

        elseif ($request->has('editClient')){
            Client::validateUpdate();
            Client::updateClient();
            return back();
        }
    }

    public function rating($mailClient,$productNumber,$mark,$comment){


         return back();
    }

    public function idVendeur($id){
        $seller = Vendeur::sellerWithThisId($id);
        $shops = Appartenir::shopsOfThisSeller($seller->mailVendeur);
        return view('profiles.sellerProfile', ['seller' => $seller, 'shops' => $shops]);
    }

}
