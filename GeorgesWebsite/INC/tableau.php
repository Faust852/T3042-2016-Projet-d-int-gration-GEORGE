<?php
class tableau {

    public $liste;
    public $titre;
    public $entete;
    public $id;

    //retourne le nom de la page css
    public function getCss(){
        return 'tableau.css';
    }

    public function html () {
        //si la variable liste est vide, signale que le tableau est vide
        if (empty($this->liste)) return '<b>Le tableau est vide</b>';
        //sinon affiche le tableau
        else {
            //affiche le titre du tableau en gras
            $html = "<h1>$this->titre</h1><br>";
            //donne la couleur du tableau en fonction de l'id passé
            $html .= "<table id=$this->id class=display>";

            //si la variable en-tete est a true, affiche l'en-tete
            if ($this->entete) {
                $html .= '<thead>';
                $html .= '<tr>';
                //recupere les titres des collonnes
                $nomCollonnes = array_keys($this->liste[0]);
                //ajoute ces titre au tableau html
                foreach ($nomCollonnes as $element) {
                    $html .= "<th>$element</th>";
                }
                $html .= '</tr>';
                $html .= '</thead>';
            }

            //affiche le contenu du tableau proprement dit
            $html .= '<tbody>';
            foreach ($this->liste as $value) {
                $html .= '<tr>';
                foreach ($value as $key => $element) {
                    if ($key == 'répondu'){
                        if ($element == 'non') $html .= "<td class='repondre' id=".$value['id'].
                            " title='répondre' onclick='event.preventDefault(); gereMessage(this.id);'>$element</td>";
                        else  $html .= "<td id=".$value['id'].
                            " title='répondre' onclick='event.preventDefault(); gereMessage(this.id);'>$element</td>";
                    }
                    else {
                        $html .= "<td>$element</td>";
                    }
                }
                $html .= '</tr>';
            }
            $html .= '<tbody>';

            $html .= '</table>';
            return $html;
        }
    }

}
?>

