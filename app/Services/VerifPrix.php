<?php

namespace App\Services;

use App\Models\HistoriquePrixProduits;
use App\Notifications\NotificationAlertePrix;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

class VerifPrix 
{
    public function verificationPrix($produitsConcurrents)
    {
        $alerte = [];
        foreach ($produitsConcurrents as $produitConcurrent) {
            
            // Récupération de la relation produitConcurrent => Produit
            $produit = $produitConcurrent->produit;
            // Récupération des information de base, optionnel
            $referenceProduit = $produit->designation;
            $prixMinimumProduit = $produit->m_pvp;
    
            $concurrent = $produitConcurrent->concurrent->nom;
    
            // Récupération des infos pour recomposer le liens
            $lienProduit = "{$produitConcurrent->concurrent->url}{$produitConcurrent->categorieUrlConcurrent->url_complement}{$produitConcurrent->url_produit}";
            
            if($produitConcurrent->is_below_srp){
                
                $prix_veille = HistoriquePrixProduits::where('produit_concurrent_id', $produitConcurrent->id)
                    ->whereDate('created_at', Carbon::yesterday())
                    ->first();

                if($produitConcurrent->prix_concurrent > $produit->m_pvp){
                    $produitConcurrent->is_below_srp = false;
                    $produitConcurrent->save();
                    $alerte[] = [
                        "produit" => $referenceProduit,
                        "texte" => "A retrouvé un prix au dessus du seuil minimal.",
                        "prix" => $produitConcurrent->prix_concurrent,
                    ];
                }

                if($prix_veille && $produitConcurrent->prix_concurrent == $prix_veille->prix){
                    continue;
                }
            }

            // Ici pour peu que nous n'ayons pas mis en place le prix minimum je prefere laisser cette sécurité 
            // if( && $produitConcurrent->prix_concurrent < $prixMinimumProduit && $prixMinimumProduit !== 0)
            if(!$produitConcurrent->is_below_srp && $produitConcurrent->prix_concurrent < $prixMinimumProduit && $prixMinimumProduit !== 0){
                $alerte[] = [
                    "produit" => $referenceProduit,
                    "prix-minimum" => $prixMinimumProduit,
                    "texte" => " est passé en dessous du seuil minimum, chez le concurrent: {$concurrent}.( une vérification visuelle est nécéssaire )",
                    "lien" => $lienProduit,
                    "prix" => $produitConcurrent->prix_concurrent,
                ];
                $produitConcurrent->is_below_srp = true;
                $produitConcurrent->save();
            }
        }

        if(!empty($alerte)){
            $this->envoiEmail($alerte);
        }
        return $alerte;
    }

    public function envoiEmail($alertes){
        $emails = explode(',', env('MAIL_RECIPIENT'));

        foreach ($emails as $email){
            Notification::route('mail', trim($email))
                ->notify(new NotificationAlertePrix($alertes));
        }
        
    }
}