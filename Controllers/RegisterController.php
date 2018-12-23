<?php

namespace App\Http\Controllers;

use App\Appartenir;
use App\Client;
use App\Commerce;
use App\Ouvrir;
use App\Reduction;
use App\Vendeur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Jenssegers\Date\Date;

class RegisterController extends Controller
{
    /**
    * return the form to register the client/Seller
    */
    public function showForm()
    {
        return view('registration.registerForms');
    }

    /**
     * return the optional seller form to join or create his store
     */
    public function showOptionalForm()
    {
        if( session('seller'))
           $seller = session('seller');
            return view('registration.optionalSellerForm')->with(['seller' => $seller]);
    }
    /**
     * données : choix du type d'utilisateur
     *
     * resultat : redirige selon le choix
     */

    public function findChoice(Request $request)
    {
        if ($request->has('submitClient')){
            return $this->applyClientForm();

        }elseif ($request->has('submitSeller')){
            return $this->applySellerForm();

        }elseif ($request->has('joinStore')) {
            return $this->applyJoinForm();

        }elseif ($request->has('addStore')){
            return $this->applyAddForm();
        }
    }

    /**
     * check if there are no errors in the form if the form is ok the client
     * is saved in the Database then we give a success view for the new client
     */

    public function applyClientForm()
    {
        Client::validateFormClient();
        Client::createClient();
        Reduction::createClientReduction(request('mail'));
        return redirect('/');
    }

    /**
     * check if there are no errors in the form if the form is ok the seller is saved in
     * the Database then we give a optional view to add or join a Store for the new seller
     */

    public function applySellerForm()
    {
        Vendeur::validateFormSeller();
        Vendeur::createSeller();
        $seller = Vendeur::sellerWithThisMail(request('mailSeller'));
        return redirect('register/optionalForm')->with(['seller' => $seller]);
    }

    public function applyJoinForm()
    {
        Appartenir::validateFormAppartenir();
        $match = Commerce::matchSiretAndCode(request('numSiret'),request('joinCode'));
        if($match->count()>0)
        {
            Appartenir::createAppartenir(request('numSiret'), request('sellerMail'));
            return redirect('vendeur/commerces');
        }
            return back()->withErrors(["le numero SIRET et/ou le code est incorrect"]);
    }

    public function applyAddForm()
    {
        Commerce::validateFormShop(); // todo : add the cssfile here and create a function to create products in this file
        Commerce::createShop();
        Appartenir::createAppartenir(request('numSiret'), request('sellerMail'));
        return redirect('/vendeur/commerces');
    }
}