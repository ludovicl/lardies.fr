<?php
class champArt extends plxPlugin {

		public function __construct($default_lang) {
			parent::__construct($default_lang);
			
			$this->setConfigProfil(PROFIL_ADMIN);

			$this->addHook('AdminArticleContent', 'AdminArticleContent');
			$this->addHook('AdminArticleTop', 'AdminArticleTop');
			$this->addHook('plxAdminEditArticleXml', 'plxAdminEditArticleXml');
			$this->addHook('plxMotorParseArticle', 'plxMotorParseArticle');
			$this->addHook('AdminTopEndHead', 'AdminTopEndHead');
			$this->addHook('champArt', 'champArt');
		}


		public function AdminTopEndHead() { // insère la feuille de style du plugin que dans la page d'édition de l'article
			echo "\t".'<link rel="stylesheet" type="text/css" href="'.PLX_PLUGINS.'champArt/style.css" media="screen" />'."\n";
		}
		
		public function AdminArticleTop() {
		$nbchamp = sizeof($this->aParams)/4;

		for($i=1; $i<=$nbchamp; $i++) {
			$string = "
					if(!empty(\$_POST)) {
								\$champArt_".$this->aParams['champ'.$i]['value']." = trim(\$_POST['champArt_".$this->aParams['champ'.$i]['value']."']);
						if(!empty(\$_POST['preview'])) {
								\$art['champArt_".$this->aParams['champ'.$i]['value']."'] = trim(\$_POST['champArt_".$this->aParams['champ'.$i]['value']."']);
						}
					} elseif(!empty(\$_GET['a'])) {
							\$champArt_".$this->aParams['champ'.$i]['value']." = trim(\$result['champArt_".$this->aParams['champ'.$i]['value']."']);
					} else {
						\$champArt_".$this->aParams['champ'.$i]['value']."='';
					}
				";
			echo "<?php ".$string." ?>";
			}

		}

		public function AdminArticleContent() {

			$nbchamp = sizeof($this->aParams)/4; // compte le nombre de ligne
			$champgroupe = array(0); // création du tableau des groupes
			for($i=1; $i<=$nbchamp; $i++) {
				array_push($champgroupe, $this->aParams['groupe'.$i]['value']); // injecte tous les groupes dans un tableau
			}

			$champgroupe = array_unique($champgroupe); // supprime les groupes en doublons
			$champgroupe = array_values($champgroupe); // remet les clefs dans un bon ordre

			$nbgroupe = sizeof($champgroupe); // compte le nombre de groupe unique


			echo "<div id=\"champart\">\n";

			for($j=1; $j<$nbgroupe; $j++) { // on boucle sur chaque groupe
				echo "<fieldset class=\"article\">\n";
					echo "<legend>".$champgroupe[$j]."</legend>";

					for($i=1; $i<=$nbchamp; $i++) { // on boucle sur chaque ligne
						if($this->aParams['groupe'.$i]['value']==$champgroupe[$j]){ // si la ligne appartient à ce groupe

							echo "<p><label for=\"id_champArt_".$this->aParams['champ'.$i]['value']."\">".$this->aParams['label'.$i]['value']." :</label> ( ".$this->aParams['champ'.$i]['value']." ) <a id=\"toggler_".$this->aParams['champ'.$i]['value']."\" href=\"javascript:void(0)\" onclick=\"toggleDiv('toggle_".$this->aParams['champ'.$i]['value']."', 'toggler_".$this->aParams['champ'.$i]['value']."', '".$this->getlang('L_AFFICHER')."','".$this->getlang('L_MASQUER')."')\">";
							echo '<?php if(empty($champArt_'.$this->aParams['champ'.$i]['value'].')){echo "'.$this->getlang('L_AFFICHER').'";}else{echo "'.$this->getlang('L_MASQUER').'";}?></a></p>'; // test si le champ possède une valeur. Si oui > affichage du champ, sinon il reste caché

							// affichage du champ sous la forme défini
							if($this->aParams['type'.$i]['value']=="ligne"){ // si le champ est de type input ( ligne )
								echo '<div id="toggle_'.$this->aParams['champ'.$i]['value'].'" <?php if(empty($champArt_'.$this->aParams['champ'.$i]['value'].')){echo "style=\"display: none;\"";}?>>'; // test si le champ possède une valeur. Si oui > affichage du champ, sinon il reste caché
								echo '<?php plxUtils::printInput("champArt_'.$this->aParams['champ'.$i]['value'].'",plxUtils::strCheck($champArt_'.$this->aParams['champ'.$i]['value'].'),"text","66-255"); ?>';
								echo '</div>';
							} else { // sinon c'est un textarea ( bloc )
								echo '<div id="toggle_'.$this->aParams['champ'.$i]['value'].'" <?php if(empty($champArt_'.$this->aParams['champ'.$i]['value'].')){echo "style=\"display: none;\"";}?>>'; // test si le champ possède une valeur. Si oui > affichage du champ, sinon il reste caché
								echo '<?php plxUtils::printArea("champArt_'.$this->aParams['champ'.$i]['value'].'",plxUtils::strCheck($champArt_'.$this->aParams['champ'.$i]['value'].'),"20","5"); ?>';
								echo '</div>';
							}
						}
					}

				echo "</fieldset>\n";
			}
			echo "<ul>";
			echo "<li><a href=\"parametres_plugin.php?p=champArt\" title=\"".$this->getlang('L_TITLE_LIEN_CONFIG')."\">".$this->getlang('L_TITLE_LIEN_CONFIG')."</a></li>";
			echo "<li><a href=\"parametres_pluginhelp.php?p=champArt\" title=\"".$this->getlang('L_TITLE_LIEN_AIDE')."\">".$this->getlang('L_TITLE_LIEN_AIDE')."</a></li>";
			echo "<li>( ".$this->getlang('L_TITLE_LIEN_OUPS')." )</li>";
			echo "</ul>";
			echo "</div>";
		}


