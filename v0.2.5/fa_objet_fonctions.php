<?php

// http://programmer.spip.net/Recuperer-objet-et-id_objet
function balise_FA($p){
	// on prend nom de la cle primaire de l'objet pour calculer sa valeur
	$_id_objet = $p->boucles[$p->id_boucle]->primary;
	$id_objet = champ_sql($_id_objet, $p);
	$objet = $p->boucles[$p->id_boucle]->id_table;
	$p->code = "calculer_balise_FA('$objet', $id_objet)";
	return $p;
}
function calculer_balise_FA($objet,$id_objet){
	$objet = objet_type($objet);
	$row = sql_fetsel("fa_objet", "spip_fa_objet_liens", "objet=".sql_quote($objet)." AND id_objet=".intval($id_objet));
	$fa_objet = $row['fa_objet'];
	return $fa_objet;
}
