<?php
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);
$rootDomain = $data['rootDomain'] ?? '';
$links = $data['links'] ?? [];
$result = [];

foreach ($links as $item) {
	$type = $item['type'] ?? '';
    $url = $item['url'] ?? '';
    $text = $item['text'] ?? $url;
	$source = $item['source'] ?? '';
	$naturalHeight = $item['naturalHeight'] ?? '';
	$naturalWidth = $item['naturalWidth'] ?? '';
	$external = true;
	// Liens externes ou internes
    $urlHost = parse_url($url, PHP_URL_HOST);
    if (!$urlHost) {
        // URL relative
        $external = false;
    } else {
		$urlHost = strtolower($urlHost);
		// comparaison avec le root domain du site
		$external = !($urlHost === $rootDomain || str_ends_with($urlHost, '.' . $rootDomain));
	}
	// Script inline
    if ($type === 'script-inline') {
		$result[] = [
		'type'	=> $type,
        'url'   => $url,
        'text'  => $text,
		'source' => $source,
		'external' => $external,
        'code'  => '200',
		'final_url'     => '',
		'content_type'  => '',
		'size'          => ''
		];
        continue;
    }	
    // Ressources sans URL exploitable
    if (
        !$url ||
        strpos($url, 'mailto:') === 0 ||
        strpos($url, 'javascript:') === 0 ||
        strpos($url, '#') === 0
    ) {
        continue;
    }
	// Image, vidéo intégrées
	if (strpos($url, 'data:') === 0 || strpos($url, 'blob:') === 0){
		$result[] = [
			'type'          => $type,
			'url'           => $url,
			'text'          => $text,
			'external'      => false,
			'naturalHeight' => $naturalHeight,
			'naturalWidth'  => $naturalWidth,
			'code'          => '',
			'final_url'     => '',
			'content_type'  => '',
			'size'          => ''
		];
		continue;
	}
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_USERAGENT => ('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36')
    ]);
    curl_exec($ch);
    $result[] = [
		'type'	=> $type,
        'url'   => $url,
        'text'  => $text,
		'external' => $external,
		'naturalHeight' => $naturalHeight,
		'naturalWidth' => $naturalWidth,
        'code'  => curl_getinfo($ch, CURLINFO_HTTP_CODE),
		'final_url'     => curl_getinfo($ch, CURLINFO_EFFECTIVE_URL),
		'content_type'  => curl_getinfo($ch, CURLINFO_CONTENT_TYPE),
		'size'          => curl_getinfo($ch, CURLINFO_SIZE_DOWNLOAD)
    ];
    curl_close($ch);
}
echo json_encode($result);
?>
