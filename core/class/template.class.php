<?php

class template {

    /**
    * Crée un bouton
    * @param string $nameId Nom et id du champ
    * @param array $attributes Attributs ($key => $value)
    * @return string
    */
    public static function button($nameId, array $attributes = []) {
        // Attributs par défaut
        $attributes = array_merge([
            'class' => '',
            'disabled' => false,
            'href' => 'javascript:void(0);',
            'ico' => '',
            'id' => $nameId,
            'name' => $nameId,
            'target' => '',
            'uniqueSubmission' => false,
            'value' => 'Bouton'
        ], $attributes);
        // Retourne le html
        return  sprintf(
            '<a %s class="button %s %s %s">%s</a>',
            helper::sprintAttributes($attributes, ['class', 'disabled', 'ico', 'value']),
            $attributes['disabled'] ? 'disabled' : '',
            $attributes['class'],
            $attributes['uniqueSubmission'] ? 'uniqueSubmission' : '',
            ($attributes['ico'] ? template::ico($attributes['ico'], 'right') : '') . $attributes['value']
        );
    }

   /**
    * Crée un champ captcha
    * @param string $nameId Nom et id du champ
    * @return string
    */
    public static function captcha($nameId, $classWrapper) {

		$html = '<div id="' . $nameId . 'Wrapper" class="captcha inputWrapper ' . $classWrapper. '">';
		$html .= '<img src="core/vendor/captcha/captcha.php" alt="Captcha" id="captcha">';
		$html .= '<input name="codeCaptcha" type="text" size="9" style="position:relative;top:-40px;left:-10px;">';
		$html .= '<img src="core/vendor/captcha/reload.png" alt="" style="cursor:pointer;position:relative;top:-30px;left:10px;width:24px;height:auto;"';
		$html .= ' onclick="document.images.captcha.src=\'core/vendor/captcha/captcha.php?id=\'+Math.round(Math.random(0)*1000)">';
		$html .= '</div>';

        // Retourne le html
        return $html;
    }

    /**
    * Crée une case à cocher à sélection multiple
    * @param string $nameId Nom et id du champ
    * @param string $value Valeur de la case à cocher
    * @param string $label Label de la case à cocher
    * @param array $attributes Attributs ($key => $value)
    * @return string
    */
    public static function checkbox($nameId, $value, $label, array $attributes = []) {
        // Attributs par défaut
        $attributes = array_merge([
            'before' => true,
            'checked' => '',
            'class' => '',
            'classWrapper' => '',
            'disabled' => false,
            'help' => '',
            'id' => $nameId,
            'name' => $nameId,
			'required' => false
        ], $attributes);

        // Sauvegarde des données en cas d'erreur
        if($attributes['before'] AND array_key_exists($attributes['id'], common::$inputBefore)) {
            $attributes['checked'] = (bool) common::$inputBefore[$attributes['id']];
        }
        // Début du wrapper
        $html = '<div id="' . $attributes['id'] . 'Wrapper" class="inputWrapper ' . $attributes['classWrapper'] . '">';
        // Notice
        $notice = '';
        if(array_key_exists($attributes['id'], common::$inputNotices)) {
            $notice = common::$inputNotices[$attributes['id']];
            $attributes['class'] .= ' notice';
        }
        $html .= self::notice($attributes['id'], $notice);
        // Case à cocher
		if( $attributes['required'] === false ){
			$html .= sprintf(
				'<input type="checkbox" value="%s" %s>',
				$value,
				helper::sprintAttributes($attributes)
			);
		} else {
			$html .= sprintf(
				'<input type="checkbox" value="%s" %s required>',
				$value,
				helper::sprintAttributes($attributes)
			);

		}
        // Label
        $html .= self::label($attributes['id'], '<span>' . $label . '</span>', [
            'help' => $attributes['help']
        ]);
        // Fin du wrapper
        $html .= '</div>';
        // Retourne le html
        return $html;
    }

