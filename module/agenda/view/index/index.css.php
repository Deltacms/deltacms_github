
/* Personnalisation des couleurs de l'agenda � associer avec votre th�me*/

/**/
/*Bordures ne pas modifier, cette couleur est r�glable dans la configuration de l'agenda*/
/**/


.fc-unthemed th,
.fc-unthemed td,
.fc-unthemed thead,
.fc-unthemed tbody,
.fc-unthemed .fc-divider,
.fc-unthemed .fc-row,
.fc-unthemed .fc-content,
.fc-unthemed .fc-popover,
.fc-unthemed .fc-list-view,
.fc-unthemed .fc-list-heading td,
.fc .fc-row .fc-content-skeleton td {
  border-color: <?=$this->getData(['module', $this->getUrl(0),'config', 'gridColor'])?> !important;
}

/**/
/* Background */
/**/

/* Fond du bandeau boutons de l'agenda, comment� pour conserver la couleur du th�me*/
/*
.fc-toolbar {
	background-color : #ffffff;
}
*/

/* Fond des cellules de la grille, comment� pour conserver la couleur du th�me */
/*
.fc-day {
	background-color : #ffffff;
}
*/

/* Fond de la cellule s�lectionn�e (clic) */
.fc-highlight {
  background: #ffff54;
  opacity: 0.3;
}

/* Fond de la cellule aujourd'hui */
.fc-unthemed td .fc-today{
	/*background-color : #F6F7F8;*/
}

/* Fond du bandeau sup�rieur des jours, comment� pour conserver la couleur du th�me*/

.fc th {
	background-color : #F6F7F8;

}


/**/
/* Textes */
/**/

/* Couleur de la valeur des jours, comment� pour conserver la couleur du th�me*/
/*table td {
	color: rgba(33, 34, 35, 1);
}*/

/* Opacit� pour les jours du mois pass� ou futur*/
.fc-day-top.fc-other-month{
  opacity: 0.3;
}


/* Nom des jours dans la ligne sup�rieure, comment� pour conserver la couleur du th�me*/
table th{
	color: rgba(33, 34, 35, 1);
	/*font-weight: normal;*/
	font-size: 1em;
}

/* font-size des jours dans la ligne sup�rieure et du mois dans le titre en petit �cran */
@media (max-width: 799px) {
	.fc-center h2{
		font-size: 1.2em;
		text-align: center;
	}
	table th{
		font-size: 8px;
	}
	.fc-button {
		font-size: 10px !important;
	}
}

/**/
/* Boutons */
/**/

/* Couleurs bouton et texte non actif*/
.fc-button-primary {
  color: #fff;
  background-color: #2C3E50;
  border-color: #2C3E50;
}

/* Couleurs bouton et texte (non actif) au survol */
.fc-button-primary:hover {
  color: #fff;
  background-color: #1a252f;
  border-color: #1a252f;
}

/* Contour des boutons 'Aujourd'hui' et d�filement apr�s s�lection*/
.fc-button-primary:focus {
  -webkit-box-shadow: 0 0 0 0.2rem rgba(76, 91, 106, 0.5);
  box-shadow: 0 0 0 0.2rem rgba(76, 91, 106, 0.5);
}

/* Bouton 'Aujourd'hui' quand ce jour est affich� dans la grille */
.fc-today-button.fc-button.fc-button-primary:disabled  {
/*  color: #0000ff; /* color et background-color inop�rant � cause de !important sur ces param�tres pour button::disabled dans common.css*/
/*  background-color: #ff0000; */
  border-color: #ff0000;
}

/* Bouton mois ou semaine actif (s�lectionn�) */
.fc-button-primary:not(:disabled):active,
.fc-button-primary:not(:disabled).fc-button-active {
  color: #fff;
  background-color: #151e27;
  border-color: #151e27;
}

/* Contour des boutons mois et semaine*/
.fc-button-primary:not(:disabled):active:focus,
.fc-button-primary:not(:disabled).fc-button-active:focus {
  -webkit-box-shadow: 0 0 0 0.2rem rgba(76, 91, 106, 0.5);
  box-shadow: 0 0 0 0.2rem rgba(76, 91, 106, 0.5);
} 

/* Wrapper*/
#index_wrapper {
	margin:0 auto;
}
