<?php

namespace DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use UserBundle\Entity\CompanyUsers;
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
/**
 * CompanyUsersController.
 * @Route("/companyusers")
 */
class CompanyUsersController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
    /**
     * @Rest\Post("/createcompany",name="company_createuser")
     */
    public function postUserAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $commonfunction=new CommonFunctions();
        $userobject=$this->getUser();
        $requestContent=json_decode($request->getContent(),true);
        $companyUserVlaue=$requestContent['modelobject'];
        $companyDetails=$requestContent['currentuserobject'];
        $userManager = $this->get('fos_user.user_manager');
        $name = $companyUserVlaue['name'];
        $email = $companyUserVlaue['email'];
        $username = $companyUserVlaue['username'];
        $password = $companyUserVlaue['password'];
        $email_exist = $userManager->findUserByEmail($email);
        $username_exist = $userManager->findUserByUsername($username);

        if($email_exist || $username_exist){
            $response = new JsonResponse();
            $response->setData("Username/Email ".$username."/".$email." Already Exist");
            return $response;
        }

        $user = $userManager->createUser();
        $user->setUsername($username);
        $user->setName($name);
        $user->setEmail($email);
        $user->setEnabled(true);
        $user->setPlainPassword($password);
        $user->setRoles( array($companyUserVlaue['roles']) );
        $user->setMobile($companyUserVlaue['mobileno']);
        $userManager->updateUser($user, true);
        $companyUserobject=new CompanyUsers();
        $companyUserobject->setCompanyname($companyDetails['company_id']);
        $companyUserobject->setUserId($user);
        try{
            $em->persist($companyUserobject);
            $em->flush();
            $UserList = $em->createQueryBuilder()
                ->select('c.username', 'c.email', 'c.mobile','c.id','c.roles','c.password','c.lastLogin','c.salt','c.enabled')
                ->from('UserBundle:User', 'c')
                ->join('UserBundle:CompanyUsers', 'a', 'with', 'c.id = a.userId')
                ->where('a.companyname = :companyId ')
                ->setParameter('companyId',$userobject->getCompanyId())
                ->getQuery()
                ->getResult();
            $response = new Response($this->serialize(['resmsg' => 'Company user create sucessfully!!!!','userList'=>$UserList]), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);
        }
        catch (Exception $e){
            $response = new Response($this->serialize(['resmsg' => $e->getMessage()]), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);

        }

    }
    /**
     * listAllUsers for Company
     * @Rest\Post("/get_companyuser",name="companyusers")
     */
    public function getcompanyuserAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $requestContent=json_decode($request->getContent(),true);
        $companyDetailsId=$requestContent['company_id'];
        $UserList = $em->createQueryBuilder()
            ->select('c.username', 'c.email', 'c.mobile','c.enabled','c.id','c.roles','c.password','c.lastLogin','c.salt')
            ->from('UserBundle:User', 'c')
            ->join('UserBundle:CompanyUsers', 'a', 'with', 'c.id = a.userId')
            ->where('a.companyname = :companyId ')
            ->setParameter('companyId', $companyDetailsId)
            ->getQuery()
            ->getResult();

        $response = new Response($this->serialize(['userlist' => $UserList]), Response::HTTP_CREATED);

        return $this->setBaseHeaders($response);

    }
    /**
     * Find User by Id
     * @Rest\Post("/finduserbyId",name="findUserbyId")
     */
    public function findUserbyIdAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $requestContent=json_decode($request->getContent(),true);
        $userId=$requestContent['userId'];
        $findUserbyId = $em->createQueryBuilder()
            ->select('c.username', 'c.email', 'c.mobile','c.id','c.roles','c.password', 'c.lastLogin','c.salt','c.name')
            ->from('UserBundle:User', 'c')
            ->where('c.id = :UseId ')
            ->setParameter('UseId', $userId)
            ->getQuery()
            ->getResult();

        $response = new Response($this->serialize(['userlist' => $findUserbyId]), Response::HTTP_CREATED);

        return $this->setBaseHeaders($response);

    }
    /**
     * Change User Status
     * @Rest\Post("/changeuserstatus",name="changeUsrstatus")
     */
    public function changeUserStatusAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $requestContent=json_decode($request->getContent(),true);
        $userId=$requestContent['id'];
        $findUser = $em->createQueryBuilder()
            ->select('c.username', 'c.email', 'c.mobile', 'c.enabled','c.id','c.roles', 'c.lastLogin','c.salt')
            ->from('UserBundle:User', 'c')
            ->where('c.id = :UseId ')
            ->setParameter('UseId', $userId)
            ->getQuery()
            ->getResult();
        $userStatus=$findUser[0]['enabled'];
        $userOject= $em->getRepository('UserBundle:User')->find($userId);
        $responseMsg='';
        $responseStatus='';
        if($userStatus)
        {
            $userOject->setEnabled(false);
            $responseMsg=$userOject->getUsername().' Deactiveted';
            $responseStatus=false;
            $em->flush();

        }
        else
        {
            $userOject->setEnabled(true);
            $responseMsg=$userOject->getUsername().' Activetd';
            $responseStatus=true;
            $em->flush();
        }

        $response = new Response($this->serialize(['resMsg' => $responseMsg,'userStatus'=>$responseStatus]), Response::HTTP_CREATED);

        return $this->setBaseHeaders($response);

    }
    /**
     * Update User
     * @Rest\Put("/updateuser",name="updateuser")
     */
    public function updateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $username = $request->get('username');
        $email = $request->get('email');
        $mobileno = $request->get('mobileno');
        $role = $request->get('roles');
        $name=$request->get('name');
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserByUsername($username);
        $user->setRoles(array($role));
        $user->setName($name);
        $user->setMobile($mobileno);
        $userManager->updateUser($user, true);
        $response = new Response($this->serialize(['userdetails' => $user,'resMsg'=>$username.' Updated']), Response::HTTP_CREATED);
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
}