    /**
    * Crée un champ date
    * @param string $nameId Nom et id du champ
    * @param array $attributes Attributs ($key => $value)
    * @return string
    */
    public static function date($nameId, array $attributes = []) {
        // Attributs par défaut
        $attributes = array_merge([
            'autocomplete' => 'on',
            'before' => true,
            'class' => '',
            'classWrapper' => '',
            'noDirty' => false,
            'disabled' => false,
            'help' => '',
            'id' => $nameId,
            'label' => '',
            'name' => $nameId,
            'placeholder' => '',
            'readonly' => true,
            'value' => ''
        ], $attributes);
        // Sauvegarde des données en cas d'erreur
        if($attributes['before'] AND array_key_exists($attributes['id'], common::$inputBefore)) {
            $attributes['value'] = common::$inputBefore[$attributes['id']];
        }
        else {
            $attributes['value'] = ($attributes['value'] ? helper::filter($attributes['value'], helper::FILTER_TIMESTAMP) : '');
        }
        // Début du wrapper
        $html = '<div id="' . $attributes['id'] . 'Wrapper" class="inputWrapper ' . $attributes['classWrapper'] . '">';
        // Label
        if($attributes['label']) {
            $html .= self::label($attributes['id'], $attributes['label'], [
                'help' => $attributes['help']
            ]);
        }
        // Notice
        $notice = '';
        if(array_key_exists($attributes['id'], common::$inputNotices)) {
            $notice = common::$inputNotices[$attributes['id']];
            $attributes['class'] .= ' notice';
        }
        $html .= self::notice($attributes['id'], $notice);
        // Date visible
        $html .= '<div class="inputDateManagerWrapper">';
        $html .= sprintf(
            '<input type="text" class="datepicker %s" value="%s" %s>',
            $attributes['class'],
            $attributes['value'],
            helper::sprintAttributes($attributes, ['class', 'value'])
        );
        $html .= self::button($attributes['id'] . 'Delete', [
            'class' => 'inputDateDelete',
            'value' => self::ico('cancel')
        ]);
        $html .= '</div>';
        // Fin du wrapper
        $html .= '</div>';
        // Retourne le html
        return $html;
    }

    /**
    * Crée un champ d'upload de fichier
    * @param string $nameId Nom et id du champ
    * @param array $attributes Attributs ($key => $value)
    * @return string
    */
    public static function file($nameId, array $attributes = []) {
        // Attributs par défaut
        $attributes = array_merge([
            'before' => true,
            'class' => '',
            'classWrapper' => '',
            'noDirty' => false,
            'disabled' => false,
            'extensions' => '',
            'help' => '',
            'id' => $nameId,
            'label' => '',
            'maxlength' => '500',
            'name' => $nameId,
            'type' => 2,
            'value' => ''
        ], $attributes);
        // Sauvegarde des données en cas d'erreur
        if($attributes['before'] AND array_key_exists($attributes['id'], common::$inputBefore)) {
            $attributes['value'] = common::$inputBefore[$attributes['id']];
        }
        // Début du wrapper
        $html = '<div id="' . $attributes['id'] . 'Wrapper" class="inputWrapper ' . $attributes['classWrapper'] . '">';
        // Label
        if($attributes['label']) {
            $html .= self::label($attributes['id'], $attributes['label'], [
                'help' => $attributes['help']
            ]);
        }
        // Notice
        $notice = '';
        if(array_key_exists($attributes['id'], common::$inputNotices)) {
            $notice = common::$inputNotices[$attributes['id']];
            $attributes['class'] .= ' notice';
        }
        $html .= self::notice($attributes['id'], $notice);
        // Champ caché contenant l'url de la page
        $html .= self::hidden($attributes['id'], [
            'class' => 'inputFileHidden',
            'disabled' => $attributes['disabled'],
            'maxlength' => $attributes['maxlength'],
            'value' => $attributes['value']
        ]);
        // Champ d'upload
        $html .= '<div class="inputFileManagerWrapper">';
        $html .= sprintf(
            '<a
                href="' .
                    helper::baseUrl(false) . 'core/vendor/filemanager/dialog.php' .
                    '?relative_url=1' .
                    '&field_id=' . $attributes['id'] .
                    '&type=' . $attributes['type'] .
                    '&akey=' . md5_file(core::DATA_DIR.'core.json') .
                    ($attributes['extensions'] ? '&extensions=' . $attributes['extensions'] : '')
                . '"
                class="inputFile %s %s"
                %s
                data-lity
            >
                ' . self::ico('upload', 'right') . '
                <span class="inputFileLabel"></span>
            </a>',
            $attributes['class'],
            $attributes['disabled'] ? 'disabled' : '',
            helper::sprintAttributes($attributes, ['class', 'extensions', 'type', 'maxlength'])

        );
        $html .= self::button($attributes['id'] . 'Delete', [
            'class' => 'inputFileDelete',
            'value' => self::ico('cancel')
        ]);
        $html .= '</div>';
        // Fin du wrapper
        $html .= '</div>';
        // Retourne le html
        return $html;
    }

