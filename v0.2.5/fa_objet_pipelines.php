<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

function fa_objet_header_prive($flux) {
	return $flux.'<link rel="stylesheet" type="text/css" media="all" href="'.find_in_path('lib/fontawesome/css/font-awesome.css').'" />
    
    <link rel="stylesheet" type="text/css" media="all" href="'.find_in_path('css/icone_objet.css').'" />
    ';

}

function fa_objet_affiche_droite($flux){

	$e     = trouver_objet_exec($flux['args']['exec']);
	$table_objet_sql = $e['table_objet_sql'];
	$objets_config = lire_config('fa_objet/objets',array());
	if (
		in_array($table_objet_sql,$objets_config) // si configuration objets ok
		AND $e !== false // page d'un objet éditorial
		AND $e['edition'] === false // pas en mode édition
		AND $id_objet=$flux['args'][$e['id_table_objet']]
	){
		$objet = $e['type'];
		$row = sql_fetsel("fa_objet", "spip_fa_objet_liens", "objet=".sql_quote($objet)." AND id_objet=".intval($id_objet));
		$fa_objet = $row['fa_objet'];
		$contexte = array('objet' => $objet, 'id_objet' => $id_objet, 'fa_objet' => $fa_objet);
		$flux["data"] .= recuperer_fond("inclure/fa_objet", $contexte);
	}
	return $flux;
}


function fa_objet_insert_head_css($flux) {
	   return $flux.'<link rel="stylesheet" type="text/css" media="all" href="'.find_in_path('lib/fontawesome/css/font-awesome.css').'" />';

	    return $flux;
}
	
function fa_objet_jqueryui_plugins($scripts){
   $scripts[] = "jquery.ui.selectmenu";
   return $scripts;
} 