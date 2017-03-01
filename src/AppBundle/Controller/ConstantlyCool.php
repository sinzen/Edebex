<?php
/**
 * Created by PhpStorm.
 * User: yassirhessane
 * Date: 26/02/17
 * Time: 20:32
 */

namespace AppBundle\Controller;


class ConstantlyCool {
 // soustraction et comparaison de heure sont tronqué
  // car dans la soustration il il présente un difference de une heure
  // separer les constante de comparaison et d'operation arithmetique
  const C900 = "09:00";
  const C12 = "11:00"; //- 1h car calcule erroner donne une heure de plus
  const C12Bis = "12:00"; //- 1h car calcule erroner donne une heure de plus
  const C1330 = "13:30";
  const C17 = "16:00"; // - 1h car calcule erroner donne une heure de plus
  const C400 = "04:00:00";
  const C400Bis = "03:00:00";
  const C130 = "02:30";

}