    /**
    * Ferme un formulaire
    * @return string
    */
    public static function formClose() {
        return '</form>';
    }

    /**
    * Ouvre un formulaire protégé par CSRF
    * @param string $id Id du formulaire
	* @param string $action action du formulaire
    * @return string
    */
    public static function formOpen($id, $action = '') {
        // Ouverture formulaire
		if($action === ''){
			$html = '<form id="' . $id . '" method="post">';
		} else {
			$html = '<form id="' . $id . '" method="post" action="'.$action.'">';
		}
        // Stock le token CSRF
        $html .= self::hidden('csrf', [
            'value' => $_SESSION['csrf']
        ]);
        // Retourne le html
        return $html;
    }

	/**
    * Ouvre un formulaire avec pièce jointe protégé par CSRF
    * @param string $id Id du formulaire
	* @param string $action action du formulaire
    * @return string
    */
    public static function formOpenFile($id, $action = '') {
        // Ouverture formulaire   
		if($action === ''){
			$html = '<form id="' . $id . '" enctype="multipart/form-data" method="post">';
		} else {
			$html = '<form id="' . $id . '" enctype="multipart/form-data" method="post" action="'.$action.'">';
		}
        // Stock le token CSRF
        $html .= self::hidden('csrf', [
            'value' => $_SESSION['csrf']
        ]);
        // Retourne le html
        return $html;
    }


    /**
    * Crée une aide qui s'affiche au survole
    * @param string $text Texte de l'aide
    * @return string
    */
    public static function help($text) {
        return '<span class="helpButton" data-tippy-content="' . $text . '">' . self::ico('help') . '<!----></span>';
    }

    /**
    * Crée un champ caché
    * @param string $nameId Nom et id du champ
    * @param array $attributes Attributs ($key => $value)
    * @return string
    */
    public static function hidden($nameId, array $attributes = []) {
        // Attributs par défaut
        $attributes = array_merge([
            'before' => true,
            'class' => '',
            'noDirty' => false,
            'id' => $nameId,
            //'maxlength' => '500',
            'name' => $nameId,
            'value' => ''
        ], $attributes);
        // Sauvegarde des données en cas d'erreur
        if($attributes['before'] AND array_key_exists($attributes['id'], common::$inputBefore)) {
            $attributes['value'] = common::$inputBefore[$attributes['id']];
        }
        // Texte
        $html = sprintf('<input type="hidden" %s>', helper::sprintAttributes($attributes, ['before']));
        // Retourne le html
        return $html;
    }

    /**
    * Crée un icône
    * @param string $ico Classe de l'icône
    * @param string $margin Ajoute un margin autour de l'icône (choix : left, right, all)
    * @param bool $animate Ajoute une animation à l'icône
    * @param string $fontSize Taille de la police
    * @return string
    */
    public static function ico($ico, $margin = '', $animate = false, $fontSize = '1em') {
        return '<span class="delta-ico-' . $ico . ($margin ? ' delta-ico-margin-' . $margin : '') . ($animate ? ' animate-spin' : '') . '" style="font-size:' . $fontSize . '"><!----></span>';
    }

        /**
    * Crée un drapeau du site courant
    * @param string $langId Id de la langue à affiche ou site pour la langue traduite courante
    * @param string $size fixe la largeur du drapeau
    * @return string
    */
    public static function flag($langId, $size = 'auto') {
		$lang = $langId;
		if( ! file_exists( 'core/vendor/i18n/png/' . $lang . '.png')) $lang = 'blanc';
		$text = $lang;
		if ($text === 'blanc') $text = 'Your language';
        return '<img class="flag" src="' . helper::baseUrl(false) . 'core/vendor/i18n/png/' . $lang . '.png"
                width="' . $size .'"
                height="' . $size .'"
                title="' . $text .'" />';
    }

    /**
    * Crée un label
    * @param string $for For du label
    * @param array $attributes Attributs ($key => $value)
    * @param string $text Texte du label
    * @return string
    */
    public static function label($for, $text, array $attributes = []) {
        // Attributs par défaut
        $attributes = array_merge([
            'class' => '',
            'for' => $for,
            'help' => ''
        ], $attributes);
        // Ajout d'une aide
        if($attributes['help'] !== '') {
            $text = $text . self::help($attributes['help']);
        }
        // Retourne le html
        return sprintf(
            '<label %s>%s</label>',
            helper::sprintAttributes($attributes),
            $text
        );
    }

