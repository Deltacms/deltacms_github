<?php
class init extends news {
    public static $defaultData = [
        'feeds'              => false,
        'feedsLabel'         => '',
        'itemsperPage'       => 8,
        'itemsperCol'        => 12,
        'height'             => -1,
        'versionData'        => self::VERSION,
		'hiddeTitle'		=> false,
		'hideMedia'			=> false,
		'sameHeight'		=> false,
		'noMargin'			=> true
    ];

    public static $defaultTheme = [
        'style'               => '',
        'borderColor'         => 'rgba(33, 34, 35, 1)',
        'backgroundColor'     => 'rgba(255, 255, 255, 1)',
        'borderWidth'          => '0',
		'borderRadius'		=> '0px',
		'borderShadows'		=> '0px 0px 0px'
    ];

}