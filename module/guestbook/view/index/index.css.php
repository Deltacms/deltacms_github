/**
 * This file is part of DeltaCMS.
 */

#formFileReset {
	background-color: red;
	border-width:1px;
	border-color: orange;
	font-size: 1.15em;
	font-weight: bold;
	color: yellow;
}

#formFileReset:hover {
	background-color: orange;
	border-color: orange;
	font-style: normal;
	color:black;
}

.formInputFile {
	padding: 9px;
	border-radius: 2px;
	border: 1px solid;
}

.formOuter{
	text-align: center;
    margin: 0 auto;
    width: 50%;
	border-radius: 2px;
	border: 1px solid;
}

/*formulaire*/
#formForm {
max-width: 85vw;
margin: auto;
}
/* messages */
.msgs {
max-width: 85vw;
margin: auto;
overflow: hidden;
box-sizing: border-box;
border: ridge rgba(0,0,0,0.3) 2px;
padding: 5px;
}
div.clef {
font-weight: 600;
display: inline-block;
margin: 3px 0 2px;
}
div.valeur {
display: block;
padding: 3px;
}
div.valeur > p {
margin: 0;
line-height: 1.2;
}

/*séparateur de message*/
.msgs > hr {
	width: 50%;
	border: ridge <?=$this->getData(['theme', 'block', 'borderColor'])?> 2px;
	margin: 25px auto;
}

#GuestBook > #formForm .editorWysiwygComment {
	overflow: auto;
	resize: vertical;
	min-height: 220px;
}

@media screen and (max-width: 799px) {
	.formOuter{
		width: 100%;
	}
}

.formInner{
	display: inline-block;
}

.formCheckBlue {
	display: none;
}