    /**
    * Crée un champ mail
    * @param string $nameId Nom et id du champ
    * @param array $attributes Attributs ($key => $value)
    * @return string
    */
    public static function mail($nameId, array $attributes = []) {
        // Attributs par défaut
        $attributes = array_merge([
            'autocomplete' => 'on',
            'before' => true,
            'class' => '',
            'classWrapper' => '',
            'noDirty' => false,
            'disabled' => false,
            'help' => '',
            'id' => $nameId,
            'label' => '',
            //'maxlength' => '500',
            'name' => $nameId,
            'placeholder' => '',
            'readonly' => false,
            'value' => ''
        ], $attributes);
        // Sauvegarde des données en cas d'erreur
        if($attributes['before'] AND array_key_exists($attributes['id'], common::$inputBefore)) {
            $attributes['value'] = common::$inputBefore[$attributes['id']];
        }
        // Début du wrapper
        $html = '<div id="' . $attributes['id'] . 'Wrapper" class="inputWrapper ' . $attributes['classWrapper'] . '">';
        // Label
        if($attributes['label']) {
            $html .= self::label($attributes['id'], $attributes['label'], [
                'help' => $attributes['help']
            ]);
        }
        // Notice
        $notice = '';
        if(array_key_exists($attributes['id'], common::$inputNotices)) {
            $notice = common::$inputNotices[$attributes['id']];
            $attributes['class'] .= ' notice';
        }
        $html .= self::notice($attributes['id'], $notice);
        // Texte
        $html .= sprintf(
            '<input type="email" %s>',
            helper::sprintAttributes($attributes)
        );
        // Fin du wrapper
        $html .= '</div>';
        // Retourne le html
        return $html;
    }

    /**
    * Crée une notice
    * @param string $id Id du champ
    * @param string $notice Notice
    * @return string
    */
    public static function notice($id, $notice) {
        return ' <span id="' . $id . 'Notice" class="notice ' . ($notice ? '' : 'displayNone') . '">' . $notice . '</span>';
    }

    /**
    * Crée un champ mot de passe
    * @param string $nameId Nom et id du champ
    * @param array $attributes Attributs ($key => $value)
    * @return string
    */
    public static function password($nameId, array $attributes = []) {
        // Attributs par défaut
        $attributes = array_merge([
            'autocomplete' => 'on',
            'class' => '',
            'classWrapper' => '',
            'noDirty' => false,
            'disabled' => false,
            'help' => '',
            'id' => $nameId,
            'label' => '',
            //'maxlength' => '500',
            'name' => $nameId,
            'placeholder' => '',
            'readonly' => false
        ], $attributes);
        // Début du wrapper
        $html = '<div id="' . $attributes['id'] . 'Wrapper" class="inputWrapper ' . $attributes['classWrapper'] . '">';
        // Label
        if($attributes['label']) {
            $html .= self::label($attributes['id'], $attributes['label'], [
                'help' => $attributes['help']
            ]);
        }
        // Notice
        $notice = '';
        if(array_key_exists($attributes['id'], common::$inputNotices)) {
            $notice = common::$inputNotices[$attributes['id']];
            $attributes['class'] .= ' notice';
        }
        $html .= self::notice($attributes['id'], $notice);
        // Mot de passe
        $html .= sprintf(
            '<input type="password" %s >',
            helper::sprintAttributes($attributes)
        );
        // Fin du wrapper
        $html .= '</div>';
        // Retourne le html
        return $html;
    }

