<?php
if (!defined("_ECRIRE_INC_VERSION")) return;

function formulaires_fa_objet_charger_dist($objet,$id_objet,$fa_objet){
	// autorisation : #ENV{editable} est evite car on veut toujours voir le formulaire meme apres validation
	$editable = true;
	if ($GLOBALS['visiteur_session']['statut']!=='0minirezo')
		$editable = false;
	else {
		include_spip("inc/config");
		if (lire_config("fa_objet/bloquer")=="oui")
			$editable = false;
	}
	// chargement des valeurs du formulaire
	$valeurs = array(
		'objet' => $objet,
		'id_objet' => $id_objet,
		'fa_objet' => $fa_objet,
		'supprimer' => '',
		"editable" => $editable,
	);
	return $valeurs;
}

function formulaires_fa_objet_traiter_dist($objet,$id_objet,$fa_objet){
	if (_request('supprimer')){
		// requête sql dans spip_fa_objet_liens pour supprimer la ligne où #ID_OBJET = $id_objet et #OBJET = $objet
		sql_delete("spip_fa_objet_liens", "id_objet=".intval($id_objet)." AND objet=".sql_quote($objet));
		set_request('fa_objet','');
	}
	else {
		$fa_objet = _request('fa_objet');
		$where =  "objet=".sql_quote($objet)." AND id_objet=".intval($id_objet);
		// si la ligne $id_objet / $objet existe dans la table spip_fa_objet_liens alors on fait sql_updateq
		if (sql_countsel('spip_fa_objet_liens', array(
			"objet=" . sql_quote($objet),
			"id_objet=" . sql_quote($id_objet)
		))) {
			sql_updateq('spip_fa_objet_liens', array('fa_objet' => $fa_objet), $where);
		}else{
			// si la ligne $id_objet / $objet n'existe pas dans la table spip_fa_objet_liens alors on fait sql_insertq
			sql_insertq('spip_fa_objet_liens', array('id_objet' => $id_objet, 'objet' => $objet, 'fa_objet' => $fa_objet));
		}
	}
}