		public function plxAdminEditArticleXml() {
		$nbchamp = sizeof($this->aParams)/4;

					for($i=1; $i<=$nbchamp; $i++) {
						echo "<?php \$xml .= \"\t\".'<champArt_".$this->aParams['champ'.$i]['value']."><![CDATA['.plxUtils::cdataCheck(trim(\$content['champArt_".$this->aParams['champ'.$i]['value']."'])).']]></champArt_".$this->aParams['champ'.$i]['value'].">'.\"\n\"; ?>";
					}
		}

		public function plxMotorParseArticle() {
		$nbchamp = sizeof($this->aParams)/4;

					for($i=1; $i<=$nbchamp; $i++) {
						echo "<?php if(isset(\$iTags['champArt_".$this->aParams['champ'.$i]['value']."'][0])){ \$art['champArt_".$this->aParams['champ'.$i]['value']."'] = trim(\$values[ \$iTags['champArt_".$this->aParams['champ'.$i]['value']."'][0] ]['value']);} ?>";
					}
		}

		public function champArt($param) {
			$plxMotor_inst = plxMotor::getInstance(); // permet de récupérer les champs de l'article
			$champ = array();
			$nbchamp = sizeof($this->aParams)/4;
			for($i=1; $i<=$nbchamp; $i++) {
				array_push($champ, plxUtils::strCheck($this->aParams['champ'.$i]['value']));
			}

			if(in_array($param, $champ) AND $plxMotor_inst->plxRecord_arts->f('champArt_'.$param)) { // si le paramètre fait parti du tableau des valeurs à afficher
				echo $plxMotor_inst->plxRecord_arts->f('champArt_'.$param); // on affiche la valeur
			} elseif(in_array(substr($param, 0, -2), $champ) AND substr($param, -2)=="_R" AND $plxMotor_inst->plxRecord_arts->f('champArt_'.substr($param, 0, -2))) { // si le paramètre fait parti du tableau des valeurs à retourner
				$return = $plxMotor_inst->plxRecord_arts->f('champArt_'.substr($param, 0, -2));
				return $return;
			} elseif(in_array(substr($param, 0, -2), $champ) AND substr($param, -2)=="_L" AND $plxMotor_inst->plxRecord_arts->f('champArt_'.substr($param, 0, -2))) { // si le paramètre fait parti du tableau des valeurs à retourner
				$nbchamp = sizeof($this->aParams)/4;
				for($i=1; $i<=$nbchamp; $i++) {
					if ($this->aParams['champ'.$i]['value']==substr($param, 0, -2)){
						echo "<span>".$this->aParams['label'.$i]['value'].":</span>";
						echo $plxMotor_inst->plxRecord_arts->f('champArt_'.substr($param, 0, -2));
					}
				}
			}
		return false;
		}
	
	}

?>