    /**
    * Crée un champ sélection
    * @param string $nameId Nom et id du champ
    * @param array $options Liste des options du champ de sélection ($value => $text)
    * @param array $attributes Attributs ($key => $value)
    * @return string
    */
    public static function select($nameId, array $options, array $attributes = []) {
        // Attributs par défaut
        $attributes = array_merge([
            'before' => true,
            'class' => '',
            'classWrapper' => '',
            'noDirty' => false,
            'disabled' => false,
            'help' => '',
            'id' => $nameId,
            'label' => '',
            'name' => $nameId,
            'selected' => '',
            'fonts' => false,
			'ksort' => true
        ], $attributes);
        // Sauvegarde des données en cas d'erreur
        if($attributes['before'] AND array_key_exists($attributes['id'], common::$inputBefore)) {
            $attributes['selected'] = common::$inputBefore[$attributes['id']];
        }

        // Début du wrapper
        $html = '<div id="' . $attributes['id'] . 'Wrapper" class="inputWrapper ' . $attributes['classWrapper'] . '">';
        // Label
        if($attributes['label']) {
            $html .= self::label($attributes['id'], $attributes['label'], [
                'help' => $attributes['help']
            ]);
        }
        // Notice
        $notice = '';
        if(array_key_exists($attributes['id'], common::$inputNotices)) {
            $notice = common::$inputNotices[$attributes['id']];
            $attributes['class'] .= ' notice';
        }
        $html .= self::notice($attributes['id'], $notice);
        // Début sélection
        $html .= sprintf('<select %s>',
            helper::sprintAttributes($attributes)
        );
		if( $attributes['ksort'] === true ) ksort($options);
        foreach($options as $value => $text) {
            $html .=   $attributes['fonts'] === true ? sprintf(
                    '<option value="%s"%s style="font-family: %s;"> %s </option>',
                    $value,
                    $attributes['selected'] == $value ? ' selected' : '', // Double == pour ignorer le type de variable car $_POST change les types en string
                    $value,
                    $text
                ) : sprintf(
                    '<option value="%s"%s>%s</option>',
                        $value,
                        $attributes['selected'] == $value ? ' selected' : '', // Double == pour ignorer le type de variable car $_POST change les types en string
                        $text
                );
        }
        // Fin sélection
        $html .= '</select>';
        // Fin du wrapper
        $html .= '</div>';
        // Retourne le html
        return $html;
    }

    /**
    * Crée une bulle de dialogue
    * @param string $text Texte de la bulle
    * @return string
    */
    public static function speech($text) {
        return '<div class="speech"><div class="speechBubble">' . $text . '</div></div>';
    }

    /**
    * Crée un bouton validation
    * @param string $nameId Nom & id du bouton validation
    * @param array $attributes Attributs ($key => $value)
    * @return string
    */
    public static function submit($nameId, array $attributes = []) {
        // Attributs par défaut
        $attributes = array_merge([
            'class' => '',
            'disabled' => false,
            'ico' => 'check',
            'id' => $nameId,
            'name' => $nameId,
            'uniqueSubmission' => false,
            'value' => 'Enregistrer'
        ], $attributes);
        // Retourne le html
        return  sprintf(
            '<button type="submit" class="%s%s" %s>%s</button>',
            $attributes['class'],
            $attributes['uniqueSubmission'] ? 'uniqueSubmission' : '',
            helper::sprintAttributes($attributes, ['class', 'ico', 'value']),
            ($attributes['ico'] ? template::ico($attributes['ico'], 'right') : '') . $attributes['value']
        );
    }

    /**
	 * Crée un tableau
	 * @param array $cols Cols des colonnes (format: [col colonne1, col colonne2, etc])
	 * @param array $body Contenu (format: [[contenu1, contenu2, etc], [contenu1, contenu2, etc]])
	 * @param array $head Entêtes (format : [[titre colonne1, titre colonne2, etc])
     * @param array $rowsId Id pour la numérotation des rows (format : [id colonne1, id colonne2, etc])
	 * @param array $attributes Attributs ($key => $value)
	 * @return string
	 */
	public static function table(array $cols = [], array $body = [], array $head = [], array $attributes = [], array $rowsId = []) {
		// Attributs par défaut
		$attributes = array_merge([
			'class' => '',
			'classWrapper' => '',
			'id' => ''
		], $attributes);
		// Début du wrapper
		$html = '<div id="' . $attributes['id'] . 'Wrapper" class="tableWrapper ' . $attributes['classWrapper']. '">';
		// Début tableau
		$html .= '<table id="' . $attributes['id'] . '" class="table ' . $attributes['class']. '">';
		// Entêtes
		if($head) {
			// Début des entêtes
			$html .= '<thead>';
			$html .= '<tr class="nodrag">';
			$i = 0;
			foreach($head as $th) {
				$html .= '<th class="col' . $cols[$i++] . '">' . $th . '</th>';
			}
			// Fin des entêtes
			$html .= '</tr>';
			$html .= '</thead>';
        }
        // Pas de tableau d'Id transmis, générer une numérotation
        if (empty($rowsId)) {
            $rowsId = range(0,count($body));
        }
		// Début contenu
		$j = 0;
		foreach($body as $tr) {
			// Id de ligne pour les tableaux drag and drop
			$html .= '<tr id="' . $rowsId[$j++] . '">';
			$i = 0;
			foreach($tr as $td) {
				$html .= '<td class="col' . $cols[$i++] . '">' . $td . '</td>';
			}
			$html .= '</tr>';
		}
		// Fin contenu
		$html .= '</tbody>';
		// Fin tableau
		$html .= '</table>';
		// Fin container
		$html .= '</div>';
		// Retourne le html
		return $html;
	}

