<?php
// le namespace des controllers sera toujours le même
namespace App\Controller;

// La classe Response nous sert pour renvoyer la réponse (voir après)
use Symfony\Component\HttpFoundation\Response;
// la classe Controller est la classe mère de tous les controllers
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use App\Entity\Telephone;

// notre controller doit forcément hériter de la classe Controller ("use" ci-dessus)
// Le nom de la classe doit être exactement le même que celui du fichier
class TelephoneController extends Controller
{


    public function new_perso($marque, $type, $taille)
    {
      $tel = new Telephone();
      $tel->setMarque($marque);
      $tel->setType($type);
      $tel->setTaille($taille);
      $tel->getId();

      $em = $this->getDoctrine()->getManager();
      $em->persist($tel);
      $em->flush();

      return $this->render('new.html.twig', array(
        "marque" => $marque,
        "type" => $type,
        "taille" => $taille,
      ));
    }

    public function modify_perso($id, $marque, $type, $taille)
    {
      $repo = $this->getDoctrine()
                   ->getRepository(Telephone::class);
      $tel=  $repo->find($id);

      $tel->setMarque($marque);
      $tel->setType($type);
      $tel->setTaille($taille);

      $em = $this->getDoctrine()->getManager();
      $em->flush();

      return $this->render('modify.html.twig', array(
        "id" => $id,
        "marque" => $marque,
        "type" => $type,
        "taille" => $taille,
      ));
    }

    public function remove_perso($id)
    {
      $repo = $this->getDoctrine()
                   ->getRepository(Telephone::class);
      $tel=  $repo->find($id);


      $em = $this->getDoctrine()->getManager();
      $em->remove($tel);
      $em->flush();

      return $this->render('remove.html.twig', array(
        "id" => $id,

      ));
    }

    public function index()
    {
            // création du repository en lui précisant l'entité associée
      $repo = $this->getDoctrine()
              ->getRepository(Telephone::class);
      // par exemple, ici je récupère le téléphone avec l'id 1
      $tels = $repo->findAll();

      return $this->render('affiche.html.twig', array(
        "tels" => $tels,
      ));

    }

    public function tri() {
       $repo = $this->getDoctrine()
                    ->getRepository(Telephone::class);
       $tels = $repo->findBiggerSizeThan(6.2);

     return $this->render('tri.html.twig', array(
         "tels" => $tels,
     ));
   }

   public function triParMarque($marque) {
      $repo = $this->getDoctrine()
                   ->getRepository(Telephone::class);
      $tels = $repo->findMarque($marque);

    return $this->render('triParMarque.html.twig', array(
        "marque" => $marque,
        "tels" => $tels,
    ));
  }

  public function triParMarqueTypeQb($marque, $type) {
     $repo = $this->getDoctrine()
                  ->getRepository(Telephone::class);
     $tels = $repo->findMobile($marque, $type);

   return $this->render('triParMarqueTypeQb.html.twig', array(
       "marque" => $marque,
       "type" => $type,
       "tels" => $tels,
   ));
 }












}
?>
