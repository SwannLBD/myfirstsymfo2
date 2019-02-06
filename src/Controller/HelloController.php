<?php
// le namespace des controllers sera toujours le même
namespace App\Controller;

// La classe Response nous sert pour renvoyer la réponse (voir après)
use Symfony\Component\HttpFoundation\Response;
// la classe Controller est la classe mère de tous les controllers
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// notre controller doit forcément hériter de la classe Controller ("use" ci-dessus)
// Le nom de la classe doit être exactement le même que celui du fichier
class HelloController extends Controller
{
    public function index()
    {

      $prenom1 = "Swann";
      $prenom2 = "Tom";
      return $this->render('hello_prenom.html.twig', array (
        "prenom1" => $prenom1,
        "prenom2" => $prenom2,
      ));

    }

      public function index_perso($prenom, $age)
      {
        return $this->render('hello_perso.html.twig', array(
          "prenom" => $prenom,
          "age" => $age,
        ));
      }

      public function index_perso_error($prenom)
      {
        return $this->render('hello_perso_error.html.twig', array(
          "prenom" => $prenom,
        ));
      }


}
?>