    /**
    * Crée un champ texte court
    * @param string $nameId Nom et id du champ
    * @param array $attributes Attributs ($key => $value)
    * @return string
    */
    public static function text($nameId, array $attributes = []) {
        // Attributs par défaut
        $attributes = array_merge([
            'autocomplete' => 'on',
            'before' => true,
            'class' => '',
            'classWrapper' => '',
            'noDirty' => false,
            'disabled' => false,
            'help' => '',
            'id' => $nameId,
            'label' => '',
            //'maxlength' => '500',
            'name' => $nameId,
            'placeholder' => '',
            'readonly' => false,
            'value' => ''
        ], $attributes);
        // Sauvegarde des données en cas d'erreur
        if($attributes['before'] AND array_key_exists($attributes['id'], common::$inputBefore)) {
            $attributes['value'] = common::$inputBefore[$attributes['id']];
        }
        // Début du wrapper
        $html = '<div id="' . $attributes['id'] . 'Wrapper" class="inputWrapper ' . $attributes['classWrapper'] . '">';
        // Label
        if($attributes['label']) {
            $html .= self::label($attributes['id'], $attributes['label'], [
                'help' => $attributes['help']
            ]);
        }
        // Notice
        $notice = '';
        if(array_key_exists($attributes['id'], common::$inputNotices)) {
            $notice = common::$inputNotices[$attributes['id']];
            $attributes['class'] .= ' notice';
        }
        $html .= self::notice($attributes['id'], $notice);
        // Texte
        $html .= sprintf(
            '<input type="text" %s>',
            helper::sprintAttributes($attributes)
        );
        // Fin du wrapper
        $html .= '</div>';
        // Retourne le html
        return $html;
    }

    /**
    * Crée un champ texte long
    * @param string $nameId Nom et id du champ
    * @param array $attributes Attributs ($key => $value)
    * @return string
    */
    public static function textarea($nameId, array $attributes = []) {
        // Attributs par défaut
        $attributes = array_merge([
            'before' => true,
            'class' => '', // editorWysiwyg et editorWysiwygComment possible pour utiliser un éditeur (il faut également instancier les librairies)
            'classWrapper' => '',
            'disabled' => false,
            'noDirty' => false,
            'help' => '',
            'id' => $nameId,
            'label' => '',
            //'maxlength' => '500',
            'name' => $nameId,
            'readonly' => false,
            'value' => ''
        ], $attributes);
        // Sauvegarde des données en cas d'erreur
        if($attributes['before'] AND array_key_exists($attributes['id'], common::$inputBefore)) {
            $attributes['value'] = common::$inputBefore[$attributes['id']];
        }
        // Début du wrapper
        $html = '<div id="' . $attributes['id'] . 'Wrapper" class="inputWrapper ' . $attributes['classWrapper'] . '">';
        // Label
        if($attributes['label']) {
            $html .= self::label($attributes['id'], $attributes['label'], [
                'help' => $attributes['help']
            ]);
        }
        // Notice
        $notice = '';
        if(array_key_exists($attributes['id'], common::$inputNotices)) {
            $notice = common::$inputNotices[$attributes['id']];
            $attributes['class'] .= ' notice';
        }
        $html .= self::notice($attributes['id'], $notice);
        // Texte long
		// Limitation à maxlength
		if( isset($attributes['maxlength'] ) && $attributes['maxlength'] !== '' && is_string($attributes['value']) ) $attributes['value'] = substr( $attributes['value'] , 0, (int) $attributes['maxlength']);
        $html .= sprintf(
            '<textarea %s>%s</textarea>',
            helper::sprintAttributes($attributes, ['value']),
            $attributes['value']
        );
        // Fin du wrapper
        $html .= '</div>';
        // Retourne le html
        return $html;
    }
}
