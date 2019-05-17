<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Craue\FormFlowBundle\Form\FormFlow;
use Craue\FormFlowBundle\Form\FormFlowInterface;
use App\Form\CreateUserStep1Type;
use App\Form\CreateUserStep2Type;




class HomeController extends Controller
{

    /**
     * @Route("/home", name="home")
     */
    public function CreateUserFromFlow() {
        $formData = new User(); // Your form data class. Has to be an object, won't work properly with an array.

        $flow = $this->get('Amiltone.form.flow'); // must match the flow's service id
        $flow->bind($formData);

        // form of the current step
        $form = $flow->createForm();
        if ($flow->isValid($form)) {
            $flow->saveCurrentStepData($form);

            if ($flow->nextStep()) {               
                // form for the next step
                $form = $flow->createForm();
            } else {
                // flow finished
                $em = $this->getDoctrine()->getManager();
                $em->persist($formData);
                $em->flush();

                $flow->reset(); // remove step data from the session

                return $this->redirect($this->generateUrl('home')); // redirect when done
            }
        }

        return $this->render('User/CreateUser.html.twig', [
            'form' => $form->createView(),
            'flow' => $flow,
        ]);
    }
}
