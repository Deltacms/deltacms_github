<?php
class init extends search {
    public static $defaultConfig_fr = [
        'previewLength'      => 100,
        'resultHideContent'  => false,
        'placeHolder'        => 'Un ou plusieurs mots-clés séparés par un espace ou par +',
        'submitText'         => 'Rechercher',
        'versionData'        => '3.1',
		'nearWordText'		 => 'Mots approchants',
		'successTitle'		 => 'Résultat de votre recherche',
		'failureTitle'		 => 'Aucun résultat',
		'commentFailureTitle' => 'Avez-vous pensé aux accents ?'
    ];
    public static $defaultConfig_en = [
        'previewLength'      => 100,
        'resultHideContent'  => false,
        'placeHolder'        => 'One or more keywords separated by a space or +',
        'submitText'         => 'Search',
        'versionData'        => '3.1',
		'nearWordText'		 => 'NearWord',
		'successTitle'		 => 'Result of your search',
		'failureTitle'		 => 'No results',
		'commentFailureTitle' => ''
    ];
    public static $defaultTheme = [
        'keywordColor'       => 'rgba(229, 229, 1, 1)'
    ];
}