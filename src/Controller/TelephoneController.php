<?php
// le namespace des controllers sera toujours le même
namespace App\Controller;

// La classe Response nous sert pour renvoyer la réponse (voir après)
use Symfony\Component\HttpFoundation\Response;
// la classe Controller est la classe mère de tous les controllers
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


// use utilisé mais non nécessaire à présent ! Voir TelephoneType
// use Symfony\Component\Form\Extension\Core\Type\TextType;
//
// use Symfony\Component\Form\Extension\Core\Type\NumberType;
//
// use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\HttpFoundation\Request;


use App\Entity\Telephone;

use App\Form\TelephoneType;







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

    public function index() {
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

 public function new(Request $request)
 {
     $tel = new Telephone();

     // Nous précisons ici que nous voulons utiliser `TelephoneType` et hydrater $tel
     $form = $this->createForm(TelephoneType::class, $tel);

     // nous récupérons ici les informations du formulaire validée
     // c'est-à-dire l'équivalent du $_POST
     // ... et ce, grâce à l'objet $request
     // qui représente les informations sur la requête HTTP reçue (voir l'explication après le code)
     $form->handleRequest($request);

     // Si nous venons de valider le formulaire et s'il est valide (problèmes de type, etc)
     if ($form->isSubmitted() && $form->isValid()) {
         // nous enregistrons directement l'objet $tel !
         // En effet, il a été hydraté grâce au paramètre donné à la méthode createFormBuilder !
         $em = $this->getDoctrine()->getManager();
         $em->persist($tel);
         $em->flush();

         // nous redirigeons l'utilisateur vers la route /telephone/
         // nous utilisons ici l'identifiant de la route, créé dans le fichier yaml
         // (il est peut-être différent pour vous, adaptez en conséquence)
         // extrèmement pratique : si nous devons changer l'url en elle-même,
         // nous n'avons pas à changer nos contrôleurs, mais juste les fichiers de configurations yaml
         return $this->redirectToRoute('telephone_new');
     }

     return $this->render('telephone/new.html.twig', array(
         'form' => $form->createView(),
     ));
 }






}
?>
