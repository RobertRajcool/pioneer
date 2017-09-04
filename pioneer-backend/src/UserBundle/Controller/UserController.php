<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use FOS\RestBundle\Controller\FOSRestController;
use JMS\Serializer\SerializationContext;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\Form\FormInterface;
use UserBundle\Util\CommonFunctions;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Event\GetResponseNullableUserEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Util\TokenGeneratorInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * DefaultController.
 * @Route("/authencation")
 */
class UserController extends Controller
{
    /**
     * @Rest\Get("/welcome",name="user_welcome")
     * @return JsonResponse
     */
    public function WelcomeAction()
    {
        return new JsonResponse(array('name' => "Robert"));
    }

    /**
     * @Rest\Get("/logout",name="userLogout")
     */
    public function logoutAction()
    {
        throw new \RuntimeException('You must activate the logout in your security firewall configuration.');
    }


    /**
     * @Rest\Post("/createcompany",name="createuser")
     */
    public function postUserAction(Request $request)
    {
        $commonfunction=new CommonFunctions();
        $systemSettings = $request->request->get('systemsettings');
        $requestContent=json_decode($request->getContent(),true);
        $userManager = $this->get('fos_user.user_manager');
        $email = $request->request->get('email');
        $username = $request->request->get('username');
        $password = $request->request->get('password');
        $email_exist = $userManager->findUserByEmail($email);
        $username_exist = $userManager->findUserByUsername($username);

        if($email_exist || $username_exist){
            $response = new JsonResponse();
            $response->setData("Username/Email ".$username."/".$email." Already Exist");
            return $response;
        }

        $user = $userManager->createUser();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setEnabled(true);
        $user->setPlainPassword($password);
        $user->setRoles( array('ROLE_ADMIN') );
        $user->setSystemsettings( implode(",",$systemSettings));
        $user->setCompanyId($commonfunction->randomCompanyId());
        $userManager->updateUser($user, true);
        $response = new Response($this->serialize(['resmsg' => 'Company Create Sucessfully!!!!']), Response::HTTP_CREATED);

        /*
                }
                else{
                    $response = new Response($this->serialize(['resmsg' => 'Form Values Invalid!!!!!']), Response::HTTP_CREATED);

                }*/

        return $this->setBaseHeaders($response);
    }
    /**
     * @Rest\Post("/forgot_password",name="requestpassword")
     */
    public function requestNewPaaswordAction(Request $request)
    {
        $username = $request->request->get('email');
        /** @var $user UserInterface */
        $user = $this->get('fos_user.user_manager')->findUserByUsernameOrEmail($username);
        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');
        /* Dispatch init event */
        $event = new GetResponseNullableUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::RESETTING_SEND_EMAIL_INITIALIZE, $event);
        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }
        $ttl = $this->container->getParameter('fos_user.resetting.token_ttl');
        if (null !== $user && !$user->isPasswordRequestNonExpired($ttl)) {
            $event = new GetResponseUserEvent($user, $request);
            $dispatcher->dispatch(FOSUserEvents::RESETTING_RESET_REQUEST, $event);
            if (null !== $event->getResponse()) {
                return $event->getResponse();
            }
            if (null === $user->getConfirmationToken()) {
                /** @var $tokenGenerator TokenGeneratorInterface */
                $tokenGenerator = $this->get('fos_user.util.token_generator');
                $user->setConfirmationToken($tokenGenerator->generateToken());
            }
            /* Dispatch confirm event */
            $event = new GetResponseUserEvent($user, $request);
            $dispatcher->dispatch(FOSUserEvents::RESETTING_SEND_EMAIL_CONFIRM, $event);
            if (null !== $event->getResponse()) {
                return $event->getResponse();
            }
            $this->get('fos_user.mailer')->sendResettingEmailMessage($user);
            $user->setPasswordRequestedAt(new \DateTime());
            $comonfunction=new CommonFunctions();
            $password =$comonfunction->random_password(8);
            $user->setPlainPassword($password);
            $this->get('fos_user.user_manager')->updateUser($user);
            $mailer = $this->container->get('mailer');
            $message = \Swift_Message::newInstance()
                ->setFrom('starshipping123@gmail.com')
                ->setTo($username)
                ->setSubject("New Password From Incident Reports")
                ->setBody('<h1>Your Password is <span>'.$password.'</span></h1>', "text/html");
            //$message->attach(\Swift_Attachment::fromPath()->setFilename());
            $mailer->send($message);
            /* Dispatch completed event */
            $event = new GetResponseUserEvent($user, $request);
            $dispatcher->dispatch(FOSUserEvents::RESETTING_SEND_EMAIL_COMPLETED, $event);
            if (null !== $event->getResponse()) {
                return $event->getResponse();
            }
        }
        $response = new Response($this->serialize(['resmsg' => 'Password has been Send Check Your Mail...!!!!']), Response::HTTP_CREATED);
        return $response;

    }
    /**
     * List All User Activities(Logs)
     *
     * @Rest\Post("/log_details", name="log_details")
     */
    public function logdetailsAction(Request $request)
    {
        $pageNumber=$request->request->get('pageNumber');
        $records_per_page=$request->request->get('recordsperPage');
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $log_Details = $em->createQueryBuilder()
            ->select('b.createdondatetime', 'b.oldvalue', 'b.newvalue', 'b.fieldName', 'c.username')
            ->from('UserBundle:LogDetails', 'b')
            ->join('UserBundle:User', 'c', 'WITH', 'c.id = b.createdbyid')
            ->getQuery()
            ->getResult();
        $total_records = count($log_Details);
        $last_page = ceil($total_records / $records_per_page);
        $previous_page = $pageNumber > 1 ? $pageNumber - 1 : 1;
        $next_page = $pageNumber < $last_page ? $pageNumber + 1 : $last_page;
        $listActiveRecords = $em->createQueryBuilder()
            ->select('b.createdondatetime', 'b.oldvalue', 'b.newvalue', 'b.fieldName', 'c.username', 'b.tablename')
            ->from('UserBundle:LogDetails', 'b')
            ->join('UserBundle:User', 'c', 'WITH', 'c.id = b.createdbyid')
            ->setMaxResults($records_per_page)
            ->setFirstResult(($pageNumber - 1) * $records_per_page)
            ->getQuery()
            ->getResult();
        $response = new Response($this->serialize(['logDetails' => $listActiveRecords,
            'totalRecords'=>$total_records,'last_page' => $last_page,
            'previous_page' => $previous_page, 'current_page' => (int)$pageNumber,
            'next_page' => $next_page]), Response::HTTP_CREATED);
        return $this->setBaseHeaders($response);
    }


    /**
     * Set base HTTP headers.
     *
     * @param Response $response
     *
     * @return Response
     */
    public function setBaseHeaders(Response $response)
    {
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }
    /**
     * Data serializing via JMS serializer.
     *
     * @param mixed $data
     *
     * @return string JSON string
     */
    public function serialize($data)
    {
        $context = new SerializationContext();
        $context->setSerializeNull(true);

        return $this->get('jms_serializer')
            ->serialize($data, 'json', $context);
    }
    /**
     * @Rest\Post("/check_user",name="userAuthencation")
     */
    public function loginAction(Request $request)
    {
        $userName = $request->get('username');
        $password = $request->get('password');
        $user = $this->getDoctrine()
            ->getRepository('UserBundle:User')
            ->findOneBy(['username' => $userName]);

        if (!$user) {
            $response = new Response($this->serialize(['error' => 'Username not Exist','status'=>false]), Response::HTTP_OK);
            return $this->setBaseHeaders($response);
        }
        $isValid = $this->get('security.password_encoder')
            ->isPasswordValid($user, $password);

        if (!$isValid) {
            $response = new Response($this->serialize(['error' => 'Username and Password Mismatch','status'=>false]), Response::HTTP_OK);
            return $this->setBaseHeaders($response);
        }
        else{
            $userStatus=$user->isEnabled();
            if(!$userStatus){
                $response = new Response($this->serialize(['error' => 'User Account Has Been Locked','status'=>false]), Response::HTTP_OK);
                return $this->setBaseHeaders($response);
            }
            else
            {
                $token = $this->getToken($user);
                $response = new Response($this->serialize(['token' => $token,'userdetails'=>$user ,'status'=>true]), Response::HTTP_OK);

                return $this->setBaseHeaders($response);
            }
            //Get Token for User

        }

    }
    /**
     * listAllUsers
     * @Rest\Get("/get_companyuser",name="companyuserlist")
     */
    public function getAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $requestContent=json_decode($request->getContent(),true);
        $companyDetails=$requestContent['currentuserobject'];
        $UserList = $em->createQueryBuilder()
            ->select('b')
            ->from('UserBundle:User', 'b')
            ->getQuery()
            ->getResult();

        $response = new Response($this->serialize(['userlist' => $UserList]), Response::HTTP_CREATED);

        return $this->setBaseHeaders($response);

    }
    /**
     * Returns token for user.
     *
     * @param User $user
     *
     * @return array
     */
    public function getToken(User $user)
    {
        return $this->container->get('lexik_jwt_authentication.encoder')
            ->encode([
                'username' => $user->getUsername(),
                'exp' => $this->getTokenExpiryDateTime(),
            ]);
    }

    /**
     * Returns token expiration datetime.
     *
     * @return string Unixtmestamp
     */
    private function getTokenExpiryDateTime()
    {
        $tokenTtl = $this->container->getParameter('lexik_jwt_authentication.token_ttl');
        $now = new \DateTime();
        $now->add(new \DateInterval('PT'.$tokenTtl.'S'));

        return $now->format('U');
    }
}
