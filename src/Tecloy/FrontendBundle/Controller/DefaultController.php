<?php

namespace Tecloy\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FrontendBundle:Default:index.html.twig');
    }

    public function empresaAction()
    {
        return $this->render('FrontendBundle:Default:empresa.html.twig');
    }

    public function contactoAction(Request $request)
    {    	
    	$request = $this->getRequest();                     

        $form = $this->createFormBuilder()     
        	->add('name', 'text',array('max_length' => '50','attr' => array('class' => 'form-control','placeholder' => '* Escriba su nombre completo', 'data-rule' => 'maxlen:4', 'data-msg' => 'Introduzca por lo menos 4 caracteres')))                
        	->add('email', 'text',array('max_length' => '100','attr' => array('class' => 'form-control','placeholder' => '* Ingrese su dirección de correo electrónico', 'data-rule' => 'maxlen:4', 'data-msg' => 'Por favor, introduzca un email válido')))                              
            ->add('subject', 'text',array('max_length' => '50','attr' => array('class' => 'form-control','placeholder' => '* Ingresa el asunto', 'data-rule' => 'maxlen:4', 'data-msg' => 'Introduzca por lo menos 4 caracteres')))
            ->add('message', 'textarea',array('max_length' => '300','attr' => array('class' => 'form-control','placeholder' => '* Tu mensaje aquí', 'data-rule' => 'maxlen:4', 'data-msg' => 'Por favor, escribir algo', 'rows' => '10')))                                        
            ->add('enviar', 'submit', array('attr' => array('class' => 'btn btn-theme margintop10 pull-left')))
            ->getForm();        

        if ($request->getMethod() == 'POST')
            {                
                $form->handleRequest($request);                
                if ($form->isValid())
                {                	
                    $datos = $form->getData();                       
                
                    $contenido = sprintf(" Remitente: %s \n\n E-mail: %s \n\n Asunto: %s \n\n Mensaje: %s \n\n Navegador: %s \n Dirección IP: %s \n",
                        $datos['name'],
                        $datos['email'],
                        $datos['subject'],
                        htmlspecialchars($datos['message']),
                        $request->server->get('HTTP_USER_AGENT'),
                        $request->server->get('REMOTE_ADDR')
                    );

                    $mensaje = \Swift_Message::newInstance()
                        ->setSubject('Contacto')
                        ->setFrom($datos['email'])
                        ->setTo('info@tecloy.com')
                        ->setBody($contenido)
                    ;

                    $this->container->get('mailer')->send($mensaje);

                    $this->get('session')->getFlashBag()->add('info','Tu mensaje ha sido enviado. Gracias');                                                                                                         
                }                    
                return $this->redirect($this->generateUrl('frontend_contacto'));                      
            }

            return $this->render('FrontendBundle:Default:contacto.html.twig', array('form' => $form->createView()));
        
    }

    public function hardwareAction()
    {
        return $this->render('FrontendBundle:Default:hardware.html.twig');
    }

    public function soporteAction()
    {
        return $this->render('FrontendBundle:Default:soporte.html.twig');
    }
   
    public function mantenimientoAction()
    {
        return $this->render('FrontendBundle:Default:mantenimiento.html.twig');
    }

    public function sopormantenAction()
    {
        return $this->render('FrontendBundle:Default:sopormante.html.twig');
    }

    public function mesaayudaAction()
    {
        return $this->render('FrontendBundle:Default:mesaayuda.html.twig');
    }
}
